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
        {{-- <div class="header-update">
            <h2>Configuraciones</h2>
    
        </div> --}}
        <div class="card" id="card">
            <div class="card-body container m-0">
                <div class="col-12">
                    <div class="row header-update">
                    <h1 class="card-title col-9 mb-0"> SOY UN CATALOGO</h1>
                    {{-- <a href="{{ route('providers.create')}}" type="button" class="btn btn-info btn-lg col-3">Nuevo Proveedor</a> --}}
                    </div>
                    <div class="table-container row">
                        <table class="table table-responsive table-striped col-12">
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
                                </tr>
                                <tr>
                                <th scope="row">X</th>
                                <td>Ningun proveedor activo </td>
                                </tr>
                            </tbody>
                            </table>
                    </div>

                    <div class="catalogs">
                        <h4>Listas adjuntadas</h4>
                        <ul>
                           {{--  @forelse ($catalogs as $catalod)
                                <li><button type="button" class="btn btn-info">
                                    Profile <span class="badge badge-light">9</span>
                                    <span class="sr-only">unread messages</span>
                                  </button></li>
                            @empty
                                <button type="button" class="btn btn-warning">
                                    Ningna lista cargada <span class="badge badge-light">9</span>
                                    <span class="sr-only">unread messages</span>
                                </button>
                            @endforelse --}}
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