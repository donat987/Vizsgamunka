@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Új jelszó</h5>
                        <form action="{{ route('newpassword') }}" method="POST">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-floating mb-3">
                                <x-input-label for="password" :value="__('Jelszó')" />
                                <x-text-input id="password" class="form-control" type="password" name="password"
                                    :value="old('password')" required autofocus placeholder="Jelszó" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="password_confirmation" :value="__('Jelszó újra')" />
                                <x-text-input id="password_confirmation" class="form-control" type="password"
                                    name="password_confirmation" :value="old('password_confirmation')" required autofocus
                                    placeholder="Jelszó" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <hr>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Mentés</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
