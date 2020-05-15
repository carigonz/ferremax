@extends('layouts/master')

@section('title', 'Catalogo')

@section('inline-css')
<style>
    .details-catalog > li {
        margin-bottom: 15px;
    }
    .details-catalog > h5,
    #form-update-catalog > h4 {
        margin: 10px 0px 15px 10px;
        color: #7322dd;
    }
    #form-update-catalog{
        border: solid 1px #b2afb6;
        border-radius: 5px;
        margin-left: 30px;
        padding-bottom: 20px;
    }
</style>
@endsection

@section('main')

    <div class="card-deck flex-column">
        <div class="card" id="card">
            <div class="card-body m-0">
                <div class="row">
                    <h2 class="card-title col-9 mb-0 header-update">Lista: {{ $catalog->name }}</h2>
                </div>
                <div class="row d-flex">
                    <div class="col-5">
                        <ul class="details-catalog">
                            <h5><i class="fas fa-angle-double-right"></i> Detalles</h5>
                            <li>Nombre de archivo: {{ $catalog->file_name}}.</li>
                            <li>Última actialización: {{ $catalog->updated_at->format('d-m-Y')}}.</li>
                            <li>Condición de IVA: {{ (int)$catalog->taxes_amount}} %</li>
                            @if ($parent = $provider->parent())
                                <li>Distribuidora/Empresa: {{ $provider->name }}</li>
                                <li>Corredor/Proveedor: {{ $provider->parent->name }}</li>
                            @else
                                <li>Proveedor: {{ $provider->name }}</li>
                            @endif
                            <h5><i class="fas fa-angle-double-right"></i> Descuentos</h5>
                            @if (!empty($catalog->discounts))
                                @foreach ($catalog->discounts as $discount)
                                    <li><i class="fas fa-{{$discount->active ? 'check': 'times'}}" aria-hidden="true"></i>   -{{$discount->amount}}% - {{$discount->active ? 'Aplicado': 'Sin aplicar'}}</li>
                                @endforeach
                            @else
                                <li><i class="fas fa-times" aria-hidden="true"></i> No hay descuentos cargados para esta lista.</li>
                            @endif
                        </ul>
                        <p>En esta pantalla podrá actualizar los descuento o la condición de iva para los productos de esta lista.
                            Para una actualización general de precios o secciones de todos los productos, debe ingresar un archivo .xls o .xlsx. También puede actualizar productos puntuales desde la pantalla Menú -> Configuración -> productos.
                        </p>
                        <button id="update-show" type="button" class="btn btn-light btn-lg">Actualizar lista</button>
                    </div>

                    <div class="col-6" id="form-update-catalog">
                        <h4><i class="fas fa-angle-double-right"></i> Actualizar</h4>
                        {!! Form::open(array('route' => array('catalogs.update', $provider->id, $catalog->id), 'id' => 'update-catalog-form', 'class'=>'d-inline form-update', 'method' => 'POST')) !!}
                        <div class="form-group d-flex flex-column">
                            {!! Form::label('file', 'Adjunte la nueva versión de la lista') !!}
                            {!! Form::file('file') !!}
                        </div>
                        <h5>Actualizar condición de IVA</h5>
                        <div class="form-check">
                            {!! Form::label('taxes', 'lista con IVA incluido', ['id' => 'taxes_check']) !!}
                            {!! Form::checkbox('taxes', true , $catalog->taxes ? true : false , ['id' => 'taxes_check']) !!}
                        </div>
                        <div class="form-group d-flex flex-column " id="taxes_select">
                            {!! Form::label('taxes_amount', 'Agregar IVA a la lista') !!}
                            {!! Form::select('taxes_amount', [12 => 'Medio IVA (11.5%)', 21 => 'IVA completo (21%)'], $catalog->taxes_amount ? (int)$catalog->taxes_amount: 0, ['class'=>'form-control taxes_amount', 'placeholder' => 'Seleccione condicion de IVA']) !!}
                        </div>
                        <h5>Aplicar Descuentos</h5>
                        <p>Los descuentos serán aplicados sobre el precio neto. En caso de existir precio publico, no se aplicará ningún descuento cargado acontinuacion.</p>
                        <div class="form-group flex-column " id="taxes_select">
                            <button type="button" id="discounts-button" class="btn btn-light">Agregar Descuentos a la lista</button>
                            {!! Form::label('discounts[]', 'Ingrese el descuento como numero entero sin signos. Ej: lista -15.4% = 15.4', ['class' => 'd-none label-discounts']) !!}
                            @forelse ($catalog->discounts as $discount)
                            <div>
                                <input name="discounts[]" value="{{ $discount->amount}}" type="number" step="any" min="0" max="100" class="form-control" style="width: 85%; display:inline-block;"><button type="button" style="height: 38px; margin-bottom: 2px;" class="btn btn-outline-danger btn-sm px-3 delete-discount" ><i class="fas fa-times"></i></button>
                            </div>
                            @empty
                                
                            @endforelse
                        </div>
                        {{ Form::button('Enviar', ['type' => 'submit', 'class' => 'btn btn-info form-submit'] )  }}
                        {!! Form::close() !!}

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
            $('#form-update-catalog').hide();

            $('#update-show').click(function (e) { 
                e.preventDefault();

                $('.delete-discount').each(function (index, element) {
                    $(this).bind('click', function (e) {
                        $(this).parent().remove();
                    });
                });

                $('#form-update-catalog').show();
            });
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
                $(this).parent().append('<div><input name="discounts[]" type="number" step="any" min="0" max="100" class="form-control" style="width: 85%; display:inline-block;"><button type="button" style="height: 38px; margin-bottom: 2px;" class="btn btn-outline-danger btn-sm px-3 delete-discount"><i class="fas fa-times"></i></button></div>');

                $('.delete-discount').click(function (e) { 
                    e.preventDefault();
                    $(this).parent().remove();
                });
            });

            $('.form-submit').click(function (e) { 
                e.preventDefault();
                confirm('Esta seguro que los datos son correctos?');
                $('#update-catalog-form').submit();
            });
        });
    </script>
@endsection