@extends('layouts.user')
@section('content')
    <form action="/kosarhozadas" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product[0]->id }}">
        <input type="hidden" name="product_name" value="{{ $product[0]->name }}">
        <div class='site-section mt-5'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-6'> <img src='{{ $product[0]->file }}' alt='Image' class='img-fluid'>
                    </div>
                    <div class='col-lg-5 ml-auto'>
                        <h2 class='text-primary'>{{ $product[0]->name }}</h2>
                        <h2 class='text-primary'>{{ $product[0]->price }} ft</h2>
                        <p>Márka: Agárdi Pálinka</p>
                        <p>Gyümölcs: Birs</p>
                        <p>Mennyiség: 0.5 l.</p>
                        <p>{{ $product[0]->description }}</p>
                        <input type="number" name="quantity" value="1">
                        <p><input type='submit' value='Kosárba'
                                class='btn btn-outline-dark  btn-lg btn-block' /></p>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="container my-5">
        <h1 class="text-center">Eddigi értékelések:</h1>
        @foreach ($comment as $s)
            <div class="card">
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

    <div class="container my-5">
        <h1 class="text-center">Értékeld a terméket!</h1>
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
