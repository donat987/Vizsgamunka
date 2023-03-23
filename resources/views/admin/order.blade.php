@extends('admin.layout')
@section('admincontent')
    <div class="card">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Feldolgozásra váró:</h6>
            </div>
        </div>
        <div class="card-body pt-4 p-3">
            <ul class="list-group">
                @foreach ($sql as $sor)
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex justify-content-between align-items-center">
                            <table>
                                <tr>
                                    <th colspan="2">
                                        <h5 class="mb-0 ">Rendelési azonosító:<span
                                                class="text-primary font-weight-bold">#{{ $sor->id }}</span></h5>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <p class="mb-0">Állapot:<span>{{ $sor->status }}</span> </p>
                                    <td>
                                        <p class="mb-0">Rendelési dátum: <span>{{ $sor->date }}</span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h5 class="mb-0">Szállítási cím:</h5>
                                    </th>
                                    <td>
                                        <h5 class="mb-0">Számlázási cím:</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p class="mb-0">Név: <span>{{ $sor->name }}</span></p>
                                    </th>
                                    <td>
                                        @if ($sor->company_name != '')
                                            <p class="mb-0">Név: <span>{{ $sor->company_name }}</span></p>
                                        @else
                                            <p class="mb-0">Név: <span>{{ $sor->name }}</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">
                                        <p class="mb-0">Cím: <span>{{ $sor->zipcode }} {{ $sor->city }}
                                                {{ $sor->street }} {{ $sor->house_number }}</span></p>
                                    </th>
                                    <td scope="col" >
                                        @if ($sor->company_zipcode != '')
                                            <p class="mb-0">Cím: <span>{{ $sor->company_zipcode }}
                                                    {{ $sor->company_city }}
                                                    {{ $sor->company_street }} {{ $sor->company_house_number }}</span>
                                            </p>
                                        @else
                                            <p  class="mb-0">Cím: <span>{{ $sor->zipcode }} {{ $sor->city }}
                                                    {{ $sor->street }} {{ $sor->house_number }}</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p class="mb-0">Egyéb: <span>{{ $sor->other }}</span></p>
                                    </th>
                                    <td>@if ($sor->tax_number != '')
                                        <p class="mb-0">Adószám: <span>{{ $sor->tax_number }}</span></p>
                                    @endif</td>
                                </tr>
                                <tr>
                                    <th>
                                        <p class="mb-0">Mobil: <span>{{ $sor->mobile_number }}</span></p>
                                    </th>
                                    <td></td>
                                </tr>
                            </table>

                        </div>
                        <div class="ms-auto text-end">
                            <button type="button" onclick="window.location.href='/admin/rendelesek/{{$sor->id}}'"  class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                                Megrendelés csomagolása
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
