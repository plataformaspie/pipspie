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
		padding: 3px;
	}
	table thead{
		font-weight: bold;
		color:white;
		background-color: #00558A;
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
      width: 400px;
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
		<div id="main-container">
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
      

      
			<h1>CUADRO Nº3</h1>
			<h2>SEGUIMIENTO FISICO - FINANCIERO</h2>
			<h3>GESTION : {{ $gestionActiva->gestion }}</h3>
			<table style="width: 100%">
        <thead>
          <tr>
            <th  rowspan="3"><strong>ACCION DE MEDIANO PLAZO</strong></th>
            <th  rowspan="3"><strong>ACCION ETA</strong></th>
            <th  rowspan="3"><strong>LINEA BASE</strong></th>
            <th  rowspan="3"><strong>INDICADOR DE PROCESO</strong></th>
            <th  colspan="4" class="text-center"><strong>PROGRAMACION PTDI</strong></th>
            <th  colspan="4" class="text-center"><strong>PROGRAMACION PEI</strong></th>
            <th  colspan="6" class="text-center"><strong>PROGRAMACION POA</strong></th>
            <th  rowspan="3" class="text-center"><strong>CAUSAS DESVIACION</strong></th>
            
          </tr>
          <tr>
            
            <th colspan="2" class="text-center"><strong>FINANCIERA</strong></th>
            <th colspan="2" class="text-center"><strong>ACCION</strong></th>
            <th colspan="2" class="text-center"><strong>FINANCIERA</strong></th>
            <th colspan="2" class="text-center"><strong>ACCION</strong></th>
            <th colspan="3" class="text-center"><strong>FINANCIERA</strong></th>
            <th colspan="3" class="text-center"><strong>ACCION</strong></th>

          </tr>
          <tr>
            <th class="text-center"><strong>Pf</strong></th>
            <th class="text-center"><strong>%Ef</strong></th>
            <th class="text-center"><strong>Pa</strong></th>
            <th class="text-center"><strong>%Ea</strong></th>
            <th class="text-center"><strong>Pf</strong></th>
            <th class="text-center"><strong>%Ef</strong></th>
            <th class="text-center"><strong>Pf</strong></th>
            <th class="text-center"><strong>%Ef</strong></th>
            <th class="text-center"><strong>Pf</strong></th>
            <th class="text-center"><strong>E</strong></th>
            <th class="text-center"><strong>%Ef</strong></th>
            <th class="text-center"><strong>Pf</strong></th>
            <th class="text-center"><strong>E</strong></th>
            <th class="text-center"><strong>%Ef</strong></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($distint as $mifuente)
            @if($mifuente->contador_objetivos > 0) 
            <tr>
              <td rowspan="{{ $mifuente->contador_objetivos}}">{{ $mifuente->nombre_programa }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->descripcion }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->linea_base }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->nombre_indicador }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->monto }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->porcentaje_ptdi }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->valor }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->porcentaje_accion_ptdi }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{ $mifuente->primer_objetivo_eta->monto_poa_planificado }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->monto_poa_ejecutado }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->monto_poa_porcentaje }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->accion_poa_programado }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->accion_poa_ejecutado }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->accion_poa_porcentaje }}</td>
              <td>{{ $mifuente->primer_objetivo_eta->causas_variacion }}</td>
            </tr>
            @foreach($mifuente->resto_objetivo_eta as $p)
              <tr>
                <td>{{ $p->descripcion}}</td>
                <td>{{ $p->linea_base }}</td>
                <td>{{ $p->nombre_indicador }}</td>
                <td>{{ $p->monto }}</td>
                <td>{{ $p->porcentaje_ptdi }}</td>
                <td>{{ $p->valor }}</td>
                <td>{{ $p->porcentaje_accion_ptdi }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $p->monto_poa_planificado }}</td>
                <td>{{ $p->monto_poa_ejecutado }}</td>
                <td>{{ $p->monto_poa_porcentaje }}</td>
                <td>{{ $p->accion_poa_programado }}</td>
                <td>{{ $p->accion_poa_ejecutado }}</td>
                <td>{{ $p->accion_poa_porcentaje }}</td>
                <td>{{ $p->causas_variacion }}</td>
              </tr>
            @endforeach 
            <tr style="background-color: #C0CAD0; text-align: right;">
              <td colspan="4">TOTALES</td>
              <td>{{ number_format($mifuente->totales['total_ptdi_planificado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_ptdi_porcentaje_ejecutado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_accion_ptdi_planificado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_accion_ptdi_ejecutado'],2,",",".") }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{ number_format($mifuente->totales['total_monto_poa_planificado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_monto_poa_ejecutado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_monto_poa_porcentaje'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_accion_poa_planificado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_accion_poa_ejecutado'],2,",",".") }}</td>
              <td>{{ number_format($mifuente->totales['total_accion_poa_porcentaje'],2,",",".") }}</td>
              <td></td>

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
        <footer >
          <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
        </footer>
    </div>
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