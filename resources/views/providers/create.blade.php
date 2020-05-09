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
    .form-std > div form > * {
        max-width: 300px;
        margin-bottom: 20px;
    }
    form > input {
        border-radius: 5px;
    }
</style>
@endsection

@section('main')
<section class="main-container-update flex-column container-fluid d-flex justify-content-around align-items-center">
    <h4><a href="{{route('configuration')}}">Configuración</a> / <strong>Nuevo proveedor</strong></h4>
<div class="card-deck flex-column">
    <div class="header-update">
    </div>
    <div class="card" id="card">
        <div class="card-body container form-std">
            <div class="col-12 flex-column">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul> 
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                {!! Form::open(array('route' => 'providers.create', 'class'=>'d-flex flex-column')) !!}
                <h5 class="card-title">Crear</h5>
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', isset($provider) ? $provider->name : null, array('placeholder' => 'Indica el nombre del nuevo proveedor') ) !!}
                {!! Form::label('description', 'Descripción') !!}
                {!! Form::text('description', isset($provider) ? $provider->name : null, array('placeholder' => 'Indica anotaciones o descripción') ) !!}
                {!! Form::label('provider_type_id', 'Tipo de Proveedor') !!}
                {!! Form::select("provider_type_id", $providerTypes->pluck('type', 'id'), isset($provider) ? $provider->provider_type_id : null)!!}
                {{ Form::button('Enviar', ['type' => 'submit', 'class' => 'btn btn-info'] )  }}
                {!! Form::close() !!}

            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
    </div>
</section>
@endsection