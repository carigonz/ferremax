@extends('/layouts/master')

@section('title', 'Ferremax')

@section('css')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet" type="text/css" >    
@endsection

@section('main')
    <main>
        @if (Auth::check())
            <section class=" main-container-welcome d-flex justify-content-center align-items-center" >
                <div class="target-search d-flex align-items-center justify-content-center flex-column">
                    <h3>Ir al Buscador</h3>
                    <button  onclick="location.href = '{{ Route('search') }}'" id="query" class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button>
                </div>
            </section>
        @endif
    </main>
@endsection

@section('inline-scripts')
    <script>
        $('.target-search').addClass('load');
        $('.main-container-welcome').addClass('load');
    </script>
@endsection