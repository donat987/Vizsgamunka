@extends('layouts.user')
@section('content')
<section class="section-content">
    <div class="container mb-5 mt-5">
        <h2>{{$successful}}</h2>
    </div>
    <div class="container">
        <header class="section-heading">
            <a href="/termekek" class="btn btn-outline-primary float-right">Összes termék</a>
            <h3 class="section-title">Ajánló</h3>

        </header><!-- sect-heading -->
        <div class="row">
            @foreach ($negyrandom as $sor)
                <div class="col-md-3">
                    <div href="/termekek/{{ $sor->link }}" class="card card-product-grid">
                        <a href="/termekek/{{ $sor->link }}" class="img-wrap mt-3"> <img src="{{ $sor->file }}"> </a>
                        <figcaption class="info-wrap">
                            <a href="/termekek/{{ $sor->link }}" class="title">{{ $sor->name }}</a>

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
@endsection
