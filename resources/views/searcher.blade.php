@section('css')
	<link href="{{ asset('css/searcher.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('title', 'Buscador - Ferremax')
		
@extends('layouts/master')

@section('main')
<main class="body-container-searcher flex-column">
		<div class="button-item">
				<input type ='button' data-toggle="button" aria-pressed="false" autocomplete="off" class="btn btn-warning"  value = 'Nuevo Producto' onclick="location.href = '{{ Route('newProduct') }}'"/>
		</div>
		<div class="jumbotron m-auto">
				<h1 class="display-4">Hello, world!</h1>
				<p class="lead">Este va a ser el buscador principal</p>
				<hr class="my-4">
				<p>cuando creo la tabla del forEach de los resultados necesito un boton para agregar al nuevo presupuesto ?? </p>
				<form class="form-inline">
					{{ csrf_field() }}
				<input type="hidden" name="_token" id="login-token" value="{{ csrf_token()}}">
						<input class="form-control mr-sm-2 big-searcher" type="text" name="search" id="search" placeholder="Buscar" aria-label="Search">
						<button  onclick="location.href = '{{ Route('newProduct') }}'" id="search" class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button>
					</form>
			</div>
			<section class="table-container">
				<div class="table table-responsive">
					<h3>Total data: <span id="total-records"></span></h3>
						<table class="table table-sm">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nombre</th>
										<th scope="col">Proveedor</th>
										<th scope="col">Costo</th>
										<th scope="col">Publico</th>
									</tr>
								</thead>
								<tbody>


								</tbody>
							</table>
				</div>
			</section>
</main>

<script>
	$(document).ready(function () {
		fetchData();
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
		});
		
		function fetchData(query = '')
		{
			$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
			});
			$.ajax({
				url:'{{ route('search.action') }}',
				method: 'GET',
				data: {query:query, _token: $('#signup-token').val()},
				dataType: 'json'
			}).done( function(data){
					$('tbody').html(data.table_data);
					$('#total_records').text(data.total_data);
				console.log(data);
				}
			).fail( function(){
				console.log('pasaron cosas');
			});
		}
		$(document).on('keyup', '#search', function(){
			let query = $(this).val();
			fetchData(query);
		});
	});
</script>
@endsection