@extends('layouts.sistemaremi')

@section('header')

  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
   <div class="panel panel-inverse ">
     <div class="panel-heading"> Detalle de los Usuarios Registrados
          <div class="pull-right">
              <a href="#" data-perform="panel-collapse">
                   <i class="ti-minus"></i>
              </a>
          </div>
      </div>
	<br/>
	<a href="{{ route('registrarUser') }}" class="btn waves-effect waves-light btn-info"><font color="#fff"><span class="glyphicon glyphicon-th-list"></span> Nueva Cuenta de Usuario</font>
	</a>
    <br/><br/>
    <div class="row justify-content-center">
	<table class="table color-table danger-table table-hover table-bordered table-striped text-center">
		<thead>
		  <tr>
			<th style="text-align: center;">ID</th>
			<th style="text-align: center;">NOMBRE</th>
      <th style="text-align: center;">INSTITUCION</th>
			<th style="text-align: center;">CARGO</th>
			<th style="text-align: center;">CARNET</th>
			<th style="text-align: center;">CELULAR</th>
			<th style="text-align: center;">CORREO</th>
			<th style="text-align: center;">ROLES</th>
			<th style="text-align: center;">USUARIO</th>
		  </tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
        <td>{{ $user->denominacion }}</td> 
				<td>{{ $user->cargo }}</td>
				<td>{{ $user->carnet }}</td>
				<td>{{ $user->telefono }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->nombre_rol }}</td>
				<td>{{ $user->username }}</td>
				<td>
					<a href="{{ route('SistemaRemi.registrar.editarUser',$user->id) }}" class="btn waves-effect waves-light btn-outline-info" title="Editar">
						<span class="glyphicon glyphicon-pencil"></span>
					</a>
					<a href="{{ route('SistemaRemi.registrar.eliminarUser', $user->id) }}" class="btn waves-effect waves-light btn-outline-danger" title="Eliminar">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $users->links() }}
    </div>
    </div>
  </div>
</div>
@endsection

@push('script-head')

	<script type="text/javascript">
		$('.btn-danger').on('click',function(event){
			event.preventDefault();
			if(confirm('Esta seguro de eliminar el Ususario?')){
				$(location).attr('href',$(this).attr('href'));
			}
			return false;
		});
	</script>

@endpush
