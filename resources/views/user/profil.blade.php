@extends('layouts.profil')
@section('profilcontent')
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body p-5">
                @if(Auth::user()->email_verified_at == "")
                <div class="row">
                    <div class="col-sm-9">
                        <h2 class="text-danger">Kérjük aktiválja fiókját!</h2>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary"
                            onclick="window.location.href='/profil/emailregisztacio'">Email újra küldése</button>
                    </div>
                </div>
                <hr>
                @endif
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Teljes név</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Felhasználó név</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->username }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Születési dátum</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->date_of_birth }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Hírlevélre feliratkozott?</p>
                    </div>
                    <div class="col-sm-9">
                        @if ($sql == 1)
                            <p class="text-muted mb-0">Igen</p>
                        @else
                            <p class="text-muted mb-0">Nem</p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Regisztált</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->created_at }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary w-25"
                            onclick="window.location.href='/profil/modositas'">Módosítás</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
