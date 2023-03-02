@extends('layouts.user')
@section('content')
<section class="section-content mt-5">
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="d-flex flex-column align-items-center justify-content-center p-3">
                        <img src="{{ Auth::user()->file }}" class="rounded-circle mb-2" alt="User Avatar" width="150px">
                        <h5>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h5>
                        <p>{{ Auth::user()->username }}</p>
                        <button onclick="sajatadat()">Profil</button>
                        <button onclick="titles()">Szállítási címek</button>
                        <a href="">Eddigi rendelések</a>
                        <a href="">Jelszó módosítás</a>
                    </div>
                </div>
                <div class="col-sm-9" id="tartalom">
                    @yield('profilcontent')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection