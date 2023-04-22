@extends('layouts.user')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Bejelentkezés</h5>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <x-input-label for="email" :value="__('Email cím')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="password" :value="__('Jelszó')" />
                                <x-text-input id="password" class="form-control"
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Bejelentkezve marad') }}</span>
                                </label>
                            </div>
                            <div class="form-floating mb-3">
                                <a href="/elfelejtettjelszo">Elfelejtette jelszavát?</a>
                            </div>
                            <hr>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Bejelentkezés</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
