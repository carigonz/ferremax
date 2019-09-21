@extends('layouts/master')

@section('title', 'Actualizar Listas')

@section('css')
	<link href="{{ asset('css/update.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('main')
	<section class="main-container-update container-fluid d-flex justify-content-around align-items-center">
		<div class="container-item-update text-left">
			<div class="header-update flex-wrap d-flex justify-content-around align-items-center">
					<h2 class="text-center d-block">soy un update por codigo</h2>
			</div>
			<div class="form-container m-auto d-flex flex-column">
				<form action="#" class="form-items m-auto d-flex flex-column text-center" method="post">
					{{ csrf_field() }}
					{{-- display errors --}}
					<div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
							@if ($errors->has('csv_file'))
									<span class="help-block">
									<strong>{{ $errors->first('csv_file') }}</strong>
							</span>
							@endif
					</div>
					<div class="form-group">
							<label for="code">Ingrese el código del producto</label>
							<input type="text" class="form-control" name="code" id="code">
					</div>
					<div class="form-group">
							<label for="id_supplier">Proveedor: </label>
								<select name="id_supplier" class="custom-select" id="id_supplier">
									<option selected value="0">Elija una opción</option>
										@for ($i = 0; $i < count($suppliers) ; $i++)
											<option value="{{$i + 1}}">{{$suppliers[$i]}}</option>
										@endfor
								</optgroup>
							</select>
					</div>
					<div class="form-group">
							<label for="price">Nuevo precio:</label>
							<input type="number"  class="form-control"  min="0" step="any" name="price" id="price">
					</div>
				<button name="product" value="true" type="submit" class="btn btn-primary">Enviar</button>
				</form>
			</div>	
		</div>
		<div class="container-json-update text-center">
				<div class="header-update flex-wrap d-flex justify-content-around align-items-center">
						<h2>soy un update por input</h2>				
				</div>
				<div class="form-container m-auto d-flex flex-column">
			
					<form action="#" class="form-items m-auto d-flex flex-column" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">

						@if ($errors->has('csv_file'))
								<span class="help-block">
								<strong>{{ $errors->first('csv_file') }}</strong>
						</span>
						@endif
						</div>

						<div class="form-group">
							<label for="id_supplier">Proveedor: </label>
								<select name="id_supplier" class="custom-select" id="id_supplier">
									<option selected value="0">Elija una opción</option>
										@for ($i = 0; $i < count($suppliers) ; $i++)
											<option value="{{$i + 1}}">{{$suppliers[$i]}}</option>
										@endfor
								</optgroup>
							</select>
					</div>
					<div class="form-group">
						<label for="list">Ingrese lista <strong>extensión .csv</strong></label>
						<input type="file" name="csv_file" accept=".csv" id="csv_file">
					</div>
						<div class="form-group">
								<div class="">
										<div class="checkbox">
												<input type="checkbox" name="header" checked> 
												<label>File contains header row?</label>
										</div>
								</div>
						</div>
						
						<button type="submit" class="btn btn-primary">Parse csv</button>
						</div>
					</form>
			</div>
		</div>
		
	</section>		
@endsection