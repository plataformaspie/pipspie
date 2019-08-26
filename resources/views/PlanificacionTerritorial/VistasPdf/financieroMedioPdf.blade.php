<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
<style>
	 html {
      margin: 0px;
    } 
    body{
      /*background-color: #632432;*/
      font-family: Arial;
      font-size: 8px;
      margin: 0mm 10mm 10mm 10mm;
      padding: 0;
    }

    #main-container{
      margin: 30px auto;
      width: 100%;
    }
    header{
      position: fixed;
      margin-top: 20px;
      margin-bottom: 20px;
      margin-right: 20px;
      overflow: hidden;
    }
    footer {
          position: fixed;
          bottom: 0cm; 
          left: 1cm; 
          right: 0cm;
          height: 2cm;
    }

    table, td{
        border:1px solid black;
        border-collapse: collapse;
        text-align: center;
        padding: 5px;
    }
    table thead{
        font-weight: bold;
        color:white;
        background-color: #03a9f3;
    }
    table thead,th{
        
        border:1px solid white;
    }
    table tbody{
        background-color: #white;
    }
    .alinear-derecha{
      width: 300px;
      position: relative;
      right: -350px;
    }
    .alinear_izquierda{
      width: 300px;
      text-align: left;
      /*position:relative
      right: 0px;
      top:0px;*/
      margin-left: -150px;
      float: right;
    }
    .firmas{
      background-color: white;
      overflow: hidden;
      margin-top: 50px;
    }
    .firmas ul {
      display: inline-block;;
    }
    .firmas ul li {
      list-style: none;
    }
    .pagenum:before {
          content: counter(page);
    }
    .numero_pagina{
          position: relative;
      top: 0.3cm;
      left: 1.25cm;
    }
    .logo_dpgt{
      
      float: left;
    }
    .logo_mpd{
      float: right;
     margin-top: 5px;

    }
    .page-break {
    page-break-after: always;
}
	

</style>
</head>
	
	<body>
        <header>
          <div>
            <img class="logo_mpd" src="img/mpd_jpeg_reportes.jpeg" height="40px" width="250px" />  
          </div>
          <div class="logo_dgpt">
             <img  src="img/DGPT.jpeg" height="40px" width="250px" />   
          </div>
        </header>
        <br>
        <br>
        <h2>DATOS DEL MUNICIPIO:</h2>
        <div><strong>DENOMINACION:</strong> {{ strtoupper($institucion->denominacion) }}</h3>
        <div><strong>SIGLA: </strong>{{ $institucion->sigla }}</div>
        <div><strong>CODIGO:</strong> {{ $institucion->codigo }}</div>
        <div><strong>GRUPO CLASIFICADOR:</strong> {{ $institucion->clasificador }}</div>
        <br>
        <br>
		<div id="main-container">
			<h1>CUADRO Nº3</h1>
			<h2>EVALUACION A LA EJECUCION FISICO - FINANCIERO</h2>
			<h3>GESTION : 2016 - 2018</h3>
			<table class="table table-bordered" >
        <thead >
          <tr>
            <th  style="vertical-align:middle" rowspan="3" colspan="2">ACCION DE MEDIANO PLAZO ETA</th>
            <th  style="vertical-align:middle" rowspan="2" colspan="3">PLANIFICACION</th>
            <th  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE RECURSOS</th>
            <th  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE ACCIONES</th>
            <th style="vertical-align:middle" rowspan="3" >CAUSAS DE VARIACION</th>
          </tr>
          <tr>
            
            <th style="vertical-align:middle" colspan="2" >2016</th>
            <th style="vertical-align:middle" colspan="2" >2017</th>
            <th style="vertical-align:middle" colspan="2" >2018</th>
            <th style="vertical-align:middle" rowspan="2" >TOTAL<br/>PRES. PROGRAMADO<br/>(2016-2018)</th>
            <th style="vertical-align:middle" rowspan="2">TOTAL<br/> PRES. EJECUTADO<br/>(2016-2018)</th>
            <th style="vertical-align:middle" rowspan="2">% EJEC.</th>
            <th style="vertical-align:middle" rowspan="2">META AL<br/> 2020</th>
            <th style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</th>
            <th style="vertical-align:middle" colspan="2">2016</th>
            <th style="vertical-align:middle" colspan="2">2017</th>
            <th style="vertical-align:middle" colspan="2">2018</th>
            <th style="vertical-align:middle" rowspan="2" >TOTAL <br/>PROGRAMACION DE ACCIONES<br/>(2016-2018)</th>
            <th style="vertical-align:middle" rowspan="2">TOTAL<br/> ACCIONES EJECUTADO<br/>(2016-2018)</th>
            <th style="vertical-align:middle" rowspan="2">% EJEC.</th>
            <th style="vertical-align:middle" rowspan="2">META <br/>AL 2020</th>
            <th style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</th>
          </tr>
          <tr>
            
            <th>PthI/<br/>PGTC</th>
            <th>PEI</th>
            <th>POA</th>
            <th style="vertical-align:middle">P</th>
            <th style="vertical-align:middle">E</th>
            <th style="vertical-align:middle">P</th>
            <th style="vertical-align:middle" >E</th>
            <th style="vertical-align:middle" >P</th>
            <th style="vertical-align:middle" >E</th>
            <th style="vertical-align:middle">P</th>
            <th style="vertical-align:middle">E</th>
            <th style="vertical-align:middle">P</th>
            <th style="vertical-align:middle" >E</th>
            <th style="vertical-align:middle" >P</th>
            <th style="vertical-align:middle" >E</th>
          </tr>
        </thead>
        <tbody>
          @foreach($programa as $p)
            @if($p->cantidad_objetivos > 1)
            <tr>
              <td colspan="2">{{ $p->nombre_programa}}</td>
              <td colspan="3">TOTALES</td>
              
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_programado_2016,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_ejecutado_2016,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_programado_2017,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_ejecutado_2017,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_programado_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_ejecutado_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_total_programado_2016_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_total_ejecutado_2016_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_porcentaje_ejecutado,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_meta_programado_al_2020,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->recurso_porcentaje_ejecucion_al_2020,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_programado_2016,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_ejecutado_2016,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_programado_2017,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_ejecutado_2017,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_programado_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_ejecutado_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_total_programado_2016_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_total_ejecutado_2016_2018,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_porcentaje_ejecutado,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_meta_al_2020,2,".",",") }}</td>
              <td style="text-align: right;">{{ number_format($p->totales_agregador[0]->accion_porcentaje_ejecucion_al_2020,2,".",",") }}</td>
              <td></td>
            </tr>
            @foreach($p->objetivos_eta as $o)
            <tr>
              <td></td>
              <td>{{ $o->nombre_objetivo}}</td>
              @if($o->datos_evaluacion[0]->inscrito_ptdi == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              @if($o->datos_evaluacion[0]->inscrito_pei == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              @if($o->datos_evaluacion[0]->inscrito_poa == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              <td style="text-align: right;">{{ $o->datos_evaluacion[0]->recurso_programado_2016 }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_ejecutado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_programado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_ejecutado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_programado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_ejecutado_201,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_total_programado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_total_ejecutado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_porcentaje_ejecutado,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_meta_programado_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->recurso_porcentaje_ejecucion_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_programado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_ejecutado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_programado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_ejecutado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_programado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_ejecutado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_total_programado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_total_ejecutado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_porcentaje_ejecutado,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_meta_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($o->datos_evaluacion[0]->accion_porcentaje_ejecucion_al_2020,2,",",".") }}</td>
              <td>{{  $o->datos_evaluacion[0]->causas_de_variacion}}</td>
            </tr>
            @endforeach
            
          @else
            <tr>
              <td>{{ $p->nombre_programa }}</td>
              <td>{{ $p->objetivos_eta[0]->nombre_objetivo}}</td>
              @if($p->objetivos_eta[0]->datos_evaluacion[0]->inscrito_ptdi == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              @if($p->objetivos_eta[0]->datos_evaluacion[0]->inscrito_pei == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              @if($p->objetivos_eta[0]->datos_evaluacion[0]->inscrito_poa == true)
                <td>X</td>
              @else
                <td></td>
              @endif
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_programado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_ejecutado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_programado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_ejecutado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_programado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_ejecutado_201,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_total_programado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_total_ejecutado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_porcentaje_ejecutado,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_meta_programado_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->recurso_porcentaje_ejecucion_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_programado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_ejecutado_2016,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_programado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_ejecutado_2017,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_programado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_ejecutado_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_total_programado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_total_ejecutado_2016_2018,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_porcentaje_ejecutado,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_meta_al_2020,2,",",".") }}</td>
              <td style="text-align: right;">{{ number_format($p->objetivos_eta[0]->datos_evaluacion[0]->accion_porcentaje_ejecucion_al_2020,2,",",".") }}</td>
              <td>{{  $p->objetivos_eta[0]->datos_evaluacion[0]->causas_de_variacion}}</td>
            </tr>
          @endif
           
          @endforeach
		    	
        </tbody>
      </table>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <div style="page-break-after: always;">
        <div class="firmas">
          <div class="alinear_izquierda">
            
              <ul >
                <li class="alinear"><strong>Aprobado MAE:</strong></li>
                <li class="alinear"><strong>Nombre:.................................................</strong></li>
                <li class="alinear"><strong>Firma:.....................................................</strong></li>
                <li class="alinear"><strong style="color:white;">.</strong></li>
              </ul>
          </div>
          <div class="alinear-derecha">
            <ul >
                <li class="alinear"><strong>Elaborado por:</strong></li>
                <li class="alinear"><strong>Nombre:.................................................</strong></li>
                <li class="alinear"><strong>Cargo:....................................................</strong></li>
                <li class="alinear"><strong>Firma:.....................................................</strong></li>
              </ul>
          </div>
        </div>
      </div>
		</div>
    <footer >
      <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
    </footer>
      <script type="text/php">
           if (isset($pdf)) {
              $x = 700;
              $y = 565;
              $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";
              $font = null;
              $size = 8;
              $color = array(0,0,0);
              $word_space = 0.0;  //  default
              $char_space = 0.0;  //  default
              $angle = 0.0;   //  default
              $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
          }
      </script>
	</body>
</html>