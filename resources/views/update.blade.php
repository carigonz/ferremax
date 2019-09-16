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
										<option value="{{$i + 1}}">{{$suppliers[$i]}}</option>
									@endfor
							</optgroup>
						</select>
				</div>
				<div class="form-group">
						<label for="price">Nuevo precio:</label>
						<input type="number"  class="form-control"  min="0" step="any" name="price" id="price">
				</div>
			<button name="product" type="submit">Enviar</button>
			</form>
		</div>
		<div class="container-json-update text-center">



				
				{{-- <div class="container"> --}}
						{{-- <div class="row m-auto">
								<div class="col-md-8 col-md-offset-2">
										<div class="panel panel-default">
												<div class="panel-heading">CSV Import</div>
		
												<div class="panel-body">
														<form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
																{{ csrf_field() }}
		
																<div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
																		<label for="csv_file" class="col-md-4 control-label">CSV file to import</label>
		
																		<div class="col-md-6">
																				<input id="csv_file" type="file" class="form-control" name="csv_file" required>
		
																				@if ($errors->has('csv_file'))
																						<span class="help-block">
																						<strong>{{ $errors->first('csv_file') }}</strong>
																				</span>
																				@endif
																		</div>
																</div>
		
																<div class="form-group">
																		<div class="col-md-6 col-md-offset-4">
																				<div class="checkbox">
																						<label>
																								<input type="checkbox" name="header" checked> File contains header row?
																						</label>
																				</div>
																		</div>
																</div>
		
																<div class="form-group">
																		<div class="col-md-8 col-md-offset-4">
																				<button type="submit" class="btn btn-primary">
																						Parse CSV
																				</button>
																		</div>
																</div>
														</form>
												</div>
										</div>
								</div>
						</div>
				</div> --}}
		



			<h2>soy un update por input</h2>
			
			<form action="#" class="form-items m-auto d-flex flex-column form-container" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">

				@if ($errors->has('csv_file'))
						<span class="help-block">
						<strong>{{ $errors->first('csv_file') }}</strong>
				</span>
				@endif

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
				<label for="list">Ingrese lista <strong>extensión .csv</strong></label>
				<input type="file" name="csv_file" accept=".csv" id="csv_file">
				<div class="form-group">
						<div class="">
								<div class="checkbox">
										<input type="checkbox" class="d-block" name="header" checked> 
										<label>File contains header row?</label>
								</div>
						</div>
				</div>
				<button type="submit" class="btn btn-primary">Parse csv</button>
				</div>
			</form>
		</div>
		
	</section>		
@endsection