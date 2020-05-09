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
                    <h1 class="card-title col-9 mb-0">Secciones</h1>
                <a href="{{ route('sections.create')}}" type="button" class="btn btn-info btn-lg col-3">Nueva Sección</a>
                </div>
                <div class="table-container row">
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
                            @forelse ($sections as $section)
                            <tr>
                                <th scope="row">{{ $section->id }}</th>
                                <td>{{ $section->name }}</td>
                                <td>{{ isset($section->description) ? $section->description : '' }}</td>
                                <td>{{ $section->category->name }}</td>
                                <td><a href="{{ route('sections.show', ['id' => $section->id ])}}" type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                                        {!! Form::open(array('route' => array('sections.destroy', $section->id), 'class'=>'d-inline', 'method' => 'DELETE')) !!}
                                        <button title="Borrar sección" type="submit" class="btn btn-outline-info btn-sm"><i class="far fa-trash-alt"></i></button>
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
                </div>
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
    </div>
@endsection