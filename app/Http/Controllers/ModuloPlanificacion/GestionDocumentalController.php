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
        $id_plan = $req->p;
        $list = collect(\DB::select("SELECT g.id, g.id_entidad, e.nombre as nombre_entidad, g.id_plan,  g.tipo_documento, to_char(g.fecha_documento,'DD/MM/YYYY') as fecha_documento,  g.archivo, 
                                        g.tipo_respaldo_1, to_char(g.fecha_respaldo_1,'DD/MM/YYYY') as fecha_respaldo_1, g.cite_respaldo_1, g.archivo_respaldo_1, 
                                        g.tipo_respaldo_2, to_char(g.fecha_respaldo_2,'DD/MM/YYYY') as fecha_respaldo_2, g.cite_respaldo_2, g.archivo_respaldo_2, 
                                        g.tipo_respaldo_3, to_char(g.fecha_respaldo_3,'DD/MM/YYYY') as fecha_respaldo_3, g.cite_respaldo_3, g.archivo_respaldo_3
                                        FROM sp_gestion_documental g, sp_entidades e, sp_planes p
                                        WHERE g.activo AND p.activo AND e.activo 
                                        AND g.id_entidad = e.id AND g.id_plan = p.id AND g.id_plan = {$id_plan}  "));
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
        $doc->id_entidad = $request->id_entidad;
        $doc->id_plan = $request->id_plan;
        $doc->tipo_documento = $request->tipo_documento;
        $doc->fecha_documento = $request->fecha_documento;

        $doc->tipo_respaldo_1 = $request->tipo_respaldo_1;
        $doc->fecha_respaldo_1 = $request->fecha_respaldo_1;
        $doc->cite_respaldo_1 = $request->cite_respaldo_1;
        // $doc->archivo_respaldo_1 = $request->archivo_respaldo_1;

        $doc->tipo_respaldo_2 = $request->tipo_respaldo_2;
        $doc->fecha_respaldo_2 = $request->fecha_respaldo_2;
        $doc->cite_respaldo_2 = $request->cite_respaldo_2;
        // $doc->archivo_respaldo_2 = $request->archivo_respaldo_2;

        $doc->tipo_respaldo_3 = $request->tipo_respaldo_3;
        $doc->fecha_respaldo_3 = $request->fecha_respaldo_3;
        $doc->cite_respaldo_3 = $request->cite_respaldo_3;
        // $doc->archivo_respaldo_3 = $request->archivo_respaldo_3; 
        
        $doc->activo = true;

        try {
            if($request->subir_archivo && $request->archivo){
                $file=$request->archivo;
                $extension = $file->getClientOriginalExtension();
                $localizacionArchTemp = $file->getPathName();

                $newNombreArchivo = uniqid('DOC-'.$this->user->id_institucion.'-');
                $destino = $carpeta . $newNombreArchivo . '.' . $extension ;
                move_uploaded_file($localizacionArchTemp, $destino);
                $doc->archivo = $newNombreArchivo. '.' . $extension ;
            }
            if($request->subir_archivo_1 && $request->archivo_respaldo_1){
                $file=$request->archivo_respaldo_1;
                $extension = $file->getClientOriginalExtension();
                $localizacionArchTemp = $file->getPathName();

                $newNombreArchivo = uniqid('DOC-'.$this->user->id_institucion.'-');
                $destino = $carpeta . $newNombreArchivo . '.' . $extension ;
                move_uploaded_file($localizacionArchTemp, $destino);
                $doc->archivo_respaldo_1 = $newNombreArchivo . '.' . $extension ;
            }

            if($request->subir_archivo_2 && $request->archivo_respaldo_2){
                $file=$request->archivo_respaldo_2;
                $extension = $file->getClientOriginalExtension();
                $localizacionArchTemp = $file->getPathName();

                $newNombreArchivo = uniqid('DOC-'.$this->user->id_institucion.'-');
                $destino = $carpeta . $newNombreArchivo . '.' . $extension ;
                move_uploaded_file($localizacionArchTemp, $destino);
                $doc->archivo_respaldo_2 = $newNombreArchivo. '.' . $extension ;
            }

            if($request->subir_archivo_3 && $request->archivo_respaldo_3){
                $file=$request->archivo_respaldo_3;
                $extension = $file->getClientOriginalExtension();
                $localizacionArchTemp = $file->getPathName();

                $newNombreArchivo = uniqid('DOC-'.$this->user->id_institucion.'-');
                $destino = $carpeta . $newNombreArchivo . '.' . $extension ;
                move_uploaded_file($localizacionArchTemp, $destino);
                $doc->archivo_respaldo_3 = $newNombreArchivo. '.' . $extension ;
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
