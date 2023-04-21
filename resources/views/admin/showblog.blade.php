@extends('admin.layout')
@section('admincontent')
    @foreach ($sql as $key => $sor)
        @if ($key % 5 === 0)
            <div class="card-group mx-2 my-6">
        @endif
        <div class="card " data-animation="true">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                    <img src="{{ $sor->file }}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </a>
                <div class="colored-shadow"
                    style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);">
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex mt-n6">
                    <div class="mx-auto ">
                        <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                            onclick="window.location.href='/admin/blog/modositas/{{ $sor->link }}'"
                            data-bs-placement="bottom" title="Módosítás">
                            <i class="material-icons text-lg">edit</i>
                        </button>
                        <button onclick="window.location.href='/blog/{{ $sor->link }}'"
                            class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Megtekintés">
                            <i class="material-icons text-lg">preview</i>
                        </button>
                    </div>
                </div>
                <h5 class="font-weight-normal mt-3 text-center">
                    <a href="/termekek/{{ $sor->link }}" target="_blank">{{ $sor->name }}</a>
                </h5>
                <p class="mb-0">{{ $sor->lastname }} {{ $sor->firstname }} </p>
                <p class="mb-0">{{ $sor->summary }}</p>
            </div>
        </div>
        @if (($key + 1) % 5 === 0)
            </div>
        @endif
    @endforeach

    @if (count($sql) % 5 !== 0)
        @for ($i = 0; $i < 5 - (count($sql) % 5); $i++)
            <div class="card" data-animation="true">
            </div>
        @endfor
        </div>
    @endif
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
