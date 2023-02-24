@extends('layouts.user')
@section('content')
    <section class="section-content mt-5">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="d-flex flex-column align-items-center justify-content-center p-3">
                            <img src="https://via.placeholder.com/150" class="rounded-circle mb-2" alt="User Avatar">
                            <h5>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h5>
                            <p>{{Auth::user()->username}}</p>
                            <a href="">Eddigi rendelések</a>
                            <a href="">Szállítási címek</a>
                            <a href="">Jelszó módosítás</a>
                        </div>
                    </div>
                    <div class="col-sm-9" id="tartalom">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        sajatadat();
        function sajatadat() {
            $.ajax({
                url: "{{ route('profildata') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#tartalom').html(data);
                }
            });
        }
        function edit(){
            $.ajax({
                url: "{{ route('profilupdate') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#tartalom').html(data);
                }
            });
        }
    </script>
@endsection
