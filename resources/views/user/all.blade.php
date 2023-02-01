@extends('layouts.user')
@section('content')
    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title">Akciós termékeink</h3>
            </header><!-- sect-heading -->
            <div class="row">
                @foreach ($all as $sor)
                    <div class="col-md-3">
                        <div href="#" class="card card-product-grid">
                            <a href="#" class="img-wrap"> <img src="{{ $sor->file }}"> </a>
                            <figcaption class="info-wrap">
                                <a href="#" class="title">{{ $sor->name }}</a>

                                <div class="rating-wrap">
                                    <ul class="rating-stars">
                                        <li style="width:80%" class="stars-active">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <span class="label-rating text-muted"> 34 reviws</span>
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

            </div>
            <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                  <a class="page-link" href="{{ $all->previousPageUrl() }}">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="{{ $all->nextPageUrl() }}">Next</a>
                </li>
              </ul>
        </nav>
    </div>

    </section>

@endsection
