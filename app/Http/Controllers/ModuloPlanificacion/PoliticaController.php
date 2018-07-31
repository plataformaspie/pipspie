<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Models\ModuloPdes\Pilares;
use Illuminate\Http\Request;

class PoliticaController extends PlanificacionBaseController
{

    public function showPolitica(Request $request)
    {
        return view('ModuloPlanificacion.show-politica');
    }

 

    /*-----------------------------------------------------------------------------------------------------------
    |  obtiene las politicas sectoriales o institucionales definidas con sus pilares
    | del plan recibido (plan_activo ) con todos sus pilares asociados    | 
    | $req = { p : id_plan }
    | retorna array con pilares
     */
    public function listPoliticasPilares(Request $req)
    {
        $politicas = \DB::select("SELECT id, politica, id_plan, ids_pilares 
                                FROM sp_politica_pilares 
                                where activo AND id_plan =  ? ORDER BY id",[$req->p]);
        if (count($politicas) > 0)  {
            $pilares = collect(\DB::table('pdes_pilares')->orderBy('cod_p')->get())->groupBy('id');

            foreach ($politicas as $pol) {
                $pol->pilares = collect(explode('|', $pol->ids_pilares))
                                    ->filter(function($val){
                                        return $val != '';
                                    })->unique()->sort()->values()
                                    ->map(function($id, $key) use ($pilares){
                                        return $pilares[$id]->first();
                                    });
                $pol->ids_pilares = $pol->pilares->map(function($elem){
                    return $elem->id;
                });
            }

        }

        return response()->json([
            'data'=> $politicas,
        ]);
    }

    /*---------------------------------------------------------------------------------------
    | Insert o Update en sp_politicas_pilares
    | contiene $req{ politica:politica, ids_pilares: [1,2,..13], p: id_plan }
    | trae la propiedad $req->p: id_plan
     */
    public function savePolitica(Request $req)
    {
        //TODO verificar antes de modificar o eliminar que no se este utilizando
        $politica = new \stdClass();
        $politica->politica = $req->politica;
        $ids_pilares = collect($req->ids_pilares)
                                ->unique()->sort()->values()
                                ->reduce(function($carry, $id){
                                    return $carry . $id . '|';
                                },'|');

        $politica->ids_pilares = $ids_pilares;

        try {
            if ($req->id) // uPDATE
            {
                $politica->id_user_updated = $this->user->id;
                $politica->updated_at      = \Carbon\Carbon::now(-4);
                \DB::table('sp_politica_pilares')->where('id', $req->id)->update(get_object_vars($politica));
            }
            else // INSERT
            {
                $politica->activo     = true;
                $politica->id_plan    = $req->id_plan;
                $politica->id_user    = $this->user->id;
                $politica->created_at = \Carbon\Carbon::now(-4);
                $politica->id         = \DB::table('sp_politica_pilares')->insertGetId(get_object_vars($politica));
            }

            return \Response::json([
                'accion' => $req->id ? 'update' : 'insert',
                // 'data'   => $politica,
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
    | delete $req = {id: id_politica}
     */
    public function deletePolitica(Request $req)
    {
        try{

            \DB::table('sp_politica_pilares')->where('id', $req->id)->update(['activo'=>false]);
            return \Response::json([ 
                'estado' => "success",
                'msg' => "Se eliminó correctamente."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'estado' => "error",
                'msg' => $e->getMessage()
            ]);
        }
    }









}
