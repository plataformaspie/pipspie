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
      font-size: 10px;
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
      margin-top: 20px;
      margin-bottom: 20px;
      margin-right: 20px;


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
    	/*position: relative;
      	top: 0.3cm;
      	left: 1.25cm;*/
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
	        <img class="logo_mpd" src="img/mpd.jpg" height="40px" width="250px" />  
	      </div>
	      <div class="logo_dgpt">
	         <img  src="img/DGPT.jpeg" height="40px" width="250px" />
	      </div>
	  </header>
		<div id="main-container">
			<h1>CUADRO Nº4</h1>
			<h2>EVALUACION PROYECTOS DE INVERSION PUBLICA</h2>
			<h3>GESTION : 2016 - 2018</h3>
			<table class="table table-bordered" >
              <thead >
                <tr >
                	<th rowspan="3">ACCION ETA</th>
                  <th  style="vertical-align:middle; text-align:center;" rowspan="2" colspan="3">PLANIFICACION</th>
                  <th  style="vertical-align:middle; text-align:center;" colspan="5" >INSCRITO EN EL VIPFE</th>
                  <th  style="vertical-align:middle; text-align:center;" colspan="9" >CONCURRENCIA ETA</th>
                  <th style="vertical-align:middle; text-align:center;" colspan="5" >TOTAL CONCURRENCIA ENTIDADES</th>
                </tr>
                <tr>
                  <th style="vertical-align:middle" rowspan="2" >COD. SISIN</th>
                  <th style="vertical-align:middle" rowspan="2" >PROYECTO</th>
                  <th style="vertical-align:middle" rowspan="2" >COSTO TOTAL <br/>PROYECTO</th>
                  <th style="vertical-align:middle" colspan="2">PERIODO<br/>DE EJECUCION</th>
                  <th style="vertical-align:middle; text-align:center" colspan="2">2016</th>
                  <th style="vertical-align:middle; text-align:center" colspan="2">2017</th>
                  <th style="vertical-align:middle; text-align:center" colspan="2">2018</th>
                  <th style="vertical-align:middle" colspan="3">TOTALES</th>
                  <th style="vertical-align:middle" rowspan="2">PROG.</th>
                  <th style="vertical-align:middle" rowspan="2">EJEC.</th>
                  <th style="vertical-align:middle" rowspan="2">% EJEC.</th>
                  <th style="vertical-align:middle" rowspan="2">META <br/>AL 2020</th>
                  <th style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</th>
                </tr>
                <tr>
                  <th>PTDI/<br/>PGTC</th>
                  <th>PEI</th>
                  <th>POA</th>
                  <th>DEL</th>
                  <th>AL</th>
                  <th style="vertical-align:middle">PROG.</th>
                  <th style="vertical-align:middle">EJEC.</th>
                  <th style="vertical-align:middle">PROG.</th>
                  <th style="vertical-align:middle">EJEC.</th>
                  <th style="vertical-align:middle">PROG.</th>
                  <th style="vertical-align:middle">EJEC.</th>
                  <th style="vertical-align:middle">PROG.</th>
                  <th style="vertical-align:middle" >EJEC.</th>
                  <th style="vertical-align:middle" >%EJEC</th>
                </tr>
              </thead>
              <tbody>

            	@foreach ($objetivoProyectos as $mifuente)

          			@if($mifuente->cantidad_proyectos_poa >0)
						<tr>
							<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
							<td>X</td>
	                        <td></td>
	                          <td>X</td>
	                          <td>{{ $mifuente->primer_poa->codigo_sisin }}</td>
	                          <td>{{ $mifuente->primer_poa->nombre }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->costo_total_proyecto,2,",",".") }}</td>
	                          <?php

									$date_del = date_create($mifuente->primer_poa->periodo_ejecucion_del);
									$date_al = date_create($mifuente->primer_poa->periodo_ejecucion_al);

								?>
								<td>{{ date_format($date_del, 'd/m/Y') }}</td>
								<td>{{ date_format($date_al, 'd/m/Y') }}</td>

	                          <td>{{ number_format($mifuente->primer_poa->programado_2016,2,",",".") }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->ejecutado_2016,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->programado_2017,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->ejecutado_2017,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->programado_2018,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->ejecutado_2018,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->total_programado,2,",",".")  }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->total_ejecutado,2,",",".")  }}</td>
	                          @if($mifuente->primer_poa->total_porcentaje_ejecutado)
	                          <td >{{ number_format($mifuente->primer_poa->total_porcentaje_ejecutado,2,",",".")  }}</td>
	                          @else
	                          <td ></td>
	                          @endif
	                          <td>{{ number_format($mifuente->primer_poa->concurrencia_entidades_programado,2,",",".") }}</td>
	                          <td>{{ number_format($mifuente->primer_poa->concurrencia_entidades_ejecutado,2,",",".")  }}</td>

	                          @if($mifuente->primer_poa->concurrencia_entidades_porcentaje_ejecutado)
	                          <td >{{ number_format($mifuente->primer_poa->concurrencia_entidades_porcentaje_ejecutado,2,",",".")  }}</td>
	                          @else
	                          <td ></td>
	                          @endif
	                          <td>{{ number_format($mifuente->primer_poa->meta_recurso_2020,2,",",".") }}</td>

	                          @if($mifuente->primer_poa->concurrencia_entidades_porcentaje_al_2020)
	                          <td >{{ number_format($mifuente->primer_poa->concurrencia_entidades_porcentaje_al_2020,2,",",".")  }}</td>
	                          @else
	                          <td ></td>
	                          @endif
						</tr>
						@foreach($mifuente->proyectosInversion as $p)
						<tr>
							<td>X</td>
	                        <td></td>
	                          <td>X</td>
	                          <td>{{ $p->codigo_sisin }}</td>
	                          <td>{{ $p->nombre }}</td>
	                          <td>{{ number_format($p->costo_total_proyecto,2,",",".") }}</td>
	                          <?php

									$date_del = date_create($p->periodo_ejecucion_del);
									$date_al = date_create($p->periodo_ejecucion_al);

								?>
								<td>{{ date_format($date_del, 'd/m/Y') }}</td>
								<td>{{ date_format($date_al, 'd/m/Y') }}</td>

	                          <td>{{ number_format($p->programado_2016,2,",",".") }}</td>
	                          <td>{{ number_format($p->ejecutado_2016,2,",",".") }}</td>
	                          <td>{{ number_format($p->programado_2017,2,",",".") }}</td>
	                          <td>{{ number_format($p->ejecutado_2017,2,",",".") }}</td>
	                          <td>{{ number_format($p->programado_2018,2,",",".") }}</td>
	                          <td>{{ number_format($p->ejecutado_2018,2,",",".") }}</td>
	                          <td>{{ number_format($p->total_programado,2,",",".") }}</td>
	                          <td>{{ number_format($p->total_ejecutado,2,",",".") }}</td>
	                          @if($p->total_porcentaje_ejecutado)
	                          <td >{{ number_format($p->total_porcentaje_ejecutado,2,",",".") }}</td>
	                          @else
	                          <td ></td>
	                          @endif
	                          <td>{{ number_format($p->concurrencia_entidades_programado,2,",",".") }}</td>
	                          <td>{{ number_format($p->concurrencia_entidades_ejecutado,2,",",".") }}</td>

	                          @if($p->concurrencia_entidades_porcentaje_ejecutado)
	                          <td >{{ number_format($p->concurrencia_entidades_porcentaje_ejecutado,2,",",".") }}</td>
	                          @else
	                          <td ></td>
	                          @endif
	                          <td>{{ number_format($p->meta_recurso_2020,2,",",".") }}</td>

	                          @if($p->concurrencia_entidades_porcentaje_al_2020)
	                          <td >{{ number_format($p->concurrencia_entidades_porcentaje_al_2020,2,",",".") }}</td>
	                          @else
	                          <td ></td>
	                          @endif
						</tr>
						@endforeach
					@else
					<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
					<td colspan="10">NO TIENE PROYECTOS POA</td>
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
			    $x = 900;
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
