@extends('layouts.user')
@section('content')
    <!-- ========================= SECTION INTRO ========================= -->
    <section class="section-intro padding-y-sm">
        <div class="container">
            <div class="intro-banner-wrap">
                <img src="assets/images/1.jpg" class="img-fluid rounded">
            </div>
        </div> <!-- container //  -->
    </section>
    <!-- ========================= SECTION INTRO END// ========================= -->
    <!-- ========================= SECTION FEATURE ========================= -->
    <section class="section-content padding-y-sm">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary  d-flex justify-content-center"><i
                                    class="fa fa-2x fa-truck"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title d-flex justify-content-center">Gyors szállítás</h5>
                                <p>Ha hétköznap 12:00-ig leadja a rendelését, akkor már másnap kézbesítjük.</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary d-flex justify-content-center"><i
                                    class="fa fa-2x fa-wine-bottle"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title  d-flex justify-content-center">Tudjuk, hogy törékeny</h5>
                                <p>Biztonságos csomagolás, elégedettséggel garantálva! Minden árut gondosan becsomagolunk, hogy az épségben és jó állapotban érkezzen meg.
                                </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary  d-flex justify-content-center"><i
                                    class="fa fa-2x fa-glasses"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title  d-flex justify-content-center">Figyelünk a minőségre</h5>
                                <p>Stílusos és minőségi termékek egy helyen! Az oldalunkon található összes termék gondosan kiválogatott, hogy biztosítsuk a legjobb minőséget és stílust minden vásárlónk számára.
                                </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div> <!-- col // -->
                </div>
            </article>
        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION FEATURE END// ========================= -->
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <a href="/termekek?fajta%5B%5D=Pálinka" class="btn btn-outline-primary float-right">Összes termék</a>
                <h3 class="section-title">Pálinka különlegességek</h3>

            </header><!-- sect-heading -->
            <div class="row">
                @foreach ($negyrandom as $sor)
                    <div class="col-md-3">
                        <div href="/termekek/{{ $sor->link }}" class="card card-product-grid">
                            <a href="/termekek/{{ $sor->link }}" class="img-wrap mt-3"> <img src="{{ $sor->file }}"> </a>
                            <figcaption class="info-wrap">
                                <a href="/termekek/{{ $sor->link }}" class="title">{{ $sor->name }}</a>

                                @if ($sor->db != 0)
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:{{ $sor->points }}%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> {{ $sor->db }}db
                                            értékelés</span>
                                    </div>
                                @else
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:0%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> 0db értékelés</span>
                                    </div>
                                @endif
                                @if ($sor->actionprice != 0)
                                    <div class="price-old mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                    <div class="price mt-1 ">{{ $sor->actionprice }} ft</div> <!-- price-wrap.// -->
                                @else
                                    <div class="price mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                @endif
                            </figcaption>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->
        </div> <!-- container .//  -->
    </section>

    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <a href="/termekek?fajta%5B%5D=Bor" class="btn btn-outline-primary float-right">Összes termék</a>
                <h3 class="section-title">Bor különlegességek</h3>

            </header><!-- sect-heading -->
            <div class="row">
                @foreach ($negyrandombor as $sor)
                    <div class="col-md-3">
                        <div href="/termekek/{{ $sor->link }}" class="card card-product-grid">
                            <a href="/termekek/{{ $sor->link }}" class="img-wrap mt-3"> <img src="{{ $sor->file }}"> </a>
                            <figcaption class="info-wrap">
                                <a href="/termekek/{{ $sor->link }}" class="title">{{ $sor->name }}</a>
                                @if ($sor->db != 0)
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:{{ $sor->points }}%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> {{ $sor->db }}db
                                            értékelés</span>
                                    </div>
                                @else
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:0%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> 0db értékelés</span>
                                    </div>
                                @endif
                                @if ($sor->actionprice != 0)
                                    <div class="price-old mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                    <div class="price mt-1 ">{{ $sor->actionprice }} ft</div> <!-- price-wrap.// -->
                                @else
                                    <div class="price mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                @endif
                            </figcaption>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->
        </div> <!-- container .//  -->
    </section>

    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <a href="/termekek?fajta%5B%5D=Whiskey" class="btn btn-outline-primary float-right">Összes termék</a>
                <h3 class="section-title">Whiskey különlegességek</h3>

            </header><!-- sect-heading -->
            <div class="row">
                @foreach ($negyrandomwiskey as $sor)
                    <div class="col-md-3">
                        <div href="/termekek/{{ $sor->link }}" class="card card-product-grid">
                            <a href="/termekek/{{ $sor->link }}" class="img-wrap mt-3"> <img src="{{ $sor->file }}">
                            </a>
                            <figcaption class="info-wrap">
                                <a href="/termekek/{{ $sor->link }}" class="title">{{ $sor->name }}</a>
                                @if ($sor->db != 0)
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:{{ $sor->points }}%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> {{ $sor->db }}db
                                            értékelés</span>
                                    </div>
                                @else
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:0%" class="stars-active">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <span class="label-rating text-muted"> 0db értékelés</span>
                                    </div>
                                @endif
                                @if ($sor->actionprice != 0)
                                    <div class="price-old mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                    <div class="price mt-1 ">{{ $sor->actionprice }} ft</div> <!-- price-wrap.// -->
                                @else
                                    <div class="price mt-1 ">{{ $sor->price }} ft</div> <!-- price-wrap.// -->
                                @endif
                            </figcaption>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->
        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->

    </section>
    <!-- ========================= FOOTER ========================= -->
@endsection
