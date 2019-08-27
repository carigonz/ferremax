@section('css')
	<link href="{{ asset('css/searcher.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('title', 'Buscador - Ferremax')
		
@extends('layouts/master')

{{-- @section('js')
<script src="{{ asset('js/liveSearch.js') }}"></script>		
@endsection --}}
@section('main')
<main class="body-container-searcher flex-column">
		<div class="button-item">
				<input type ='button' data-toggle="button" aria-pressed="false" autocomplete="off" class="btn btn-warning"  value = 'Nuevo Producto' onclick="location.href = '{{ Route('newProduct') }}'"/>
		</div>
		<div class="jumbotron">
				<p class="lead">Este va a ser el buscador principal</p>
				<hr class="my-4">{{-- 
				<p>cuando creo la tabla del forEach de los resultados necesito un boton para agregar al nuevo presupuesto ?? </p> --}}
				<form class="form-inline" method="get">
					
					{{ csrf_field() }}
						<input autofocus class="form-control mr-sm-2 big-searcher" type="text" name="query" id="query" placeholder="Solo tenés que tipear tu búsqueda" aria-label="Search">
						{{-- <button  onclick="{{ Route('search.action') }}" id="query" class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button> --}}
					</form>
			</div>
			
			<section class="table-container">
				<div class="table table-responsive">
					<h4>Total data: <span id="total_records"></span></h4>
						<table class=" table table-hover table-striped table-sm">
								<thead>
									<tr>
										<th scope="col" class="table-info">#</th>
										<th scope="col" class="table-info">Nombre</th>
										<th scope="col" class="table-info">Descripcion</th>
										<th scope="col" class="table-info">Proveedor</th>
										<th scope="col" class="table-info d-none">Descuento</th>
										<th scope="col" class="table-info">Costo</th>
										<th scope="col" class="bg-success text-center">Publico</th>
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
		$('#query').keyup( function(){
			let query = $(this).val();
			fetchData(query);
			//console.log(query);
		});

		$('.showDesc').click(function (e) { 
			e.preventDefault();
			$(selector).removeClass('hide');
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
				data: {query:query},
				dataType: 'json'
			}).done( function(data){
					$('tbody').html(data.table_data);
					$('#total_records').text(data.total_data);
					console.log(data);
				}
			).fail( function(data){
				console.log(data.responseJSON);
				console.log('pasaron cosas');
			});
		}
	});
</script>
@endsection