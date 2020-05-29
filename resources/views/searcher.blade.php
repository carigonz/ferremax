@section('css')
	<link href="{{ asset('css/searcher.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('title', 'Buscador - Ferremax')
		
@extends('layouts/master')

@section('main')
		<div class="button-item">
				<input type ='button' data-toggle="button" aria-pressed="false" autocomplete="off" class="btn btn-warning"  value = 'Nuevo Producto' onclick="location.href = '{{ Route('newProduct') }}'"/>
		</div>
		<div class="jumbotron">
			<h1>holiz</h1>
				<p class="lead">Este va a ser el buscador principal</p>
				<hr class="my-4">
				<form class="form-inline" method="get">
					{{ csrf_field() }}
						<input autofocus class="form-control mr-sm-2 big-searcher" type="text" name="query" id="query" placeholder="Solo tenés que tipear tu búsqueda" aria-label="Search">
						{{-- <button  onclick="{{ Route('search.action') }}" id="query" class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button> --}}
					</form>
			</div>
			<section id="filters" class="d-flex flex-wrap justify-content-around ">
				<div class="suppliers d-none">
					{{-- <ul class="d-flex justify-content-around flex-wrap align-self-center flex-column">
						@for ($i = 0; $i < count($suppliers); $i++)
						<li><a href='#total_records' onClick="searchSupplier({{$i}})" id="{{$i}}">{{$suppliers[$i]}}</a></li>
							
						@endfor
					</ul> --}}
				</div>
				<div class="categories-filter d-flex flex-wrap ">
					<ul class="d-flex justify-content-around flex-wrap categories align-self-center">
						{{-- here comes filters --}}
					</ul>
				</div>
		</section>
			<section class="table-container">
				<div class="table table-responsive">
					<h4>Total data: <span id="total_records"></span></h4>
					
					
					<table id="table-container" class=" table table-hover table-striped table-sm">
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
								{{-- productController --}}
							</tbody>
						</table>
					</div>
				</section>
			</main>
			
			<script>

				/* $('#query').keyup(function (e) { 
					query = $(this).val();
					console.log(query);
					$.ajax({
						url:'{{ route('search.action') }}',
						method: 'GET',
						data: { query },
						dataType: 'json',
  						contentType : 'application/x-www-form-urlencoded; charset=UTF-8'
					}).done( function(data){
						console.log(`=====success response=====`);
						console.log(data);
						$('tbody').html(data.table_data);
						$('#total_records').text(data.total_data);
					}).fail( function(data){
						console.log(`=======error=======`);
						console.log(data);
					});
				}); */
				
				


				// 	$(function () {
				// 		$('[data-toggle="popover"]').popover()
				// 	});
				// 	$('.popover-dismiss').popover({
				// 		trigger: 'focus'
				// 	});
				// 	$(function () {
				// 		$('[data-toggle="tooltip"]').tooltip();
				// 		$('[data-toggle="popover"]').popover();  
				// 		$('#table-container').on('all.bs.table', function (e, name, args) {
				// 			$('[data-toggle="tooltip"]').tooltip();
				// 			$('[data-toggle="popover"]').popover();  
				// 		});
				// 	});

				</script>

@endsection