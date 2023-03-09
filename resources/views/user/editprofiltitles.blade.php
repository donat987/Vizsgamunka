@extends('layouts.profil')
@section('profilcontent')
<form action="/profil/cimek/modositas/mentes" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control" id="id" name="id" value="{{$sql[0]->id}}">
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
                <input type="text" class="form-control" id="teljes_név" name="teljes_név" value="{{$sql[0]->name}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="irányítószám">Irányítószám:</label>
                <input type="text" class="form-control" id="irányítószám" name="irányítószám" value="{{$sql[0]->zipcode}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="település">Település:</label>
                <input type="text" class="form-control" id="település" name="település" value="{{$sql[0]->city}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="utca">Utca:</label>
                <input type="text" class="form-control" id="utca" name="utca" value="{{$sql[0]->street}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="házszám">Házszám:</label>
                <input type="text" class="form-control" id="házszám" name="házszám" value="{{$sql[0]->house_number}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="egyéb">Egyéb:</label>
                <input type="text" class="form-control" id="egyéb" name="egyéb" value="{{$sql[0]->other}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="telefonszám">Telefonszám:</label>
                <input type="text" class="form-control" id="telefonszám" name="telefonszám" value="{{$sql[0]->mobile_number}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="adószám">Adászám:</label>
                <input type="text" class="form-control" id="adószám" name="adószám" value="{{$sql[0]->tax_number}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cégnév">Cégnév:</label>
                <input type="text" class="form-control" id="cégnév" name="cégnév" value="{{$sql[0]->company_name}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_irányítószám">Cég irányítószám:</label>
                <input type="text" class="form-control" id="cég_irányítószám" name="cég_irányítószám" value="{{$sql[0]->company_zipcode}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_település">Cég település:</label>
                <input type="text" class="form-control" id="cég_település" name="cég_település" value="{{$sql[0]->company_city}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_utca">Cég utca:</label>
                <input type="text" class="form-control" id="cég_utca" name="cég_utca" value="{{$sql[0]->company_street}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group">
                <label for="cég_házszám">Cég házszám:</label>
                <input type="text" class="form-control" id="cég_házszám" name="cég_házszám" value="{{$sql[0]->company_house_number}}">
            </div>
        </li>
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" onclick="window.location.href='/profil/cimek'" class="btn btn-secondary w-25">Vissza</button>
                <button type="button" onclick="window.location.href='/profil/cimek/torles/{{$sql[0]->id}}'" class="btn btn-danger w-25">Törlés</button>
                <button type="submit" value="Submit" class="btn btn-primary w-25">Mentés</button>
            </div>
        </li>
    </ul>
</form>
@endsection