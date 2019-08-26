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

    table{
      background-color: white;
      text-align: right;
      border-collapse: collapse;
      width: 100%;
    }

    th, td{
      padding: 10px;
    }

    thead{
      background-color: #03a9f3;
      border-bottom: solid 1px #ffffff;
      color: white;
    }
    thead tr{
      border:solid 1px white;
    }
    thead tr th{
      /*background-color: #246355;
      border-bottom: solid 1px #ffffff;
      color: white;*/
      border:solid 1px white;
    }

    tbody tr:nth-child(even){
      background-color: #ddd;
    }

    tbody tr:hover td{
      background-color: #369681;
      color: white;
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
      margin-top: 5px;
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
    <h3>CUADRO Nº1</h3>
    <h3>SEGUIMIENTO A LA PROGRAMACION PRESUPUESTAREA</h3>
    <h4>GESTION : {{ $gestionActiva->gestion }}</h4>
    <table>
      <thead>
      <tr>
        <th rowspan="3">FUENTE INGRESOS</th>
        <th colspan="3">PTDI/PGTC</th>
        <th colspan="3">PEI</th>
        <th colspan="">POA</th>
        <th rowspan="3">CAUSAS DE VARIACION</th>
      </tr>
      <tr>
        <th colspan="3">{{ $gestionActiva->gestion }} </th>
        <th colspan="3">{{ $gestionActiva->gestion }} </th>
        <th colspan="">{{ $gestionActiva->gestion }} </th>
      </tr>
      <tr>
        <th>Prog.</th>
        <th>Dif a Poa</th>
        <th>%Dif</th>
        <th>Prog.</th>
        <th>Dif a Poa</th>
        <th>% Dif</th>
        <th>Prog.</th>
      </tr>
      </thead>
      <tbody>
        <?php $a = 0; ?>
        @foreach($recursos as $r)
        <tr>
          <td>{{ $r->nombre }}</td>
          <td>{{ number_format($r->monto,2,",",".") }}</td>
          <td>{{ number_format($r->recursos_poa[0]->diferencia_ptdi_poa,2,",",".") }}</td>
          <td>{{ number_format($r->recursos_poa[0]->diferencia_porcentaje_ptdi_poa,2,",",".") }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>{{ number_format($r->recursos_poa[0]->monto_poa_gestion,2,",",".") }}</td>
          <td>{{ $r->recursos_poa[0]->causas_variacion }}</td>
        </tr>
        @endforeach 
        @foreach($otros as $o)
        <tr>
          <td>{{ $o->concepto }}</td>
          <td>{{ number_format($o->monto,2,",",".") }}</td>
          <td>{{ number_format($o->otros_poa[0]->diferencia_ptdi_poa,2,",",".") }}</td>
          <td>{{ number_format($o->otros_poa[0]->diferencia_porcentaje_ptdi_poa,2,",",".") }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>{{ number_format($o->otros_poa[0]->monto_poa_gestion,2,",",".") }}</td>
          <td>{{ $o->otros_poa[0]->causas_variacion }}</td>
        </tr>
        @endforeach 
        <tr>
          <td>TOTALES</td>
          <td>{{ number_format($total_recursos_planificado[0]->total_ptdi_monto,2,",",".") }}</td>
          <td>{{ number_format($total_recursos_planificado[0]->totales_poa[0]->total_diferencia_ptdi_poa,2,",",".") }}</td>
          <td>{{ number_format($total_recursos_planificado[0]->totales_poa[0]->total_diferencia_porcentaje_ptdi_poa,2,",",".") }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td>{{ number_format($total_recursos_planificado[0]->totales_poa[0]->total_monto_poa_gestion,2,",",".") }}</td>
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
    <footer >
      <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
    </footer>
  </div>  
  
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