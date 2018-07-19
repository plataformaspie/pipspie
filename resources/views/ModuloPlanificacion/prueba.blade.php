
@extends('layouts.single')

@section('header')
{{-- <link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" /> --}}
@endsection



@section('content')

Estoy en la <b>PRUEBA</b> 
<div class="bg-purple deee">
	aaaa ........-------------------------------------------
</div>
<button id="btn">momomo</button>

<div id="dvp"></div>

@endsection


@section('script-head')
 <script>
	$(function(){
		// $('head').append('<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" />');
		
		$("#btn").click(function(){
			alert('miii');
		})
		$(".deee").dblclick(function(){
			console.log('variiiii')
			console.log(vari)
		})
		var varj = 'es prueba'
		$("#dvp").append('<button >ol</button>');

		$("#dvp button").click(function(){
			console.log("desde el boton creado");
		})
	})
	
</script>
@endsection
