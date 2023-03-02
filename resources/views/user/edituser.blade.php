@extends('layouts.profil')
@section('profilcontent')
    <form action="/profil/modositas/mentes" id="update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="csrf-token" value="<?php echo csrf_token(); ?>" />
        <ul class="list-group">
            <li class="list-group-item">
                <div class="form-group">
                    <label for="lastname">Vezetéknék:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo Auth::user()->lastname; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="firstname">Vezetéknék:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo Auth::user()->firstname; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="date_of_birth">Születési dátum:</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                        value="<?php echo Auth::user()->date_of_birth; ?>">
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="username">Felhasználó név:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo Auth::user()->username; ?>">
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
                        <option value="1">igen</option>
                        <option value="0">nem</option>
                    </select>
                </div>
            </li>
            <li class="list-group-item">
                <div class="custom-file" lang="hu">
                    <input type="file" class="custom-file-input" name="file" id="file">
                    <label class="custom-file-label" for="customFile">Profilkép</label>
                </div>
            </li>
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div></div>
                    <button type="submit" value="Submit" class="btn btn-primary">Mentés</button>
                </div>
            </li>
        </ul>
    </form>
@endsection
