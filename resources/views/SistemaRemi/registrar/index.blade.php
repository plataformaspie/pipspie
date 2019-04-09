@extends('layouts.sistemaremi')

@section('header')

  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


@endsection

@section('content')
	<a href="{{ route('registrar.create') }}" class="btn btn-primary">
		Nuevo Usuario
	</a>
	<table class="table">
		<thead>
			<th>ID</th>
			<th>NOMBRE</th>
			<th>CARGO</th>
			<th>CARNET</th>
			<th>CELULAR</th>
			<th>CORREO</th>
			<th>ROLES</th>
			<th>USUARIO</th>			
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->cargo }}</td>
				<td>{{ $user->carnet }}</td>
				<td>{{ $user->telefono }}</td>
				<td>{{ $user->email }}</td>				
				<td>{{ $user->id_rol }}</td>
				<td>{{ $user->username }}</td>
				<td>
					<a href="{{ route('registrar.destroy', $user->id) }}" class="btn btn-danger" title="Eliminar">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
					<a href="{{ route('registrar.edit', $user->id) }}" class="btn btn-info" title="Editar">
						<span class="glyphicon glyphicon-pencil"></span>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>	
	</table>
	{{ $users->links() }}
@endsection

