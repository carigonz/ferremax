@extends('layouts/master')

@section('title', 'Crear Provedor')
    
@section('inline-css')
<style>
.main-container-update {
    background-image: linear-gradient(
        to bottom,
        #b675e7,
        #af6ae8,
        #a85fe9,
        #a054ea,
        #9749eb
    );
    height: 100vh;
}

.container-json-update,
.container-item-update {
    margin-bottom: 30px;
    background-color: #fafafa;
    color: #b657ee;
    min-height: 500px;
    width: 80vw;
    -webkit-box-shadow: 0px 0px 20px 0px rgba(120, 116, 120, 1);
    -moz-box-shadow: 0px 0px 20px 0px rgba(120, 116, 120, 1);
    box-shadow: 0px 0px 20px 0px rgba(120, 116, 120, 1);
    max-width: 35vw;
}
.form-container {
    max-width: 360px;
    padding: 30px;
    vertical-align: middle;
}
.header-update {
    margin-bottom: 20px;
    color: #fafafa;
    width: 82vw;
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
<section class="main-container-update flex-column container-fluid d-flex justify-content-around align-items-center">
<div class="card-deck flex-column">
    <div class="header-update">
    <h4><a href="{{route('configuration')}}">Configuración</a> / <strong>Nuevo proveedor</strong></h4>
    </div>
    <div class="card" id="card">
        <div class="card-body container">
            <div class="col-12">
                <div class="row">
                    <h5 class="card-title col-9">Proveedores</h5>
                <a href="{{ route('providers.create')}}" type="button" class="btn btn-info col-3">Nuevo Proveedor</a>
                </div>
            </div>
            <div class="col-12">
                <h5 class="card-title">Nuevo proveedor</h5>
                {{-- {!! Form::open(array('route' => 'providers.create')) !!}
                {!! Form::text('name', null) !!}
                {!! Form::text('description', null) !!}
                {!! Form::select("provider_type_id", [
                    '1' => 'Corredor'
                ], '1') !!}
                {!! Form::submit('enviar', [$options]) !!}
                {!! Form::close() !!} --}}

            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
    </div>
</section>
@endsection