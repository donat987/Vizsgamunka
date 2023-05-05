@extends('layouts.user')
@section('content')
    <form action="/kosarhozadas" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product[0]->id }}">
        <input type="hidden" name="product_name" value="{{ $product[0]->name }}">
        <input type="hidden" name="product_price" value="{{ $product[0]->price }}">
        <input type="hidden" name="product_actionprice" value="{{ $product[0]->actionprice }}">
        <input type="hidden" name="product_file" value="{{ $product[0]->file }}">
        <input type="hidden" name="product_tax" value="{{ $product[0]->taxprice }}">
        <input type="hidden" name="product_actiontax" value="{{ $product[0]->actiontaxprice }}">
        <input type="hidden" name="product_link" value="{{ $product[0]->link }}">
        <input type="hidden" name="product_vat" value="{{ $product[0]->vat }}">
        <input type="hidden" name="product_categid" value="{{ $product[0]->categoryid }}">
        <input type="hidden" name="product_brandid" value="{{ $product[0]->brandid }}">
        <div class='site-section mt-5'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-6'> <img src='{{ $product[0]->file }}' alt='Image' class='img-fluid'>
                    </div>
                    <div class="col-lg-5 ml-auto d-flex flex-column">
                        <h2 class="text">{{ $product[0]->name }}</h2>
                        @if ($product[0]->actionprice != 0)
                            <h3 class="price-old text">{{ $product[0]->price }} ft</h3>
                            <h2 class="text-danger">{{ $product[0]->actionprice }} ft</h2>
                        @else
                            <h2 class="text">{{ $product[0]->price }} Ft</h2>
                        @endif
                        <p>Márka: <a class="text-body"
                                href="/termekek?marka%5B%5D={{ $product[0]->brandname }}">{{ $product[0]->brandname }}</a>
                        </p>
                        <p>Űrtartalom: {{ $product[0]->capacity }} l.</p>
                        <p>Alkoholfok: {{ $product[0]->alcohol }}°</p>
                        <p>Származási ország: <a class="text-body"
                                href="/termekek?orszag%5B%5D={{ $product[0]->subcategory1 }}">{{ $product[0]->subcategory1 }}</a>
                        </p>
                        <p>Italfajta: <a class="text-body"
                                href="/termekek?fajta%5B%5D={{ $product[0]->subcategory2 }}">{{ $product[0]->subcategory2 }}</a>
                        </p>
                        <p>Megjelenés: {{ $product[0]->subcategory3 }} {{ $product[0]->subcategory4 }}</p>
                        @if ($product[0]->other != '')
                            <p>Egyéb: {{ $product[0]->other }}</p>
                        @endif
                        <p>Raktáron: {{ $product[0]->quantity }} db</p>
                        <div class="input-group mb-3 mt-auto">
                            <input type="number" value="1" min="1" max="{{ $product[0]->quantity }}"
                                name="quantity" class="form-control" placeholder="Darabszám" aria-label="Darabszám"
                                aria-describedby="button-addon2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">db</span>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Kosárba</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if ($product[0]->description != '')
        <div class="container my-5">
            <h2 class="text-center">Leírás:</h2>
            <p>{{ $product[0]->description }}</p>
        </div>
    @endif
    @if (count($comment))
        <div class="container  my-5">

            <h2 class="text-center ">Eddigi értékelések:</h2>
            @foreach ($comment as $s)
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img width="50px" src="{{ $s->file }}" class="rounded-circle mr-3">
                            <div>
                                <h5 class="mb-0">{{ $s->username }}</h5>
                                <small class="text-muted">Dátum: {{ $s->date }}.</small>
                            </div>
                            <div class="ml-auto">
                                <span>
                                    @for ($i = 0; $i < $s->point; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $s->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="container my-5">
        <h2 class="text-center">Értékeld a terméket!</h2>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('starsave') }}" id="starform" method="POST">
            @csrf
            <input type="hidden" id="productid" name="productid" value="{{ $product[0]->id }}">
            <label>Pontozás 1-től 5-ig</label>
            <div class="rating" style="white-space: nowrap;">
                <input type="radio" id="star1" name="point" value="5" />
                <label for="star1"></label>
                <input type="radio" id="star2" name="point" value="4" />
                <label for="star2"></label>
                <input type="radio" id="star3" name="point" value="3" />
                <label for="star3"></label>
                <input type="radio" id="star4" name="point" value="2" />
                <label for="star4"></label>
                <input type="radio" id="star5" name="point" value="1" />
                <label for="star5"></label>
            </div>
            <div class="form-group">
                <label for="comment">Vélemény:</label>
                <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Beküldés</button>
        </form>
    </div>
@endsection
