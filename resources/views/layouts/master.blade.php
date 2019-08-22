<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />

		<!--FontAwesome-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
		integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

		<!-- css laravel + ferremax -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
		<link href="{{ asset('css/master.css') }}" rel="stylesheet" type="text/css" >
		@yield('css')

		{{-- jquery --}}
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		{{-- <script
  src="https://code.jquery.com/jquery-3.4.1.js"></script> --}}

    <title>@yield('title')</title>
  </head>
  <body class="container-fluid">
    <header class="header-container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="/"><img src="{{ asset('images/logo-ferremax.jpg')}}" alt="logo" style="height: 25px;"></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link" href="#">Something<span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Presupuesto
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="#">Nuevo Presupuesto</a>
									<a class="dropdown-item" href="#">Historial</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Something else here</a>
									<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
																document.getElementById('logout-form').submit();">
									 {{ __('Logout') }}
							 		</a>
							 		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									 @csrf
									 </form>
								</div>
							</li>
						</ul>

						<div class="flex-center position-ref full-height">
								@if (Route::has('login'))
										<div class="top-right links">
												@auth
												<form class="form-inline my-2 my-lg-0">
														<input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
														<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
													</form> 
												@else
														<a class="nav-item" href="{{ route('login') }}">Login</a>
		
														@if (Route::has('register'))
																<a href="{{ route('register') }}">Register</a>
														@endif
												@endauth
										</div>
								@endif
						{{--<form class="form-inline my-2 my-lg-0">
							<input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
						</form> --}}
					</div>
				</nav>
		</header>
		@yield('section')
		@yield('main')
		<footer class="footer-main">
			<ul>
				<a href="http://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
				<a href="http://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
				<a href="http://plus.google.com" target="_blank"><i class="fab fa-google-plus"></i></a>
				<a href="http://twitter.com" target="_blank"><i class="fab fa-twitter"></i> </a>
			</ul>
			<p style="margin-top:1rem">COPYRIGHT © CAROLINA GONZALEZ</p>
		<img src="{{ asset('images/logo-ferremax.jpg')}}" alt="logo" style="height:30px">
		</footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     --}}<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
