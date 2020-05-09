@extends('layouts/master')

@section('title', 'Crear Clasificación')
    
@section('inline-css')
<style>
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
                {!! Form::open(array('route' => 'classifications.store', 'class'=>'d-flex flex-column')) !!}
                <h5 class="card-title">Crear</h5>
                {!! Form::label('tyoe', 'Nombre') !!}
                {!! Form::text('type', null, array('placeholder' => 'Nombra una clasificación de tus productos.') ) !!}
                {!! Form::label('description', 'Descripción') !!}
                {!! Form::text('description', null, array('placeholder' => 'Indica anotaciones o descripción') ) !!}
                {{ Form::button('Enviar', ['type' => 'submit', 'class' => 'btn btn-info'] )  }}
                {!! Form::close() !!}

            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
</div>
@endsection