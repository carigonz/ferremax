@extends('layouts/master')

@section('title', 'Configurar proveedor')

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
        {{-- <div class="header-update">
            <h2>Configuraciones</h2>
    
        </div> --}}
        <div class="card" id="card">
            <div class="card-body container m-0">
                <div class="row header-update">
                <h1 class="card-title col-9 mb-0">Configurar {{ $provider->name}}</h1>
                {{-- <a href="{{ route('providers.create')}}" type="button" class="btn btn-info btn-lg col-3">Nuevo Proveedor</a> --}}
                </div>
                <div class="table-container row">
                    <div class="col-8">
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr class="table-success">
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descipción</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Nueva Lista</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $provider->id }}</th>
                                    <td class="text-muted">{{ $provider->name }}</td>
                                    <td class="text-muted">{{ isset($provider->description) ? $provider->description : '' }}</td>
                                    <td class="text-muted">{{ $provider->providerType->type }}</td>
                                    <td><span data-toggle="tooltip" data-placement="top" title="{{ $provider->status ? 'Activo' : 'Inactivo - de baja' }}" class="btn btn-outline-{{ $provider->status ? 'success' : 'danger' }} btn-sm text-center"><i class="fas fa-toggle-{{ $provider->status ? 'on' : 'off' }}"></span></i></td>
                                    <td>
                                        {!! Form::open(array('route' => array('catalogs.create', $provider->id), 'class'=>'d-inline', 'method' => 'GET')) !!}
                                        <button title="Borrar proveedor" type="submit" class="btn btn-outline-info">Crear Lista</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            </tbody>
    
                        </table>
                        {!! Form::open(array('route' => array('providers.update', $provider->id), 'class'=>'d-inline', 'method' => 'PUT')) !!}
                        {!! Form::hidden( 'status', $provider->status ? false : true ) !!}
                            <button class="btn btn-outline-info btn-lg">Cambiar status del proveedor</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="catalogs col-4">
                        <h4>Listas adjuntadas - configurar</h4>
                        <ul>
                            @forelse ($catalogs as $catalog)
                                <li>
                                    {!! Form::open(array('route' => array('catalogs.show', $provider->id, $catalog->id), 'class'=>'d-inline', 'method' => 'GET')) !!}
                                    <button class="btn btn-light">
                                    {{ $catalog->name }} 
                                    </button>
                                    {!! Form::close() !!}
                                </li>
                            @empty
                                <li>Ninguna lista cargada.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
            </div> --}}
        </div>
    </div>

@endsection

@section('inline-scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection