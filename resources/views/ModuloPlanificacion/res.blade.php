
@extends('layouts.single')

@section('header')
<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" />
@endsection

@section('content')
Estoy en la <b> ______________________________________________ RESSSSS</b> 
<div class="bg-primary-dark">
	aaaa lmllmmll----------------------
</div>
<button id="btn">vrrv</button>
@endsection

@section('script-head')
<script>
	// $appendHead('<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" />');
	$(function(){
		var i;
		$("#btn").click(function(){
			i = 0;
			console.log('EE _______________SSS');
		})

		var vari="es RESSSS";
		i++;
	})
</script>
@endsection

