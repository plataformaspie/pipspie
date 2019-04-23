<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use PDF;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\Variables;
use App\Models\SistemaRemi\IndicadorResultado;
use App\Models\SistemaRemi\IndicadorResultado_Ods;
use App\Models\SistemaRemi\Metas;
use App\Models\SistemaRemi\Etapas;
use App\Models\SistemaRemi\Tipos_Roles;
use App\Models\SistemaRemi\IndicadorAvance;
use App\Models\SistemaRemi\Resultados;
use App\Models\SistemaRemi\VistaCatalogoPdespmr;
use App\Models\SistemaRemi\VistaCatalogoODSods;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\IndicadoresArchivosRespaldos;
use App\Models\SistemaRemi\RelacionOdsPdes;
use App\Models\SistemaRemi\IndicadoresVariables;
use App\Models\SistemaRemi\Usuario;
use App\Models\SistemaRemi\IndicadorSector;
use Laracasts\flash\flash;

class IndicadorController extends Controller
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
  /*public function setIndicadores(Request $request)
  {
    //$indicadores = Indicadores::paginate();
    $sw=0;
    $sb=0;
    $tipo = "";
    $unidad = "";
    $buscar = "";
    $where = array();
    $orwhere = array();

    if($request->has('buscar')){
        $sb=1;
        $orwhere[] = array(\DB::raw("upper(lower(nombre))"),'LIKE','%'.mb_strtoupper($request->buscar,'utf-8') .'%');
        $buscar = $request->buscar;
        $sw++;
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }

    if($sw > 0){

          $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);

    }else{
          $indicadores = Indicadores::where('activo',true)->paginate(5);
    }



    $tiposMedicion = TiposMedicion::get();
    $unidadesMedidas = UnidadesMedidas::get();

    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad','tiposMedicion','unidadesMedidas','buscar'));
  }*/

  public function setIndicadoresEntidad()
  {

    return view('SistemaRemi.set-indicadores-ver');
  }

  public function apiSetListIndicadores(Request $request)
  {


      $dataFuente  = \DB::select("SELECT fd.*,et.nombre as estado1, et.id as Id_Estado from remi_indicadores fd
                                  inner join remi_estados et on to_number(fd.estado,'9')=et.id
                                  where fd.activo=true
                                  order by id asc");
      /*foreach ($dataFuente as $value) {
        $data[$value->id] = $value->nombre;
      }*/
      $this->listFuente = array();
      foreach ($dataFuente as $item) {
          array_push($this->listFuente, array('id' => $item->id,
                                              'estado' => $item->estado,
                                              'etapa' => $item->etapa,
                                              'nombre' => $item->nombre,
                                              'id_estado' => $item->id_estado,
                                              'codigo' => $item->codigo));
      }
      return \Response::json($this->listFuente);

   }


  // public function apiDataSetIndicador(Request $request)
  // {
  //     $fuente  = \DB::select("select fd.*,et.nombre as estado, et.id as Id_Estado from remi_indicadores fd
  //     inner join remi_estados et on to_number(fd.estado,'9')=et.id
  //     where fd.id=".$request->id."
  //     order by id asc");
  //     $resposables = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();
  //     $archivos = FuenteArchivosRespaldos::where('id_fuente',$request->id)->where('activo', true)->get();
  //     $tiposCobertura = FuenteTiposCobertura::where('activo', true)->get();



  //     $cobertura = Array();
  //     foreach ($tiposCobertura as $item) {
  //       $cobertura[$item->id] = $item->nombre;
  //     }

  //     return \Response::json(array(
  //         'error' => false,
  //         'title' => "Success!",
  //         'msg' => "Se guardo con exito.",
  //         'fuente' => $fuente,
  //         'responsables' => $resposables,
  //         'cobertura' => $cobertura,
  //         'archivos' => $archivos)
  //     );
  // }

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
        //dd("SDFGSDFGSD",$request->all());
        $user=Usuario::find($request->cod_inst);
        //$user->fill($request->all());
        $user->id_rol=$request['roles'];
        $user->save();
        return  redirect()->route('mostrarReg');
        //flash('Genero editado exitosamente')->success();
        //return 'Se actualiza correctamente';  //  redirect()->route('mostrarReg');   //redirect()->route('admin.genero.index');
        //return //view('SistemaRemi.registrar.crear-users');
  }


  public function mostrarReg(Request $request)
  {
        $users=Usuario::where('activo','=',true)->orderBy('id','ASC')->paginate(10);
        //dd("fgdfgfd",$users);
        return view('SistemaRemi.registrar.detalles-users')->with('users', $users);
  }

  public function registrarUser(Request $request)
  {
        $tipo_rol = Tipos_Roles::get();
        $filinstitucion = \DB::select("SELECT  codigo, denominacion
                              FROM pip_instituciones
                               order by codigo");
        return view('SistemaRemi.registrar.crear-users')->with('filinstitucion',$filinstitucion)->with('tipo_rol',$tipo_rol);
  }

  public function guardarUser(Request $request)
  {
        //dd("dsfsf",$request);
        $user=new Usuario($request->all());
        // dd($request['name']);
        $rolecito = \DB::select("SELECT nombre_rol
                                FROM remi_tipo_rol
                                where  id_roles=".$request->roles);

        $user->tipo_rol= $rolecito[0]->nombre_rol;
        $user->id_rol=$request['roles'];
        $user->id_institucion=$request->pcod_ent;
        $user->activo=true;
        $user->password=bcrypt($request['password']);
        $user->save();
        return  redirect()->route('mostrarReg');
        //return response()->json($user);
        // return 'Usuario registrado exitosamente';
        //return 'registrado' //flash('Usuario registrado exitosamente')->success();
        //return redirect()->route('admin.user.index');
  }

  public function editarUser($id)
    {
        // Mostrar formulario para editar usuario
        //dd("SDFGSDFGSD",$id);
        $mis_roles = Tipos_Roles::get();
        // $nombre_roles = \DB::select("SELECT tipo_rol
        //                         FROM users
        //                         where  id=".$id);

        $user=Usuario::find($id);  // realizar la consulta en la tabla con id uy cambia el rol
        return view('SistemaRemi.registrar.editar-users')->with('user',$user)->with('mis_roles',$mis_roles);
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
        //dd("SDFGSDFGSD",$request->all());
        $user=Usuario::find($id);
        $user->fill($request->all());

        $user->save();
        flash('Actualizado exitosamente')->success();
        return   redirect()->route('mostrarReg');   //redirect()->route('admin.genero.index');
        //return //view('SistemaRemi.registrar.crear-users');
  }

  public function eliminarUser($id)
    {
        //dd("sdfsdf",$id);
        $user=Usuario::find($id);
        $user->activo=false;
        $user->save();
      //  flash('Genero registrado exitosamente')->success();
        return  redirect()->route('mostrarReg');
       // flash('Genero eliminado exitosamente')->success();
    }


  /*public function setIndicadores(Request $request)
  {
    //dd("VALORES",$request);
    //$indicadores = Indicadores::paginate();
    $swe=1;
    $sw=0;
    $sb=0;
    $cond=0;
    $pent = 1;
    $tipo = "";
    $unidad = "";
    $buscar = "";
    $pdes = 1;
    $where = array();
    $orwhere = array();
    $fil_sector = "";
    $fil_sector_desc = "";
    //$filindent = "1";

    if($request->has('buscar')){
        $sb=1;
        $orwhere[] = array(\DB::raw("upper(lower(nombre))"),'LIKE','%'.mb_strtoupper($request->buscar,'utf-8') .'%');
        $buscar = $request->buscar;
        $sw++;
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }
    if($request->has('pdes')){
        $pdes = $request->pdes;
        $pdes_new=$pdes;$swe=2;
        //dd("fsdfsdf",$pent);
    }
    if($request->has('cod_ent')){
        $cod_ent = $request->cod_ent;
        $pent=(int)$cod_ent;
       // $swe=2;
      // dd("codigo entidad:",$pent);
    }


      if(isset())
      $filnoment = \DB::select("SELECT nombre_entidad
                                FROM remi_entidad
                                where  codigo_entidad=".$pent." AND activo = true");
      $fil_sector_desc = $filnoment[0]->nombre_entidad;


    if($sw > 0){

          $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);

    }else{
          $indicadores = Indicadores::where('activo',true)->paginate(5);
    }




    $filindent = \DB::select("SELECT distinct c.cod_p
                              FROM remi_indicador_pdes_resultado ir
                              INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                              WHERE ir.id_indicador IN (
                                SELECT id_fuente
                                FROM public.remi_fuente_datos_responsable
                                where cod_entidad=".$pent.")
                              order by c.cod_p");//$swe=2;

    if($swe==1){
          $pdes_new=$filindent[0]->cod_p;
    }
          // if(empty($pdes_new)){
          //   dd("PILARES1",$pent,$pdes_new);
          // }

    $filinstitucion = \DB::select("SELECT  codigo, denominacion
                              FROM pip_instituciones
                               order by codigo");



    $filindpil = \DB::select("SELECT DISTINCT sec.id,sec.denominacion as sector,sec.sigla
                              FROM remi_indicadores i
                              INNER JOIN remi_indicadores_sectores s ON i.id = s.id_indicador
                              INNER JOIN pip_instituciones sec ON s.id_institucion = sec.id
                              ORDER BY sec.denominacion ASC");


    $filtropdes = \DB::select("SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre
                              FROM pdes_vista_catalogo_pmr c
                              LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                              WHERE cod_p = ".$pdes_new."
                              ORDER BY cod_p,cod_m,cod_r ASC");    // ".$pdes."

    $countPilar = \DB::select("SELECT count(i.id) as total
                          FROM pdes_vista_catalogo_pmr c
                          LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                          LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                          WHERE cod_p = ".$pdes_new);   //  $pdes
    $countPilar =$countPilar[0];


    $totalPilar = \DB::select("select count(*) as totalp
                              From (SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre
                              FROM pdes_vista_catalogo_pmr c
                              LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                              WHERE cod_p = ".$pdes_new."
                              ORDER BY cod_p,cod_m,cod_r ASC) a");
    $totalPilar = $totalPilar[0];

   $totalResPilar = \DB::select("SELECT (b.totalp-c.total) as totalgral
                              FROM
                              (
                              select count(*) as totalp
                              From (SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre
                              FROM pdes_vista_catalogo_pmr c
                              LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                              WHERE cod_p = ".$pdes_new."
                              ORDER BY cod_p,cod_m,cod_r ASC) a
                              ) b,
                              (
                              SELECT count(i.id) as total
                              FROM pdes_vista_catalogo_pmr c
                              LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                              WHERE cod_p = ".$pdes_new."
                              ) c ");
    $totalResPilar = $totalResPilar[0];

    $tiposMedicion = TiposMedicion::get();
    $unidadesMedidas = UnidadesMedidas::get();
   // dd("Los Pilares",$request->cod_ent1);
    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad',
    'nom_ent','tiposMedicion','unidadesMedidas','buscar','filtropdes','countPilar',
    'totalPilar','totalResPilar','filindpil','filindent','swe','pent'));
  }*/




  public function setIndicadores(Request $request)
    {
      //$indicadores = Indicadores::paginate();
      $sw=0;
      $sb=0;
      $tipo = "";
      $unidad = "";
      $buscar = "";
      $countSinIndicador='';
      $fil_sector = 0;
      $fil_pilares = \DB::select("SELECT * FROM pdes_pilares ORDER BY cod_p ASC ");
      $fil_pilar_sector = 0;
      $pdes = 1;
      $where = array();
      $orwhere = array();



      if($request->has('fil_sector')){
          $fil_sector = $request->fil_sector;
          $fil_pilares = \DB::select("SELECT DISTINCT c.cod_p,c.logo
                                            FROM remi_indicadores i
                                            INNER JOIN remi_indicadores_sectores s ON (i.id = s.id_indicador AND s.activo = true)
                                            INNER JOIN remi_indicador_pdes_resultado pdes ON i.id = pdes.id_indicador
                                            INNER JOIN pdes_vista_catalogo_pmr c ON pdes.id_resultado = c.id_resultado
                                            WHERE i.activo = true
                                            AND s.id_institucion = ?
                                            ORDER BY c.cod_p ASC",[$fil_sector]);
          if($fil_pilares){
            $fil_pilar_sector =  $fil_pilares[0]->cod_p;
          }else{
            $fil_pilar_sector =  0;
          }
          $pdes = $fil_pilar_sector;
      }

      if($request->has('pdes')){
          $pdes = $request->pdes;
      }




      // if($sw > 0){
      //
      //       $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);
      //
      // }else{
      //       $indicadores = Indicadores::where('activo',true)->paginate(5);
      // }
      if($request->has('fil_sector')){
          $filtropdes = \DB::select("SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre,LPAD(i.id::text, 4, '0') as codigo_id
                                      FROM pdes_vista_catalogo_pmr c
                                      LEFT JOIN remi_indicador_pdes_resultado ir ON (c.id_resultado = ir.id_resultado AND ir.activo = true)
                                      LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                                      LEFT JOIN remi_indicadores_sectores s ON (i.id = s.id_indicador AND s.activo = true)
                                      WHERE cod_p = ?
                                      AND s.id_institucion = ?
                                      ORDER BY cod_p,cod_m,cod_r ASC",[$pdes,$request->fil_sector]);

          $countPilar = \DB::select("SELECT COUNT(i.id ) as total
                                    FROM pdes_vista_catalogo_pmr c
                                    INNER JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                                    INNER JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                                    INNER JOIN remi_indicadores_sectores s ON (i.id = s.id_indicador AND s.activo = true)
                                    WHERE cod_p = ?
                                    AND s.id_institucion = ?",[$pdes,$request->fil_sector]);
          $countPilar =$countPilar[0];
      }else{
        $filtropdes = \DB::select("SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre,LPAD(i.id::text, 4, '0') as codigo_id
                                   FROM pdes_vista_catalogo_pmr c
                                   LEFT JOIN remi_indicador_pdes_resultado ir ON (c.id_resultado = ir.id_resultado AND ir.activo = true)
                                   LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                                   WHERE cod_p = ".$pdes."
                                   ORDER BY cod_p,cod_m,cod_r ASC");

        $countPilar = \DB::select("SELECT count(i.id) as total
                              FROM pdes_vista_catalogo_pmr c
                              INNER JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              INNER JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                              WHERE cod_p = ".$pdes);
         $countPilar =$countPilar[0];
          $countSinIndicador = \DB::select("SELECT count(*) as total
                                          FROM (
                                            SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre,LPAD(i.id::text, 4, '0') as codigo_id
                                            FROM pdes_vista_catalogo_pmr c
                                            LEFT JOIN remi_indicador_pdes_resultado ir ON (c.id_resultado = ir.id_resultado AND ir.activo = true)
                                            LEFT JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                                            WHERE cod_p = ".$pdes."
                                            ORDER BY cod_p,cod_m,cod_r ASC
                                          ) as fuente
                                          WHERE id_indicador is NULL");
          $countSinIndicador =$countSinIndicador[0]->total;

      }


      $sectores = \DB::select("SELECT DISTINCT sec.id,sec.denominacion as sector,sec.sigla
                                  FROM remi_indicadores i
                                  INNER JOIN remi_indicadores_sectores s ON i.id = s.id_indicador
                                  INNER JOIN pip_instituciones sec ON s.id_institucion = sec.id
                                  ORDER BY sec.denominacion ASC");

      return view('SistemaRemi.set-indicadores',compact('filtropdes','countPilar','sectores','fil_sector','fil_pilares',
      'fil_pilar_inicial','countSinIndicador'));
    }

  public function filtraPdesEntidad(Request $request){
     dd("valors ent",77);
     if($request->ajax()){
          dd("valors",$request->pcod_ent);
      }
  }

  public function dataIndicador($id)
  {
    $indicador = Indicadores::find($id);
    $pdes = \DB::select("SELECT c.*,ir.id
                         FROM remi_indicador_pdes_resultado ir
                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                         WHERE ir.id_indicador = ".$id);
    $ods = \DB::select("SELECT c.*,ir.id,ir.comparabilidad_ods_pdes
                        FROM remi_indicador_ods_indicador ir
                        INNER JOIN ods_vista_catalogo_omi c ON ir.id_resultado_ods = c.id_indicador
                        WHERE ir.id_indicador_ods = ".$id);
    $metas = Metas::where('id_indicador',$id)->orderBy('gestion', 'asc')->get();
    $avance = IndicadorAvance::where('id_indicador',$id)->orderBy('fecha_generado', 'DESC')->first();


    $dataMetasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC
                            LIMIT 5");
    $metasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC");
    $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$id)->where('activo', true)->get();


    //$idFuenteNumerador = explode(",", $indicador->fuente_datos);
    if($indicador->fuente_datos)
    $descFuenteNumerador = \DB::select("SELECT * FROM remi_fuente_datos WHERE id IN (".$indicador->fuente_datos.")");
    else
    $descFuenteNumerador=[];

    if($indicador->fuente_datos_d)
    $descFuenteDenominador = \DB::select("SELECT * FROM remi_fuente_datos WHERE id IN (".$indicador->fuente_datos_d.")");
    else
    $descFuenteDenominador=[];


    $grafica = json_encode($dataMetasAvance);
    $estado_desc = \DB::select("SELECT * FROM remi_estados WHERE id = ".$indicador->estado);
    $estado_desc = $estado_desc[0]->nombre;

    $brechaDatos =  Array('9' =>'',
                          '0' => "Existen Fuentes de Datos con la frecuencia requerida y las variables de desagregación necesarias para reportar el indicador",
                          '1' => "No existen datos para reportar el indicador",
                          '2' => "Existen datos pero no se recopilan con la frecuencia requerida",
                          '3' => "Existen datos pero no se recopilan con las variables de desagregación requeridas",
                          '4' => "Existen datos pero no se recopilan con la frecuencia requerida ni con las variables de desagregación necesarias");
    $brechaMetodologia =  Array('9' =>'',
                          '0' => "Existe metodología nacional adaptada a recomendaciones internacionales",
                          '1' => "No existe Metodología Nacional",
                          '2' => "No Existe Metodología bajo Recomendaciones Internacionales",
                          '3' => "No existe metodología nacional ni bajo recomentaciones internacionales");
    $brechaCapacitacion =  Array('9' =>'',
                          '0' => "Existe personal capacitado",
                          '1' => "No existe Personal permanente para la generación de estadísticas",
                          '2' => "No exite personal capacitado para generar estadísticas",
                          '3' => "No existe personal permanente ni capacitado para generar estadísticas");
    $brechaFinanciamiento = Array('9' =>'',
                            '0' => "Existe financiamiento",
                            '1' => "No se cuenta con financiamiento nacional",
                            '2' => "Sólo se cuenta con financiamiento temporal de la cooperación",
                            '3' => "No se cuenta con financiamiento nacio nal ni internacional ");

    $dataBrechaDatos = $brechaDatos[$indicador->brecha_datos];
    $dataBrechaMetodologia = $brechaMetodologia[$indicador->brecha_metodologia];
    $dataBrechaCapacitacion = $brechaCapacitacion[$indicador->brecha_capacitacion];
    $dataBrechaFinanciamiento = $brechaFinanciamiento[$indicador->brecha_financiamiento];

    $sectores = IndicadorSector::where('id_indicador',$id)->where('activo', true)->get();
    $agrupSectores ='';
    foreach ($sectores as $value) {
      $agrupSectores .= $value->id_institucion."," ;
    }
    $agrupSectores = trim($agrupSectores, ',');
    $sectoresRelacionados = \DB::select("SELECT * FROM pip_instituciones WHERE id IN (".$agrupSectores.")");

    return view('SistemaRemi.data-indicador',compact('indicador',
    'metas','pdes','avance','grafica','metasAvance','archivos','ods','descFuenteNumerador',
    'descFuenteDenominador','estado_desc','dataBrechaDatos','dataBrechaMetodologia',
    'dataBrechaCapacitacion','dataBrechaFinanciamiento','sectoresRelacionados'));
  }

  public function adminIndicador()
  {


    $relacop = RelacionOdsPdes::where('activo', true)->orderBy('id')->get();
    $estados = \DB::select("SELECT * FROM remi_estados ORDER BY id ASC");
    $tipos = TiposMedicion::get();
    $estado =  Array('1' => "Preliminar",'2' =>"Enviado a Revision",'3' =>"Modificar",'4' =>"Aprobado",'5' =>"Eliminado");

    $brechaDatos =  Array('0' => "Existen Fuentes de Datos con la frecuencia requerida y las variables de desagregación necesarias para reportar el indicador",
                          '1' => "No existen datos para reportar el indicador",
                          '2' => "Existen datos pero no se recopilan con la frecuencia requerida",
                          '3' => "Existen datos pero no se recopilan con las variables de desagregación requeridas",
                          '4' => "Existen datos pero no se recopilan con la frecuencia requerida ni con las variables de desagregación necesarias");
    $brechaMetodologia =  Array('0' => "Existe metodología nacional adaptada a recomendaciones internacionales",
                          '1' => "No existe Metodología Nacional",
                          '2' => "No Existe Metodología bajo Recomendaciones Internacionales",
                          '3' => "No existe metodología nacional ni bajo recomentaciones internacionales");
    $brechaCapacitacion =  Array('0' => "Existe personal capacitado",
                          '1' => "No existe Personal permanente para la generación de estadísticas",
                          '2' => "No exite personal capacitado para generar estadísticas",
                          '3' => "No existe personal permanente ni capacitado para generar estadísticas");
    $brechaFinanciamiento = Array('0' => "Existe financiamiento",
                            '1' => "No se cuenta con financiamiento nacional",
                            '2' => "Sólo se cuenta con financiamiento temporal de la cooperación",
                            '3' => "No se cuenta con financiamiento nacio nal ni internacional ");

    $etapas = Etapas::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    //$variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::where('activo', true)->orderBy('nombre', 'ASC ')->get();
    $fuente_tipos = FuenteTipos::get();
    $instituciones = \DB::select("SELECT * FROM pip_instituciones ORDER BY codigo ASC");
    $setPP = \DB::select("SELECT * FROM pdes_pilares ORDER BY cod_p ASC");
    $setPM = \DB::select("SELECT cod_m,nombre FROM pdes_metas GROUP BY cod_m,nombre ORDER BY cod_m ASC");
    $setPR = \DB::select("SELECT * FROM pdes_resultados ORDER BY cod_r ASC");

    $setOO = \DB::select("SELECT cod_o,nombre  FROM ods_objetivos ORDER BY length(cod_o),cod_o ASC");
    $setOM = \DB::select("SELECT cod_m,nombre  FROM ods_metas GROUP BY cod_m,nombre ORDER BY length(cod_m),cod_m ASC");
    $setOI = \DB::select("SELECT cod_i,nombre  FROM ods_indicadores GROUP BY cod_i,nombre ORDER BY length(cod_i),cod_i ASC");


    $route = \Request::path();
    $route=explode("/",$route);
    if($route[1] == "adminIndicador"){ $filtData = 0; }else{ $filtData = 1;}
    return view('SistemaRemi.admin-indicador',compact('tipos',
    'unidades','frecuencia','fuente_datos','fuente_tipos',
    'dimensiones','relacop','etapas','estado','brechaDatos',
    'brechaMetodologia','brechaCapacitacion','brechaFinanciamiento',
    'instituciones','filtData','estados','setPP','setPM','setPR',
    'setOO','setOM','setOI'));
  }

  public function adminIndicadorEntidad()
  {
    $relacop = RelacionOdsPdes::get();
    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    //$variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::where('activo', true)->get();
    $fuente_tipos = FuenteTipos::get();
    return view('SistemaRemi.admin-indicador-ent',compact('tipos','unidades','frecuencia','fuente_datos','fuente_tipos','dimensiones','relacop'));
  }

  public function setDataPdes(Request $request)
  {
    try{
        $sql = \DB::select("SELECT  *
                            FROM pdes_vista_catalogo_pmr
                            where cod_p = ".$request->p."
                            AND cod_m = ".$request->m."
                            AND cod_r = '".$request->r."'");

        if($sql){
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se recupero datos con exito.",
              'set' => $sql)
          );
        }else{
          return \Response::json(array(
              'error' => true,
              'title' => "Alerta!",
              'msg' => "No existe la articulación solicitada.",
              'set' => "")
          );
        }
    }
    catch (Exception $e) {
        return \Response::json(array(
          'error' => true,
          'title' => "Error!",
          'msg' => $e->getMessage())
        );
    }

  }


  public function setDataODS(Request $request)
  {
    try{
        $sql = \DB::select("SELECT  *
                            FROM ods_vista_catalogo_omi
                            where cod_o = cast(".$request->o." as varchar)
                            AND cod_m = '".$request->m."'
                            AND cod_i = cast(".$request->i." as varchar)");
                            // AND cod_m = cast(".$request->m." as varchar)
        if($sql){
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se recupero datos con exito.",
              'set' => $sql)
          );
        }else{
          return \Response::json(array(
              'error' => true,
              'title' => "Alerta!",
              'msg' => "No existe la articulación solicitada.",
              'set' => "")
          );
        }
    }
    catch (Exception $e) {
        return \Response::json(array(
          'error' => true,
          'title' => "Error!",
          'msg' => $e->getMessage())
        );
    }

  }

  public function apiSetIndicadores(Request $request)
  {
      $indicadores = "";

      $user = \Auth::user();
      $id=$user->id;
      $id_rol=$user->id_rol;
      if($request->filter > 0){
        $indicadores = \DB::select("SELECT *,
                                     (
                                       SELECT string_agg(DISTINCT ('- '||denominacion),'<br/>')
                                       FROM remi_indicadores_sectores s
                                       INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                                       WHERE id_indicador = fuente.id
                                       AND activo = TRUE
                                       GROUP BY id_indicador
                                       ORDER BY id_indicador ASC
                                     ) as sectores,
                                     (
                                       SELECT
                                         CASE
                                           WHEN COUNT(DISTINCT s.id_institucion)>1 THEN 'Si'
                                           ELSE 'No'
                                         END
                                         AS res
                                       FROM remi_indicadores_sectores s
                                       INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                                       WHERE id_indicador = fuente.id
                                       AND activo = TRUE
                                     ) as compartido,
                                     (
                                       SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ')
                                       FROM remi_indicador_pdes_resultado pr
                                       INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado
                                       WHERE pr.id_indicador = fuente.id
                                       GROUP BY pr.id_indicador
                                     ) as pdes,
                                     (
                                       SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ')
                                       FROM remi_indicador_ods_indicador oi
                                       INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador
                                       WHERE oi.id_indicador_ods = fuente.id
                                       GROUP BY oi.id_indicador_ods
                                     ) as ods
                                     FROM(
                                        SELECT i.*,ins.denominacion,es.nombre as estado_desc,LPAD(i.id::text, 4, '0') as codigo_id
                                        FROM remi_indicadores i
                                        INNER JOIN remi_indicadores_sectores ise ON (i.id = ise.id_indicador AND ise.activo = true)
                                        INNER JOIN pip_instituciones ins ON ise.id_institucion = ins.id
                                        INNER JOIN remi_estados es ON i.estado = es.id
                                        WHERE i.activo = true
                                        AND ise.id_institucion = ?
                                        ORDER BY nombre ASC
                                     ) as fuente",[$user->id_institucion]);
      } else  {
         $indicadores = \DB::select("SELECT *,
                                      (
                                      	SELECT string_agg(DISTINCT ('- '||denominacion),'<br/>')
                                      	FROM remi_indicadores_sectores s
                                      	INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                                      	WHERE id_indicador = fuente.id
                                      	AND activo = TRUE
                                      	GROUP BY id_indicador
                                      	ORDER BY id_indicador ASC
                                      ) as sectores,
                                      (
                                      	SELECT
                                      		CASE
                                      			WHEN COUNT(DISTINCT s.id_institucion)>1 THEN 'Si'
                                      			ELSE 'No'
                                      		END
                                      		AS res
                                      	FROM remi_indicadores_sectores s
                                      	INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                                      	WHERE id_indicador = fuente.id
                                      	AND activo = TRUE
                                      ) as compartido,
                                      (
                                      	SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ')
                                      	FROM remi_indicador_pdes_resultado pr
                                      	INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado
                                      	WHERE pr.id_indicador = fuente.id
                                      	GROUP BY pr.id_indicador
                                      ) as pdes,
                                      (
                                      	SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ')
                                      	FROM remi_indicador_ods_indicador oi
                                      	INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador
                                      	WHERE oi.id_indicador_ods = fuente.id
                                      	GROUP BY oi.id_indicador_ods
                                      ) as ods
                                      FROM(
                                        SELECT i.*, es.nombre as estado_desc,LPAD(i.id::text, 4, '0') as codigo_id
                                        FROM remi_indicadores i
                                        INNER JOIN remi_estados es ON i.estado = es.id
                                        WHERE activo = TRUE
                                        ORDER BY i.id ASC
                                      ) as fuente");
      }
      //'codigo' => str_pad($item->id, 4, "0", STR_PAD_LEFT),
      return \Response::json($indicadores);
  }


  public function apiFiltroGrid(Request $request)
  {
      $indicadores = "";

      $user = \Auth::user();
      $id=$user->id;
      $id_rol=$user->id_rol;

      $estado = "";
      $compartidos = "";
      $tipo = "";
      $sector = "";
      $pedes_p = "";
      $pedes_m = "";
      $pedes_r = "";
      $where = "";

       if($request->fil_estados != 0){
          $where .="AND tabla.estado = '".$request->fil_estados."' ";
       }
       if($request->fil_compartidos != '0'){
          $where .="AND tabla.compartido = '".$request->fil_compartidos."' ";
       }
       if($request->fil_tipos != '0'){
          $where .="AND tabla.tipo = '".$request->fil_tipos."' ";
       }
       if($request->fil_sectores != ''){
          $where.="AND(";
          foreach ($request->fil_sectores as $key=>$value) {
            if($key==0)
            $where .="tabla.sectores_id LIKE '".$value."' ";
            else
            $where .="OR tabla.sectores_id LIKE '".$value."' ";

            $where .="OR tabla.sectores_id LIKE '%,".$value.",%' ";
            $where .="OR tabla.sectores_id LIKE '%,".$value."' ";
            $where .="OR tabla.sectores_id LIKE '".$value.",%'";
          }
          $where.=")";
       }
       if($request->fil_pdes_pilar != ''){
          $where.="AND(";
          foreach ($request->fil_pdes_pilar as $key=>$value) {
            if($key==0)
            $where .="tabla.pdes_p LIKE '".$value."' ";
            else
            $where .="OR tabla.pdes_p LIKE '".$value."' ";

            $where .="OR tabla.pdes_p LIKE '%,".$value.",%' ";
            $where .="OR tabla.pdes_p LIKE '%,".$value."' ";
            $where .="OR tabla.pdes_p LIKE '".$value.",%'";
          }
          $where.=")";
       }
       if($request->fil_pdes_meta != ''){
          $where.="AND(";
          foreach ($request->fil_pdes_meta as $key=>$value) {
            if($key==0)
            $where .="tabla.pdes_m LIKE '".$value."' ";
            else
            $where .="OR tabla.pdes_m LIKE '".$value."' ";

            $where .="OR tabla.pdes_m LIKE '%,".$value.",%' ";
            $where .="OR tabla.pdes_m LIKE '%,".$value."' ";
            $where .="OR tabla.pdes_m LIKE '".$value.",%'";
          }
          $where.=")";
       }
       if($request->fil_pdes_resultado != ''){
          $where.="AND(";
          foreach ($request->fil_pdes_resultado as $key=>$value) {
            if($key==0)
            $where .="tabla.pdes_r LIKE '".$value."' ";
            else
            $where .="OR tabla.pdes_r LIKE '".$value."' ";

            $where .="OR tabla.pdes_r LIKE '%,".$value.",%' ";
            $where .="OR tabla.pdes_r LIKE '%,".$value."' ";
            $where .="OR tabla.pdes_r LIKE '".$value.",%'";
          }
          $where.=")";
       }

       if($request->fil_ods_objetivo != ''){
          $where.="AND(";
          foreach ($request->fil_ods_objetivo as $key=>$value) {
            if($key==0)
            $where .="tabla.ods_o LIKE '".$value."' ";
            else
            $where .="OR tabla.ods_o LIKE '".$value."' ";

            $where .="OR tabla.ods_o LIKE '%,".$value.",%' ";
            $where .="OR tabla.ods_o LIKE '%,".$value."' ";
            $where .="OR tabla.ods_o LIKE '".$value.",%'";
          }
          $where.=")";
       }

       if($request->fil_ods_meta != ''){
          $where.="AND(";
          foreach ($request->fil_ods_meta as $key=>$value) {
            if($key==0)
            $where .="tabla.ods_m LIKE '".$value."' ";
            else
            $where .="OR tabla.ods_m LIKE '".$value."' ";

            $where .="OR tabla.ods_m LIKE '%,".$value.",%' ";
            $where .="OR tabla.ods_m LIKE '%,".$value."' ";
            $where .="OR tabla.ods_m LIKE '".$value.",%'";
          }
          $where.=")";
       }

       if($request->fil_ods_indicador != ''){
          $where.="AND(";
          foreach ($request->fil_ods_indicador as $key=>$value) {
            if($key==0)
            $where .="tabla.ods_i LIKE '".$value."' ";
            else
            $where .="OR tabla.ods_i LIKE '".$value."' ";

            $where .="OR tabla.ods_i LIKE '%,".$value.",%' ";
            $where .="OR tabla.ods_i LIKE '%,".$value."' ";
            $where .="OR tabla.ods_i LIKE '".$value.",%'";
          }
          $where.=")";
       }

      if($request->filter > 0){
        $sql = "SELECT *
                FROM (
                  SELECT *,
                   (
                     SELECT string_agg(DISTINCT ('- '||denominacion),'<br/>') FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                     WHERE id_indicador = fuente.id AND activo = TRUE GROUP BY id_indicador ORDER BY id_indicador ASC
                   ) as sectores,
                   (
                     SELECT string_agg(DISTINCT i.id::text,',') FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                     WHERE id_indicador = fuente.id AND activo = TRUE GROUP BY id_indicador ORDER BY id_indicador ASC
                   ) as sectores_id,
                   (
                     SELECT CASE WHEN COUNT(DISTINCT s.id_institucion)>1 THEN 'Si' ELSE 'No' END AS res
                     FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id WHERE id_indicador = fuente.id AND activo = TRUE
                   ) as compartido,
                   (
                     SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ') FROM remi_indicador_pdes_resultado pr
                     INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                   ) as pdes,
                   (
                   SELECT string_agg(DISTINCT c.cod_p::text,',') FROM remi_indicador_pdes_resultado pr
                   INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                   ) as pdes_p,
                   (
                   SELECT string_agg(DISTINCT c.cod_m::text,',') FROM remi_indicador_pdes_resultado pr
                   INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                   ) as pdes_m,
                   (
                   SELECT string_agg(DISTINCT c.cod_r::text,',') FROM remi_indicador_pdes_resultado pr
                   INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                   ) as pdes_r,
                   (
                     SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ') FROM remi_indicador_ods_indicador oi
                     INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                   ) as ods,
                   (
                			SELECT string_agg(DISTINCT c.cod_o,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_o,
                		(
                			SELECT string_agg(DISTINCT c.cod_m,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_m,
                		(
                			SELECT string_agg(DISTINCT c.cod_i,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_i
                   FROM(
                      SELECT i.*,ins.denominacion,es.nombre as estado_desc,LPAD(i.id::text, 4, '0') as codigo_id
                      FROM remi_indicadores i
                      INNER JOIN remi_indicadores_sectores ise ON (i.id = ise.id_indicador AND ise.activo = true)
                      INNER JOIN pip_instituciones ins ON ise.id_institucion = ins.id
                      INNER JOIN remi_estados es ON i.estado = es.id
                      WHERE i.activo = true
                      AND ise.id_institucion = ".$user->id_institucion."
                      ORDER BY nombre ASC
                   ) as fuente
                 ) as tabla
                 WHERE 1=1
                 ".$where;
      } else  {
         $sql = "SELECT *
                 FROM (
                   SELECT *,
                    (
                    	SELECT string_agg(DISTINCT ('- '||denominacion),'<br/>') FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                    	WHERE id_indicador = fuente.id AND activo = TRUE GROUP BY id_indicador ORDER BY id_indicador ASC
                    ) as sectores,
                    (
                			SELECT string_agg(DISTINCT i.id::text,',') FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id
                			WHERE id_indicador = fuente.id AND activo = TRUE GROUP BY id_indicador ORDER BY id_indicador ASC
                		) as sectores_id,
                    (
                    	SELECT CASE WHEN COUNT(DISTINCT s.id_institucion)>1 THEN 'Si' ELSE 'No' END AS res
                    	FROM remi_indicadores_sectores s INNER JOIN pip_instituciones i ON s.id_institucion = i.id WHERE id_indicador = fuente.id AND activo = TRUE
                    ) as compartido,
                    (
                    	SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ') FROM remi_indicador_pdes_resultado pr
                    	INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                    ) as pdes,
                    (
                		SELECT string_agg(DISTINCT c.cod_p::text,',') FROM remi_indicador_pdes_resultado pr
                		INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                		) as pdes_p,
                		(
                		SELECT string_agg(DISTINCT c.cod_m::text,',') FROM remi_indicador_pdes_resultado pr
                		INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                		) as pdes_m,
                		(
                		SELECT string_agg(DISTINCT c.cod_r::text,',') FROM remi_indicador_pdes_resultado pr
                		INNER JOIN pdes_vista_catalogo_pmr c ON pr.id_resultado = c.id_resultado WHERE pr.id_indicador = fuente.id GROUP BY pr.id_indicador
                		) as pdes_r,
                    (
                    	SELECT string_agg(DISTINCT ('- '||c.codigo),' <br/> ') FROM remi_indicador_ods_indicador oi
                    	INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                    ) as ods,
                    (
                			SELECT string_agg(DISTINCT c.cod_o,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_o,
                		(
                			SELECT string_agg(DISTINCT c.cod_m,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_m,
                		(
                			SELECT string_agg(DISTINCT c.cod_i,',') FROM remi_indicador_ods_indicador oi
                			INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador WHERE oi.id_indicador_ods = fuente.id GROUP BY oi.id_indicador_ods
                		) as ods_i
                    FROM(
                      SELECT i.*, es.nombre as estado_desc,LPAD(i.id::text, 4, '0') as codigo_id FROM remi_indicadores i
                      INNER JOIN remi_estados es ON i.estado = es.id WHERE activo = TRUE ORDER BY i.id ASC
                    ) as fuente
                  ) as tabla
                  WHERE 1=1
                  ".$where;
      }
      $indicadores = \DB::select($sql);
      //'codigo' => str_pad($item->id, 4, "0", STR_PAD_LEFT),
      return \Response::json($indicadores);
  }


  public function apiSaveIndicador(Request $request)
  {
    $this->user= \Auth::user();

    $codigo = "";
    if(!$request->id_indicador){
       // dd($request->resultado_articulado[0]);
        if(isset($request->resultado_articulado)){
            $vistaPmr = VistaCatalogoPdespmr::where('id_resultado',$request->resultado_articulado[0])->first();
            $codigo = $vistaPmr->codigo_ext.($vistaPmr->correlativo_indicador+1);

            $resultado = Resultados::find($vistaPmr->id_resultado);
            $resultado->correlativo_indicador = ($vistaPmr->correlativo_indicador+1);//dd("DDDDD",$vistaPmr);
            $resultado->save();

        }
        if(isset($request->resultado_articuladods)){
          $vistaOds = VistaCatalogoODSods::where('id_indicador',$request->resultado_articuladods[0])->first();
          //$codig_ods = $vistaOds->codigo_ext_ods.($vistaOds->correlativo_indicador_ods+1);
        }

        try{
           // dd("Holasd");
           // dd("GGGHGHGHGHH",$request->id_indicador);
            $indicador = new Indicadores();
            $indicador->codigo = $codigo;
          //  $indicador->codig_ods = $codig_ods;
            $indicador->nombre = $request->nombre; // 1
            $indicador->etapa = $request->etapa; //2
            $indicador->tipo = $request->tipo;  //3
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->variables_desagregacion = $request->variables_desagregacion;  //8
            $indicador->desagregacion_sexo = $request->has('desagregacion_sexo');
            $indicador->desagregacion_edad = $request->has('desagregacion_edad');
            $indicador->desagregacion_nac = $request->has('desagregacion_nac');
            $indicador->desagregacion_deptal = $request->has('desagregacion_deptal');
            $indicador->desagregacion_munic = $request->has('desagregacion_munic');



            $indicador->unidad_medida = $request->unidad_medida; //4
            $indicador->frecuencia = $request->frecuencia;  //5
            $indicador->definicion = $request->definicion;  //6

          /*  $indicador->formula = $request->formula;
            $indicador->numerador_detalle = $request->numerador_detalle;
            $indicador->numerador_fuente = $request->numerador_fuente;
            $indicador->denominador_detalle = $request->denominador_detalle;
            $indicador->denominador_fuente = $request->denominador_fuente;  */

            $indicador->serie_disponible = $request->serie_disponible;   //7
            $indicador->observacion = $request->observacion;
            $indicador->asistencia_tec = $request->asistencia;
            $indicador->form_activo = $request->tap_next;
            $indicador->estado = 1;
            $indicador->logo = "default.png";
            $indicador->id_user = $this->user->id;
            $dia = null;  //
            $mes = null;  //
            $anio = null;
            $fechaLB =null;
            $fechaLBF =null;

            // if($request->linea_base_fecha){  //
            //   list ($dia ,$mes, $anio ) = explode ( "/", $request->linea_base_fecha );  ///
            //   //$dia = date('t', mktime(0,0,0, $mes, 1, $anio));   ///
      		  //   $fechaLB = $anio . "-" . $mes . "-" . $dia;    ///
            // }
            //
            // $indicador->linea_base_fecha = $fechaLB;  // 9
            // $indicador->linea_base_anio = $anio;  // 10
            // $indicador->linea_base_mes = $mes;  //11
            // $indicador->linea_base_dia = $dia;  //12

            $indicador->linea_base_dia = $request->base_linea_dia;
            $indicador->linea_base_mes = $request->base_linea_mes;
            $indicador->linea_base_anio = $request->base_linea_anio;
            if((int)$request->base_linea_dia!=0){
                $fechaLBF = $request->base_linea_anio . "-" . $request->base_linea_mes . "-" . $request->base_linea_dia;
                //dd("concatfecj",$fechaLBF);
                $indicador->linea_base_fecha = date("Y-m-d", strtotime($fechaLBF));
            }else{
                $indicador->linea_base_fecha = null;
            }
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;  //13
            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;
            $indicador->fuente_datos_d = ($request->fuente_datos_d)?implode(",", $request->fuente_datos_d):null;

            $indicador->brecha_datos = $request->brecha_datos;
            $indicador->brecha_metodologia = $request->brecha_metodologia;
            $indicador->brecha_capacitacion = $request->brecha_capacitacion;
            $indicador->brecha_financiamiento = $request->brecha_financiamiento;
            $indicador->activo = true;
            $indicador->save();

            $id_reg = $indicador->id;

            // $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            // for($i=1; $i <= count($metasList); $i++){
            //     $metas = new Metas();
            //     $metas->id_indicador = $indicador->id;
            //     $metas->gestion = $metasList[$i];
            //     $metas->valor = ($request->input('meta_'.$metasList[$i]))?$this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
            //     $metas->id_user = $this->user->id;
            //     $metas->save();
            // }

            if(isset($request->resultado_articulado)){
              foreach ($request->resultado_articulado as $k => $v) {
                    $indicadorPdes = new IndicadorResultado();
                    $indicadorPdes->id_indicador = $indicador->id;
                    $indicadorPdes->id_resultado = $request->resultado_articulado[$k];
                    $indicadorPdes->id_user = $this->user->id;
                    $indicadorPdes->activo = true;
                    $indicadorPdes->save();
              }
            }

            if(isset($request->resultado_articuladods)){
              foreach ($request->resultado_articuladods as $k => $v) {
                    $indicadorOds = new IndicadorResultado_Ods();
                    $indicadorOds->id_indicador_ods = $indicador->id;
                    $indicadorOds->comparabilidad_ods_pdes = $request->relac;
                    $indicadorOds->id_resultado_ods = $request->resultado_articuladods[$k];
                    $indicadorOds->id_user = $this->user->id;
                    $indicadorOds->activo = true;
                    $indicadorOds->save();
              }
            }

            $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = new Metas();
                $metas->id_indicador = $indicador->id;
                $metas->gestion = $metasList[$i]; //dd($metas->id_indicador);
                $metas->valor = ($request->input('meta_'.$metasList[$i]))?$this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
                $metas->id_user = $this->user->id;
                $metas->save();
            }
            //dd("sdfssdf");
            if(isset($request->avance_fecha)){
              foreach ($request->avance_fecha as $k => $v) {
                    $avance = new IndicadorAvance();
                    $avance->id_indicador = $indicador->id;
                    $fechaAV="";


                    // if($request->avance_fecha[$k]){
                    //   list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                    //   $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
              		  //   $fechaAV = $anio . "-" . $mes . "-" . $dia;
                    // }
                    if($request->avance_fecha[$k]){
                        if(strlen($request->avance_fecha[$k])==7){
                            list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                            $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
                            $fechaAV = $anio . "-" . $mes . "-" . $dia;
                            $avance->avance_fecha_tam = 7;
                        }else{
                            list ($dia, $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                            $fechaAV = $anio . "-" . $mes . "-" . $dia;
                            $avance->avance_fecha_tam = 10;
                        }
                    }


                    $avance->fecha_generado = $fechaAV;
                    $avance->fecha_generado_dia = $dia;
                    $avance->fecha_generado_mes = $mes;
                    $avance->fecha_generado_anio = $anio;
                    $avance->fecha_reportado = date('Y-m-d');
                    $avance->valor =  ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
                    $avance->detalle_avance =  $request->avance_detalle[$k];
                    $avance->id_user = $this->user->id;
                    //$avance->save();
              }
            }

          if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    $archivos = new IndicadoresArchivosRespaldos();
                    $archivos->id_indicador = $indicador->id;
                    $archivos->nombre =  $request->arc_nombre[$k];
                    $archivos->archivo = $request->arc_archivo[$k];
                    $archivos->activo = true;
                    $archivos->id_user = $this->user->id;
                   // $archivos->save();
              }
            }

            $sector = new IndicadorSector();
            $sector->id_indicador = $indicador->id;
            $sector->id_institucion = $this->user->id_institucion;
            $sector->activo = true;
            $sector->id_user_updated = $this->user->id;
            $sector->save();



            return \Response::json(array(
                'error' => false,
                'id_indicador'=>$id_reg,//---------------aqui
                'title' => "Success!",
                'msg' => "Se guardo con exito.")
            );

          }  // fin del try
          catch (Exception $e) {
              return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
          }
      }else{


        try{
           // dd("GWWWWWWWWWDDDSDDF",$request->id_indicador);
            $indicador = Indicadores::find($request->id_indicador);//dd("SSDSDAD",$indicador);
            if($indicador->codigo == ""){
              if(isset($request->resultado_articulado)){
                  $vistaPmr = VistaCatalogoPdespmr::where('id_resultado',$request->resultado_articulado[0])->first();
                  //$codigo = $vistaPmr->codigo_ext.($vistaPmr->correlativo_indicador+1);

                  $vistaOds = VistaCatalogoODSods::where('id_indicador',$request->resultado_articuladods[0])->first();
                  //$codig_ods = $vistaOds->codigo_ext_ods.($vistaOds->correlativo_indicador_ods+1);

                  $resultado = Resultados::find($vistaPmr->id_resultado);
                  $resultado->correlativo_indicador = ($vistaPmr->correlativo_indicador+1);
                  //$resultado->save();
              }
              $indicador->codigo = $codigo;
              $indicador->codig_ods = $codig_ods;
            }

            $indicador->nombre = $request->nombre;
            $indicador->estado = $request->estado_indicador;
            $indicador->etapa = $request->etapa;
            $indicador->tipo = $request->tipo;
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->variables_desagregacion = $request->variables_desagregacion;
            $indicador->desagregacion_sexo = $request->has('desagregacion_sexo');
            $indicador->desagregacion_edad = $request->has('desagregacion_edad');
            $indicador->desagregacion_nac = $request->has('desagregacion_nac');
            $indicador->desagregacion_deptal = $request->has('desagregacion_deptal');
            $indicador->desagregacion_munic = $request->has('desagregacion_munic');

            $indicador->unidad_medida = $request->unidad_medida;
            $indicador->frecuencia = $request->frecuencia;
            $indicador->definicion = $request->definicion;

            $indicador->formula = $request->formula;
            $indicador->numerador_detalle = $request->numerador_detalle;
            $indicador->numerador_fuente = $request->numerador_fuente;
            $indicador->denominador_detalle = $request->denominador_detalle;
            $indicador->denominador_fuente = $request->denominador_fuente;

            $indicador->serie_disponible = $request->serie_disponible;
            $indicador->observacion = $request->observacion;
            $indicador->asistencia_tec = $request->asistencia;

            if($request->tap_next<$indicador->form_activo){
              //$fuente->form_activo = $request->form_activo;
                $j=1;
            }
            else {
                $indicador->form_activo = $request->tap_next;
            }

            $indicador->logo = "default.png";
            $indicador->id_user_updated = $this->user->id;
            $dia = null;
            $mes = null;
            $anio = null;
            $fechaLB =null;
            $fechaLBF =null;


            // if($request->linea_base_fecha){
            //   list ($dia, $mes, $anio ) = explode ( "/", $request->linea_base_fecha );
            //   //$dia = date('t', mktime(0,0,0, $mes, 1, $anio));
            //   $fechaLB = $anio . "-" . $mes . "-" . $dia;
            // }
            // $indicador->linea_base_fecha = $fechaLB;
            // $indicador->linea_base_anio = $anio;
            // $indicador->linea_base_mes = $mes;
            // $indicador->linea_base_dia = $dia;

            $indicador->linea_base_dia = $request->base_linea_dia;
            $indicador->linea_base_mes = $request->base_linea_mes;
            $indicador->linea_base_anio = $request->base_linea_anio;
            if((int)$request->base_linea_dia!=0){
                $fechaLBF = $request->base_linea_anio . "-" . $request->base_linea_mes . "-" . $request->base_linea_dia;
                //dd("concatfecj",$fechaLBF);
                $indicador->linea_base_fecha = date("Y-m-d", strtotime($fechaLBF));
            }else{
                $indicador->linea_base_fecha = null;
            }
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;





            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;
            $indicador->fuente_datos_d = ($request->fuente_datos_d)?implode(",", $request->fuente_datos_d):null;
            $indicador->brecha_datos = $request->brecha_datos;
            $indicador->brecha_metodologia = $request->brecha_metodologia;
            $indicador->brecha_capacitacion = $request->brecha_capacitacion;
            $indicador->brecha_financiamiento = $request->brecha_financiamiento;
            $indicador->save();


            if(isset($request->resultado_articulado)){
              foreach ($request->resultado_articulado as $k => $v) {

                    if(!$request->id_resultado_articulado[$k]){
                        $indicadorPdes = new IndicadorResultado();
                        $indicadorPdes->id_indicador = $indicador->id;
                        $indicadorPdes->id_resultado = $request->resultado_articulado[$k];
                        $indicadorPdes->id_user = $this->user->id;
                        $indicadorPdes->activo = true;
                        $indicadorPdes->save();
                    }else{
                      //dd("esta:".$request->estado_resultado_articulado[$k]."resultado:".$request->resultado_articulado[$k]."id:".$request->id_resultado_articulado[$k]);
                        if($request->estado_resultado_articulado[$k]==0){
                          $indicadorPdes = IndicadorResultado::find($request->id_resultado_articulado[$k]);
                          $indicadorPdes->id_user_updated = $this->user->id;
                          //$indicadorPdes->save();
                          $indicadorPdes->delete();
                        }
                    }
              }
            }

            if(isset($request->resultado_articuladods)){
              foreach ($request->resultado_articuladods as $k => $v) {
                    if(!$request->id_resultado_articuladods[$k]){
                        $indicadorOds = new IndicadorResultado_Ods();
                        $indicadorOds->id_indicador_ods = $indicador->id;
                        $indicadorOds->comparabilidad_ods_pdes = $request->relac;
                        $indicadorOds->id_resultado_ods = $request->resultado_articuladods[$k];
                        $indicadorOds->id_user = $this->user->id;
                        $indicadorOds->activo = true;
                        $indicadorOds->save();
                    }else{
                        if($request->estado_resultado_articuladods[$k]==0){
                          $indicadorOds = IndicadorResultado_Ods::find($request->id_resultado_articuladods[$k]);
                          $indicadorOds->id_user_updated = $this->user->id;
                          //$indicadorOds->save();
                          $indicadorOds->delete();
                        }
                    }
              }
            }


            if(isset($request->avance_fecha)){
              foreach ($request->avance_fecha as $k => $v) {
                  if(!$request->id_avance[$k]){
                        $avance = new IndicadorAvance();
                        $avance->id_indicador = $indicador->id;
                        $fechaAV="";
                        // if($request->avance_fecha[$k]){
                        //   list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                        //   $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
                  		  //   $fechaAV = $anio . "-" . $mes . "-" . $dia;
                        // }
                        if($request->avance_fecha[$k]){
                            if(strlen($request->avance_fecha[$k])==7){
                                list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                                $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
                                $fechaAV = $anio . "-" . $mes . "-" . $dia;
                                $avance->avance_fecha_tam = 7;
                            }else{
                                list ($dia, $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                                $fechaAV = $anio . "-" . $mes . "-" . $dia;
                                $avance->avance_fecha_tam = 10;
                            }
                        }
                        $avance->fecha_generado = $fechaAV;
                        $avance->fecha_generado_dia = $dia;
                        $avance->fecha_generado_mes = $mes;
                        $avance->fecha_generado_anio = $anio;
                        $avance->fecha_reportado = date('Y-m-d');
                        $avance->valor = ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
                        $avance->detalle_avance =  $request->avance_detalle[$k];
                        $avance->id_user = $this->user->id;
                        $avance->save();
                   }else{
                        if($request->avance_estado[$k]==0){
                          $avance = IndicadorAvance::find($request->id_avance[$k]);
                          $avance->id_user_updated = $this->user->id;
                          //$avance->save();
                          $avance->delete();
                        }
                   }
              }
            }



            // \DB::table('remi_indicadores_sectores')->where('id_indicador', $indicador->id)->update(['activo' => false]);
            \DB::table('remi_indicadores_sectores')->where('id_indicador', $indicador->id)->delete();
            if(isset($request->sectores)){

              foreach ($request->sectores as $k => $v) {
                        $sector = new IndicadorSector();
                        $sector->id_indicador = $indicador->id;
                        $sector->id_institucion = $v;
                        $sector->activo = true;
                        $sector->id_user_updated = $this->user->id;
                        $sector->save();
              }
            }


            // $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            // for($i=1; $i <= count($metasList); $i++){
            //     $metas = new Metas();
            //     $metas->id_indicador = $indicador->id;
            //     $metas->gestion = $metasList[$i];
            //     $metas->valor = ($request->input('meta_'.$metasList[$i]))?$this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
            //     $metas->id_user = $this->user->id;
            //     $metas->save();
            // }

            $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);

            //dd("QQ",$request->input('id_meta_'.$metasList[1]));
            if($request->input('id_meta_2016')!=null){
               //dd("QQ",$request->input('id_meta_'.$metasList[1]));
              for($i=1; $i <= count($metasList); $i++){
                  $metas = Metas::find($request->input('id_meta_'.$metasList[$i]));//dd("QQ",$indicador->$request->input('id_meta_'.$metasList[$i]));
                  $metas->valor = ($request->input('meta_'.$metasList[$i]))? $this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0; //dd($metas->valor);
                  $metas->id_user_updated = $this->user->id;
                  $metas->save();
              }
            }else{

            for($i=1; $i <= count($metasList); $i++){
                $metas = new Metas();
                $metas->id_indicador = $indicador->id;
                $metas->gestion = $metasList[$i];
                $metas->valor = ($request->input('meta_'.$metasList[$i]))?$this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
                $metas->id_user = $this->user->id;
                $metas->save();
              }

            }


           // dd("SDXCZXVXVB",$request->arc_archivo);
            // if(isset($request->arc_archivo)){
            //   foreach ($request->arc_archivo as $k => $v) {
            //     //dd("SDXCZXVXVB",$request->arc_estado[$k]);
            //         // if( $v == 2){dd("SDXCZXVXVB",$request->arc_id[$k]);}
            //         // else { $v=$v+1; }
            //         if(!$request->arc_id[$k]){
            //             $archivos = new IndicadoresArchivosRespaldos();
            //             $archivos->id_indicador = $indicador->id;
            //             $archivos->nombre =  $request->arc_nombre[$k];
            //             $archivos->archivo = $request->arc_archivo[$k];
            //             $archivos->activo = true;
            //             $archivos->id_user = $this->user->id;
            //             $archivos->save();
            //         }else{
            //             if($request->arc_estado[$k]==0){
            //               $archivos = IndicadoresArchivosRespaldos::find($request->arc_id[$k]);
            //               $archivos->activo = false;
            //               $archivos->id_user_updated = $this->user->id;
            //               $archivos->save();
            //             }
            //         }
            //   }
            // }

           // dd("fsdf",$request->arc_edad[0]);
          if(isset($request->arc_archivo_s)){
              foreach ($request->arc_archivo_s as $k => $v) {

                    if(!$request->arc_id_s[$k]){
                        $archivos = new IndicadoresVariables();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->id_variable = $request->arc_sexo[$k];
                        $archivos->nombre =  $request->arc_nombre_s[$k];
                        $archivos->archivo = $request->arc_archivo_s[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado_s[$k]==0){
                          $archivos = IndicadoresVariables::find($request->arc_id_s[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
              }
            }

            if(isset($request->arc_archivo_e)){
              foreach ($request->arc_archivo_e as $k => $v) {
                    if(!$request->arc_id_e[$k]){
                        $archivos = new IndicadoresVariables();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->id_variable = $request->arc_edad[$k];
                        $archivos->nombre =  $request->arc_nombre_e[$k];
                        $archivos->archivo = $request->arc_archivo_e[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado_e[$k]==0){
                          $archivos = IndicadoresVariables::find($request->arc_id_e[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
              }
            }


            if(isset($request->arc_archivo_n)){
              foreach ($request->arc_archivo_n as $k => $v) {
                    if(!$request->arc_id_n[$k]){
                        $archivos = new IndicadoresVariables();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->id_variable = $request->arc_nac[$k];
                        $archivos->nombre =  $request->arc_nombre_n[$k];
                        $archivos->archivo = $request->arc_archivo_n[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado_n[$k]==0){
                          $archivos = IndicadoresVariables::find($request->arc_id_n[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
              }
            }

            if(isset($request->arc_archivo_d)){
              foreach ($request->arc_archivo_d as $k => $v) {
                    if(!$request->arc_id_d[$k]){
                        $archivos = new IndicadoresVariables();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->id_variable = $request->arc_dptal[$k];
                        $archivos->nombre =  $request->arc_nombre_d[$k];
                        $archivos->archivo = $request->arc_archivo_d[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        //dd($request->arc_estado_d[$k]);
                        if($request->arc_estado_d[$k]==0){
                          $archivos = IndicadoresVariables::find($request->arc_id_d[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
              }
            }


            if(isset($request->arc_archivo_m)){
              foreach ($request->arc_archivo_m as $k => $v) {
                    if(!$request->arc_id_m[$k]){
                        $archivos = new IndicadoresVariables();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->id_variable = $request->arc_munic[$k];
                        $archivos->nombre =  $request->arc_nombre_m[$k];
                        $archivos->archivo = $request->arc_archivo_m[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{

                        if($request->arc_estado_m[$k]==0){
                          $archivos = IndicadoresVariables::find($request->arc_id_m[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
              }
            }

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg' => "Se guardo con exito.",
                'id_indicador' => $request->id_indicador)//---------------aqui
            );

          }
          catch (Exception $e) {
              return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
          }
      }
  }


  public function apiDataSetIndicador(Request $request)
  {
      //dd("HJHJHJHJ",$request->id);
      $indicador = Indicadores::where('id',$request->id)->get();
      $pdes = \DB::select("SELECT c.*,ir.id
                           FROM remi_indicador_pdes_resultado ir
	                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                           WHERE ir.id_indicador = ".$request->id);

      $ods = \DB::select("SELECT c.*,ir.id,ir.comparabilidad_ods_pdes
                           FROM remi_indicador_ods_indicador ir
                           INNER JOIN ods_vista_catalogo_omi c ON ir.id_resultado_ods = c.id_indicador
                           WHERE ir.id_indicador_ods = ".$request->id);

      $indicetapa = \DB::select("SELECT *
                                  from remi_etapas e
                                  where e.nombre ='".$indicador[0]->etapa."'");
      if($indicetapa){
        $descEtapa = $indicetapa[0]->descripcion;
      }else{
        $descEtapa = "";
      }


      $metas = Metas::where('id_indicador',$request->id)->get();
      $avances = IndicadorAvance::where('id_indicador',$request->id)->get();
      $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$request->id)->where('activo', true)->get();
      $archiv_ods = IndicadoresVariables::where('id_indicador',$request->id)->where('activo', true)->get();
      $sectores = IndicadorSector::where('id_indicador',$request->id)->where('activo', true)->get();
      $agrupSectores ='';
      foreach ($sectores as $value) {
        $agrupSectores .= $value->id_institucion."," ;
      }
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'indicador' => $indicador,
          'descripcion_etapa' =>  $descEtapa,
          'pdes' => $pdes,
          'ods' => $ods,
          'metas' => $metas,
          'avances' => $avances,
          'archiv_ods' => $archiv_ods,
          'archivos' => $archivos,
          'sectores' => trim($agrupSectores, ','))
      );
  }

  public function apiDeleteIndicador(Request $request)
  {
      $this->user= \Auth::user();
      $indicador = Indicadores::find($request->id_indicador);
      $indicador->activo = false;
      $indicador->id_user_updated = $this->user->id;
      $indicador->save();

      \DB::table('remi_indicador_pdes_resultado')->where('id_indicador', $indicador->id)->update(['activo' => false]);
      \DB::table('remi_indicador_ods_indicador')->where('id_indicador_ods', $indicador->id)->update(['activo' => false]);
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.")
      );
  }

  public function apiSourceOrderbyArray(Request $request)
  {
      if($request->fechas){
          $array = $request->fechas;

          $orderByAr = Array();
          $i=0;
          foreach ($array as $key => $value) {
            $orderByAr[$i]['index'] = $key;
            list ( $mes, $anio ) = explode ( "/", $value );
            $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $orderByAr[$i]['filtro'] = $fecha;
            $orderByAr[$i]['valor'] = $value;
            $i++;
          }

          $sortArray = array();

          foreach($orderByAr as $validate){
              foreach($validate as $key=>$value){
                  if(!isset($sortArray[$key])){
                      $sortArray[$key] = array();
                  }
                  $sortArray[$key][] = $value;
              }
          }

          $orderby = "filtro"; //change this to whatever key you want from the array
          array_multisort($sortArray[$orderby],SORT_DESC,$orderByAr);
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              'item' =>$orderByAr)
          );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Vacio!",
          'msg' => "la matriz esta vacia.",
          'item' => [] )
      );
    }
  }

  public function ordenar_fecha($a, $b)
  {
     $a = strtotime($a);
     $b = strtotime($b);
     return strcmp($a, $b);
  }

  public function apiSetFuenteDatos(Request $request)
  {

      //$fuenteId = explode(",", $request->fuente);
      if($request->fuente){
      $dataFuente = FuenteDatos::whereIn('id',$request->fuente)->where('activo', true)->get();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'item' =>$dataFuente)
      );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Alert!",
          'msg' => "No se recupero ningun codigo valido.",
          'item' => "")
      );
    }
  }


  public function apiSourceOrderbyArray2(Request $request)
  {
      if($request->responsable1){
          $array = $request->responsable1;

          $orderByAr = Array();
          $i=0;
          foreach ($array as $key => $value) {
            $orderByAr[$i]['index'] = $key;
            $orderByAr[$i]['filtro'] = $value;
            $orderByAr[$i]['valor'] = $value;
            $i++;
          }

          $sortArray = array();

          foreach($orderByAr as $validate){
              foreach($validate as $key=>$value){
                  if(!isset($sortArray[$key])){
                      $sortArray[$key] = array();
                  }
                  $sortArray[$key][] = $value;
              }
          }

          $orderby = "filtro"; //change this to whatever key you want from the array
          array_multisort($sortArray[$orderby],SORT_ASC,$orderByAr);
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              'item' =>$orderByAr)
          );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Vacio!",
          'msg' => "la matriz esta vacia.",
          'item' => [] )
      );
    }
  }

  public function apiSaveFuente(Request $request)
  {
    $this->user= \Auth::user();
    if(!$request->id_fuente){

        try{
            $fuente = new FuenteDatos();
             $fuente->codigo = "";
             $fuente->serie_datos = $request->fd_serie;
             $fuente->nombre = $request->fd_nombre;
             $fuente->tipo = $request->fd_tipo;
             $fuente->activo = true;
             $fuente->estado = 1;
             $fuente->id_user = $this->user->id;
             $fuente->save();

             $fdatos = new FuenteDatosResponsable();
             $fdatos->id_fuente = $fuente->id;  //   $fdato;
             $fdatos->responsable_nivel_1 = $request->sectorial;
             $fdatos->responsable_nivel_2 = $request->fd_resp_2;
             $fdatos->save();


            /*if(isset($request->responsable_nivel_1)){
              foreach ($request->responsable_nivel_1 as $k => $v) {
                    $responsable = new FuenteDatosResponsable();
                    $responsable->id_fuente = $fuente->id;
                    $responsable->responsable_nivel_1 = $request->responsable_nivel_1[$k];
                    $responsable->responsable_nivel_2 = $request->responsable_nivel_2[$k];
                    $responsable->responsable_nivel_3 = $request->responsable_nivel_3[$k];
                    $responsable->numero_referencia = $request->numero_referencia[$k];
                    $responsable->id_user = $this->user->id;
                    $responsable->save();
              }
            }*/



            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg' => "Se guardo con exito.")
            );

          }
          catch (Exception $e) {
              return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
          }
      }else{

          ///agregar el update

      }
  }

  public function apiUpdateComboFuente(Request $request)
  {
      $dataFuente = FuenteDatos::where('activo', true)->select('id','nombre')->get();
      /*foreach ($dataFuente as $value) {
        $data[$value->id] = $value->nombre;
      }*/
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'item' =>$dataFuente)
      );

  }
  public function setPdes(Request $request)
  {
      $pdes = VistaCatalogoPdespmr::get();
      $html = "";
      foreach ($pdes as $value) {
        $html .= '<tr>
                      <td>P'.$value["cod_p"].'</td>
                      <td>M'.$value["cod_m"].'</td>
                      <td>R'.$value["cod_r"].'</td>
                  </tr>';
      }
      return \Response::json($html);

  }

  public function format_numerica_db($numeric,$decimal){
    if($decimal == '.'){
      $formated = str_replace(',','',$numeric);
    }elseif($decimal == ','){
      $formated = str_replace('.','',$numeric);
      $formated = str_replace(',','.',$formated);
    }else{
      $formated = str_replace(',','',$numeric);
    }
    return $formated;
  }

  public function apiUploadArchivosRespaldos(Request $request)
  {
    //dd("info",$request->arc_nombre_ing);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_sexo )
      {
          $file = $request->arc_archivo_sexo;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_sexo;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_sexo)
        );
      }

  }


  public function apiUploadArchivoRespaldoEdad(Request $request)
  {
    //dd("info",$request->arc_nombre_ing2);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_ing2 )
      {
          $file = $request->arc_archivo_ing2;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_ing2;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_ing2)
        );
      }

  }

  public function apiUploadArchivoRespaldoNac(Request $request)
  {
    //dd("info",$request->arc_nombre_ing2);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_ing_n )
      {
          $file = $request->arc_archivo_ing_n;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_ing_n;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_ing_n)
        );
      }

  }

  public function apiUploadArchivoRespaldoDptal(Request $request)
  {
    //dd("info",$request->arc_nombre_ing2);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_ing_d )
      {
          $file = $request->arc_archivo_ing_d;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_ing_d;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_ing_d)
        );
      }

  }


  public function apiUploadArchivoRespaldoMunic(Request $request)
  {
    //dd("info",$request->arc_nombre_ing2);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_ing_m )
      {
          $file = $request->arc_archivo_ing_m;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_ing_m;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_ing_m)
        );
      }

  }

    public function apiUploadArchivoRespaldoMod(Request $request)
  {
    //dd("info",$request);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_mod )
      {
          $file = $request->arc_archivo_mod;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_mod;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error! XXXXXX",
            'item' => "",
            'msg' => $request->arc_nombre_mod)
        );
      }

  }


    public function apiUploadArchivoRespaldo(Request $request)
  {
    //dd("info",$request);
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_input )
      {
          $file = $request->arc_archivo_input;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('ARC-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_input;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_input)
        );
      }

  }

  public function apiDeleteArchivo(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }
  public function apiDeleteArchivo_s(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }

    public function apiDeleteArchivo_e(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }


      public function apiDeleteArchivo_n(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }


      public function apiDeleteArchivo_d(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }


      public function apiDeleteArchivo_m(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }

  public function generatePdf(Request $request)
  {

    $id = $request->id;
    $indicador = Indicadores::find($id);
    $pdes = \DB::select("SELECT c.*,ir.id
                         FROM remi_indicador_pdes_resultado ir
                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                         WHERE ir.id_indicador = ".$id);
    $ods = \DB::select("SELECT c.*,ir.id,ir.comparabilidad_ods_pdes
                        FROM remi_indicador_ods_indicador ir
                        INNER JOIN ods_vista_catalogo_omi c ON ir.id_resultado_ods = c.id_indicador
                        WHERE ir.id_indicador_ods = ".$id);
    $metas = Metas::where('id_indicador',$id)->orderBy('gestion', 'asc')->get();
    $avance = IndicadorAvance::where('id_indicador',$id)->orderBy('fecha_generado', 'DESC')->first();


    $dataMetasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC
                            LIMIT 5");
    $metasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC");
    $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$id)->where('activo', true)->get();


    //$idFuenteNumerador = explode(",", $indicador->fuente_datos);
    if($indicador->fuente_datos)
    $descFuenteNumerador = \DB::select("SELECT * FROM remi_fuente_datos WHERE id IN (".$indicador->fuente_datos.")");
    else
    $descFuenteNumerador=[];

    if($indicador->fuente_datos_d)
    $descFuenteDenominador = \DB::select("SELECT * FROM remi_fuente_datos WHERE id IN (".$indicador->fuente_datos_d.")");
    else
    $descFuenteDenominador=[];


    $grafica = json_encode($dataMetasAvance);
    $estado_desc = \DB::select("SELECT * FROM remi_estados WHERE id = ".$indicador->estado);
    $estado_desc = $estado_desc[0]->nombre;

    $brechaDatos =  Array('9' =>'',
                          '0' => "Existen Fuentes de Datos con la frecuencia requerida y las variables de desagregación necesarias para reportar el indicador",
                          '1' => "No existen datos para reportar el indicador",
                          '2' => "Existen datos pero no se recopilan con la frecuencia requerida",
                          '3' => "Existen datos pero no se recopilan con las variables de desagregación requeridas",
                          '4' => "Existen datos pero no se recopilan con la frecuencia requerida ni con las variables de desagregación necesarias");
    $brechaMetodologia =  Array('9' =>'',
                          '0' => "Existe metodología nacional adaptada a recomendaciones internacionales",
                          '1' => "No existe Metodología Nacional",
                          '2' => "No Existe Metodología bajo Recomendaciones Internacionales",
                          '3' => "No existe metodología nacional ni bajo recomentaciones internacionales");
    $brechaCapacitacion =  Array('9' =>'',
                          '0' => "Existe personal capacitado",
                          '1' => "No existe Personal permanente para la generación de estadísticas",
                          '2' => "No exite personal capacitado para generar estadísticas",
                          '3' => "No existe personal permanente ni capacitado para generar estadísticas");
    $brechaFinanciamiento = Array('9' =>'',
                            '0' => "Existe financiamiento",
                            '1' => "No se cuenta con financiamiento nacional",
                            '2' => "Sólo se cuenta con financiamiento temporal de la cooperación",
                            '3' => "No se cuenta con financiamiento nacio nal ni internacional ");

    $dataBrechaDatos = $brechaDatos[$indicador->brecha_datos];
    $dataBrechaMetodologia = $brechaMetodologia[$indicador->brecha_metodologia];
    $dataBrechaCapacitacion = $brechaCapacitacion[$indicador->brecha_capacitacion];
    $dataBrechaFinanciamiento = $brechaFinanciamiento[$indicador->brecha_financiamiento];

    $sectores = IndicadorSector::where('id_indicador',$id)->where('activo', true)->get();
    $agrupSectores ='';
    foreach ($sectores as $value) {
      $agrupSectores .= $value->id_institucion."," ;
    }
    $agrupSectores = trim($agrupSectores, ',');
    $sectoresRelacionados = \DB::select("SELECT * FROM pip_instituciones WHERE id IN (".$agrupSectores.")");

    // return view('SistemaRemi.ficha-indicador-pdf',compact('indicador',
    // 'metas','pdes','avance','grafica','metasAvance','archivos','ods','descFuenteNumerador',
    // 'descFuenteDenominador','estado_desc','dataBrechaDatos','dataBrechaMetodologia',
    // 'dataBrechaCapacitacion','dataBrechaFinanciamiento','sectoresRelacionados'));

      $data = [
        'title' => 'Welcome to HDTuto.com',
        'indicador' => $indicador,
        'metas' => $metas,
        'pdes' => $pdes,
        'avance' => $avance,
        'metasAvance' => $metasAvance,
        'ods' => $ods,
        'descFuenteNumerador' => $descFuenteNumerador,
        'descFuenteDenominador' => $descFuenteDenominador,
        'estado_desc' => $estado_desc,
        'dataBrechaDatos' => $dataBrechaDatos,
        'dataBrechaMetodologia' => $dataBrechaMetodologia,
        'dataBrechaCapacitacion' => $dataBrechaCapacitacion,
        'dataBrechaFinanciamiento' => $dataBrechaFinanciamiento,
        'sectoresRelacionados' => $sectoresRelacionados
      ];
      $pdf = PDF::loadView('SistemaRemi/ficha-indicador-pdf', $data);
      return $pdf->download('fichaIndicador.pdf');

  }





}
