<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Models\ModuloPdes\Pilares;
use Illuminate\Http\Request;

class GestionDocumentalController extends PlanificacionBaseController
{

    public function showGestionDocumental(Request $request)
    {
        return view('ModuloPlanificacion.show-gestion-documental');
    }

    /*-----------------------------------------------------------------------------------------------------------
    |  obtiene lista de todos los documentos del plan
    |  $req = { p : id_plan }
     */
    public function listDocumentos(Request $req)
    {   
        $list = collect(\DB::select("SELECT g.id, g.descripcion, g.cite_respaldo, g.tipo_respaldo, g.archivo, g.nombre_original
                                        FROM sp_gestion_documental g, sp_planes p
                                        WHERE g.activo AND p.activo AND p.id = g.id_plan "));
        return response()->json([
            'data' => $list,
        ]);
    }

    /*----------------------------------------------------------------------------------------------------------
    | Insert o Updaqte - Guarda el documento
    | tambien trae como propiedad el plan  p: id_plan
     */
    public function saveDocumento(Request $request)
    {     
        $carpeta = "sp-files/gestion-documental/";
        $doc                   = (object) [];
        $doc->cite_respaldo = $request->cite_respaldo;
        $doc->tipo_respaldo = $request->tipo_respaldo;
        $doc->descripcion = $request->descripcion;   
        $doc->id_plan = $request->id_plan;
        $doc->activo = true;


        try {
            if($request->subir_archivo && $request->archivo){
                $file=$request->archivo;

                $nombreOriginal = $file->getClientOriginalName();
                // $tipo   = $file->getMimeType();
                // $size = $file->getSize();
                $extension = $file->getClientOriginalExtension();
                $localizacionArchTemp = $file->getPathName();

                $newNombreArchivo = uniqid('DOC-'.$this->user->id_institucion.'-');
                $destino = $carpeta . $newNombreArchivo . '.' . $extension ;
                move_uploaded_file($localizacionArchTemp, $destino);
                $doc->archivo = $newNombreArchivo. '.' . $extension ;
                $doc->nombre_original = $nombreOriginal;
            }

            if ($request->id) // update
            {
                $doc->id_user_updated = $this->user->id;
                $doc->updated_at = \Carbon\Carbon::now(-4);
                \DB::table('sp_gestion_documental')->where('id', $request->id)->update(get_object_vars($doc));
                $msg="Archivo subido correctamente";
                $estado = 'success';
            }
            else // insert
            {
                $doc->id_user = $this->user->id;
                $doc->created_at = \Carbon\Carbon::now(-4);
                $id_archivo = \DB::table('sp_gestion_documental')->insertGetId(get_object_vars($doc));
                $msg="Documento modificado correctamente";
                $estado = 'success';
            }
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }

        return response()->json([
                'msg'=>$msg,
                'estado'=>$estado,
            ]);
    }





    /*---------------------------------------------------------------------------------------
    | delete $req = {id: id}
     */
    public function deleteDocumento(Request $req)
    {
        \DB::table('sp_gestion_documental')->where('id', $req->id)->update(['activo'=>false]);
        return \Response::json([ 
            'error' => false,
            'estado' => "Success",
            'msg' => "Se eliminó correctamente."
        ]);        
    }





}
