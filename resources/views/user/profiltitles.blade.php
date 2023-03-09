@extends('layouts.profil')
@section('profilcontent')
    @if (isset($sql[0]))
        <h2>Felvett címek</h2>
        @foreach ($sql as $i)
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Teljes név</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $i->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Cím</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $i->zipcode }} {{ $i->city }} {{ $i->street }}
                                    {{ $i->house_number }}</p>
                            </div>
                        </div>
                        <hr>
                        @if ($i->other != '')
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Egyéb</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> {{ $i->other }}</p>
                            </div>
                        </div>
                        <hr>
                        @endif
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mobil</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $i->mobile_number }}</p>
                            </div>
                        </div>
                        <hr>
                        @if ($i->tax_number != '')
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Adószám</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $i->tax_number }}</p>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary w-25"
                                    onclick="window.location.href='/profil/cimek/modositas/{{ $i->id }}'">Módosítás</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary w-25"
                                onclick="window.location.href='/profil/cimek/hozzaad'">Hozzáadás</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h2>Önnek még nincsen felvett címe</h2>
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary w-25"
                                onclick="window.location.href='/profil/modositas'">Hozzáadás</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
