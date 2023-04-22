@extends('layouts.profil')
@section('profilcontent')
    <form action="/profil/modositas/mentes" id="update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="csrf-token" value="<?php echo csrf_token(); ?>" />
        <ul class="list-group">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <li class="list-group-item">
                <div class="form-group">
                    <label for="vezetéknév">Vezetéknév:</label>
                    <input type="text" class="form-control" id="vezetéknév" name="vezetéknév"
                        value="<?php echo Auth::user()->lastname; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="keresztnév">Keresztnév:</label>
                    <input type="text" class="form-control" id="keresztnév" name="keresztnév"
                        value="<?php echo Auth::user()->firstname; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="születési_dátum">Születési dátum:</label>
                    <input type="date" class="form-control" id="születési_dátum" name="születési_dátum"
                        value="<?php echo Auth::user()->date_of_birth; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="felhasználónév">Felhasználó név:</label>
                    <input type="text" class="form-control" id="felhasználónév" name="felhasználónév"
                        value="<?php echo Auth::user()->username; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo Auth::user()->email; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="advertising">Hírdetésre feliratkozott?</label>
                    <select class="form-control" id="advertising" name="advertising">
                        @if($sql == 1)
                        <option value="1" selected>igen</option>
                        <option value="0">nem</option>
                        @else
                        <option value="1" >igen</option>
                        <option value="0" selected>nem</option>
                        @endif
                    </select>
                </div>
            </li>
            <li class="list-group-item">
                <div class="custom-file" lang="hu">
                    <input type="file" class="custom-file-input" name="file" id="file" onchange="document.getElementById('customFile').innerHTML = this.value.split('\\').pop()">
                    <label class="custom-file-label" for="file" id="customFile">Profilkép</label>
                 </div>
            </li>
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" onclick="window.location.href='/profil'" class="btn btn-secondary w-25">Vissza</button>
                    <button type="submit" value="Submit" class="btn btn-primary w-25">Mentés</button>
                </div>
            </li>
        </ul>
    </form>
@endsection
