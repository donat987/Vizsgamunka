@extends('admin.layout')
@section('admincontent')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Csoportos akció</h6>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('actionprices') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="exampleFormControlSelect1" class="ms-0">Termékek kiválasztása</label>
                                        <select size="20" multiple="" class="form-control pb-4" name="pro[]">
                                            @foreach ($pro as $sor)
                                                <option value="{{ $sor->id }}">{{ $sor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="exampleFormControlSelect1" class="ms-0">Márka kiválasztása</label>
                                        <select size="20" multiple="" class="form-control pb-4" name="bra[]">
                                            @foreach ($bra as $sor)
                                                <option value="{{ $sor->id }}">{{ $sor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kategória kiválasztása</label>
                                        <select size="20" multiple="" class="form-control pb-4" name="cat[]">
                                            @foreach ($cat as $sor)
                                                <option value="{{ $sor->id }}">
                                                    {{ $sor->subcategory }}-{{ $sor->subcategory1 }}-{{ $sor->subcategory2 }}-{{ $sor->subcategory3 }}-{{ $sor->subcategory4 }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Kedvezmény százalékosan</label>
                                        <input type="number" name="szaz" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal"> Mentés
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button type="button" onclick="window.location.href='/admin/akcio/osszestorlese'"
                                    class="btn btn-info btn-lg w-100" data-bs-toggle="modal"> Összes
                                    akció törlése
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
