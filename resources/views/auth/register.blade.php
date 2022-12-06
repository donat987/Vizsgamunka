@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Regisztráció</h5>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <x-input-label for="username" :value="__('Felhasználó név')" />
                                <x-text-input id="username" class="form-control" type="text" name="username"
                                    :value="old('username')" required autofocus placeholder="user987" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="lastname" :value="__('Vezetéknév')" />
                                <x-text-input id="lastname" class="form-control" type="text" name="lastname"
                                    :value="old('lastname')" required autofocus placeholder="Kiss" />
                                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="firstname" :value="__('Keresztnév')" />
                                <x-text-input id="firstname" class="form-control" type="text" name="firstname"
                                    :value="old('firstname')" required autofocus placeholder="Lajos" />
                                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email"
                                    :value="old('email')" required autofocus placeholder="user@webcim.hu" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="password" :value="__('Jelszó')" />
                                <x-text-input id="password" class="form-control" type="password" name="password"
                                    :value="old('password')" required autofocus placeholder="Jelszó" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="form-floating mb-3">
                                <x-input-label for="password_confirmation" :value="__('Jelszó újra')" />
                                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                                    :value="old('password_confirmation')" required autofocus placeholder="Jelszó" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <hr>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Regisztáció</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
