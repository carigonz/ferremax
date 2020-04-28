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
			<section id="filters" class="d-flex flex-wrap justify-content-around ">
				<div class="suppliers d-none">
					<ul class="d-flex justify-content-around flex-wrap align-self-center flex-column">
						@for ($i = 0; $i < count($suppliers); $i++)
						<li><a href='#total_records' onClick="searchSupplier({{$i}})" id="{{$i}}">{{$suppliers[$i]}}</a></li>
							
						@endfor
					</ul>
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

							</tbody>
						</table>
				</div>
			</section>
</main>

<script>
	

	const filterButtons = ['pvc','ppn','bronce','polietileno','epoxi','galvanizado','sigas','redeco','duratop'];

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
					//$('tbody').html(data.table_data);
					//$('#total_records').text(data.total_data);
					console.log(data);
				}
			).fail( function(data){
				console.log(data.responseJSON.message);
				console.log('pasaron cosas');
			});
		}

	function searchSupplier(id){
		//const totalData = fetchData().filter( product => product.id_supplier === id);
		$('tbody').filter('a').css( "background-color", "red" );
	}
	
	const searchFilter = (filter) => fetchData(filter);
	
	$(document).ready(function () {
		fetchData();
		$('#query').keyup( function(){
			let query = $(this).val();
			fetchData(query);
			//console.log(query);
		});
		$(function () {
			$('[data-toggle="popover"]').popover()
		});
				$('.popover-dismiss').popover({
			trigger: 'focus'
		});
		$(function () {
				$('[data-toggle="tooltip"]').tooltip();
				$('[data-toggle="popover"]').popover();  
				$('#table-container').on('all.bs.table', function (e, name, args) {
						$('[data-toggle="tooltip"]').tooltip();
						$('[data-toggle="popover"]').popover();  
				});
		});

		//button filters
		let rowFilter = '';
		const buttons = filterButtons.map( filter => {
			rowFilter += `
				<li><a href='#total_records' onClick="searchFilter('`+filter+`')" id="`+filter+`" class="btn btn-success">`+filter+`</a></li>
			`
		});

		$('.categories-filter .categories').append(rowFilter);
	});

	$(document).ready(function () {
		$('tbody').html(data.table_data);
		$('#total_records').text(data.total_data);
		//$total_row = $data->count();
		console.log(data);
            // if($total_row>0){
            //     $i = 1;
            //     foreach ($data as $key => $product) {
            //         if ($product->discount === 0){
            //         $output.='<tr>'.
            //         '<th scope="row">'.$i.'</th>'.
            //         '<td>'.strtoupper($product->name).'</td>'.
            //         '<td>'.ucfirst(strtolower($product->description)).'</td>'.
            //         '<td><a tabindex="0" href="#" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus"  title="descuento '.$product->discount*100
            //         .' %" data-html="true" class="">'.$product->factoryName.'</a></td>'.
            //         '<td class="d-none">'.$product->discount*100 .' %</td>'.
            //         '<td data-toggle="popover" data-trigger="focus" title=" '. $product->updated_at .'ss " data-html="true">'.$product->price.'</td>'.
            //         '<td class="bg-success text-center">'.round($product->price*1.6,2).'</td>'.
            //         '</tr>';
            //         $i++;
            //         } else {
            //             $output.='<tr>'.
            //             '<th scope="row">'.$i.'</th>'.
            //             '<td>'.strtoupper($product->name).'</td>'.
            //             '<td>'.ucfirst(strtolower($product->description)).'</td>'.
            //             '<td><a tabindex="0" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus" title="Descuento '. $product->discount*100 .' %" data-html="true" class="">'.$product->factoryName.'</a></td>'.
            //             '<td class="d-none">'.$product->discount*100 .' %</td>'.
            //             '<td data-toggle="popover" data-trigger="focus" title=" ss'. $product->updated_at .' " data-html="true">'.$product->price .'</td>'.
            //             '<td class="bg-success text-center">'.
            //             round(($product->price-($product->price*$product->discount))*1.6,2)
            //             .'</td>'.
            //             '</tr>';
            //             $i++;
            //         }
            //     }
            // } else{
            //         $output .= '
            //         <tr>
            //             <td>No data found</td>
            //         <tr>
            //         ';
            //     }
	});
</script>
@endsection