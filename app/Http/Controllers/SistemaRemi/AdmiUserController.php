<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\Tipos_Roles;
use App\Models\SistemaRemi\Usuario;
use App\Http\Requests\UserRequest;
use Laracasts\flash\flash;
use Validator;

class AdmiUserController extends Controller
{

/**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
    $this->middleware(function ($request, $next) {
    $this->user= \Auth::user();
    $rol = (int) $this->user->id_rol;
    $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
    $this->modulos = array();
    foreach ($sql as $mn) {
        array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'target' => $mn->target,'id_html' => $mn->id_html,'sigla' => $mn->sigla));
    }


    $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 11 AND activo = true ORDER BY m.tipo_menu,m.orden ASC");
    $this->menus = array();
    foreach ($sql as $mn) {

        //$submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
        $submenu = \DB::select("SELECT s.* FROM sub_menus s INNER JOIN roles_sub_menus rs ON s.id = rs.id_sub_menu
          WHERE rs.id_rol = ".$rol." AND s.id_menu = ".$mn->id." AND s.activo = true  ORDER BY orden ASC");
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'class'=>$mn->class,'submenus' => $submenu));
    }

    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);

    return $next($request);

    });

  }


  public function CrudUsers(Request $request)
  {
        $users=Usuario::orderBy('id','ASC')->paginate(10);
        //dd("fgdfgfd",$users);
        return view('SistemaRemi.registrar.clab-users')->with('users', $users);
  }

  public function asignarRoles(Request $request)
  {
        // crear el querys a la BD y enviar a la vista y datos con with
      $id_institucion  = \DB::select("select i.id,i.name,i.username,i.cargo
                                        from users i
                                  order by i.id");

      return view('SistemaRemi.Seguridad.roles-permisos')->with('codinstitucion',$id_institucion);
  }

  public function actualizarUserRol(Request $request)
  {
        $userSession = \Auth::user();

        $user=Usuario::find($request->cod_inst);
        //$user->fill($request->all());
        $user->id_rol=$request['roles'];
        $user->id_user_updated=$userSession->id;
        $user->save();
        return  redirect()->route('mostrarReg');
        //flash('Genero editado exitosamente')->success();
        //return 'Se actualiza correctamente';  //  redirect()->route('mostrarReg');   //redirect()->route('admin.genero.index');
        //return //view('SistemaRemi.registrar.crear-users');
  }

	public function search(Request $request)
	{
	//	dd("CZSDF",$request->get('search');
//        $search = Request::get('search');
		$search = $request->get('search');
		$users = DB::table('users')->where('username','like','%'.$search.'%')->paginate(10);
		return view('SistemaRemi.registrar.detalles-users')->with('users', $users);
	}

  public function mostrarReg(Request $request)
  {

    $users = Usuario::join('remi_tipo_rol as r','users.id_rol', '=', 'r.id_roles')
               ->join('pip_instituciones as e','users.id_institucion', '=', 'e.id')
               ->where('users.activo', true)
               ->orderBy('users.name','ASC')
               ->select('users.*','r.nombre_rol','e.denominacion')
               ->paginate(10);
    return view('SistemaRemi.registrar.detalles-users')->with('users', $users);
  }

  public function registrarUser(Request $request)
  {
        $tipo_rol = Tipos_Roles::get();
        $filinstitucion = \DB::select("SELECT  id,codigo, denominacion
                              FROM pip_instituciones
                               order by codigo");
        return view('SistemaRemi.registrar.crear-users')->with('filinstitucion',$filinstitucion)->with('tipo_rol',$tipo_rol);
  }

  public function guardarUser(Request $request)
  {
        $userSession = \Auth::user();
        $validator = Validator::make($request->all(), [
             'username'=>'required|unique:users',
             'email' => 'required|unique:users',
             'carnet' => 'required|unique:users',
             'telefono'  => 'required|unique:users'
        ]);

        if($validator->fails()){
          return back()
                ->withErrors($validator)
                ->withInput();
        }


        //dd("dsfsf",$request);
        $user=new Usuario($request->all());
        // dd($request['name']);
        // $rolecito = \DB::select("SELECT rol
        //                         FROM roles
        //                         where  id=".$request->roles);

        // $user->tipo_rol= $rolecito[0]->rol;

        $user->id_rol=$request['roles'];
        $user->id_institucion=$request->pcod_ent;
        $user->activo=true;
        $user->password=bcrypt($request['password']);
        $user->id_user_created = $userSession->id;
        $user->save();
       // flash('Creo Usuario exitosamente !!')->success();
        return  redirect()->route('mostrarReg');
        //return response()->json($user);
        // return 'Usuario registrado exitosamente';
        //return 'registrado' //flash('Usuario registrado exitosamente')->success();
        //return redirect()->route('admin.user.index');
  }

  public function messages()
  {
      return [
          'telefono.required' => ':attribute ya esta en uso',
      ];
  }

  public function attributes()
  {
      return [
          'telefono' => ':El Celular',
      ];
  }

  public function editarUser($id)
    {
      $mis_roles = Tipos_Roles::get();

      $Modifinstitucion = \DB::select("SELECT  id, codigo, denominacion
                            FROM pip_instituciones
                             order by denominacion ASC");

      $user=Usuario::find($id);
      return view('SistemaRemi.registrar.editar-users')->with('user',$user)->with('mis_roles',$mis_roles)->with('Modifinstitucion',$Modifinstitucion);
    }

  public function addPost(Request $request)
  {
        //dd("dfdsf sdfds",$request);
        $user=new Usuario($request->all());
        // dd($request['name']);
        $user->password=bcrypt($request['password']);
        $user->save();
        return response()->json($user);
  }

  public function actualizarUser(Request $request,$id)
  {
      $pass1=$request['password_nuevo_1'];
      $pass2=$request['password_nuevo_2'];

     if($request->has('activarpass')==true && $pass1!="" && $pass2!="" && $pass1==$pass2){
         $user=Usuario::find($id);
         $user->name = $request->name;
         $user->cargo = $request->cargo;
         $user->carnet = $request->carnet;
         $user->telefono = $request->telefono;
         $user->email = $request->email;
         $user->id_institucion = $request->modent;
         $user->username = $request->username;
         $user->id_rol = $request->roles;
         $user->password=bcrypt($request['password_nuevo_1']);
         $user->save();
         return   redirect()->route('mostrarReg');
     }else{
         $user=Usuario::find($id);
         $user->name = $request->name;
         $user->cargo = $request->cargo;
         $user->carnet = $request->carnet;
         $user->telefono = $request->telefono;
         $user->email = $request->email;
         $user->id_institucion = $request->modent;
         $user->username = $request->username;
         $user->id_rol = $request->roles;
         $user->save();
         return   redirect()->route('mostrarReg');
     }
  }

  public function eliminarUser($id)
    {
      $userSession = \Auth::user();

        //dd("sdfsdf",$id);
        $user=Usuario::find($id);
        $user->activo=false;
        $user->id_user_updated= $userSession->id;
        $user->save();
      //  flash('Genero registrado exitosamente')->success();
        return  redirect()->route('mostrarReg');
       // flash('Genero eliminado exitosamente')->success();
    }

}
