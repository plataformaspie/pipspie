<?php

namespace App\Http\Controllers\ModuloEntidades;

use Illuminate\Http\Request;
use App\Models\ModuloEntidades\Institucion;
use App\Http\Controllers\Controller;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
        }


        $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 2 ORDER BY m.orden ASC");
        $this->menus = array();
        foreach ($sql as $mn) {

            $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." ORDER BY orden ASC");
            array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
        }



        \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);

        return $next($request);

        });

    }    
    public function index()
    {
        //$instituciones=Institucion::latest()->paginate(12);
        //return view('ModuloEntidades/index');//,compact('instituciones'))->with('i',(request()->input('page',1)-1)*12);
        return view('ModuloEntidades.index');//,compact('instituciones'))->with('i',(request()->input('page',1)-1)*12);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ModuloEntidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crudInstitucion(Request $request)
    {
        $msg='Operacion Sin Exito';
        $crudRegs=0;
        $data = [
            'nombre'=>$request->nombre,
            'categoriaid'=>$request->categoriaid,
            'dependede_id'=>$request->dependede_id,
            'codigo'=>$request->codigo,
            'sigla'=>$request->sigla,
            'direccion'=>$request->direccion,
            'region_id'=>$request->region_id,
            'updated_at'=>date("Y-m-d h:i:s")
        ];
        if($request->task=='create'){
            $crudRegs=\DB::table('spie_instituciones')->insert($data);
        }
        if($request->id && $request->task=='update'){

            $crudRegs=\DB::table('spie_instituciones')->where('id',$request->id)->update($data);

        }
        if($request->id && $request->task=='delete'){
            $data=['borrado'=>'1','updated_at'=>date("Y-m-d h:i:s")];
            $crudRegs=\DB::table('spie_instituciones')->where('id',$request->id)->update($data);
        }        
        if($crudRegs){
            $msg="Operacion Realizada con Exito";
        }
        // $institucionNueva = new Institucion();
        // $institucionNueva->nombre = $request->nombre;
        // $institucionNueva->sigla = $request->sigla;

        // $intitucionNueva->save();

        return response()->json([
            'mensaje' =>$msg,
            'institucion'=>$data
        ]);
        // request()->validate([
        //     'nombre'=>'required',
        //     'codigo'=>'required',
        //     'sigla'=>'required',
        //     'direccion'=>'required',
        //     'localidad'=>'required'
        // ]);
        // Institucion::create($request->all());
        //return redirect()->route('instituciones.index')->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institucion=Institucion::find($id);
        return view('ModuloEntidades.show',compact('institucion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institucion=Institucion::find($id);
        return view('ModuloEntidades.edit',compact('institucion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'nombre'=>'required',
            'codigo'=>'required',
            'sigla'=>'required',
            'direccion'=>'required',
            'localidad'=>'required'            
        ]);
        Institucion::find($id)->update($request->all());
        return redirect()->route('instituciones.index')->with('success','Institucion Actualizada con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Institucion::find($id)->delete();
        return redirect()->route('instituciones.index')->with('success','Institucion Borrada con Exito');
    }

    public function getInstituciones()
    {
        $inst = Institucion::where('borrado',0)->get();
        return response()->json([
            'listaInstituciones' => $inst,
            'estado'=> 'ok',
        ]);
    }
    public function getCategorias(){
        $categorias=\DB::select("select id,nombre from spie_categoriasinstitucionales order by nombre");
        return response()->json(['categorias'=>$categorias,'listado'=>'ok']);
    }
    public function getRegiones(){
        $regiones=\DB::select("SELECT r3.id, r1.nombre_comun || ' - ' || r3.nombre_comun as nombre 
FROM (SELECT id, codigo_numerico, nombre_comun, substring(codigo_numerico, 1,2) as codigo_numerico_n1 FROM regiones   WHERE categoria = 'NIVEL_3') r3,(SELECT id, codigo_numerico, nombre_comun FROM regiones WHERE categoria = 'NIVEL_1') r1 WHERE r1.codigo_numerico = r3.codigo_numerico_n1 order by r1.nombre_comun,r3.nombre_comun");
        return response()->json(['regiones'=>$regiones,'listado'=>'ok']);

    }
}
