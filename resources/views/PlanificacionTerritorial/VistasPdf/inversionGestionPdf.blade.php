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
      font-size: 6px;
      margin: 0mm 10mm 10mm 10mm;
      padding: 0;
    }

    #main-container{
      margin: 0 auto;
      width: 100%;
    }
    header{
      margin-top: 10px;
      margin-bottom: 10px;
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
	.alinear{
      margin-bottom: 10px;

    }
   .alinear-derecha{
      width: 300px;
      /*position: relative;
      right: -350px;*/
      margin-left: 30px;
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
      font-size: 8px;
    }
    .logo_dpgt{
      
      float: left;
    }
    .logo_mpd{
      float: right;
    }
	
	

</style>
</head>
	
	<body>
		<header>
	      <div>
	        <img class="logo_mpd" src="img/mpd.png" height="40px" width="250px" />  
	      </div>
	      <div class="logo_dgpt">
	         <img  src="img/DGPT.jpeg" height="40px" width="250px" />   
	      </div>
	  	</header>
		<div id="main-container">
			<h1>CUADRO Nº4</h1>
			<h2>SEGUIMIENTO A PROYECTOS DE INVERSION PUBLICA</h2>
			<h3>GESTION : {{ $gestionActiva->gestion }}</h3>
			<div class="table-responsive">
	            <table class="table table-bordered" >
	              <thead >
	                <tr style="color:#fff; background:rgb(36, 136, 181);">
	                	<th  style="vertical-align:middle; text-align:center;" rowspan="3">ITEM</th>		
	                	<th  style="vertical-align:middle; text-align:center;" rowspan="3">ACCION ETA</th>		
	                	<th  style="vertical-align:middle; text-align:center;" rowspan="2" colspan="3">PLANIFICACION</th>
	                  	<th  style="vertical-align:middle; text-align:center;" colspan="5" >INSCRITO EN EL VIPFE</th>
	                  	<th  style="vertical-align:middle; text-align:center;" colspan="3">CONCURRENCIA ETA</th>
	                  	@if($maximo_entidades > 0)
	                  	<?php $colspan = $maximo_entidades*4;?>
	                  	<th  style="vertical-align:middle; text-align:center;" colspan="{{ $colspan }}">CONCURRENCIA ETA</th>
	                  	@endif
	                  	<th  style="vertical-align:middle; text-align:center;" colspan="2">ENTIDAD EJECUTORIA</th>

	                </tr>
	                <tr style="color:#fff; background:rgb(36, 136, 181);">
	                  <th style="vertical-align:middle" rowspan="2" >COD. SISIN</th>
	                  <th style="vertical-align:middle" rowspan="2" >PROYECTO</th>
	                  <th style="vertical-align:middle" rowspan="2" >COSTO TOTAL <br/>PROYECTO</th>
	                  <th style="vertical-align:middle" colspan="2">PERIODO<br/>DE EJECUCION</th>
	                  <th style="vertical-align:middle" rowspan="2" ="2">PROG.</th>
	                  <th style="vertical-align:middle" rowspan="2">EJEC..</th>
	                  <th style="vertical-align:middle" rowspan="2">% EJEC.</th>
	                  @if($maximo_entidades > 0)
	                  	@for($j=1;$j<=$maximo_entidades;$j++)
	                  	<th  style="vertical-align:middle; text-align:center;" rowspan="2" >ENT. {{ $j }}</th>
	                  	<th  style="vertical-align:middle; text-align:center;" rowspan="2" >PROG.</th>
	                  	<th  style="vertical-align:middle; text-align:center;" rowspan="2" >EJEC.</th>
	                  	<th  style="vertical-align:middle; text-align:center;" rowspan="2" >% EJEC.</th>
	                  	@endfor
	                  @endif
	                  <th style="vertical-align:middle" rowspan="2">COD. ENT.</th>
	                  <th style="vertical-align:middle" rowspan="2">DENOMINACION</th>
	                </tr>
	                <tr style="color:#fff; background:rgb(36, 136, 181);">
	                  <th>PTDI/<br/>PGTC</th>
	                  <th>PEI</th>
	                  <th>POA</th>
	                  <th>DEL</th>
	                  <th>AL</th>
	                </tr>
	              </thead>
	              <tbody>
	              	<?php $i = 0; ?>
					@foreach ($objetivoProyectos as $mifuente) 
					     
	          			@if($mifuente->cantidad_proyectos_poa >0)
							<tr>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $i++ }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
								@if($mifuente->primer_poa->inscrito_ptdi == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								@if($mifuente->primer_poa->inscrito_pei == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								@if($mifuente->primer_poa->inscrito_poa == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								<td>{{ $mifuente->primer_poa->codigo_sisin }}</td>
								<td>{{ $mifuente->primer_poa->nombre }}</td>
								<td>{{ $mifuente->primer_poa->costo_total_proyecto }}</td>
								<?php 

									$date_del = date_create($mifuente->primer_poa->periodo_ejecucion_del);
									$date_al = date_create($mifuente->primer_poa->periodo_ejecucion_al);

								?>
								<td>{{ date_format($date_del, 'd/m/Y') }}</td>
								<td>{{ date_format($date_al, 'd/m/Y') }}</td>
								<td>{{ $mifuente->primer_poa->monto_poa_planificado }}</td>
								<td>{{ $mifuente->primer_poa->monto_poa_ejecutado }}</td>
								<td>{{ $mifuente->primer_poa->monto_poa_porcentaje }}</td>
								
								@foreach($mifuente->primer_poa->entidadesConcurrencia as $ent)
				                  <td>{{ $ent->nombre_entidad}}</td>
				                  <td>{{ $ent->programacion_entidad }}</td>
				                  <td>{{ $ent->ejecucion_entidad }}</td>
				                  <td>{{ $ent->porcentaje_ejecucion_entidad }}</td>
				                @endforeach 
				                <?php $resta = $maximo_entidades - $mifuente->primer_poa->cantidad_entidad; ?>
				                @if($resta >0)
				                  @for($j=1;$j<=$resta;$j++)
				                    <td></td>
				                    <td></td>
				                    <td></td>
				                    <td></td>
				                  @endfor
				                @endif
				                <td>{{ $mifuente->primer_poa->entidad_ejecutora_cod }}</td>
				                <td>{{ $mifuente->primer_poa->entidad_ejecutora_denominacion }}</td>
							</tr>
							@foreach($mifuente->proyectosInversion as $p)
							<tr>
								@if($p->inscrito_ptdi == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								@if($p->inscrito_pei == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								@if($p->inscrito_poa == true)
								<td>X</td>
								@else
								<td>X</td>
								@endif
								<td>{{ $p->codigo_sisin }}</td>
								<td>{{ $p->nombre }}</td>
								<td>{{ $p->costo_total_proyecto }}</td>
								<?php 

									$date_del = date_create($p->periodo_ejecucion_del);
									$date_al = date_create($p->periodo_ejecucion_al);

								?>
								<td>{{ date_format($date_del, 'd/m/Y') }}</td>
								<td>{{ date_format($date_al, 'd/m/Y') }}</td>
								<td>{{ $p->monto_poa_planificado }}</td>
								<td>{{ $p->monto_poa_ejecutado }}</td>
								<td>{{ $p->monto_poa_porcentaje }}</td>
								<?php $entidades = $p->entidadesConcurrencia; ?>
								@if($entidades)
									@foreach($entidades as $ent)
					                  <td>{{ $ent->nombre_entidad}}</td>
					                  <td>{{ $ent->programacion_entidad }}</td>
					                  <td>{{ $ent->ejecucion_entidad }}</td>
					                  <td>{{ $ent->porcentaje_ejecucion_entidad }}</td>
					                @endforeach 
				                @endif
				                <?php $resta = $maximo_entidades - $p->cantidad_entidad; ?>
				                @if($resta >0)
				                  @for($j=1;$j<=$resta;$j++)
				                    <td></td>
				                    <td></td>
				                    <td></td>
				                    <td></td>
				                  @endfor
				                @endif
				                <td>{{ $p->entidad_ejecutora_cod }}</td>
				                <td>{{ $p->entidad_ejecutora_denominacion }}</td>
							</tr>
							@endforeach	
						@else
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $i++ }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
						<td colspan="2">NO TIENE PROYECTOS POA</td>			
	          			@endif
	        		@endforeach
				</tbody>
	            </table>  
	        </div>
	         <br>
		    <br>
		    <br>
		    <br>
		    <br>
		    <br>
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