@extends('admin.layout')
@section('admincontent')
    <div class="mb-2">
        <div class="card card-frame">
            <form action="">
                <div class="row mx-1">
                    <div class="col-md-10">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Azonosító vagy név keresése</label>
                            <input type="text" class="form-control" name="keres">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-outline mt-3">
                            <button type="submit" class="btn btn-info  w-100" data-bs-toggle="modal">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Teljesítve:</h6>
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
                                                        class="text-primary font-weight-bold">#{{ $sor->id }}</span>
                                                </h5>
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
                                            <td scope="col">
                                                @if ($sor->company_zipcode != '')
                                                    <p class="mb-0">Cím: <span>{{ $sor->company_zipcode }}
                                                            {{ $sor->company_city }}
                                                            {{ $sor->company_street }}
                                                            {{ $sor->company_house_number }}</span>
                                                    </p>
                                                @else
                                                    <p class="mb-0">Cím: <span>{{ $sor->zipcode }} {{ $sor->city }}
                                                            {{ $sor->street }} {{ $sor->house_number }}</span></p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <p class="mb-0">Egyéb: <span>{{ $sor->other }}</span></p>
                                            </th>
                                            <td>
                                                @if ($sor->tax_number != '')
                                                    <p class="mb-0">Adószám: <span>{{ $sor->tax_number }}</span></p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <p class="mb-0">Mobil: <span>{{ $sor->mobile_number }}</span></p>
                                            </th>
                                            <td></td>
                                        </tr>
                                    </table>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if ($sql->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center  mt-4">
                <li class="page-item">
                    <a class="page-link" href="{{ $sql->appends(Request::except('oldal'))->url(1) }}">
                        << </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $sql->appends(Request::except('oldal'))->previousPageUrl() }}">
                        < </a>
                </li>
                @php
                    $currentPage = $sql->currentPage();
                    $lastPage = $sql->lastPage();
                    $b = max($currentPage - 3, 1);
                    $c = min($currentPage + 3, $lastPage);
                    if ($currentPage <= 3 && $lastPage > 7) {
                        $c = 7;
                    } elseif ($currentPage >= $lastPage - 3 && $lastPage > 7) {
                        $b = $lastPage - 6;
                    }
                @endphp
                @for ($x = $b; $x <= $c; $x++)
                    <li class="page-item {{ $x == $sql->currentPage() ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $sql->appends(Request::except('oldal'))->url($x) }}">{{ $x }}
                            <span class="sr-only"></span></a>
                    </li>
                @endfor
                <li class="page-item">
                    <a class="page-link" href="{{ $sql->appends(Request::except('oldal'))->nextPageUrl() }}">></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $sql->appends(Request::except('oldal'))->url($sql->lastPage()) }}">>></a>
                </li>
            </ul>
        </nav>
    @endif
@endsection
