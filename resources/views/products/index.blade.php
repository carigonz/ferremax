@extends('layouts/master')

@section('title', 'Secciones')

@section('inline-css')
    <style>
    .form-container {
        max-width: 360px;
        padding: 30px;
        vertical-align: middle;
    }
    .header-update {
        margin-bottom: 35px;
    }
    
    .has-error {
        color: red;
        font-size: 1.2em;
    }
    
    #card {
        margin: auto;
        width: 82vw;
        padding: 20px 30px;
        margin-bottom: 40px;
        display: block;
    }
    </style>
@endsection

@section('main')

<div class="card-deck flex-column">
    <div class="card" id="card">
        <div class="card-body container m-0">
            <div class="col-12">
                <div class="row header-update">
                    <h1 class="card-title col-9 mb-0">Productos</h1>
                <a href="{{ route('products.create')}}" type="button" class="btn btn-info btn-lg col-3">Nuevo Producto</a>
                </div>
                <div class="content">
                    <ul>
                        <li>un buscador, buscar un producto puntual y modificarlo</li>
                        <li>O clasificar ?? Tipo si no tienen seccion que no se oueda</li>
                        <li>un excel descargable</li>
                    </ul>
                </div>
                {{-- <div class="table-container row">
                    <table class="table table-responsive table-striped col-12">
                        <thead>
                            <tr class="table-info">
                                <th scope="col">#</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descipción</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ isset($product->description) ? $product->description : '' }}</td>
                                <td>{{ $product->section->name }}</td>
                                <td><a href="{{ route('products.show', ['id' => $product->id ])}}" type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                                        {!! Form::open(array('route' => array('products.destroy', $product->id), 'class'=>'d-inline', 'method' => 'DELETE')) !!}
                                        <button title="Borrar producto" type="submit" class="btn btn-outline-info btn-sm"><i class="far fa-trash-alt"></i></button>
                                        {!! Form::close() !!}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>Ninguna sección creada</td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                </div> --}}
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
    </div>
@endsection