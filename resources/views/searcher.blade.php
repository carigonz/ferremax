@section('css')
	<link href="{{ asset('css/searcher.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('title', 'Buscador - Ferremax')
		
@extends('layouts/master')

@section('main')
<main class="body-container-searcher">
		<div class="button-item">
				<input type ='button' data-toggle="button" aria-pressed="false" autocomplete="off" class="btn btn-warning"  value = 'Nuevo Producto' onclick="location.href = '{{ Route('newProduct') }}'"/>
		</div>
		<div class="jumbotron m-auto">
				<h1 class="display-4">Hello, world!</h1>
				<p class="lead">Este va a ser el buscador principal</p>
				<hr class="my-4">
				<p>cuando creo la tabla del forEach de los resultados necesito un boton para agregar al nuevo presupuesto ?? </p>
				<form class="form-inline">
						<input class="form-control mr-sm-2 big-searcher" type="search" placeholder="Buscar" aria-label="Search">
						<button class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button>
					</form>
			</div>
</main>
@endsection