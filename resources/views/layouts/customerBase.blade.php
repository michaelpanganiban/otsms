
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <title>OTSMS Homepage - Shop Now!</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="{{ asset('assets/shop-home/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        
        <style>
            .header-color{
                background-color: teal;
                color: white;
            }
            .image-container {
                height: 400px;
                width: 100%;
                text-align: center;
                padding-top: 100px;
                color: white;
                overflow: hidden;
                background: #333333;  /* fallback for old browsers */
                background: linear-gradient(rgba(1, 146, 156, 0.8), rgba(1, 146, 156, 0.8)), url("../assets/images/carousel/cas1.jpg");  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(rgba(1, 146, 156, 0.8), rgba(1, 146, 156, 0.8)), url("../assets/images/carousel/cas1.jpg"); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                background-size: cover;
                background-repeat: no-repeat;
            }

            .image-container2 {
                height: 400px;
                width: 100%;
                text-align: center;
                padding-top: 100px;
                color: white;
                overflow: hidden;
                background: #333333;  /* fallback for old browsers */
                background: linear-gradient(rgba(1, 146, 156, 0.8), rgba(1, 146, 156, 0.8)), url("../assets/images/carousel/buttons.jpg");  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(rgba(1, 146, 156, 0.8), rgba(1, 146, 156, 0.8)), url("../assets/images/carousel/buttons.jpg"); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                background-size: cover;
                background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5" >
                <a class="navbar-brand" href="/" >Shop Now!</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link {{ (request()->is('/') ? 'active' : '') }}" aria-current="page" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ (request()->is('about') ? 'active' : '') }}"" href="/about">About</a></li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                    @guest
                        @if (Route::has('login'))
                            <form class="d-flex">
                                <a href="/login" class="btn btn-outline-dark" style="background-color: teal; color: white;">
                                    <i class="bi-lock-fill me-1"></i>
                                    Login
                                </a>
                            </form>
                        @endif

                        @if (Route::has('register'))
                            <form class="d-flex">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </form>
                        @endif
                    @else
                        <a href="/orders" class="btn btn-outline-dark" style="background-color: teal; color: white;">
                            <i class="bi-cart me-1"></i>
                            Orders
                        </a> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                        <a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                    {{-- <form class="d-flex">
                        <a href="/login" class="btn btn-outline-dark" style="background-color: teal; color: white;">
                            <i class="bi-lock-fill me-1"></i>
                            Login
                        </a>
                    </form>
                    &nbsp;<b>|</b>&nbsp;
                    <form class="d-flex">
                        <a href="/register">Register</a>
                    </form> --}}
                </div>
            </div>
        </nav>
            @yield('content')
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Daneil & Janine Tailoring Shop</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/shop-home/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/custom/main.js') }}"></script>
        <script src="{{ asset('assets/custom/orders.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    </body>
</html>