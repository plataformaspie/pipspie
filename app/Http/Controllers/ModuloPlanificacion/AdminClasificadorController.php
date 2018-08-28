<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Clasificador;

use Illuminate\Http\Request;

class AdminClasificadorController extends PlanificacionBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct(Request $request)
    // {
    //      // $middleware('auth');
    //     $this->middleware(function ($request, $next)
    //     {
    //       $user    = \Auth::user();
    //       $ModulosMenus = IndexController::GeneraMenus($user);

    //       \View::share($ModulosMenus);

    //       return $next($request);
    //     });
    // }
   /* public function showAdminEntidades(){
        return "hola desde el controlador";

    }*/
    public function showClasificador(){
        
       
        $clasificador = [];
        $nivel_0 = \DB::select("SELECT *
                                FROM sp_clasificador 
                                where nivel = '0'");


        

        foreach ($nivel_0 as $key => $row_0) {
            $id_0 = $row_0->id_clasificador;
            
            $nivel_1 = \DB::select("SELECT *
                                FROM sp_clasificador 
                                where id_clasificador_dependiente = ".$id_0."");//buscando todos sus dependientes

            foreach ($nivel_1 as $key => $row_1) {
                $id_1 = $row_1->id_clasificador;
                $nivel_2 = \DB::select("SELECT *
                                FROM sp_clasificador 
                                where id_clasificador_dependiente = ".$id_1."");//buscando todos sus dependientes
                foreach ($nivel_2 as $key => $row_2) {
                    $id_2 = $row_2->id_clasificador;
                    $nivel_3 = \DB::select("SELECT *
                                FROM sp_clasificador 
                                where id_clasificador_dependiente = ".$id_2."");//buscando todos sus dependientes
                    $row_2->dependientes_3 = $nivel_3;
                }

                $row_1->dependientes_2 =$nivel_2;//agregando a la fila el atributo dependientes
            }

            $row_0->dependientes_1 =$nivel_1;//agregando a la fila el atributo dependientes

        }

        $clasificador = $nivel_0;
        $clasificador = Clasificador::all();
        
        return view('ModuloPlanificacion.show-clasificador');


        
        //return \Response::json($clasificador);
    }

    public function setClasificador  (){
        $clasificador = Clasificador::where('activo_clasificador',true)->get();
                        
        
        return \Response::json($clasificador);
    }

    public function saveInstitucion(Request $request){

        //dd($request->nombre);
        $this->user = \Auth::user();
        

        try {
            $clasificador              = new Clasificador();
            $clasificador->denominacion      = $request->nombre;
            $clasificador->sigla       = $request->sigla;
            $clasificador->codigo_mef  = $request->codigo_mef;
            $clasificador->id_clasificador_dependiente = $request->id_clasificador_dependiente;
            $clasificador->codigo_geografico = $request->codigo_geografico;
            $clasificador->activo_clasificador = true; 
            $clasificador->nivel = $request->nivel_seleccionado + 1;
            $clasificador->si_es_nominal_o_institucion = false;//es true cuando es nominal          

            $clasificador->id_user = $this->user->id;//capturando el id del usuario logueado
            $clasificador->gestion = 2018;

            $clasificador->save();

            /*$entidadID             = Entidades::find($entidad->id);
            $entidadID->id_entidad = $entidad->id;
            $entidadID->save();*/
            
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }

    }
    public function saveInstitucionEdit(Request $request){
        //dd("hola desde el controlador");
        $this->user = \Auth::user();
        try {
            $clasificador             = Clasificador::find($request->mod_id);
            $clasificador->denominacion     = $request->mod_nombre;
            $clasificador->sigla      = $request->mod_sigla;
            $clasificador->codigo_mef = $request->mod_codigo_mef;
            //$clasificador->codigo_geografico = $request->mod_codigo_geografico;          
            $clasificador->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }

    }

    public function dataSetInstitucion(Request $request)
    {
        $institucion = Clasificador::find($request->id);
        return \Response::json($institucion);
    }
    public function deleteInstitucion(Request $request)
    {


        try {
            $clasificador         = Clasificador::find($request->id);
            $clasificador->activo_clasificador = false;
            $clasificador->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se elimino con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }
    
    




    
}
