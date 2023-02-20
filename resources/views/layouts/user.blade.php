<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="icon" href="{{ asset('assets/images/items/1.jpg') }}" type="image/x-icon" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/ui.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/responsive.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/all.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />

</head>

<body>

    <header class="section-header">
        <nav class="navbar navbar-dark navbar-expand p-0 bg-primary">
            <div class="container">
                <ul class="navbar-nav d-none d-md-flex mr-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Delivery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Payment</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link"> Call: +0000000000 </a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> English </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="max-width: 100px;">
                            <li><a class="dropdown-item" href="#">Arabic</a></li>
                            <li><a class="dropdown-item" href="#">Russian </a></li>
                        </ul>
                    </li>
                </ul> <!-- list-inline //  -->

            </div> <!-- container //  -->
        </nav> <!-- header-top-light.// -->
        <section class="header-main border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-6">

                        <a href="/" class="brand-wrap">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class="col-lg-6 col-12 col-sm-12">
                        <form action="/kereses/szures" class="search">
                            <div class="input-group w-100">
                                <input type="text" name="keres" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form> <!-- search-wrap .end// -->
                    </div> <!-- col.// -->
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="widgets-wrap float-md-right">
                            <div class="widget-header  mr-3">
                                <a href="#" data-toggle="modal" data-target="#cartModal"
                                    class="icon icon-sm rounded-circle border"><i class="fa fa-shopping-cart"></i></a>
                                <span class="badge badge-pill badge-danger notify">
                                    @php
                                        $cart = json_decode(Cookie::get('cart'), true);
                                        $totalQuantity = 0;
                                        if ($cart) {
                                            foreach ($cart as $item) {
                                                $totalQuantity += $item['quantity'];
                                            }
                                        }
                                    @endphp
                                    <p> {{ $totalQuantity }}</p>
                                </span>
                            </div>
                            <div class="widget-header icontext">
                                <a href="#" class="icon icon-sm rounded-circle border"><i
                                        class="fa fa-user"></i></a>
                                <div class="text">
                                    @if (Route::has('login'))
                                        @auth
                                            <span class="text-muted">Üdvözlünk {{ Auth::user()->firstname }}!</span>
                                            <div>
                                                @if (Auth::user()->admin == 0)
                                                    <a href="{{ url('/profil') }}">Profil</a>
                                                @else
                                                    <a href="{{ url('/admin') }}">Adminisztáció</a>
                                                @endif
                                                <a href="{{ url('/logout') }}">Kijelentkezés</a>
                                            </div>
                                        @else
                                            <span class="text-muted">Üdvözlünk!</span>
                                            <div>
                                                <a href="{{ route('login') }}">Bejelentkezés</a> |
                                                @if (Route::has('register'))
                                                    <a href="{{ route('register') }}"> Regisztráció</a>
                                                @endif
                                            </div>
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        </div> <!-- widgets-wrap.// -->
                    </div> <!-- col.// -->
                </div> <!-- row.// -->
            </div> <!-- container.// -->
        </section> <!-- header-main .// -->
        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Kosár tartalma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (null !== Cookie::get('cart'))
                            @if (count(json_decode(Cookie::get('cart'))))
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Termék név</th>
                                            <th>Mennyiség</th>
                                            <th>Összesen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode(Cookie::get('cart')) as $item)
                                            <tr>
                                                <td><img width="50px" src="{{ $item->file }}"
                                                        class="rounded-circle mr-3"></td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->quantity }}db</td>
                                                @if ($item->actionprice == 0)
                                                    <td>{{ $item->oneprice * $item->quantity }}ft</td>
                                                @else
                                                    <td>{{ $item->actionprice * $item->quantity }}ft</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>A kosár jelenleg üres.</p>
                            @endif
                        @else
                            <p>A kosár jelenleg üres.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="/kosartorles" class="btn btn-secondary">Kosár ürítése</a>
                        <a href="/kosar" class="btn btn-primary">Ugrás a kosár oldal</a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                    aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong></i> Ital
                                    fajták</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['category'] as $cat)
                                    <a class="dropdown-item" href="#">{{ $cat->subcategory2 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown"
                                href="#"><strong></i>Országok</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['country'] as $con)
                                    <a class="dropdown-item" href="#">{{ $con->subcategory1 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong>Borok</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['category'] as $cat)
                                    <a class="dropdown-item" href="#">{{ $cat->subcategory2 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong>
                                    Sörök</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['category'] as $cat)
                                    <a class="dropdown-item" href="#">{{ $cat->subcategory2 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown"
                                href="#"><strong>Pálinkák</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['category'] as $cat)
                                    <a class="dropdown-item" href="#">{{ $cat->subcategory2 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/akcios-termekek">Akciós termékek</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/osszes-termekek">Összes termék</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Baby &amp Toys</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Fitness sport</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Clothing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Furnitures</a>
                        </li>
                    </ul>
                </div> <!-- collapse .// -->
            </div> <!-- container .// -->
        </nav>
    </header> <!-- section-header.// -->


    @yield('content')


    <footer class="section-footer border-top bg">
        <div class="container">
            <section class="footer-top  padding-y">
                <div class="row">
                    <aside class="col-md col-6">
                        <h6 class="title">Brands</h6>
                        <ul class="list-unstyled">
                            <li> <a href="#">Adidas</a></li>
                            <li> <a href="#">Puma</a></li>
                            <li> <a href="#">Reebok</a></li>
                            <li> <a href="#">Nike</a></li>
                        </ul>
                    </aside>
                    <aside class="col-md col-6">
                        <h6 class="title">Company</h6>
                        <ul class="list-unstyled">
                            <li> <a href="#">About us</a></li>
                            <li> <a href="#">Career</a></li>
                            <li> <a href="#">Find a store</a></li>
                            <li> <a href="#">Rules and terms</a></li>
                            <li> <a href="#">Sitemap</a></li>
                        </ul>
                    </aside>
                    <aside class="col-md col-6">
                        <h6 class="title">Help</h6>
                        <ul class="list-unstyled">
                            <li> <a href="#">Contact us</a></li>
                            <li> <a href="#">Money refund</a></li>
                            <li> <a href="#">Order status</a></li>
                            <li> <a href="#">Shipping info</a></li>
                            <li> <a href="#">Open dispute</a></li>
                        </ul>
                    </aside>
                    <aside class="col-md col-6">
                        <h6 class="title">Felhasználó</h6>
                        <ul class="list-unstyled">
                            <li> <a href="/bejelentkezes"> Bejelentkezés </a></li>
                            <li> <a href="/regisztacio"> Regisztráció </a></li>
                            <li> <a href="#"> Account Setting </a></li>
                            <li> <a href="#"> My Orders </a></li>
                        </ul>
                    </aside>
                    <aside class="col-md">
                        <h6 class="title">Social</h6>
                        <ul class="list-unstyled">
                            <li><a href="#"> <i class="fab fa-facebook"></i> Facebook </a></li>
                            <li><a href="#"> <i class="fab fa-twitter"></i> Twitter </a></li>
                            <li><a href="#"> <i class="fab fa-instagram"></i> Instagram </a></li>
                            <li><a href="#"> <i class="fab fa-youtube"></i> Youtube </a></li>
                        </ul>
                    </aside>
                </div> <!-- row.// -->
            </section> <!-- footer-top.// -->
            <section class="footer-bottom row">
                <div class="col-md-2">
                    <p class="text-muted"> 2021 Company name </p>
                </div>
                <div class="col-md-8 text-md-center">
                    <span class="px-2">info@com</span>
                    <span class="px-2">+000-000-0000</span>
                    <span class="px-2">Street name 123, ABC</span>
                </div>
                <div class="col-md-2 text-md-right text-muted">
                    <i class="fab fa-lg fa-cc-visa"></i>
                    <i class="fab fa-lg fa-cc-paypal"></i>
                    <i class="fab fa-lg fa-cc-mastercard"></i>
                </div>
            </section>
        </div><!-- //container -->
    </footer>
    <!-- ========================= FOOTER END // ========================= -->

</body>

</html>
