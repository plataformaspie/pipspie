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
        <img class="logo_mpd" src="img/mpd.jpg" height="40px" width="250px" />  
      </div>
      <div class="logo_dgpt">
         <img  src="img/DGPT.jpeg" height="40px" width="250px" />
      </div>
  	</header>
	<div id="main-container">
		<h1>CUADRO Nº2</h1>
		<h2>EVALUACION A LA VINCULACION DE ACCIONES</h2>
		<h3>GESTION : 2016 - 2018</h3>
		<table class="table table-bordered">
            <thead >
              <tr style="color:#fff; background:rgb(36, 136, 181);">
                <th  colspan="4">ARTICULACION PDES</th>
                <th  rowspan="2">INSCRITO EN EL PTDI/PGTC<br>ACCION ETA</th>
                <th  rowspan="2">INSCRITO EN EL PEI</th>
                <th  rowspan="2">INSCRITO POA</th>
                <th  rowspan="2">CAT. PROG.</th>
                <th  colspan="3">GESTION</th>
              </tr>
              <tr style="color:#fff; background:rgb(36, 136, 181);">
                <th>P</th>
                <th>M</th>
                <th>R</th>
                <th>A</th>
                <th>2016</th>
                <th>2017</th>
                <th>2018</th>
              </tr>
            </thead>
            <tbody>
            			<?php $i=0; ?>
            		@foreach ($objetivo_indicador as $mifuente)

	          			@if($mifuente->cantidad_proyectos_poa >0)
							<tr>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_p }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_m }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_r }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_a }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">PEI</td>
								<td>{{ $mifuente->primer_poa->nombre }}</td>
								<td>{{ $mifuente->primer_poa->categoria_programatica }}</td>
								@if($mifuente->primer_poa->gestion === 2016)
								<td>X</td>
								<td></td>
								<td></td>
								@elseif($mifuente->primer_poa->gestion === 2017)
								<td></td>
								<td>X</td>
								<td></td>
								@else
								<td></td>
								<td></td>
								<td>X</td>
								@endif
							</tr>
							@foreach($mifuente->poa as $p)
							<tr>
								<td>{{ $p->nombre}}</td>
								<td>{{ $p->categoria_programatica }}</td>
								@if($p->gestion == 2016)
								<td>X</td>
								<td></td>
								<td></td>
								@elseif($p->gestion == 2017)
								<td></td>
								<td>X</td>
								<td></td>
								@else
								<td></td>
								<td></td>
								<td>X</td>
								@endif
							</tr>

								<?php

							    $i++;
							    if($i % 25 == 0)
							        echo "<div style='page-break-after: always;'></div>";

							    ?>
							@endforeach
													@else
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_p }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_m }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_r }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_a }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">PEI</td>
						<td colspan="2">NO TIENE PROYECTOS POA</td>
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
