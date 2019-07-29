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
      <h3>CUADRO Nº2</h3>
      <h3>SEGUIMIENTO A LAS ACCIONES</h3>
      <h4>GESTION : {{ $gestionActiva->gestion }}</h4>
      <table style="width: 100%">
        <thead>
          <tr>
            <th colspan="4">ARTICULACION PDES</th>
            <th rowspan="2">INSCRITO PTDI/PGTC ACCION ETA</th>
            <th rowspan="2">INSCRITO PEI</th>
            <th rowspan="2">PROYECTOS POA</th>
            <th rowspan="2">CAT. PROG.</th>

          </tr>
          <tr>
            <th>P</th>
            <th>M</th>
            <th>R</th>
            <th>A</th>
          </tr>
        </thead>
        <tbody>
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
              </tr>
              @foreach($mifuente->poa as $p)
              <tr>
                <td>{{ $p->nombre}}</td>
                <td>{{ $p->categoria_programatica }}</td>

              </tr>
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
