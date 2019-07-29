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
      position: relative;
      right: -350px;
    }
    .alinear_izquierda{
      width: 300px;
      text-align: left;
      position:relative
      right: 0px;
      top:0px;
      margin-left: 50px;
    }
    .firmas{
      background-color: white;
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
		<h1>CUADRO Nº1</h1>
		<h2>SEGUIMIENTO A LA PROGRAMACION PRESUPUESTAREA</h2>
		<h3>GESTION : 2016 - 2018</h3>
		<table class="table table-bordered " >
          <thead style="color:#fff; background:rgb(36, 136, 181);">
            <tr style="vertical-align:middle">

              <th  style="vertical-align:middle" colspan="" rowspan="2">FUENTE DE INGRESOS</th>
              <th  style="vertical-align:middle; horizontal-align:middle" colspan="6">PTDI/PGTC</th>
              <th  style="vertical-align:middle" colspan="6">PEI</th>
              <th  style="vertical-align:middle" colspan="4">POA</th>
              <th style="vertical-align:middle;"  rowspan="2" width="20%">CAUSAS DE VARIACION</th>
            </tr>
            <tr>

              <th style="vertical-align:middle" >2016 (Prog)</th>
              <th style="vertical-align:middle" >2017 (Prog)</th>
              <th style="vertical-align:middle" >2018 (Prog)</th>
              <th style="vertical-align:middle" >TOTAL (2016-2018)</th>
              <th style="vertical-align:middle" >DIF A POA % </th>
              <th style="vertical-align:middle" >DIF %</th>
              <th style="vertical-align:middle" >2016 (Prog)</th>
              <th style="vertical-align:middle" >2017 (Prog)</th>
              <th style="vertical-align:middle" >2018 (Prog)</th>
              <th style="vertical-align:middle" >TOTAL (2016-2018)</th>
              <th style="vertical-align:middle" >DIF A POA % </th>
              <th style="vertical-align:middle" >DIF %</th>
              <th style="vertical-align:middle" >2016 (Prog)</th>
              <th style="vertical-align:middle" >2017 (Prog)</th>
              <th style="vertical-align:middle" >2018 (Prog)</th>
              <th style="vertical-align:middle" >TOTAL (2016-2018)</th>
            </tr>
          </thead>
          <tbody style="color:#000">

          	@foreach($filas as $r)
          	<tr >
              <td class="text-right">{{ $r['recurso'] }}</td>
              <td class="text-right">{{ number_format($r['planificacion_2016'],2,",",".") }}</td>
              <td class="text-right">{{ $r['planificacion_2017'] }}</td>
              <td class="text-right">{{ $r['planificacion_2018'] }}</td>
              <td class="text-right">{{ $r['total_planificacion'] }}</td>
              <td class="text-right">{{ $r['diferencia_a_poa'] }}</td>
              <td class="text-right">{{ number_format($r['diferencia_porcentaje_a_poa'],2,",",".") }}</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">datos pei</td>
              <td class="text-right">{{ number_format($r['poa_2016'],2,",",".")}}</td>
              <td class="text-right">{{ $r['poa_2017'] }}</td>
              <td class="text-right">{{ $r['poa_2018'] }}</td>
              <td class="text-right">{{ $r['total_poa'] }}</td>
              <td class="text-right">{{ $r['causas_variacion'] }}</td>
            </tr>
			@endforeach
			<tr>
				<td>TOTALES</td>
				<td>{{ $totales['total_gestion_2017'] }}</td>
				<td>{{ $totales['total_gestion_2017'] }}</td>
				<td>{{ $totales['total_gestion_2018'] }}</td>
				<td>{{ $totales['totales_planificacion_ptdi'] }}</td>
				<td>{{ $totales['total_diferencia_a_poa'] }}</td>
				<td>{{ $totales['total_diferencia_porcentaje_a_poa'] }}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>{{ $totales['total_gestion_poa_2016'] }}</td>
				<td>{{ $totales['total_gestion_poa_2017'] }}</td>
				<td>{{ $totales['total_gestion_poa_2018'] }}</td>
				<td>{{ $totales['totales_planificacion_poa'] }}</td>
				<td></td>
			</tr>
          </tbody>
        </table>

		<br>
	    <br>
	    <br>
	    <br>
	    <br>
	    <br>
	    <div class="firmas">

	        <ul class="alinear_izquierda">
	          <li class="alinear"><strong>Elaborado por:</strong></li>
	          <li class="alinear"><strong>Nombre:.................................................</strong></li>
	          <li class="alinear"><strong>Cargo:....................................................</strong></li>
	          <li class="alinear"><strong>Firma:.....................................................</strong></li>
	        </ul>
	        <ul class="alinear-derecha">
	          <li class="alinear"><strong>Aprobado MAE:</strong></li>
	          <li class="alinear"><strong>Nombre:.................................................</strong></li>
	          <li class="alinear"><strong>Firma:.....................................................</strong></li>
	          <li class="alinear"><strong style="color:white;">.</strong></li>
	        </ul>
	    </div>
    </div>
    <footer >
      <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
    </footer>

    <script type="text/php">
		 if (isset($pdf)) {
		    $x = 500;
		    $y = 749;
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
