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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Termék neve</th>
                                    <th>Darabár ár</th>
                                    <th>Darabszám</th>
                                    <th>Teljes összeg</th>
                                    <th>Törlés</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode(Cookie::get('cart')) as $sor)
                                    <tr>
                                        <td><img width="100px" src="{{ $sor->file }}"</td>
                                        <td class="align-middle">{{ $sor->product_name }}</td>
                                        <td class="align-middle">{{ $sor->oneprice }} Ft</td>
                                        <td class="align-middle">
                                            <div class="input-group mb-3" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus"
                                                        id="{{ $sor->link }}" onclick="kivon(this.id)" name="minus"
                                                        type="button">−</button>
                                                </div>
                                                <input type="text" id="" style="padding: 6px"
                                                    class="form-control text-center border mr-0"
                                                    value="{{ $sor->quantity }}" readonly="e{{ $sor->link }}"
                                                    id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                        id="{{ $sor->link }}" onclick="hozzaad(this.id)" name="plus"
                                                        type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $sor->price }} Ft</td>
                                        <td class="align-middle"><a><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- row.// -->
                    <script>
                        kosarbetolt();

                        function kosarbetolt() {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                                url: "{{ route('cartt') }}",
                                method: "get",
                                data: {_token: _token},
                                succes: function(data) {
                                    $('#kocsi').html(data);
                                }
                            });
                        }

                    </script>
                </div> <!-- container .//  -->
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
@endsection
