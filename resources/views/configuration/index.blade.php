@extends('layouts/master')

@section('title', 'Crear Provedor')

@section('main')
<style>

    .container-cards {
        margin: 30px;
    }
</style>

    <div class="card-deck container-cards" >
        <div class="card">
            <h5 class="card-header">Proveedores</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="{{ route('providers.index')}}" class="btn btn-primary">Configurar Proveedores</a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Clasificaciones</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="{{ route('classifications.index')}}" class="btn btn-primary">Configurar Clasificaciones</a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Categorías</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="{{ route('categories.index')}}" class="btn btn-primary">Configurar Categorias</a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Secciones</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="{{ route('sections.index')}}" class="btn btn-primary">Configurar Secciones</a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Productos</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="{{ route('products.index')}}" class="btn btn-primary">Configurar Productos</a>
            </div>
        </div>
      </div>
@endsection