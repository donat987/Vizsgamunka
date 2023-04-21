@extends('admin.layout')
@section('admincontent')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Kupon hozzáadása</h6>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('cuponsave') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kupon fajta</label>
                                        <select class="form-control" name="cuponcat" id="cuponcat">
                                            <option>Válassz...</option>
                                            @foreach ($cup as $sor)
                                                <option value="{{ $sor->id }}">{{ $sor->species }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="form">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(e) {
                $("#cuponcat").change(function() {
                    if ($('#cuponcat').val() != "") {
                        var select1 = $('#cuponcat').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ route('cuponcat') }}",
                            type: "POST",
                            data: {
                                select1: select1,
                                _token: _token
                            },
                            success: function(result) {
                                $('#form').html(result);
                            }
                        })
                    }
                });
            });
        </script>
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Kuponok</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kupon neve
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kódja</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aktív</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kezdete</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Vége</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sql as $sor)
                                        <tr>
                                            <td>
                                                {{ $sor->species }}
                                            </td>
                                            <td>
                                                {{ $sor->couponcode }}
                                            </td>
                                            @if (strtotime($sor->end) > strtotime(date('Y-m-d H:i:s')) && $sor->active == 1)
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-success">Aktív</span>
                                                </td>
                                            @else
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-secondary">Inaktív</span>
                                                </td>
                                            @endif
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ date('Y/m/d', strtotime($sor->start)) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ date('Y/m/d', strtotime($sor->end)) }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="/admin/kupon/torles/{{ $sor->id }}"
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    Inaktiválás
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
