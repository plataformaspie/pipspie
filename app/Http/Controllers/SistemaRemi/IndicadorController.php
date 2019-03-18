<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\Variables;
use App\Models\SistemaRemi\IndicadorResultado;
use App\Models\SistemaRemi\Metas;
use App\Models\SistemaRemi\IndicadorAvance;
use App\Models\SistemaRemi\Resultados;
use App\Models\SistemaRemi\VistaCatalogoPdespmr;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\IndicadoresArchivosRespaldos;
use App\Models\SistemaRemi\Usuario;

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

        $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
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
        //flash('Genero editado exitosamente')->success();
        return 'Se actualiza correctamente';  //  redirect()->route('mostrarReg');   //redirect()->route('admin.genero.index');
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
        return view('SistemaRemi.registrar.crear-users'); 
  }

  public function guardarUser(Request $request)
  {
        //dd("dsfsf",$request);
        $user=new Usuario($request->all());
        // dd($request['name']);
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
        $user=Usuario::find($id);
        return view('SistemaRemi.registrar.editar-users')->with('user',$user);
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
        //flash('Genero editado exitosamente')->success();
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


  public function setIndicadores(Request $request)
  {
    //dd("VALORES",$request);
    //$indicadores = Indicadores::paginate();
    $swp=0;    
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

      $filnoment = \DB::select("SELECT nombre_entidad
                                FROM remi_entidad
                                where  codigo_entidad=".$pent." AND activo = true"); 
      $nom_ent=$filnoment[0]->nombre_entidad;
     // dd("nombre:",$uno);
    if($sw > 0){

          $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);

    }else{
          $indicadores = Indicadores::where('activo',true)->paginate(5);
    }

   /* $filindpil = \DB::select("SELECT distinct responsable_nivel_1, activo
                              FROM public.remi_fuente_datos_responsable
                               where activo = true");*/ 
/*
    $filindent = \DB::select("SELECT distinct c.cod_p
                                FROM remi_indicador_pdes_resultado ir
                                INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                                WHERE ir.id_indicador IN (SELECT id_fuente
                                  FROM public.remi_fuente_datos_responsable
                                where cod_entidad IN ( select id from remi_indicadores r
                                where r.fuente_datos IN (SELECT cast(id_fuente as varchar)
                                  FROM public.remi_fuente_datos_responsable
                                where cod_entidad=".$pent.")))");  */                                   

          $filindent = \DB::select("SELECT distinct c.cod_p
                                FROM remi_indicador_pdes_resultado ir
                                INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                                WHERE ir.id_indicador IN (SELECT id_fuente
                                  FROM public.remi_fuente_datos_responsable
                                where cod_entidad=".$pent.") order by c.cod_p");//$swe=2;

    // if($swe==1){
    //       $pdes_new=$filindent[0]->cod_p;
    // }
          // if(empty($pdes_new)){
          //   dd("PILARES1",$pent,$pdes_new);        
          // }   

    if(empty($filindent)){    //   if($swe==1){ 
          $pdes_new=5;$swp=1;         
    }else {
          $pdes_new=$filindent[0]->cod_p;$swp=2;     // esta con datos
    }    

    $filindpil = \DB::select("SELECT  id,codigo_entidad,sigla_entidad,nombre_entidad, activo
                              FROM remi_entidad
                               where activo = true order by id");    


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
    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad','nom_ent','tiposMedicion','unidadesMedidas','buscar','filtropdes','countPilar','totalPilar','totalResPilar','filindpil','filindent','swe','pent','swp'));
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


    $grafica = json_encode($dataMetasAvance);

    return view('SistemaRemi.data-indicador',compact('indicador','metas','pdes','avance','grafica','metasAvance','archivos'));
  }

  public function adminIndicador()
  {
    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    //$variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::where('activo', true)->get();
    $fuente_tipos = FuenteTipos::get();
    return view('SistemaRemi.admin-indicador',compact('tipos','unidades','frecuencia','fuente_datos','fuente_tipos','dimensiones'));
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


  public function apiSetIndicadores(Request $request)
  {
      $indicadores = Indicadores::where('activo',true)->orderBy('id','asc')->get();
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

        try{
           // dd("Holasd");
            $indicador = new Indicadores();
            $indicador->codigo = $codigo;
            $indicador->nombre = $request->nombre; // 1
            $indicador->etapa = $request->etapa; //2
            $indicador->tipo = $request->tipo;  //3
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->variables_desagregacion = $request->variables_desagregacion;  //8
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
            $indicador->form_activo = $request->tap_next;            
            $indicador->estado = 1;
            $indicador->logo = "default.png";
            $indicador->id_user = $this->user->id;
            $dia = null;  //
            $mes = null;  //
            $anio = null;
            $fechaLB =null;
            if($request->linea_base_fecha){  //
              list ( $mes, $anio ) = explode ( "/", $request->linea_base_fecha );  ///
              $dia = date('t', mktime(0,0,0, $mes, 1, $anio));   ///
      		    $fechaLB = $anio . "-" . $mes . "-" . $dia;    ///
            }
            $indicador->linea_base_fecha = $fechaLB;  // 9
            $indicador->linea_base_anio = $anio;  // 10
            $indicador->linea_base_mes = $mes;  //11
            $indicador->linea_base_dia = $dia;  //12
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;  //13
            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;

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
                    $indicadorPdes->save();
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
                    if($request->avance_fecha[$k]){
                      list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                      $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
              		    $fechaAV = $anio . "-" . $mes . "-" . $dia;
                    }
                    $avance->fecha_generado = $fechaAV;
                    $avance->fecha_generado_dia = $dia;
                    $avance->fecha_generado_mes = $mes;
                    $avance->fecha_generado_anio = $anio;
                    $avance->fecha_reportado = date('Y-m-d');
                    $avance->valor =  ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
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

            return \Response::json(array(
                'error' => false,
                'idindicador'=>$id_reg,                
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
            $indicador = Indicadores::find($request->id_indicador);//dd("SSDSDAD",$indicador);
            if($indicador->codigo == ""){
              if(isset($request->resultado_articulado)){
                  $vistaPmr = VistaCatalogoPdespmr::where('id_resultado',$request->resultado_articulado[0])->first();
                  $codigo = $vistaPmr->codigo_ext.($vistaPmr->correlativo_indicador+1);
                  $resultado = Resultados::find($vistaPmr->id_resultado);
                  $resultado->correlativo_indicador = ($vistaPmr->correlativo_indicador+1);
                  //$resultado->save();
              }
              $indicador->codigo = $codigo;
            }

            $indicador->nombre = $request->nombre;
            $indicador->etapa = $request->etapa;
            $indicador->tipo = $request->tipo;
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->variables_desagregacion = $request->variables_desagregacion;
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
            if($request->linea_base_fecha){
              list ( $mes, $anio ) = explode ( "/", $request->linea_base_fecha );
              $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
              $fechaLB = $anio . "-" . $mes . "-" . $dia;
            }
            $indicador->linea_base_fecha = $fechaLB;
            $indicador->linea_base_anio = $anio;
            $indicador->linea_base_mes = $mes;
            $indicador->linea_base_dia = $dia;
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;
            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;
            $indicador->save();


            if(isset($request->resultado_articulado)){
              foreach ($request->resultado_articulado as $k => $v) {
                    if(!$request->id_resultado_articulado[$k]){
                        $indicadorPdes = new IndicadorResultado();
                        $indicadorPdes->id_indicador = $indicador->id;
                        $indicadorPdes->id_resultado = $request->resultado_articulado[$k];
                        $indicadorPdes->id_user = $this->user->id;
                        $indicadorPdes->save();
                    }else{
                        if($request->estado_resultado_articulado[$k]==0){
                          $indicadorPdes = IndicadorResultado::find($request->id_resultado_articulado[$k]);
                          $indicadorPdes->id_user_updated = $this->user->id;
                          $indicadorPdes->save();
                         // $indicadorPdes->delete();
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
                        if($request->avance_fecha[$k]){
                          list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                          $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
                  		    $fechaAV = $anio . "-" . $mes . "-" . $dia;
                        }
                        $avance->fecha_generado = $fechaAV;
                        $avance->fecha_generado_dia = $dia;
                        $avance->fecha_generado_mes = $mes;
                        $avance->fecha_generado_anio = $anio;
                        $avance->fecha_reportado = date('Y-m-d');
                        $avance->valor = ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
                        $avance->id_user = $this->user->id;
                        $avance->save();
                   }else{
                        if($request->avance_estado[$k]==0){
                          $avance = IndicadorAvance::find($request->id_avance[$k]);
                          $avance->id_user_updated = $this->user->id;
                          $avance->save();
                         // $avance->delete();
                        }
                   }
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


            if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    if(!$request->arc_id[$k]){
                        $archivos = new IndicadoresArchivosRespaldos();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->nombre =  $request->arc_nombre[$k];
                        $archivos->archivo = $request->arc_archivo[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado[$k]==0){
                          $archivos = IndicadoresArchivosRespaldos::find($request->arc_id[$k]);
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
      }
  }


  public function apiDataSetIndicador(Request $request)
  {
      $indicador = Indicadores::where('id',$request->id)->get();
      $pdes = \DB::select("SELECT c.*,ir.id
                           FROM remi_indicador_pdes_resultado ir
	                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                           WHERE ir.id_indicador = ".$request->id);

      $metas = Metas::where('id_indicador',$request->id)->get();
      $avances = IndicadorAvance::where('id_indicador',$request->id)->get();
      $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$request->id)->where('activo', true)->get();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'indicador' => $indicador,
          'pdes' => $pdes,
          'metas' => $metas,
          'avances' => $avances,
          'archivos' => $archivos)
      );
  }

  public function apiDeleteIndicador(Request $request)
  {
      $this->user= \Auth::user();
      $indicador = Indicadores::find($request->id_indicador);
      $indicador->activo = false;
      $indicador->id_user_updated = $this->user->id;
      $indicador->save();
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
            $fuente->acronimo = $request->fd_acronimo;
            $fuente->nombre = $request->fd_nombre;
            $fuente->tipo = $request->fd_tipo;
            /*$fuente->periodicidad = $request->fd_periodicidad;
            $fuente->serie_datos = $request->fd_serie_datos;
            $fuente->cobertura_geografica = ($request->fd_cobertura_geografica)?implode(",", $request->fd_cobertura_geografica):null;
            $fuente->nivel_representatividad_datos = $request->fd_nivel_representatividad_datos;
            $fuente->variable = $request->fd_variable;
            $fuente->observacion = $request->fd_observacion;*/
            $fuente->activo = true;
            $fuente->estado = 1;
            $fuente->id_user = $this->user->id;
            $fuente->save();


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

  public function apiUploadArchivoRespaldo(Request $request)
  {
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



}
