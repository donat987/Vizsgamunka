@extends('admin.layout')
@section('admincontent')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Vélemények</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Felhasználó</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Termék</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Komment</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Értékelés</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Dátum</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sql as $sor)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $sor->ufile }}"
                                                            class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $sor->lastname }} {{ $sor->firstname }}
                                                        </h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $sor->username }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $sor->pfile }}"
                                                            class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $sor->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $sor->comment }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span>
                                                    @for ($i = 0; $i < $sor->point; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><span class="text-secondary text-xs font-weight-bold">{{ date('Y/m/d', strtotime($sor->date)) }}</span></span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Törlés
                                                </a>
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
