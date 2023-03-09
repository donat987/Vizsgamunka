@extends('layouts.profil')
@section('profilcontent')
<form action="/profil/cimek/hozzaad/mentes" method="POST" enctype="multipart/form-data">
    @csrf
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
                <label for="teljes_név">Teljes név:</label>
                <input type="text" class="form-control" id="teljes_név" name="teljes_név">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="irányítószám">Irányítószám:</label>
                <input type="text" class="form-control" id="irányítószám" name="irányítószám">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="település">Település:</label>
                <input type="text" class="form-control" id="település" name="település">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="utca">Utca:</label>
                <input type="text" class="form-control" id="utca" name="utca">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="házszám">Házszám:</label>
                <input type="text" class="form-control" id="házszám" name="házszám">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="egyéb">Egyéb:</label>
                <input type="text" class="form-control" id="egyéb" name="egyéb">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="telefonszám">Telefonszám:</label>
                <input type="text" class="form-control" id="telefonszám" name="telefonszám" value="06">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="adószám">Adászám:</label>
                <input type="text" class="form-control" id="adószám" name="adószám">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_név">Cégnév:</label>
                <input type="text" class="form-control" id="cégnév" name="cégnév">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_irányítószám">Cég irányítószám:</label>
                <input type="text" class="form-control" id="cég_irányítószám" name="cég_irányítószám">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_település">Cég település:</label>
                <input type="text" class="form-control" id="cég_település" name="cég_település">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_utca">Cég utca:</label>
                <input type="text" class="form-control" id="cég_utca" name="cég_utca">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_házszám">Cég házszám:</label>
                <input type="text" class="form-control" id="cég_házszám" name="cég_házszám">
            </div>
        </li>
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" onclick="window.location.href='/profil/cimek'" class="btn btn-secondary w-25">Vissza</button>
                <button type="submit" value="Submit" class="btn btn-primary w-25">Mentés</button>
            </div>
        </li>
    </ul>
</form>
@endsection
