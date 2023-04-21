@extends('admin.layout')
@section('admincontent')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Rendelési információk</h6>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @foreach ($sql as $sor)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <table style="width: 100%">
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <h5 class="mb-0 ">Rendelési azonosító:<span
                                                                    class="text-primary font-weight-bold">#{{ $sor->id }}</span>
                                                            </h5>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <p class="mb-0">Állapot:<span>{{ $sor->status }}</span> </p>
                                                        </th>
                                                        <th>
                                                            <p class="mb-0">Rendelési dátum:
                                                                <span>{{ $sor->date }}</span>
                                                            </p>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <h5 class="mb-0">Szállítási cím:</h5>
                                                        </th>
                                                        <th>
                                                            <h5 class="mb-0">Számlázási cím:</h5>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <p class="mb-0">Név: <span>{{ $sor->name }}</span></p>
                                                        </th>
                                                        <th>
                                                            @if ($sor->company_name != '')
                                                                <p class="mb-0">Név: <span>{{ $sor->company_name }}</span>
                                                                </p>
                                                            @else
                                                                <p class="mb-0">Név: <span>{{ $sor->name }}</span></p>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">
                                                            <p class="mb-0">Cím: <span>{{ $sor->zipcode }}
                                                                    {{ $sor->city }}
                                                                    {{ $sor->street }} {{ $sor->house_number }}</span></p>
                                                        </th>
                                                        <th>
                                                            @if ($sor->company_zipcode != '')
                                                                <p class="mb-0">Cím: <span>{{ $sor->company_zipcode }}
                                                                        {{ $sor->company_city }}
                                                                        {{ $sor->company_street }}
                                                                        {{ $sor->company_house_number }}</span>
                                                                </p>
                                                            @else
                                                                <p class="mb-0">Cím: <span>{{ $sor->zipcode }}
                                                                        {{ $sor->city }}
                                                                        {{ $sor->street }}
                                                                        {{ $sor->house_number }}</span></p>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <p class="mb-0">Egyéb: <span>{{ $sor->other }}</span></p>
                                                        </th>
                                                        <th>
                                                            @if ($sor->tax_number != '')
                                                                <p class="mb-0">Adószám:
                                                                    <span>{{ $sor->tax_number }}</span>
                                                                </p>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <p class="mb-0">Mobil: <span>{{ $sor->mobile_number }}</span>
                                                            </p>
                                                        </th>
                                                        <th>

                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <form action="{{ route('shippingcode') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$sor->id}}">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Csomagszám</label>
                                        <input type="text" name="code" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                                        Mentés
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Termék</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Bárkód
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Darabszám</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Csomagolva</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product as $sor)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ $sor->file }}"
                                                                class="avatar avatar-xxl me-2 border-radius-lg"
                                                                alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h5 class="mb-0 text-sm">{{ $sor->name }}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h5 class="mb-0 text-sm">{{ $sor->barcode }}</h5>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h5 class="mb-0 text-sm">{{ $sor->piece }} db</h5>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <input type="checkbox" onclick="return false;" name="csomagolva[]"
                                                        value="{{ $sor->id }}" checked>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
