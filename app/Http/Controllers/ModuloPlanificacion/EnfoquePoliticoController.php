<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Models\ModuloPdes\Pilares;
use Illuminate\Http\Request;

class EnfoquePoliticoController extends PlanificacionBaseController
{

    public function showEnfoque(Request $request)
    {
        return view('ModuloPlanificacion.show-enfoque');
    }

    /*-----------------------------------------------------------------------------------------------------------
    |  obtiene el enfoque politico de la entidad actual (foco) y del plan recibido,
    |  $req = { p : id_plan }
     */
    public function getEnfoquePolitico(Request $req)
    {
        $idEntidadFoco   = $this->getIdEntidadFoco($req);
        /*$enfoquePolitico = collect(\DB::select("SELECT ep.id, ep.id_plan, ep.enfoque_politico
                                        FROM sp_enfoque_politico ep, sp_planes pl
                                        WHERE pl.activo AND ep.activo
                                        AND pl.id = ep.id_plan AND pl.id = ? AND ep.id_entidad = ?  ", [$req->p, $idEntidadFoco]))->first();*/
        $enfoquePolitico = collect(\DB::select("SELECT ep.id, ep.id_plan, ep.enfoque_politico
                                        FROM sp_enfoque_politico ep, sp_planes pl
                                        WHERE pl.activo AND ep.activo
                                        AND pl.id = ep.id_plan AND pl.id = ? AND ep.id_entidad = pl.id_entidad  ", [$req->p]))->first();

        return response()->json([
            'data' => $enfoquePolitico,
        ]);
    }

    /*----------------------------------------------------------------------------------------------------------
    | Insert o Updaqte - Guarda el enfoque politico (texto)
    | tambien trae como propiedad el plan  p: id_plan
    | recibe ids_pilare como array y lo transforma en |id||id2||id3|
     */
    public function saveEnfoque(Request $request)
    {
        $enfoque                   = (object) [];
        $enfoque->enfoque_politico = $request->enfoque_politico;
        $enfoque->id_entidad       = $this->getIdEntidadFoco($request);
        try {
            if ($request->id)
            {
                $enfoque->id_user_updated = $this->user->id;
                $enfoque->updated_at      = \Carbon\Carbon::now(-4);
                \DB::table('sp_enfoque_politico')->where('id', $request->id)->update(get_object_vars($enfoque));
            }
            else
            {
                $enfoque->activo     = true;
                $enfoque->id_plan    = $request->id_plan;
                $enfoque->id_user    = $this->user->id;
                $enfoque->created_at = \Carbon\Carbon::now(-4);
                $enfoque->id         = \DB::table('sp_enfoque_politico')->insertGetId(get_object_vars($enfoque));
            }

            return \Response::json([
                'accion' => $request->id ? 'update' : 'insert',
                'data'   => $enfoque,
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }

    }

    /*-----------------------------------------------------------------------------------------------------------
    |  obtiene las atribuciones  del plan recibido (plan_activo )
    | con todos sus pilares asociados
    | $req = { p : id_plan }
    | retorna ids_pilkares como array
     */
    public function listAtribucionesPilares(Request $req)
    {
        $atribs = \DB::select("SELECT id, atribucion, id_plan, ids_pilares
                                FROM sp_atribuciones_pilares
                                where activo AND id_plan =  ? ",[$req->p]);
        if (count($atribs) > 0)  {
            $pilares = collect(\DB::table('pdes_pilares')->orderBy('cod_p')->get())->groupBy('id');

            foreach ($atribs as $atrib)
            {
                $pilaresAtrib = [];
                $idp = [];
                $ids_pilares   = array_where(explode('|', $atrib->ids_pilares), function ($idp)
                {
                    return $idp != '';
                });
                foreach ($ids_pilares as $idpilar)
                {
                    $pilaresAtrib[] = $pilares[$idpilar]->first();
                    $idp[] =  $pilares[$idpilar]->first()->id;
                }

                $atrib->pilares = $pilaresAtrib;
                $atrib->ids_pilares = $idp;

            }
        }

        return response()->json([
            'data'=> $atribs,
        ]);
    }

    /*---------------------------------------------------------------------------------------
    | Insert o Update en sp_atribuciones
    | Tambien trae la propiedad p: id_plan
     */
    public function saveAtribucion(Request $req)
    {
        //TODO verificar antes de modificar o eliminar que no se este utilizando
        $atribucion = new \stdClass();
        $atribucion->atribucion = $req->atribucion;
        $ids_pilares = collect($req->ids_pilares)->reduce(function($carry, $id){
                                    return $carry . $id . '|';
                                },'|');

        $atribucion->ids_pilares = $ids_pilares;
        try {
            if ($req->id) // uPDATE
            {
                $atribucion->id_user_updated = $this->user->id;
                $atribucion->updated_at      = \Carbon\Carbon::now(-4);
                \DB::table('sp_atribuciones_pilares')->where('id', $req->id)->update(get_object_vars($atribucion));
            }
            else // INSERT
            {
                $atribucion->activo     = true;
                $atribucion->id_plan    = $req->id_plan;
                $atribucion->id_user    = $this->user->id;
                $atribucion->created_at = \Carbon\Carbon::now(-4);
                $atribucion->id         = \DB::table('sp_atribuciones_pilares')->insertGetId(get_object_vars($atribucion));
            }

            return \Response::json([
                'accion' => $req->id ? 'update' : 'insert',
                'data'   => $atribucion,
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

    /*---------------------------------------------------------------------------------------
    | delete $req = {id: id_atribucion}
     */
    public function deleteAtribucion(Request $req)
    {
        try{

            \DB::table('sp_atribuciones_pilares')->where('id', $req->id)->update(['activo'=>false]);
            return \Response::json([
                'error' => false,
                'estado' => "Success",
                'msg' => "Se eliminó correctamente."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'error' => true,
                'estado' => "Error",
                'msg' => $e->getMessage()
            ]);
        }
    }


        /*-----------------------------------------------------------------------------------------------------------
    |  obtiene los pilares vinculados con los atributos del plan,
    |  $req = { p : id_plan }
     */
    public function getPilaresVinculadosAlPlan(Request $req)
    {
        $atribuciones = collect(\DB::select("SELECT * from sp_atribuciones_pilares where activo AND id_plan = ? " , [$req->p]));
        $idsPilares = $atribuciones->map(function($elem){
                                return explode('|', $elem->ids_pilares);
                            })->collapse()->unique()
                            ->filter(function($val, $key){
                                return $val != '';
                            })->sort()->values();


        $pilares = \DB::table('pdes_pilares')->get()->groupBy('id');
        $pilaresPlan = [];
        foreach ($idsPilares as $idp) {
             $pilaresPlan[] = $pilares[$idp]->first();
         } 

        return response()->json([
            'data' => $pilaresPlan,
        ]);
    }



}
