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
                    <script>
                        kosarbetolt();

                        function kosarbetolt() {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                                url: "{{ route('cartt') }}",
                                method: "get",
                                data: {_token: _token},
                                success: function(data) {
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
