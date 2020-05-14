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
        <div class="card-body container form-std d-flex flex-column">
            <div class="row">
                <h1>aca te explico como usar</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, quo optio laudantium illo cum doloribus repellendus reiciendis rerum minus consequatur maxime, excepturi deleniti quibusdam modi ratione repudiandae harum, ab facere. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, accusantium maiores nesciunt tempora rerum fuga ullam dolores temporibus quis laudantium architecto perspiciatis voluptatem dignissimos minima eveniet earum totam at rem.</p>
            </div>
            <div class="row">
                <div class="col-4 flex-column">
                    <h3>Ingrese su nueva lista</h3>
                    {!! Form::open(array('route' => array('catalogs.store', $provider->id), 'class'=>'d-flex flex-column', 'method' => 'POST', 'files' => true)) !!}
                    <div class="form-group d-flex flex-column">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', null, array('placeholder' => 'Indica el nombre de la lista') ) !!}
                    </div>
                    <div class="form-group d-flex flex-column">
                        {!! Form::label('acronym', 'Acrónimo') !!}
                        {!! Form::text('acronym', null, array('placeholder' => 'Indica el acrónimo de la lista') ) !!}
                        <small>El acrónimo es usado para modificar los codigos de los productos que tengan esta lista asociada. Eso permite tener dos codigos iguales para el mismo producto, pero trazando la diferencia de que son pertenecientes a distintas listas. De 2 a 4 caracteres.</small>
                    </div>
                    <div class="form-group d-flex flex-column">
                        {!! Form::label('file', 'Adjunte la lista') !!}
                        {!! Form::file('file') !!}
                    </div>
                    <h4>condición de IVA</h4>
                    <div class="form-check">
                        {!! Form::label('taxes', 'lista con IVA incluido', ['id' => 'taxes_check']) !!}
                        {!! Form::checkbox('taxes', true , true, ['id' => 'taxes_check']) !!}
                    </div>
                    <div class="form-group flex-column " id="taxes_select">
                        {!! Form::label('taxes_amount', 'Agregar IVA a la lista') !!}
                        {!! Form::select('taxes_amount', [12 => 'Medio IVA (11.5%)', 21 => 'IVA completo (21%)'], null, ['class'=>'form-control taxes_amount', 'placeholder' => 'Seleccione condicion de IVA']) !!}
                    </div>
                    <h5>Descuentos</h5>
                    <p>Los descuentos serán aplicados sobre el precio neto. En caso de existir precio publico, no se aplicará ningún descuento cargado acontinuacion. La información del campo precio_publico es absoluta.</p>
                    <div class="form-group flex-column " id="taxes_select">
                        <button type="button" id="discounts-button" class="btn btn-light">Agregar Descuentos a la lista</button>
                        {!! Form::label('discounts[]', 'Ingrese el descuento como numero entero sin signos. Ej: lista -15.4% = 15.4', ['class' => 'd-none label-discounts']) !!}
                    </div>
                    {{ Form::button('Enviar', ['type' => 'submit', 'class' => 'btn btn-info'] )  }}
                    {!! Form::close() !!}
                </div>
                <div class="col-8">
                    <h3>Formato de archivos excel</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">Campo</th>
                                    <th scope="col" style="min-width: 110px">Condicion</th>
                                    <th scope="col">Tipo de datos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Codigo</td>
                                    <td>Requerido</td>
                                    <td>Alfanumérico</td>
                                </tr>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Requerido</td>
                                    <td>Alfanumérico</td>
                                </tr>
                                <tr>
                                    <td>Descripción</td>
                                    <td>No requerido</td>
                                    <td>Alfanumérico | Campo extra que permite hacer busquedas más completas.</td>
                                </tr>
                                <tr>
                                    <td>Neto</td>
                                    <td>Requerido</td>
                                    <td>Numérico, formato: 1234.23</td>
                                </tr>
                                <tr>
                                    <td>Público</td>
                                    <td>No requerido</td>
                                    <td>Numérico, formato: 1234.23. En caso de existir, este es el precio que se mostrará en la lista customizada. En caso de no existir, se aplicaran las reglas de los descuentos, iva, etc.</td>
                                </tr>
                                <tr>
                                    <td>Custom</td>
                                    <td>No requerido</td>
                                    <td>'0' / '1' | Los productos marcados como "custom" serán los que se muestren por default, en el buscador de "mis productos". Para marcar como custom, debe incluir un 1 en la fila de sus productos. Default: 0</td>
                                </tr>
                                <tr>
                                    <td>Sección</td>
                                    <td>No requerido</td>
                                    <td>La seccion permite una clasificacion y busqueda mas customizada de los productos. Es recomendable siempre que ingrese productos custom, le asigne su sección.</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
    </div>
</section>
@endsection

@section('inline-scripts')
    <script>
        $(document).ready(function () {

            $('.taxes_amount').select2({
                placeholder: "Seleccione condicion de IVA",
                language: "es"
            });
            let taxes_select = $('#taxes_select');

            if($('input[type="checkbox"]').is(':checked')) {
                $(taxes_select).addClass('d-none');
            } else {
                $(taxes_select).removeClass('d-none');
            }

            $('input[type="checkbox"]').change(function() {

                if ($(this).is(":checked")) {
                    $(taxes_select).removeClass('d-flex');
                    $(taxes_select).addClass('d-none');

                } else {
                    $(taxes_select).removeClass('d-none');
                    $(taxes_select).addClass('d-flex');
                }
            });

            $('#discounts-button').click(function (e) { 
                e.preventDefault();

                $('.label-discounts').removeClass('d-none');
                $(this).parent().append('<div><input name="discounts[]" type="number" step="any" min="0" max="100" class="form-control" style="width: 85%; display:inline-block;"><button type="button" style="height: 38px; margin-bottom: 2px;" class="btn btn-outline-danger btn-sm px-3" id="delete-discount"><i class="fas fa-times"></i></button></div>');

                $('#delete-discount').click(function (e) { 
                e.preventDefault();
                console.log('holis');
                $(this).parent().remove();
            });
            });
        });
    </script>
@endsection