

    
<!-- ============================================  Vista de la PROGRAMACION DE ACCIONES ============================================= -->

<!-- =================== el div que contiene a todos #planificacionContainer ================== -->
<!-- =================== el div donde se carga esta vista <div class="col-md-12 slick-slide" id="planificacion_plaa"></div> ================== -->
            

<div class="panel panel-visible" >
    <div class="panel-heading  bg-dark ">
        <div class="panel-title ">
            <div>
                <i class="glyphicons glyphicons-riflescope" ></i><span class="sp_titulo_panel"> Planificación de la  Acción</span><span id="sp_est_plaa" class="ml5 badge bg-dark dark"></span>                                 
                <span class="pull-right">                   
                </span>
            </div>
        </div>
    </div>
    <div class="panel-body pn">
        <div class="row">
            <div class="col-sm-1">
                <div class="panel ">
    {{--                                     <div class="panel-heading">
                        <span class="panel-icon"><i class="fa fa-pencil"></i>
                        </span>
                        <span class="panel-title">Pilares</span>
                    </div> --}}
                    <div id="sp_est_plaa_inds">                                       
                    </div>
                </div>
            </div>
            <div id="" class="col-sm-11" > 
                <div id="container_dt_plaa" style="max-height: 500px; overflow-y: scroll;" >
                   <div id="dt_plaa"></div> 
                </div> 


                <div id="p_contenido" hidden="">
                    <h4 id="p_titulo_sel">Atributos sel</h4>
                    <div id="p_opciones_sel">
                        <span proy-index="" proy-atrib="ind" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Indicadores"><i class="fa fa-dot-circle-o"></i> <span> I </span></span>
                        <span proy-index="" proy-atrib="pre" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Presupuesto y Contraparte"><i class="fa fa-money"></i> <span> P </span></span>
                        <span proy-index="" proy-atrib="res" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Responsables"><i class="fa fa-sitemap" ></i> <span> R </span></span>
                        <span proy-index="" proy-atrib="rol" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Roles y Actores"><i class="glyphicons glyphicons-group"></i> <span> RA </span></span>
                        <span proy-index="" proy-atrib="art" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Articulación Competencial"><i class="fa fa-share-square-o"></i> <span> AC </span></span> 
                        <span proy-index="" proy-atrib="ter" class=" bg-dark btn btn-xs ml2 br4 fs11 w40 text-warning light" data-toggle="tooltip" data-container="body" data-html="true" title="Territorialización"><i class="fa fa-map-marker"></i> <span> T </span></span>
                    </div>
                    <div class="panel panel-visible"  >
                        <div class="panel-heading  bg-dark light">
                            <div class="panel-title ">
                                <div class="p_titulo_panel">
                                    <i id="p_i" ></i> <span class="p_titulo_panel"></span>                                
                                    <span class="pull-right">
                                        <button id="atrib_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body pn">
                            <div id="p_atribContenido" class="">
                            </div>
                        </div>
                    </div> 
                </div>                                            
                
            </div>
        </div>
    </div>
</div>




    <!-- -----------------------------------------          Modal Proyecto  --------------------------------------------------- -->
    <div id="modal_plaa_proyecto"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide ">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_plaa" name="form_plaa">
                <div class="panel-body of-a">                    
                    <input class="hidden" name="" id="id_arti_pdes_proyecto" >
                    <input class="hidden" name="" id="id_proyecto" >
                    <h4 class="ml5 mt5 ph10 pb5 br-b fw700">Defina el proyecto para la acción: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 br-r">
                            <div class="section">
                                <label class="field-label" for="codp_tipo_proyecto"><b>Tipo Programa/Proyecto</b></label>
                                <label class="field select ">
                                    <select id="codp_tipo_proyecto" name="codp_tipo_proyecto" class="required br-primary" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div id="proy-ocultos" class=" hidden">

                                <div class="section proy-ocultos section_select_id_proyecto">
                                    <label class="field-label" for="select_id_proyecto">Proyecto</label>
                                    <label class="field select">
                                        <select id="select_id_proyecto" name="select_id_proyecto"  style="width:100%;">
                                        </select>
                                        <i class="arrow"></i>
                                    </label>
                                </div>

                                <div class="section proy-ocultos section_nombre_proyecto">
                                    <label class="field-label" for="codp_tipo_proyecto">Nombre proyecto</label>
                                    <label for="nombre_proyecto" class="field prepend-icon">
                                        <textarea class="gui-textarea" id="nombre_proyecto" name="nombre_proyecto"  placeholder="Nombre proyecto"></textarea>
                                        <label for="nombre_proyecto" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                        </label>                                        
                                    </label>
                                </div>

                                <div class="section proy-ocultos section_codigo">
                                    <label class="field-label" for="codigo">Código - código demanda</label>
                                    <label class="field prepend-icon">
                                        <input type="text" class="gui-input" id="codigo"   name="codigo" placeholder="Código.." style="width:40%;" >
                                        <label for="codigo" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                        </label>                 
                                    </label>
                                </div>

                                <div class="section">
                                    <div class="form-group col-md-4">
                                        <label class="field-label" for="gestion_ini_picker">Gestión inicio</label>
                                        <div class="">
                                            <div class="input-group date" id="gestion_ini_picker">
                                                <span class="input-group-addon cursor"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" id="gestion_ini" placeholder="yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="field-label" for="gestion_fin_picker">Gestión fin</label>
                                        <div class="">
                                            <div class="input-group date" id="gestion_fin_picker">
                                                <span class="input-group-addon cursor"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" id="gestion_fin" placeholder="yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="javascript:void(0)"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>        
    </div>

    <!-- -----------------------------------------          Modal indicador  --------------------------------------------------- -->
    <div id="modal_plaa_ind"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_ind" name="form_ind">
                <div class="panel-body  of-a">                    
                    <input class="hidden"  name="id_arti_pdes_proyecto_indicador" id="id_arti_pdes_proyecto_indicador" >
                    <input class="hidden"  name="id_indicador" id="id_indicador" >
                    <input class="hidden"  name="id_indicador_ejecucion" id="id_indicador_ejecucion" >
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 br-r">

                            <h5 class="mt5 ph10 pb5 br-b fw700">Indicador <small class="pull-right fw700 text-primary">- </small> </h5>
                            <div class="section">
                                <label class="field-label" for="nombre">Indicador de la acción o del proyecto</label>
                                <label for="nombre" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="nombre" name="nombre"  placeholder="Indicador"></textarea>
                                    <label for="nombre" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                    </label>                                        
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="id_diagnostico">Variables del diagnóstico</label>
                                <label class="field select">
                                    <select id="id_diagnostico" name="id_diagnostico" class="" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="variable">Variable</label>
                                <label class="field prepend-icon">
                                    <input type="text" id="variable" name="variable" class="gui-input" placeholder="Variable" style="width:100%;">
                                    <label for="variable" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="idp_unidad">Unidad de Medida </label>
                                <label class="field select">
                                    <select id="idp_unidad" name="idp_unidad" class="required sp_metrica" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="linea_base">Linea Base</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="linea_base" name="linea_base" placeholder="Linea Base" style="width:100%;">
                                    <label for="linea_base" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                 
                                </label>
                            </div>
                            <div class="section">
                                <label class="field-label" for="alcance">Alcance</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="alcance" name="alcance" placeholder="Alcance" style="width:100%;">
                                    <label for="alcance" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                  
                                </label>

                            </div>
                        </div>

                        <div class="col-sm-6" id="gestiones_ind">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Programación <small class="pull-right fw700 text-primary">- </small> </h5>
                            <table class="table mbn">
                                <thead>
                                    <tr class="hidden">
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>


    <!-- -----------------------------------------          Modal Presupuesto y Contraparte --------------------------------------------------- -->
    <div id="modal_plaa_pre" style="width:1000px; margin:40px auto"  class="white-popup-block admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_pre" name="form_pre">
                <div class="panel-body  of-a">                    
                 {{--    <input class="hidden"  name="id_arti_pdes_proyecto_indicador" id="id_arti_pdes_proyecto_indicador" >
                    <input class="hidden"  name="id_indicador" id="id_indicador" >
                    <input class="hidden"  name="id_indicador_ejecucion" id="id_indicador_ejecucion" > --}}
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div id='pre_datos_indicador'>
                        <h5 class="mt5 ph10 pb5 br-b fw700"></h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6" id="gestiones_presup">
                        </div>                        
                        <div class="col-sm-6" id="gestiones_contrp">
                        </div>

                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>

    <!-- -----------------------------------------          Modal Responsables  --------------------------------------------------- -->
    <div id="modal_plaa_res"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_res" name="form_res">
                <div class="panel-body  of-a">                    
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del Proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div id="encabezado" class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Responsables: <small class="pull-right fw700 text-primary">- </small> </h5>

                            <div class="section">
                                <label class="field-label" for="id_entidades">Instituciones o Entidades </label>
                                <label class="field">
                                    <select id="id_entidades" name="id_entidades" class="required " multiple="multiple" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>                            
                        </div>
                    </div>                   
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- -----------------------------------------          Modal Roles y Actores  --------------------------------------------------- -->
    <div id="modal_plaa_rol"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_rol" name="form_rol">
                <input class="hidden"  name="id_rol_actor" id="id_rol_actor" >
                <div class="panel-body  of-a">                    
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del Proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div id="encabezado" class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Roles y Actores <small class="pull-right fw700 text-primary">- </small> </h5>

                            <div class="section">
                                <label class="field-label" for="idp_actor">Actor </label>
                                <label class="field">
                                    <select id="idp_actor" name="idp_actor" class="required" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>   

                            <div class="section">
                                <label class="field-label" for="descripcion">Descripción</label>
                                <label for="descripcion" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="descripcion" name="descripcion"  placeholder="Nombre proyecto"></textarea>
                                    <label for="descripcion" class="field-icon"><i class="fa fa-dot-circle-o"></i>
                                    </label>                                        
                                </label>
                            </div>


                        </div>
                    </div>                   
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    
     <!-- -----------------------------------------          Modal Articulacipon Competencial  --------------------------------------------------- -->
    <div id="modal_plaa_art"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_art" name="form_art">
                <input class="hidden"  name="id_articulacion_competencial" id="id_articulacion_competencial" >
                <div class="panel-body  of-a">                    
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del Proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div id="encabezado" class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Articulación Competencial <small class="pull-right fw700 text-primary">- </small> </h5>

                            <div class="section">
                                <label class="field-label" for="idp_entidad_territorial">Entidad Territorial </label>
                                <label class="field">
                                    <select id="idp_entidad_territorial" name="idp_entidad_territorial" class="required" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div> 

                            <div class="section">
                                <label class="field-label" for="idp_competencia">Competencia </label>
                                <label class="field">
                                    <select id="idp_competencia" name="idp_competencia" class="required" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>   

                            <div class="section">
                                <label class="field-label" for="norma">Norma</label>
                                <label for="norma" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="norma" name="norma"  placeholder="Nombre proyecto"></textarea>
                                    <label for="norma" class="field-icon"><i class="fa fa-dot-circle-o"></i>
                                    </label>                                        
                                </label>
                            </div>


                        </div>
                    </div>                   
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

         <!-- -----------------------------------------          Modal Territorializacion  --------------------------------------------------- -->
    <div id="modal_plaa_ter"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <form method="post" action="/" id="form_ter" name="form_ter">
                {{-- <input class="hidden"  name="id_articulacion_competencial" id="id_articulacion_competencial" > --}}
                <div class="panel-body  of-a">                    
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Articulación del Proyecto<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div id="encabezado" class=" bg-system  row p10 mb10">
                        <div id="pmra_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Territorialización <small class="pull-right fw700 text-primary">- </small> </h5>

                            <div class="section">
                                <label class="field-label" for="id_departamento">Departamento</label>
                                <label class="field">
                                    <select id="id_departamento" name="id_departamento"  multiple="multiple" style="width:80%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                    <a href="javascript:void(0)" class="fa fa-angle-double-right btn bg-primary lighter " sp_carga_region="id_departamento"></a>
                                </label>
                            </div> 

                            <div class="section">
                                <label class="field-label" for="id_provincia">Provincia</label>
                                <label class="field">
                                    <select id="id_provincia" name="id_provincia"  multiple="multiple" style="width:80%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                    <a href="javascript:void(0)" class="fa fa-angle-double-right btn bg-primary lighter " sp_carga_region="id_provincia"></a>
                                </label>
                            </div> 

                            <div class="section">
                                <label class="field-label" for="id_municipio">Municipio</label>
                                <label class="field">
                                    <select id="id_municipio" name="id_municipio"  multiple="multiple" style="width:80%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                    <a href="javascript:void(0)" class="fa fa-angle-double-right btn bg-primary lighter " sp_carga_region="id_municipio"></a>
                                </label>
                            </div> 

                            <div class="section">
                                <label class="field-label" for="id_comunidad">Comunidad</label>
                                <label class="field">
                                    <select id="id_comunidad" name="id_comunidad"  multiple="multiple" style="width:80%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                    <a href="javascript:void(0)" class="fa fa-angle-double-right btn bg-primary lighter " sp_carga_region="id_comunidad"></a>
                                </label>
                            </div> 

                        </div>
                        <div class="col-sm-6">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Territorios seleccionados <small class="pull-right fw700 text-primary">- </small> </h5>
                            <div id="id_regiones">                                
                            </div>                            
                        </div>
                    </div>                   
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
        
    
  

<script type="text/javascript">
$(function(){

    var ctxplaa = {
            dataTable : $("#dt_plaa"),
            source : {},
            urlList: globalSP.urlApi + 'listaaccionesproy',
            proyectos:[], 
            cssDisabled : 'bg-dark darker',            

            fillDataTable : function() {
                $.get(ctxplaa.urlList, {p : globalSP.idPlanActivo}, function(resp)
                {
                    ctxplaa.source =
                    {
                        dataType: "json",
                        localdata: resp.data,
                        dataFields: [
                            { name: 'id_pmra', type: 'number' },
                            { name: 'id_a', type: 'number' },
                            { name: 'cod_p', type: 'string' },
                            { name: 'cod_m', type: 'string' },
                            { name: 'cod_r', type: 'string' },
                            { name: 'cod_a', type: 'string' },                        
                            { name: 'nombre_p', type: 'string' },
                            { name: 'nombre_m', type: 'string' },
                            { name: 'nombre_r', type: 'string' },
                            { name: 'nombre_a', type: 'string' },
                            { name: 'desc_p', type: 'string' },
                            { name: 'desc_m', type: 'string' },
                            { name: 'desc_r', type: 'string' },
                            { name: 'desc_a', type: 'string' },
                            { name: 'logo_p', type: 'string' },
                            { name: 'sector', type: 'string' },
                            { name: 'cod_periodo_plan', type: 'string' },
                            { name: 'periodo_gestion_ini', type: 'string' },
                            { name: 'periodo_gestion_fin', type: 'string' },
                            { name: 'proyectos', type: 'object' },   
                        ],
                        id: 'id',
                    };
                    ctxplaa.estadistics();
                    var dataAdapter = new $.jqx.dataAdapter(ctxplaa.source);
                    ctxplaa.dataTable.jqxDataTable({
                        source: dataAdapter,
                        theme: ctxgral.theme,
                        altRows: false,
                        sortable: true,
                        width: "100%",
                        filterable: false,
                        filterMode: 'simple',
                        selectionMode: 'singleRow',                        
                        columnsResize: true,
                        localization: getLocalization('es'),
                        columns: [
                            { text: '-', width: 50, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<img width="30" class="img-circle"  src="/img/${rowData.logo_p}" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}" /> `
                                } 
                            },
                            { text: '<span title="Pilares">P</span>', dataField: 'cod_p', width: 50, align:'center', cellsalign: 'center',  cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}">${rowData.cod_p}</span>`;
                                } 
                            },
                            { text: '<span title="Metas">M</span>', dataField: 'cod_m', width: 50,  align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_m}</b> - ${rowData.desc_m}">${rowData.cod_m}</span>`
                                } 
                            },
                            { text: '<span title="Resultados">R</span>', dataField: 'cod_r', width: 50,  cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_r}</b> - ${rowData.desc_r}">${rowData.cod_r}</span>`
                                } 
                            },
                            { text: '<span title="Acciones">A</span>', dataField: 'cod_a', width: 50,  cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_a}</b> - ${rowData.desc_a}">${rowData.cod_a}</span>`
                                } 
                            },
                            { text: '', width: 40, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                    return `<a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_add" title="Agregar proyecto en la articulación de accion " ><i class="fa fa-plus-circle fa-2x text-success "></i></a>`;
                                }
                            }, 
                            
                            { text: 'Proyectos ',    align:'center', width: 1000,cellClassName: 'sp_cellTable', 
                                cellsrenderer: function(row, column, value, rowData){
                                    var html = ''; 
                                    if(rowData.proyectos.length>0){ 

                                        html = `<table class="table table-bordered table-hover fs11 sp_table">
                                        <thead><tr class="primary"><th>.</th> <th>Tipo p.</th> <th>Proyecto </th>  <th>Codigo</th> <th>G. ini.</th> <th>G. fin</th> <th></th> </tr> </thead>
                                        <tbody>`;                                        
                                        rowData.proyectos.forEach(function(proy, index){
                                                      html += `<tr>
                                            <td>  
                                                <a href="javascript:void(0);" proy-index="${index}" proy-atrib="ind" class="text-alert dark fa fa-dot-circle-o fa-lg" data-toggle="tooltip" data-container="body" data-html="true" title="Ver Indicadores y otros atributos"></a>  
                                            </td>
                                            <td class=""> ${proy.tipo_proyecto}</td> 
                                            <td>${proy.nombre_proyecto}</td>
                                            
                                            <td>${ proy.codigo ? proy.codigo : ''} </td> 
                                            <td class="">${proy.gestion_ini || '_'}</td> <td class="">${proy.gestion_fin || '_'}</td> 
                                            
                                            <td><a href="javascript:void(0);"  index_proy="${index}" class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar proyecto" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                                            <a href="javascript:void(0);" id_arti_pdes_proyecto="${proy.id_arti_pdes_proyecto}" class="sel_delete" title="Eliminar proyecto" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
                                            </tr>`;
                                        });
                                        html +=  `</tbody>
                                                    </table>`;
                                    }
                                    return html
                                } 
                            },
                        ]
                    });


                });
            },
            getDataContent: function(content){
                inputs = $(`${content} input, ${content} select, ${content} textarea`);
                var obj = {}
                inputs.each(function(index, el) {
                    obj[$(el).attr('id')] = $(el).val();
                });
                obj._token = ctxgral.token;
                return obj;
            },
            nuevo: function(){
                if(ctxplaa.proyectos.length == 0)
                    $.get(globalSP.urlApi + "listproyectos", function(res){
                        ctxplaa.proyectos = res.data;
                    });
                $(".tituloModal span").html(`Agregar Proyecto`);
                // $('#modal_plaa_proyecto input:text, #modal_plaa_proyecto textarea').val('');
                $("#modal_plaa_proyecto select").val('').change();
                var selrow = ctxplaa.selrow();
                $("#modal_plaa_proyecto #pmra_plaa").html(`<div><b>${selrow.cod_p} . ${selrow.cod_m} . ${selrow.cod_r} . ${selrow.cod_a}</b> </div>
                                                            <div><b>${selrow.nombre_p}</b> - ${selrow.desc_p} </div>
                                                            <div><b>${selrow.nombre_m}</b> - ${selrow.desc_m} </div>
                                                            <div><b>${selrow.nombre_r}</b> - ${selrow.desc_r} </div>
                                                            <div><b>${selrow.nombre_a} - ${selrow.desc_a}</b> </div>`);

                $("#codp_tipo_proyecto").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                $("#nombre_proyecto").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                $("#codigo").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                ctxgral.showModal('#modal_plaa_proyecto');
            },
            editar: function(index){
                $(".tituloModal span").html(`Modificar datos de proyecto`);
                var selrow = ctxplaa.selrow();
                var proy = selrow.proyectos[index];
                /* coloca los pilares m r y acciones*/
                $("#modal_plaa_proyecto #pmra_plaa").html(`<div><b>${selrow.cod_p} . ${selrow.cod_m} . ${selrow.cod_r} . ${selrow.cod_a}</b> </div>
                                                            <div><b>${selrow.nombre_p}</b> - ${selrow.desc_p} </div>
                                                            <div><b>${selrow.nombre_m}</b> - ${selrow.desc_m} </div>
                                                            <div><b>${selrow.nombre_r}</b> - ${selrow.desc_r} </div>
                                                            <div><b>${selrow.nombre_a} - ${selrow.desc_a}</b> </div>`);

                /* coloca los valores de la fila seleccionada*/
                $("#id_arti_pdes_proyecto").val(proy.id_arti_pdes_proyecto);
                $("#id_proyecto").val(proy.id_proyecto);
                $("#codp_tipo_proyecto").val(proy.codp_tipo_proyecto);
                $("#nombre_proyecto").val(proy.nombre_proyecto);
                $("#codigo").val(proy.codigo);
                $("#gestion_ini").val(proy.gestion_ini);
                $("#gestion_fin").val(proy.gestion_fin);

                /* oculta el selector de proyectos (ya no se edita) y deshabilita todas las opciones no editables */
                $(".section_select_id_proyecto").hide();
                $("#proy-ocultos").removeClass('hidden');
                $("#codp_tipo_proyecto").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');
                $("#nombre_proyecto").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');
                $("#codigo").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');

                /* si es producto puede editar el nombre y codigo del proyecto*/
                if(proy.codp_tipo_proyecto == 'prod')  {
                    $("#nombre_proyecto").removeAttr('disabled').removeClass(ctxplaa.cssDisabled);
                    $("#codigo").removeAttr('disabled').removeClass(ctxplaa.cssDisabled).show();
                };
                /* si es de continuidad o accionsector no requiere codigo*/
                if(proy.codp_tipo_proyecto == 'accs' || proy.codp_tipo_proyecto == 'cont'){
                    $(".section_codigo").hide();
                }
                if(proy.codp_tipo_proyecto == 'pdes'){
                    $(".section_codigo").show();
                }
                ctxgral.showModal("#modal_plaa_proyecto");
            },            
            validateRules: function(){                
                return {
                            codp_tipo_proyecto:  { required: 'Debe seleccionar el tipo de proyecto' },
                            nombre_proyecto:  { required: 'El nombre del proyecto es obligatorio' },
                        }; 
            }, 
            saveData: function(){
                var obj = ctxplaa.getDataContent('#modal_plaa_proyecto');
                obj.id_accion = ctxplaa.selrow().id_a;
                obj.id_plan_articulacion_pdes = ctxplaa.selrow().id_pmra;
                $.post(globalSP.urlApi + 'saveartiproyecto', obj, function(resp){
                    ctxgral.refreshList(ctxplaa);
                    new PNotify({
                                title: resp.estado == 'success' ? 'Guardado' : 'Error',
                                text: resp.msg,
                                shadow: true,
                                opacity: 0.9,
                                addclass: noteStack,
                                type: (resp.estado == 'success') ? "success" : "danger",
                                stack: Stacks[noteStack],
                                width: findWidth(),
                                delay: 1500
                            });
                    $.magnificPopup.close();  
                });   
            },
            delete: function(id){
                // var rowsel = ctxplaa.selrow();
                swal({
                      title: `Está seguro de eliminar la articulación PDES del plan?`,
                      text: "No podrá recuperar este registro!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, eliminar!",
                      closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'saveartiproyecto', {'id_arti_pdes_proyecto': id, delete: true, _token : ctxgral.token, }, function(res){
                        new PNotify({
                          title: !res.error ? 'Eliminado' : 'Error!!' ,
                          text: res.msg,
                          shadow: true,
                          opacity: 1,
                          addclass: noteStack,
                          type: !res.error ? "success" : 'danger',
                          stack: Stacks[noteStack],
                          width: findWidth(),
                          delay: 2000
                      });
                        ctxgral.refreshList(ctxplaa);
                    });
                }); 
            },
            estadistics: function(){
                var proys = ctxplaa.source.localdata.reduce(function(acum, el){
                                return acum + el.proyectos.length;
                            },0);
                $("#sp_est_plaa").html('Total de proyectos ' + proys);

                var pils = _.groupBy(ctxplaa.source.localdata, function(elem){
                    return elem.cod_p;
                });
                var html = `<div class="panel-heading">
                                            <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                            </span>
                                            <span class="panel-title"></span>
                                        </div>`;
                _.mapObject(pils, function(elems, key){
                    var pilar = elems[0];
                    var nproy = elems.reduce(function(acum, el){ return acum + el.proyectos.length; }, 0);
                    html += `<div class="panel-body"> 
                                <div class="w50">                                        
                                    <span class="badge badge-hero pull-right bg-alert dark posr" style="top:6px;" data-toggle="tooltip" data-container="body" data-html="true" title="N° de proyectos ${nproy}">${nproy}</span> 
                                    <img width="50" class=""  src="/img/${pilar.logo_p}"/>
                                   
                                </div> 
                            </div>`;               
                });
                 $("#sp_est_plaa_inds").html(html);
            },
            selrow : function(){
                return ctxplaa.dataTable.jqxDataTable('getSelection')[0];
            },
        }


        /* ***************************************************************************** */
    ctxattr = {
        atributoSel: '',
        selpmra:{},
        selproy: {},
        data: [],
        atributos : {
            'ind' : { texto:'Indicadores', class: 'fa fa-dot-circle-o ' },
            'pre' : { texto:'Presupuesto y Contraparte', class: 'fa fa-money ' },
            'res' : { texto:'Responsables', class: 'fa fa-sitemap ' },
            'rol' : { texto:'Roles y Actores', class: 'glyphicons glyphicons-group' },
            'art' : { texto:'Articulación Competencial', class: 'fa fa-share-square-o' },
            'ter' : { texto:'Territorialización', class: 'fa fa-map-marker' },
        },


        cargarAtrib: function(atributo, proy_index){
            if(proy_index){
                ctxattr.selpmra = ctxplaa.selrow();
                ctxattr.selproy = ctxattr.selpmra.proyectos[proy_index];                
            }
            proy = ctxattr.selproy ;
            ctxattr.atributoSel = atributo;
            
            $("#p_contenido").show();
            // $("#p_opciones_sel span[proy-index]").attr('proy-index', proy_index);
            $("#p_titulo_sel").html(`PROYECTO: ${proy.nombre_proyecto} `);
            $(".p_titulo_panel .p_titulo_panel").html(ctxattr.atributos[atributo].texto);
            $(".p_titulo_panel #p_i").attr('class', '').addClass(ctxattr.atributos[atributo].class);

            var sendObj = {id_app: proy.id_arti_pdes_proyecto, atributo: atributo, p: globalSP.idPlanActivo};
            $.get(globalSP.urlApi + 'list_atributo', sendObj, function(res){
                console.log(res.data)
                ctxattr.data = data = res.data;

                (atributo == 'pre') ? $("#atrib_nuevo").hide() : $("#atrib_nuevo").show();

                if(atributo == 'ind') $("#p_atribContenido").html(ctxind.fillData(data)) ;
                if(atributo == 'pre') $("#p_atribContenido").html(ctxpre.fillData(data)) ;
                if(atributo == 'res') $("#p_atribContenido").html(ctxres.fillData(data)) ;
                if(atributo == 'rol') $("#p_atribContenido").html(ctxrol.fillData(data)) ;
                if(atributo == 'art') $("#p_atribContenido").html(ctxart.fillData(data)) ;
                if(atributo == 'ter') $("#p_atribContenido").html(ctxter.fillData(data)) ;
            });
        }, 
        refreshAtrib: function(){
            ctxattr.cargarAtrib(ctxattr.atributoSel);
        },
        abmAtrib: function(accion, index){
            atrib = ctxattr.atributoSel;
            if(atrib == 'ind') ctxind[accion](index);
            if(atrib == 'pre') ctxpre[accion](index);
            if(atrib == 'res') ctxres[accion](index);
            if(atrib == 'rol') ctxrol[accion](index);
            if(atrib == 'art') ctxart[accion](index);
            if(atrib == 'ter') ctxter[accion](index);
        },
        saveAtribData: function(ruta, obj){
            $.post(globalSP.urlApi + ruta, obj, function(resp){
                ctxattr.refreshAtrib();
                new PNotify({
                            title: resp.estado == 'success' ? 'Guardado' : 'Error',
                            text: resp.msg,
                            shadow: true,
                            opacity: 0.9,
                            addclass: noteStack,
                            type: (resp.estado == 'success') ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
                $.magnificPopup.close();  
            });
        },
        deleteAtrib: function(ruta, id){
            swal({
                  title: `Está seguro de eliminar ?`,
                  text: `No podrá recuperar este registro!`,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + ruta, {'id': id, atributo: ctxattr.atributoSel, _token : ctxgral.token, }, function(res){
                        new PNotify({
                                  title: !res.error ? 'Eliminado' : 'Error!!' ,
                                  text: res.msg,
                                  shadow: true,
                                  opacity: 0.9,
                                  addclass: noteStack,
                                  type: !res.error ? "success" : 'danger',
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                        ctxattr.refreshAtrib();
                    });
                });
        }
    } 

    ctxind = {
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existen indicadores.</span>";

            var pmraData = ctxplaa.selrow();
            var headGestiones = '';
            for(i = pmraData.periodo_gestion_ini; i <= pmraData.periodo_gestion_fin; i++)
                headGestiones += `<th>${i}</th>`;
            
            var html = `<table class="table table-bordered table-hover fs11 sp_table">
                            <thead><tr class="primary"> <th>Indicador</th> <th>Variable</th>  <th>L. Base</th> <th>Alcance</th>${headGestiones} <th></th> </tr> </thead>
                            <tbody>`;

            data.forEach(function(elem, index){
                var prog_row = '';
                for(i = pmraData.periodo_gestion_ini; i <= pmraData.periodo_gestion_fin; i++){
                    progGestion = _.find(elem.programacion, function(el){
                        return el.gestion == i;
                    }) ;
                    var valor = (progGestion && progGestion.dato) ? `${progGestion.dato } ${elem.unidad}` : '';
                    prog_row += `<td> ${valor}</td>`;
                }

                var row = `<tr><td>${elem.nombre_indicador}</td> <td>${elem.variable || ''}</td> <td>${ elem.linea_base? elem.linea_base + ' ' + elem.unidad : '' } </td> <td>${elem.alcance || ''} ${elem.unidad || ''}</td> ${prog_row}
                            <td><a href="javascript:void(0)" index_atrib="${index}" class="m-l-10 m-r-10 m-t-10 sel_atrib_edit" title="Editar Indicador y programación" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                                <a href="javascript:void(0)" index_atrib="${index}" class="sel_atrib_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
                            </tr>`;
                html += row;               
            });

            html += `</tbody>
                    </table>`;
            return html;
        },
        cargarElemsForm: function(){
            if($("#form_ind #idp_unidad").html().trim()==''){
                $("#form_ind #idp_unidad").html( metricas.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre} (${op.codigo}) </option>`},'') );
                $("#form_ind #idp_unidad").select2({
                    placeholder: 'Unidad de medida ...',
                });
            }

            if( $("#form_ind #id_diagnostico").html().trim() == ''){
                $("#form_ind #id_diagnostico").html( variablesDiagnostico.reduce(function(carry, op){ return carry + `<option value="${op.id_diagnostico}">${op.variable}</option>`},'')   );
                $("#form_ind #id_diagnostico").select2({
                    placeholder: 'Puede seleccionar una Variable del diagnóstico ',
                }); 
            }

            $("#form_ind #id_diagnostico").change(function() {
                var varsel = _.find(variablesDiagnostico, function(elem){ return elem.id_diagnostico == $("#form_ind #id_diagnostico").val(); });
                if(varsel){ 
                    $("#form_ind #variable").val(varsel.variable);
                    $("#form_ind #idp_unidad").val(varsel.idp_unidad).change();
                    $("#form_ind #linea_base").val(varsel.dato);
                }
            });

            var selpmra = ctxattr.selpmra;
            $("#form_ind #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);
        },
        nuevo: function(){         
            ctxind.cargarElemsForm();
            $("#modal_plaa_ind .tituloModal span").html(`Agregar indicador de Accion/Proyecto`);
            $('#form_ind input:text, #form_ind textarea').val('');
            $("#form_ind  select").val('').change();
            var selpmra = ctxattr.selpmra;
            var html = genera_inputgestiones(selpmra.periodo_gestion_ini, selpmra.periodo_gestion_fin);
            $("#form_ind #gestiones_ind tbody").html(html);            
            ctxgral.showModal("#modal_plaa_ind");
        },
        editar: function(index){
            ctxind.cargarElemsForm();
            $("#modal_plaa_ind .tituloModal span").html(`Modificar indicador de Accion/Proyecto`);            

            var indicadorsel = ctxattr.data[index];            
            $("#form_ind #id_arti_pdes_proyecto_indicador").val(indicadorsel.id_arti_pdes_proyecto_indicador);
            $("#form_ind #id_indicador").val(indicadorsel.id_indicador);
            $("#form_ind #id_indicador_ejecucion").val(indicadorsel.id_indicador_ejecucion);

            $("#form_ind #id_diagnostico").val('').change();
            $("#form_ind #nombre").val(indicadorsel.nombre_indicador);
            $("#form_ind #variable").val(indicadorsel.variable);
            $("#form_ind #idp_unidad").val(indicadorsel.idp_unidad).change();
            $("#form_ind #linea_base").val(indicadorsel.linea_base);
            $("#form_ind #alcance").val(indicadorsel.alcance);
            var selpmra = ctxattr.selpmra;
            var html = genera_inputgestiones(selpmra.periodo_gestion_ini, selpmra.periodo_gestion_fin, indicadorsel.programacion);
            $("#form_ind #gestiones_ind tbody").html(html);
            ctxgral.showModal("#modal_plaa_ind");
        },        
        validateRules: function(){
           return {
                nombre:  { required: 'Campo requerido' },
                idp_unidad:  { required: 'Campo requerido' },
                variable:  { required: 'Campo requerido' },
                linea_base:  { required: 'Campo requerido' },
                alcance:  { required: 'Campo requerido' },
            }                 
        }, 
        getDataForm: function(){
            var selpmra = ctxattr.selpmra;
            gestion_ini = selpmra.periodo_gestion_ini;
            gestion_fin = selpmra.periodo_gestion_fin;
            var obj = {
                _token : ctxgral.token,
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo,
                indicador: {
                    id : $("#form_ind #id_indicador").val(),
                    nombre :$("#form_ind #nombre").val(),
                    idp_unidad: $("#form_ind #idp_unidad").val(),
                    // id_diagnostico: $("#form_ind #id_diagnostico").val(),
                    variable: $("#form_ind #variable").val(),
                    alcance: $("#form_ind #alcance").val(),
                },
                arti_pdes_proyecto_indicador: {
                    id: $("#form_ind #id_arti_pdes_proyecto_indicador").val(),
                    id_arti_pdes_proyecto : ctxattr.selproy.id_arti_pdes_proyecto,
                },
                indicador_ejecucion: {
                    id: $("#form_ind #id_indicador_ejecucion").val(),
                    gestion: gestion_ini - 1,
                    dato: $("#form_ind #linea_base").val(),
                }
            };
            var indProgramacion = [];
            for(var i = gestion_ini; i <= gestion_fin; i++){
                var prog = {};
                prog.id = $("#form_ind .id" + i).val();;
                prog.gestion = i;
                prog.dato =  $("#form_ind .d" + i).val();
                indProgramacion.push(prog);
            }     
            obj.indicadores_programacion = indProgramacion;
            return obj;
        },
        saveData: function(){
            var obj = ctxind.getDataForm();
            ctxattr.saveAtribData('saveIndicadorAccionProg', obj);                         
        },
        eliminar: function(index){
            var indicadorsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', indicadorsel.id_arti_pdes_proyecto_indicador);
        },
    }

    ctxpre = {
        entidades_territoriales:[],
        indicadorsel : {},
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existen datos sobre presupuesto y/o contraparte.</span>";

            var pmraData = ctxplaa.selrow();
            var headGestiones = '';
            for(i = pmraData.periodo_gestion_ini; i <= pmraData.periodo_gestion_fin; i++)
                headGestiones += `<th>${i}</th>`;
            
            var html = `<table class="table table-bordered table-hover fs11 sp_table">
                            <thead><tr class="primary"> <th>Indicador</th> <th>Presupuesto  Contraparte</th> ${headGestiones} <th></th> </tr> </thead>
                            <tbody>`;

            data.forEach(function(elem, index){
                var pres_gc_row = pres_ip_row = '';
                var fila = ` <td> <div>Presup.: Inv. P. </div> <div>Presup.: Gasto </div>${elem.contraparte.length > 0 ? '<div>CntrParte: Inv. P.</div><div>CntrParte: Gasto</div>' : ''} <div><b>TOTAL</b></div> </td> `;
                for(i = pmraData.periodo_gestion_ini; i <= pmraData.periodo_gestion_fin; i++){    
                    presGestion = _.find(elem.presupuesto, function(el){
                        return el.gestion == i;
                    }) ;
                    contrGestion_ip = _.filter(elem.contraparte, function(el){
                        return (el.gestion == i && el.inversion_publica);
                    });
                    contrGestion_gc = _.filter(elem.contraparte, function(el){
                        return (el.gestion == i && el.gasto_corriente);
                    });
                    fila += `<td>`;
                    var acum = 0;
                    var presup_ip = (presGestion && presGestion.inversion_publica) ? `${presGestion.inversion_publica }` : 0;
                    var presup_gc = (presGestion && presGestion.gasto_corriente) ? `${presGestion.gasto_corriente }` : 0;

                    var ctr_ip = contrGestion_ip.reduce(function(carry, el){
                                        return carry + `<div>${el.cod_entidad_territorial} ${el.inversion_publica || 0}</div>`;
                                    }, '');
                    var ctr_gc = contrGestion_gc.reduce(function(carry, el){
                                        return carry + `<div>${el.cod_entidad_territorial} ${el.gasto_corriente || 0}</div>`;
                                    }, '');

                    fila += `<div>${presup_ip}</div><div>${presup_gc}</div>${ctr_ip + ctr_gc}`;    

                    acum +=   ( Number(presup_ip) +  Number(presup_gc) );
                    acum +=  Number(contrGestion_ip.reduce(function(carry, el){
                                        return carry + el.inversion_publica || 0;
                                    }, 0) );
                    acum += Number(contrGestion_gc.reduce(function(carry, el){
                                        return carry + el.gasto_corriente || 0;
                                    }, 0) );
                    fila += `<div><b>${acum}</b></div></td>`;

                }



                var row = `<tr><td>${elem.nombre_indicador}</td> ${fila} 
                            <td ><a href="javascript:void(0)" index_atrib="${index}" class="m-l-10 m-r-10 m-t-10 sel_atrib_edit" title="Editar presupuesto" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                                </td>
                            </tr>`;
                html += row;               
            });

            html += `</tbody>
                    </table>`;
            return html;
        },
        cargarElemsForm: function(indicadorsel){

            var selpmra = ctxattr.selpmra;
            $("#form_pre #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);

            var info_indicador = `Indicador: ${indicadorsel.nombre_indicador} <br> Variable: ${indicadorsel.variable ||''} 
            <br> Unidad medida:  ${indicadorsel.unidad ||''} `;
            $("#pre_datos_indicador h5").html(info_indicador);

            $.get(globalSP.urlApi + 'getparametros/entidad_territorial', function(res){
                ctxpre.entidades_territoriales = _.sortBy(res.data, 'id');
            });
        },
        nuevo: function(){         
            // ctxind.cargarElemsForm();
            // $("#modal_plaa_pre .tituloModal span").html(`Agregar Presupuesto`);
            // $('#form_pre input:text, #form_pre textarea').val('');
            // $("#form_pre  select").val('').change();
            // var selpmra = ctxattr.selpmra;
            // var html = genera_inputgestiones(selpmra.periodo_gestion_ini, selpmra.periodo_gestion_fin);
            // $("#form_pre #gestiones_ind tbody").html(html);            
            // ctxgral.showModal("#modal_plaa_pre");
        },
        genera_inputgestiones : function(gestion_ini, gestion_fin, dataP, dataC, gestion){
            if(gestion){
                return  `<div class="row pv5 sp_contrp">  
                                <div class="col-xs-12 fs11">
                                    Entidad Territorial: 
                                    <input type="hidden" id="sp_contrp_id_${g}" class="sp_contrp_id" value=""> 
                                    <select class=" sp_contrp_idp_et fs11"> 
                                        ${ _.reduce(ctxpre.entidades_territoriales, function(carr, op){
                                                return carr + `<option value="${op.id}">${op.codigo}- ${op.nombre}</option>`
                                            }, '')
                                        } 
                                    </select>
                                    <input type="hidden" class="sp_contrp_g" value="${gestion}"> 
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" id="sp_contrp_ip_${g}" class="gui-input w150 sp_contrp_ip" placeholder="Inv. Pub." value="">                                    
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" id="sp_contrp_gc_${g}" class="gui-input w150 sp_contrp_gc" placeholder="Gasto Corr." value="">
                                </div>
                                <div class="col-xs-2">
                                    <a href="javascript:void(0)" class="fa fa-minus-circle text-danger pull-right sp_contrp_quita"></a>
                                </div>
                                
                        </div>`
            }

            var htmlPresup = `<div><h4>Presupuesto</h4></div>
                        <table>
                        <tr><td class="mr10"></td><td><h5>Inv. Pública</h5></td><td><h5>Gasto Corriente</h5></td></tr>`;
                        

            var htmlContrp = `<div><h4>Contraparte</h4></div>
                        <table>
                        <tr><td class="mr10"></td><td><h5> 
                                                    <div class="row">
                                                            <div class="col-xs-4"><span>Inv. Pública </span></div>
                                                            <div class="col-xs-4"> <span> Gasto Corriente</span></div>
                                                        </div>
                                                        </h5></td></tr>`; 

            for(var g = gestion_ini; g <= gestion_fin; g++)
            { 
                var pres = { id_presupuesto:'', invp: '', gasc: ''};                
                if(dataP && dataP.length>0)
                    pres =  _.find(dataP, function(pre){ return pre.gestion == g});
                
                htmlPresup += `<tr class="mv5 br-b ">
                            <td class="fs17 w50">
                                <span class="glyphicon glyphicon-chevron-right text-info">${g}</span> 

                            </td>
                            <td class="fs14 fw700 text-muted"> 
                                <input type="hidden" id="sp_presup_id_${g}"  value="${pres.id_presupuesto || ''}">             
                                <input type="text" id="sp_presup_ip_${g}"  class="gui-input w150 sp_dato" placeholder="Inv. Pub." value="${pres.inversion_publica || ''}">
                            </td>
                            <td class="fs14 fw700 text-muted ">                           
                                <input type="text" id="sp_presup_gc_${g}" class="gui-input w150 sp_dato" placeholder="Inv. Pub."  value="${pres.gasto_corriente || ''}">
                            </td>
                        </tr>`;


                var ctr =[];
                if(dataC && dataC.length>0)
                    ctr =  _.filter(dataC, function(ctr){ return ctr.gestion == g});

                htmlContrp += `<tr class="mv5 br-b">
                            <td class="fs17 w75">
                                <a href="javascript:void(0)" class="fa fa-plus-circle text-warning sp_contrp_add" sp_contrp_g="${g}" title="Agreagar Contraparte con entidad territorial en esta gestión"></a>
                                <span class="glyphicon glyphicon-chevron-right text-info">${g}</span>
                            </td>
                            <td class="fs14 fw700 text-muted ">
                                ${ 
                                    _.reduce(ctr, function(carr, elemCtr){
                                    return `<div  class="row pv5 sp_contrp">  
                                                    <div class="col-xs-12  fs11">
                                                        Entidad Territorial: <small>${elemCtr.cod_entidad_territorial}- ${elemCtr.entidad_territorial} </small>
                                                        <input type="hidden" id="sp_contrp_id_${g}" class="sp_contrp_id" value="${elemCtr.id_contraparte}"> 
                                                        <input type="hidden" id="sp_contrp_idp_et_${g}" class="sp_contrp_idp_et" value="${elemCtr.idp_entidad_territorial}">
                                                        <input type="hidden" id="sp_contrp_g_${g}" class="sp_contrp_g" value="${g}"> 
                                                        
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="text" id="sp_contrp_ip_${g}" class="gui-input w150 sp_contrp_ip" placeholder="Inv. Pub." value="${elemCtr.inversion_publica || ''}">                                                        
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="text" id="sp_contrp_gc_${g}" class="gui-input w150 sp_contrp_gc" placeholder="Gasto Corr." value="${elemCtr.gasto_corriente || ''}">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <a href="javascript:void(0)" class="fa fa-minus-circle text-danger pull-right sp_contrp_quita" title="Quitar contraparte, se almacenará este cambio al guardar"></a>
                                                    </div>                                                    
                                            </div>`
                                    },'')
                                }
                            </td>
                        </tr>`;
            }
            htmlPresup += `</table>`;
            htmlContrp += `</table>`;
            return { inputs_presupuesto :htmlPresup, inputs_contraparte: htmlContrp};            
        },
        editar: function(index){
            ctxpre.indicadorsel = ctxattr.data[index];    
            ctxpre.cargarElemsForm(ctxpre.indicadorsel);
            $("#modal_plaa_pre .tituloModal span").html(`Presupuesto`);                    
            var selpmra = ctxattr.selpmra;
            var inputs = ctxpre.genera_inputgestiones(selpmra.periodo_gestion_ini, selpmra.periodo_gestion_fin, ctxpre.indicadorsel.presupuesto, ctxpre.indicadorsel.contraparte);
            $("#form_pre #gestiones_presup").html(inputs.inputs_presupuesto);
            $("#form_pre #gestiones_contrp").html(inputs.inputs_contraparte);
            ctxgral.showModal("#modal_plaa_pre");
        },        
        validateRules: function(){
           return {
                nombre:  { required: 'Campo requerido' },
                idp_unidad:  { required: 'Campo requerido' },
                variable:  { required: 'Campo requerido' },
                linea_base:  { required: 'Campo requerido' },
                alcance:  { required: 'Campo requerido' },
            }                 
        }, 
        getDataForm: function(){
            var selpmra = ctxattr.selpmra;
            gestion_ini = selpmra.periodo_gestion_ini;
            gestion_fin = selpmra.periodo_gestion_fin;
            var presupuestos = [];
            var contrapartes = [];
            for(var i=gestion_ini; i<=gestion_fin; i++){
                var objp = {
                    id: $("#sp_presup_id_"+i).val(),
                    inversion_publica : $("#sp_presup_ip_"+i).val(),
                    gasto_corriente : $("#sp_presup_gc_"+i).val(),
                    gestion : i,
                    id_arti_pdes_proyecto_indicador : ctxpre.indicadorsel.id_arti_pdes_proyecto_indicador
                };
                presupuestos.push(objp);
            }

            $(".sp_contrp").each(function(elem){
                var objc = {
                    id: $(this).find('.sp_contrp_id').val(),
                    idp_entidad_territorial: $(this).find('.sp_contrp_idp_et').val(),
                    gestion: $(this).find('.sp_contrp_g').val(),
                    inversion_publica: $(this).find('.sp_contrp_ip').val(),
                    gasto_corriente: $(this).find('.sp_contrp_gc').val(),
                    id_arti_pdes_proyecto_indicador : ctxpre.indicadorsel.id_arti_pdes_proyecto_indicador
                };
                contrapartes.push(objc);
            });

           return {
                _token : ctxgral.token,
                presupuestos : presupuestos, 
                contrapartes: contrapartes
            };


        },
        saveData: function(){
            var obj = ctxpre.getDataForm();
            console.log(obj)
            ctxattr.saveAtribData('savepresupuestoscontrapartes', obj);                         
        },
        eliminar: function(index){
            var indicadorsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', indicadorsel.id_arti_pdes_proyecto_indicador);
        },
    }

    ctxres = {
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existen instituciones responsables registradas.</span>";
           
            var html = `<table class="table table-bordered table-hover fs11 sp_table" style="width:600px">
            <thead><tr class="primary"> <th>Nombre</th> <th>Sigla</th> <th>_</th> </thead>
            <tbody>`;
            data.forEach(function(elem, index){                
                html += `<tr><td>${elem.nombre_entidad}</td> <td>${elem.sigla}</td> 
                <td>
                <a href="javascript:void(0)" index_atrib="${index}" class="sel_atrib_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
                </tr>`;              
            });

            html += `</tbody>
            </table>`;
            return html;
        },
        cargarElemsForm: function(fn){
            if($("#form_res #id_entidades").html().trim()==''){
                $.get(globalSP.urlApi + 'getEntidadesHijos/' + globalSP.usuario.id_institucion, function(res){
                    $("#form_res #id_entidades").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre} (${op.sigla}) </option>`},'') )
                    if(fn){
                        fn();
                    }
                });

            }
            else { if(fn) fn();  }

            $("#form_res #id_entidades").select2({
                    placeholder: 'Seleccione las instituciones responsables',
                    templateSelection: function (val) {
                        return $("<div class='list-group-item' style='width:100%;' title ='" + val.text + "'>" +val.text + "</div>");
                    },
                });
            var selpmra = ctxattr.selpmra;
            $("#form_res #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);

        },
        nuevo: function(){     
            ids= [];   
            ctxattr.data.forEach(function(el){
                ids.push(el.id_entidad);
            })

            ctxres.cargarElemsForm(function(){
                $("#form_res  #id_entidades").val(ids).change();
            });
            $("#modal_plaa_res .tituloModal span").html(`Agregar/Quitar Responsables`);
            // $("#form_res  select").val('').change();          
            ctxgral.showModal("#modal_plaa_res");
        },
        validateRules: function(){
             return {
                id_entidades:  { required: 'Campo requerido' },
            }                 
        }, 
        saveData: function(){
            var obj = ctxplaa.getDataContent('#form_res') ;
            obj.id_arti_pdes_proyecto = ctxattr.selproy.id_arti_pdes_proyecto;
            ctxattr.saveAtribData('saveresponsables', obj);                         
        },
        eliminar: function(index){
            var elemsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', elemsel.id_responsable);
        },
    }

    ctxrol = {
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existen roles actores registrados.</span>";
           
            var html = `<table class="table table-bordered table-hover fs11 sp_table" >
            <thead><tr class="primary"> <th>Actor</th> <th>Descripción</th> <th>_</th> </thead>
            <tbody>`;
            data.forEach(function(elem, index){                
                html += `<tr><td>${elem.actor}</td> <td>${elem.descripcion}</td> 
                <td>                
                    <a href="javascript:void(0)" index_atrib="${index}" class="m-l-10 m-r-10 m-t-10 sel_atrib_edit" title="Editar" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                    <a href="javascript:void(0)" index_atrib="${index}" class="sel_atrib_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>
                </td>
                </tr>`;              
            });

            html += `</tbody>
            </table>`;
            return html;
        },
        cargarElemsForm: function(fn){
            if($("#form_rol #idp_actor").html().trim()==''){
                $.get(globalSP.urlApi + 'getparametros/actor', function(res){
                    var actores = _.sortBy(res.data, 'nombre');
                    $("#form_rol #idp_actor").html( actores.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre} </option>`},'<option value=""></option>') )
                    if(fn){
                        fn();
                    }
                });

            }
            else { if(fn) fn(); }

            $("#form_rol #idp_actor").select2({
                    placeholder: 'Seleccione el actor',
                });
            var selpmra = ctxattr.selpmra;
            $("#form_rol #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);

        },
        nuevo: function(){     
            ctxrol.cargarElemsForm();
            $("#modal_plaa_rol .tituloModal span").html(`Agregar rol actor`);
            $("#form_rol  textarea, #form_rol  input").val('');          
            $("#form_rol  select").val('').change();          
            ctxgral.showModal("#modal_plaa_rol");
        },
        editar: function(index){
            var rolsel = ctxattr.data[index];    
            ctxrol.cargarElemsForm(function(){
                $("#form_rol #idp_actor").val(rolsel.idp_actor);
            });
            $("#form_rol #id_rol_actor").val(rolsel.id_rol_actor);
            $("#form_rol #descripcion").val(rolsel.descripcion);

            $("#modal_plaa_rol .tituloModal span").html(`Modificar Actor Rol`);                        
            ctxgral.showModal("#modal_plaa_rol");
        }, 
        validateRules: function(){
             return {
                idp_actor:  { required: 'Campo requerido' },
                descripcion:  { required: 'Campo requerido' },
            }                 
        }, 
        saveData: function(){
            var obj = ctxplaa.getDataContent('#form_rol') ;
            obj.id_arti_pdes_proyecto = ctxattr.selproy.id_arti_pdes_proyecto;
            ctxattr.saveAtribData('saverolesactores', obj);                         
        },
        eliminar: function(index){
            var elemsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', elemsel.id_rol_actor);
        },
    }

    ctxart = {
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existe ninguna Articulación Competencial registrada.</span>";
           
            var html = `<table class="table table-bordered table-hover fs11 sp_table" >
            <thead><tr class="primary"> <th>Entidad Territorial</th> <th>Competencia</th> <th>Norma</th> <th>_</th> </thead>
            <tbody>`;
            data.forEach(function(elem, index){                
                html += `<tr><td>${elem.nombre_entidad_territorial}</td> <td>${elem.nombre_competencia}</td> <td>${elem.norma}</td> 
                <td>                
                    <a href="javascript:void(0)" index_atrib="${index}" class="m-l-10 m-r-10 m-t-10 sel_atrib_edit" title="Editar" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                    <a href="javascript:void(0)" index_atrib="${index}" class="sel_atrib_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>
                </td>
                </tr>`;              
            });

            html += `</tbody>
            </table>`;
            return html;
        },
        cargarElemsForm: function(fn_et, fn_c){
            if($("#form_art #idp_entidad_territorial").html().trim()==''){
                $.get(globalSP.urlApi + 'getparametros/entidad_territorial', function(res){
                    var entidadesTerritoriales = _.sortBy(res.data, 'id');
                    $("#form_art #idp_entidad_territorial").html( entidadesTerritoriales.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre} (${op.codigo})</option>`},'<option value=""></option>') )
                    if(fn_et) fn_et();
                });
            }
            else { if(fn_et) fn_et(); }

            if($("#form_art #idp_competencia").html().trim()==''){
                $.get(globalSP.urlApi + 'getparametros/competencia', function(res){
                    var competencias = _.sortBy(res.data, 'orden');
                    $("#form_art #idp_competencia").html( competencias.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre}</option>`},'<option value=""></option>') )
                    if(fn_c) fn_c();
                });
            }
            else { if(fn_c) fn_c(); }


            $("#form_art #idp_entidad_territorial").select2({
                    placeholder: 'Seleccione la entidad territorial',
            });
            $("#form_art #idp_competencia").select2({
                    placeholder: 'Seleccione la competencia',
            });

            var selpmra = ctxattr.selpmra;
            $("#form_art #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);

        },
        nuevo: function(){     
            ctxart.cargarElemsForm();
            $("#modal_plaa_art .tituloModal span").html(`Agregar Articulación Competencial`);
            $("#form_art  textarea, #form_art  input").val('');          
            $("#form_art  select").val('').change();          
            ctxgral.showModal("#modal_plaa_art");
        },
        editar: function(index){
            var artsel = ctxattr.data[index];    
            ctxart.cargarElemsForm(function(){
                $("#form_art #idp_entidad_territorial").val(artsel.idp_entidad_territorial);
            }, function(){
                $("#form_art #idp_competencia").val(artsel.idp_competencia);
            });

            $("#form_art #id_articulacion_competencial").val(artsel.id_articulacion_competencial);
            $("#form_art #norma").val(artsel.norma);

            $("#modal_plaa_art .tituloModal span").html(`Modificar Articulación Competencial`);                        
            ctxgral.showModal("#modal_plaa_art");
        }, 
        validateRules: function(){
             return {
                idp_entidad_territorial:  { required: 'Campo requerido' },
                idp_competencia:  { required: 'Campo requerido' },
                norma:  { required: 'Campo requerido' },
            }                 
        }, 
        saveData: function(){
            var obj = ctxplaa.getDataContent('#form_art') ;
            obj.id_arti_pdes_proyecto = ctxattr.selproy.id_arti_pdes_proyecto;
            ctxattr.saveAtribData('savearticulacioncompetencial', obj);                         
        },
        eliminar: function(index){
            var elemsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', elemsel.id_articulacion_competencial);
        },
    }

    ctxter = {
        fillData: function(data){
            if (data.length == 0) 
                return "<span class='p5 ml10'>No existen territorios registradas.</span>";
           
            var html = `<table class="table table-bordered table-hover fs11 sp_table" style="width:600px">
            <thead><tr class="primary"> <th>Nombre</th> <th>Codigo</th> <th>Nivel</th> <th>_</th> </thead>
            <tbody>`;
            data.forEach(function(elem, index){                
                html += `<tr><td>${elem.nombre_region}</td> <td>${elem.codigo_region}</td> <td>${elem.categoria_region}</td> 
                <td>
                <a href="javascript:void(0)" index_atrib="${index}" class="sel_atrib_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
                </tr>`;              
            });

            html += `</tbody>
            </table>`;
            return html;
        },
        cargarElemsForm: function(fn){
            if($("#form_ter #id_departamento").html().trim()==''){
                $.get(globalSP.urlApi + 'list_regiones', {id_padre : 1}, function(res){
                    $("#form_ter #id_departamento").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.codigo_numerico} - ${op.nombre_comun} </option>`},'') );

                });
            }

            $("#form_ter #id_departamento").change(function(){
                if($("#form_ter #id_departamento").val())
                    $.get(globalSP.urlApi + 'list_regiones/', {id_padre : $("#form_ter #id_departamento").val()[0]}, function(res){
                        $("#form_ter #id_provincia").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.codigo_numerico} - ${op.nombre_comun} </option>`},'') );
                        $("#form_ter #id_municipio, #form_ter #id_comunidad").html('');
                    });
                else {
                    $("#form_ter #id_provincia, #form_ter #id_municipio, #form_ter #id_comunidad").html('');
                }    
            }).select2({
                placeholder: 'Seleccione el departamento',
            });

            $("#form_ter #id_provincia").change(function(){
                if($("#form_ter #id_provincia").val())
                    $.get(globalSP.urlApi + 'list_regiones/', {id_padre : $("#form_ter #id_provincia").val()[0]}, function(res){
                        $("#form_ter #id_municipio").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.codigo_numerico} - ${op.nombre_comun} </option>`},'') );
                        $("#form_ter #id_comunidad").html('')
                    }); 
                else{
                    $("#form_ter #id_municipio, #form_ter #id_comunidad").html('');
                }   
            }).select2({
                placeholder: 'Seleccione la provincia',
            });

            $("#form_ter #id_municipio").change(function(){
                if($("#form_ter #id_municipio").val())
                    $.get(globalSP.urlApi + 'list_regiones/', {id_padre : $("#form_ter #id_municipio").val()[0]}, function(res){
                        $("#form_ter #id_comunidad").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.codigo_numerico} - ${op.nombre_comun} </option>`},'') )
                    });
                    else{
                        $("#form_ter #id_comunidad").html('');
                    }    
            }).select2({
                placeholder: 'Seleccione el municipio',
            });

            $("#form_ter #id_comunidad").select2({
                    placeholder: 'Seleccione la comunidad',
                });


            $("#form_ter [sp_carga_region]").click(function(){
                var selectSel = $(this).attr('sp_carga_region');
                var html = $("#" + selectSel + ' option:selected').toArray().reduce(function(carry, el){
                    return carry + `<div sp_id_region="${el.value}" class="br-b p5" style="width:100%">${el.text} <a href="javascript:void(0)" class="fa fa-times pull-right sp_quita_region" style="cursor:pointer"></a></div> `
                },'');  
                $("#id_regiones").append(html);
            });

            $("#form_ter").on('click', ".sp_quita_region", function(){
                $(this).parent().remove();
            });
            
            var selpmra = ctxattr.selpmra;
            $("#form_ter #pmra_plaa").html(`<div><b>${selpmra.cod_p} . ${selpmra.cod_m} . ${selpmra.cod_r} . ${selpmra.cod_a}</b> </div>
                                            <div><b>${selpmra.nombre_p}</b> - ${selpmra.desc_p} </div>
                                            <div><b>${selpmra.nombre_m}</b> - ${selpmra.desc_m} </div>
                                            <div><b>${selpmra.nombre_r}</b> - ${selpmra.desc_r} </div>
                                            <div><b>${selpmra.nombre_a} - ${selpmra.desc_a}</b> </div>
                                            <b>PROYECTO:  ${ctxattr.selproy.nombre_proyecto}</b>`);
        },
        nuevo: function(){  
            $("#modal_plaa_ter select, #modal_plaa_ter #id_regiones").html('');   
            ctxter.cargarElemsForm();
            $("#modal_plaa_ter .tituloModal span").html(`Agregar Territorios`);       
            ctxgral.showModal("#modal_plaa_ter");
        },
        validateRules: function(){
             return {
                id_regiones:  { required: 'Campo requerido' },
            }                 
        }, 
        saveData: function(){
            var id_regiones = [];
            $("#form_ter").find("div[sp_id_region]").each(function(index, el){
                var id_region = $(el).attr('sp_id_region');
                id_regiones.push(id_region); 
            });
            var obj = {};
            obj.id_arti_pdes_proyecto = ctxattr.selproy.id_arti_pdes_proyecto;
            obj.id_regiones = id_regiones;
            obj._token = ctxgral.token;
            ctxattr.saveAtribData('saveterritorializacion', obj);                         
        },
        eliminar: function(index){
            var elemsel = ctxattr.data[index]; 
            ctxattr.deleteAtrib('delete_atributo', elemsel.id_territorializacion);
        },
    }







    var init_plaa = (function(){
            /* ----------------- FUNCIONES de inicio y genrales------------------------------------------------------ */

        var listeners_plaa = function()
        {                      
            /* Carga tipo proyecto */  
            $.get(globalSP.urlApi + "getparametros/tipo_proyecto", function(res){
                var html = res.data.reduce(function(retorno, op){
                    return retorno + `<option value="${op.codigo}">${op.nombre} </option>`;
                }, '<option value="">Seleccione el tipo de Proyecto ...</option>');
         
                $("#codp_tipo_proyecto").append(html);                
            });

                       
            /* De los selects*/
            $("#select_id_proyecto").select2({
            }); 


            /*comportamientos del select codp_tipo_proyecto si es pdes, accion sector, continuidad o producto*/
            $("#codp_tipo_proyecto").change(function() {                
                var tipo = $(this).val();
                var t=400; 
                if(tipo == ''){
                    $("#proy-ocultos").addClass('hidden');
                }
                else{
                    $("#proy-ocultos").removeClass('hidden');
                    $(".proy-ocultos").hide(300);
                    $(".proy-ocultos input, .proy-ocultos textarea, .proy-ocultos select").removeAttr('disabled').removeClass(ctxplaa.cssDisabled).val(''); 

                    /* selecciona PDES */
                    if(tipo == 'pdes'){

                        $(".section_select_id_proyecto").show(t); 
                        $(".section_codigo").show(t);
                        $("#codigo").attr('disabled', 'disabled').addClass(ctxplaa.cssDisabled); 
                        var ops = _.chain(ctxplaa.proyectos).filter(function(elem){
                            return elem.codp_tipo_proyecto=='pdes';
                        }).reduce(function(carry, elem){
                            return carry + `<option value="${elem.id}"><b>${elem.codigo || '-' } </b>- ${elem.nombre_proyecto}</option>`
                        },'<option value="">seleccione proyecto PDES ...</option>').value();
                        $("#select_id_proyecto").html(ops);    

                    }
                    /* selecciona Accion sector*/
                    else if(tipo == "accs"){
                        $(".section_nombre_proyecto").show(t);
                        $("#nombre_proyecto").attr('disabled', 'disabled').addClass(ctxplaa.cssDisabled);
                        $("#nombre_proyecto").val(ctxplaa.selrow().desc_a);

                    }
                    /* selecciona continuidad*/
                    else if(tipo == "cont"){
                        $(".section_select_id_proyecto").show(t);
                        var ops = ctxplaa.proyectos.reduce(function(carry, elem){
                            return carry +  `<option value="${elem.id}">${elem.codigo || '-'} ${elem.nombre_proyecto}</option>`;
                        }, '<option value="">seleccione proyecto...</option>');
                        $("#select_id_proyecto").html(ops);
                    }
                    /*Selecciona Prodcto*/
                    else if(tipo == "prod"){
                        $(".section_nombre_proyecto").show(t);
                        $(".section_codigo").show(t);
                        $("#nombre_proyecto").val('');
                        $("#codigo").val('');
                    }
                } 
            });

            /* Cuando cambia el combo de proyectos se actualiza el input codigo en caso de tipo_proyecto pdes*/
            $("#select_id_proyecto").change(function(){
                if($("#codp_tipo_proyecto").val()=='pdes'){ 
                    var proysel = _.find(ctxplaa.proyectos, function(elem){
                        return elem.id == $("#select_id_proyecto").val();
                    });
                    $("#codigo").val(proysel.codigo);
                };
                proyNombre = $('#select_id_proyecto').find('option:selected').text();
                $("#nombre_proyecto").val(proyNombre);
            }); 



            /* ---------- Contexto plaa proy ---------------------------------------------------------*/
            ctxplaa.fillDataTable();

            $("#form_plaa").validate(ctxgral.creaValidateRules(ctxplaa));

            $("#container_dt_plaa").on('click', '.sel_add', function(){
                ctxplaa.nuevo()
            });

            $("#container_dt_plaa").on('click', '.sel_edit', function(){
                var index = $(this).attr("index_proy");
                ctxplaa.editar(index);
            });

            $("#container_dt_plaa").on('click', '.sel_delete', function(){
                var id = $(this).attr("id_arti_pdes_proyecto");
                ctxplaa.delete(id);
            });

            $(".sp_cancelar").click(function(){
                $.magnificPopup.close();
            });

            /* botones de la tabla que habilita la visualizacion de indicadores, responsables  y otros atributos */
            $("#container_dt_plaa").on('click', '[proy-index]', function(){   
                $("#container_dt_plaa tr").removeClass('bg-warning lighter');
                $(this).parent().parent().addClass('bg-warning lighter');
                var atributo = $(this).attr('proy-atrib');
                var index = $(this).attr('proy-index');
                ctxattr.cargarAtrib( atributo, index);
            });
            /* botones del p_contenido para indicadores, responsables, etc*/
            $("#p_contenido").on('click', '[proy-atrib]', function(){   
                var atributo = $(this).attr('proy-atrib');
                ctxattr.cargarAtrib( atributo);
            });


            /* Comportamientos de Presupuestos contrapartes*/
            $("#modal_plaa_pre").on('click', '.sp_contrp_add', function(){
                var gestion = $(this).attr('sp_contrp_g');
                var tds = $(this).parent().parent().find('td');
                $(tds[1]).append(ctxpre.genera_inputgestiones(null, null, null, null, gestion) );

            });

            $("#modal_plaa_pre").on('click', '.sp_contrp_quita', function(){
                $(this).parent().parent().remove();
            });

            /* ---------- Contexto atrib ---------------------------------------------------------*/

            $("#atrib_nuevo").click(function(){
                ctxattr.abmAtrib('nuevo');
            });

            $("#p_atribContenido").on('click', '.sel_atrib_edit', function(){
                var index = $(this).attr('index_atrib');
                ctxattr.abmAtrib('editar', index);
            });

            $("#p_atribContenido").on('click', '.sel_atrib_delete', function(){
                var index = $(this).attr('index_atrib');
                ctxattr.abmAtrib('eliminar', index);
            });

            /*  validaciones atribs */
            $("#form_ind").validate(ctxgral.creaValidateRules(ctxind));
            $("#form_pre").validate(ctxgral.creaValidateRules(ctxpre));
            $("#form_res").validate(ctxgral.creaValidateRules(ctxres));
            $("#form_rol").validate(ctxgral.creaValidateRules(ctxrol));
            $("#form_art").validate(ctxgral.creaValidateRules(ctxart));
            $("#form_ter").validate(ctxgral.creaValidateRules(ctxter));

        }

        listeners_plaa();

    })();







})






</script>


