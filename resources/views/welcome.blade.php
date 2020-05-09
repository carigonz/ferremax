@extends('/layouts/master')

@section('title', 'Ferremax')

@section('inline-css')
    <style>
        .main-section {
            height: 100vh;
            background-image: url(/images/fondo1.JPG);
            background-size: cover;
            padding: 0 !important;
        }
        .main-container-welcome {
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 0;
            -webkit-transition: opacity 2s ease-in;
            -moz-transition: opacity 2s ease-in;
            -o-transition: opacity 2s ease-in;
            -ms-transition: opacity 2s ease-in;
            transition: opacity 2s ease-in;
            width: 100vw;
        }
        .target-search {
            background-color: var(--main-bg-light);
            padding: 30px;
            border-radius: 20px;
            opacity: 0;
            -webkit-transition: opacity 2s ease-in;
            -moz-transition: opacity 2s ease-in;
            -o-transition: opacity 2s ease-in;
            -ms-transition: opacity 2s ease-in;
            transition: opacity 2s ease-in;
        }
        .target-search.load,
        .main-container-welcome.load {
            opacity: 1;
        }
        .target-search h3 {
            margin-bottom: 25px;
        }

        .search-button {
            height: 68px;
            width: 90px;
            border-radius: 50px;
        }
        .btn .fas.fa-search.big {
            font-size: 35px;
        }
    </style>    
@endsection

@section('main')
    <div class="main-container-welcome d-flex align-items-center justify-content-center flex-column p-0">
        <div class="target-search d-flex align-items-center justify-content-center flex-column ">
            <h3>Ir al Buscador</h3>
            <button  onclick="location.href = '{{ Route('search') }}'" id="query" class="btn btn-primary btn-md my-2 my-sm-0 search-button" type="submit"><i class="fas fa-search big"></i></button>
        </div>
    </div>
@endsection

@section('inline-scripts')
    <script>
        $('.target-search').addClass('load');
        $('.main-container-welcome').addClass('load');
    </script>
@endsection