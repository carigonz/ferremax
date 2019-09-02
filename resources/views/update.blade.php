@extends('layouts/master')

@section('title', 'Actualizar Listas')

@section('css')
	<link href="{{ asset('css/update.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('main')
	<section class="main-container-update container-fluid d-flex flex-column justify-content-around align-items-center">
		<div class="container-item-update text-left">
				<h2 class="text-center">soy un update por codigo</h2>
			<form action="#" class="form-items m-auto d-flex flex-column form-container" method="post">
				{{ csrf_field() }}
				<div class="form-group">
						<label for="code">Ingrese el código del producto</label>
						<input type="text" class="form-control" name="code" id="code">
				</div>
				<div class="form-group">
						<label for="id_supplier">Proveedor: </label>
							<select name="id_supplier" class="custom-select" id="id_supplier">
								<option selected value="0">Elija una opción</option>
									@for ($i = 0; $i < count($suppliers) ; $i++)
										<option value="{{$i}}">{{$suppliers[$i]}}</option>
									@endfor
							</optgroup>
						</select>
				</div>
				<div class="form-group">
						<label for="price">Nuevo precio:</label>
						<input type="number"  class="form-control"  min="0" step="any" name="price" id="price">
				</div>
			<button type="submit">Enviar</button>
			</form>
		</div>
		<div class="container-json-update text-center">
			<h2>soy un update por input</h2>
		</div>
		
	</section>		
@endsection