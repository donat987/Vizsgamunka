@extends('layouts.user')
@section('content')
<section class="section-content">
    <div class="container">
        <header class="section-heading">
            <h3 class="section-title">Akciós termékeink</h3>
        </header><!-- sect-heading -->
        <div class="row">
            @foreach ($ac as $sor)
            <div class="col-md-3">
                <div href="/termek/{{ $sor->link }}" class="card card-product-grid">
                    <a href="/termek/{{ $sor->link }}" class="img-wrap"> <img src="{{$sor->file}}"> </a>
                    <figcaption class="info-wrap">
                        <a href="/termek/{{ $sor->link }}" class="title">{{$sor->name}}</a>

                        <div class="rating-wrap">
                            <ul class="rating-stars">
                                <li style="width:{{$sor->point}}%" class="stars-active">
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
                            <span class="label-rating text-muted"> {{$sor->db}}db értékelés</span>
                        </div>
                        <div class="price-old mt-1 ">{{$sor->price}} ft</div> <!-- price-wrap.// -->
                        <div class="price mt-1 ">{{$sor->actionprice}} ft</div> <!-- price-wrap.// -->
                    </figcaption>
                </div>
            </div> <!-- col.// -->
            @endforeach

        </div> <!-- row.// -->
        @if ($ac->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="{{ $ac->url(1) }}">
                            <<</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $ac->previousPageUrl() }}">
                            <
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link" href="#">{{ $ac->currentPage() }} <span class="sr-only"></span></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $ac->nextPageUrl() }}">></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $ac->url($ac->lastPage()) }}">>></a>
                    </li>
                </ul>
            </nav>
            @endif
    </div> <!-- container .//  -->
</section>

@endsection
