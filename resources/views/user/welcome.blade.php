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
                            <span class="text-primary"><i class="fa fa-2x fa-truck"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Gyors szállítás</h5>
                                <p>Ha 12:00-ig leadja a rendelését, akkor másnap megérkezik az othonához! as</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Creative Strategy</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">High secured </h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
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
                <a href="#" class="btn btn-outline-primary float-right">Összes termék</a>
                <h3 class="section-title">Pálinka különlegességek</h3>
                
            </header><!-- sect-heading -->
            <div class="row">
                @foreach ($negyrandom as $sor)
                    <div class="col-md-3">
                        <div href="/termek/{{ $sor->link }}" class="card card-product-grid">
                            <a href="/termek/{{ $sor->link }}" class="img-wrap"> <img src="{{ $sor->file }}"> </a>
                            <figcaption class="info-wrap">
                                <a href="/termek/{{ $sor->link }}" class="title">{{ $sor->name }}</a>

                                <div class="rating-wrap">
                                    <ul class="rating-stars">
                                        <li style="width:{{ $sor->point }}%" class="stars-active">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <span class="label-rating text-muted"> {{ $sor->db }}db értékelés</span>
                                </div>
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
