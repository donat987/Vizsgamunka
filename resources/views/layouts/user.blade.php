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
        <section class="header-main border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-6">

                        <a href="/" class="brand-wrap">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class="col-lg-6 col-12 col-sm-12">
                        <form action="/termekek" class="search">
                            <div class="input-group w-100">
                                <input type="text" name="keres" class="form-control" placeholder="Keresés">
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
                                <a href="{{ url('/profil') }}" class="icon icon-sm rounded-circle border"><i
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
                                    <a class="dropdown-item" href="/termekek?fajta%5B%5D={{ $cat->subcategory2 }}">{{ $cat->subcategory2 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown"
                                href="#"><strong></i>Országok</strong></a>
                            <div class="dropdown-menu">
                                @foreach ($layout['country'] as $con)
                                    <a class="dropdown-item" href="/termekek?orszag%5B%5D={{ $con->subcategory1 }}">{{ $con->subcategory1 }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/termekek?akcio=1">Akciós termékek</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/termekek">Összes termék</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/blog">Blog</a>
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
                <div class="row" style="text-align: center;">
                    <aside class="col-md col-6" style="text-align: left;">
                        <h6 class="title">Segíthetek?</h6>
                        <ul class="list-unstyled">
                            <li> <a href="/gyakori-kerdesek">Gyakori kérdések</a></li>
                            <li> <a href="/afsz">Áfsz</a></li>
                            <li> <a href="/szallitas">Szállítás</a></li>
                        </ul>
                    </aside>
                    <aside class="col-md col-6" style="text-align: center;">
                        <h6 class="title">Felhasználó</h6>
                        <ul class="list-unstyled">
                            <li> <a href="{{ route('login') }}"> Bejelentkezés </a></li>
                            <li> <a href="{{ route('register') }}"> Regisztráció </a></li>
                            <li> <a href="{{ route('profil') }}"> Felhasználó </a></li>
                            <li> <a href="{{ route('orders') }}"> Rendelések </a></li>
                        </ul>
                    </aside>
                    <aside class="col-md" style="text-align: right;">
                        <h6 class="title">Közösségi oldalak</h6>
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
                    <p class="text-muted"> 2023 Italdiszkont </p>
                </div>
                <div class="col-md-8 text-md-center">
                    <span class="px-2">inf@dalosdonat.hu</span>
                    <span class="px-2">+36-99-265-59-52</span>
                    <span class="px-2">Kiskar utca 123, Szombathely</span>
                </div>
            </section>
        </div><!-- //container -->
        <div class="cookie-disclaimer">
            <div class="cookie-close accept-cookie"><i class="fa fa-times"></i></div>
            <div class="container">
              <p>Figyelem! Az oldal sütikat tartalmaz! <a href="https://nevetnikek.hu/cookie/">Mi az a süti?</a>. 
                <br>Az oldalon elvégzett rendelés nem kerül kiszállításara, ez egy vizsga munka!</p>
              <button type="button" class="btn btn-primary accept-cookie">Elfogadom!</button>
            </div>
          </div>
          <script>$(document).ready(function() { 
            var cookie = false;
            var cookieContent = $('.cookie-disclaimer');
        
            checkCookie();
        
            if (cookie === true) {
              cookieContent.hide();
            }
        
            function setCookie(cname, cvalue, exdays) {
              var d = new Date();
              d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
              var expires = "expires=" + d.toGMTString();
              document.cookie = cname + "=" + cvalue + "; " + expires;
            }
        
            function getCookie(cname) {
              var name = cname + "=";
              var ca = document.cookie.split(';');
              for (var i = 0; i < ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
              }
              return "";
            }
        
            function checkCookie() {
              var check = getCookie("acookie");
              if (check !== "") {
                return cookie = true;
              } else {
                  return cookie = false; //setCookie("acookie", "accepted", 365);
              }
              
            }
            $('.accept-cookie').click(function () {
              setCookie("acookie", "accepted", 365);
              cookieContent.hide(500);
            });
        });</script>
    </footer>
    <!-- ========================= FOOTER END // ========================= -->

</body>

</html>
