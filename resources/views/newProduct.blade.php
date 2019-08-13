@section('css')
	<link href="{{ asset('css/newProduct.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('title', 'Agregar Producto - Ferremax')
		
@extends('layouts/master')
 
@section('main')
	<main class="container-new-product">
		<div class="form-container m-auto">
			<h1>Datos del Producto</h1>
			<form action="" method="post" class="form-items m-auto" enctype="multipart/form-data">
				{{ csrf_field() }}
				<label for="name">Nombre del Pruducto: </label>
				<input type="text" name="name" id="name">
				<label for="code">Código: </label>
				<input type="text" name="code" id="code">
				<label for="price">Precio: </label>
				<input type="number" min="0" step="any" name="price" id="prince">	
				<label for="id_supplier">Proveedor: </label>
				<select name="id_supplier" id="id_supplier">
					<option selected value="0">Elija una opción</option>
						@for ($i = 0; $i < count($suppliers) ; $i++)
							<option value="{{$i}}">{{$suppliers[$i]}}</option>
						@endfor
				</optgroup>
				</select>
				<label for="description">descripcion: </label>
				<input type="text" name="desciption" id="description">
				<label for="stock">Stock: </label>
				<input type="number" min="1" step="1" name="stock" id="stock">
				<label for="avatar">Avatar: </label>
				<input type="file" name="avatar" id="avatar">
				<button type="submit">Enviar</button>
			</form>
		</div>
	</main>
		
@endsection