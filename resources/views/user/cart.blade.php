@extends('layouts.user')
@section('content')
    @if (null !== Cookie::get('cart'))
        @if (count(json_decode(Cookie::get('cart'))))
            <section class="section-content">
                <div class="container">
                    <header class="section-heading">
                        <h3 class="section-title">Kosár</h3>

                    </header><!-- sect-heading -->
                    <div class="row" id="kocsi">

                    </div> <!-- row.// -->
                </div> <!-- container .//  -->
            </section>
            <section class="section-content">
                <div class="container mb-5 mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-md btn-block"
                                        onclick="window.location.href = '\'">Vásárlás folytatása</button>
                                </div>
                            </div>
                            <form method="post" id="cupon" action="{{ route('cupon') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-black h4" for="coupon">Kupon</label>
                                        <p>Kérlek add meg a kuponkódot.</p>
                                    </div>
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <input type="text" class="form-control py-3" name="kupon" id="kupon"
                                            placeholder="Kupon">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-md px-4" type="submit" form="cupon"
                                            value="Submit">Bevitel</button>
                                    </div>
                                </form>
                                    <div id="kuponn" class="col-md-12 mt-2">
                                        
                                    </div>
                                </div>
                            
                        </div>
                        <div class="col-md-6 pl-5">
                            <section class="section-content">
                                <div class="row justify-content-end">
                                    <div class="col-md-7" id="cartall">

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <div class="row mb-5 justify-content-center">
                <div class="col-7 section-title text-center mb-5">
                    <h2 class="d-block">A kosár jelenleg üres.</h2>
                </div>
            </div>
        @endif
    @else
        <div class="row mb-5 justify-content-center">
            <div class="col-7 section-title text-center mb-5">
                <h2 class="d-block">A kosár jelenleg üres.</h2>
            </div>
        </div>
    @endif

    <script>
        kosarbetolt();
        vegso();
        $("#cupon").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('cupon') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cupontext": $('#kupon').val()
                },
                success: function(data) {
                    $('#kuponn').html(data);
                    kosarbetolt();
                    vegso();
                }
            });
            
        });

        function delet(clickid) {
            $.ajax({
                url: "{{ route('addtocart') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cart": "1",
                    "product_id": clickid,
                    "del": "1"
                },
                success: function(data) {
                    kosarbetolt();
                    vegso();
                }
            });
        }

        function minus(clickid) {
            $.ajax({
                url: "{{ route('addtocart') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cart": "1",
                    "product_id": clickid,
                    "quantity": "-1"
                },
                success: function(data) {
                    kosarbetolt();
                    vegso();
                }
            });
        }

        function plus(clickid) {
            $.ajax({
                url: "{{ route('addtocart') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cart": "1",
                    "product_id": clickid,
                    "quantity": "1"
                },
                success: function(data) {
                    kosarbetolt();
                    vegso();
                }
            });
        }

        function kosarbetolt() {
            $.ajax({
                url: "{{ route('cartt') }}",
                method: "get",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#kocsi').html(data);
                }
            });
        }

        function vegso() {
            $.ajax({
                url: "{{ route('teljes') }}",
                method: "get",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#cartall').html(data);
                }
            });
        }
    </script>
@endsection
