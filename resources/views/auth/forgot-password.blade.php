@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Új jelszó igénylése</h5>
                        <form action="{{ route('passworsend') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <x-input-label for="email" :value="__('Email cím')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <hr>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Email elküldése</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
