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
                <div href="#" class="card card-product-grid">
                    <a href="#" class="img-wrap"> <img src="{{$sor->file}}"> </a>
                    <figcaption class="info-wrap">
                        <a href="#" class="title">{{$sor->name}}</a>

                        <div class="rating-wrap">
                            <ul class="rating-stars">
                                <li style="width:80%" class="stars-active">
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
                            <span class="label-rating text-muted"> 34 reviws</span>
                        </div>
                        <div class="price-old mt-1 ">{{$sor->price}} ft</div> <!-- price-wrap.// -->
                        <div class="price mt-1 ">{{$sor->actionprice}} ft</div> <!-- price-wrap.// -->
                    </figcaption>
                </div>
            </div> <!-- col.// -->
            @endforeach

        </div> <!-- row.// -->
    </div> <!-- container .//  -->
</section>

@endsection
