@extends('layouts.user')
@section('content')
<section class="section-content mt-5 mb-5">
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="d-flex flex-column align-items-center justify-content-center p-3">
                        @if(Auth::user()->file != null)
                        <img src="{{ Auth::user()->file }}" class="rounded-circle mb-2" alt="User Avatar" width="150px">
                        @else
                        <img src="/storage/users/profile.jpg" class="rounded-circle mb-2" alt="User Avatar" width="150px">
                        @endif
                        <h5>{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</h5>
                        <p>{{ Auth::user()->username }}</p>
                        <button type="button" onclick="window.location.href='/profil'" class="btn btn-outline-secondary btn-block  mt-1 mb-1">Profil</button>
                        <button type="button" onclick="window.location.href='/profil/cimek'" class="btn btn-outline-secondary btn-block  mt-1 mb-1">Címek</button>
                        <button type="button" onclick="window.location.href='/profil/rendelesek'" class="btn btn-outline-secondary btn-block  mt-1 mb-1">Aktív rendelések</button>
                        <button type="button" onclick="window.location.href='/profil/teljesitettrendelesek'" class="btn btn-outline-secondary btn-block  mt-1 mb-1">Teljesített rendelések</button>
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
