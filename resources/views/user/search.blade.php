@extends('layouts.user')
@section('content')
    <section class="section-content">
        <div class="container">
            <div class="container-fluid  mb-3 mt-3">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <form action="/termekek" method="GET">
                                <label for="customRange2" class="form-label">Ár szerinti rendezés :</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select" name="rendezesar" id="rendezesar" style="width: 100%;">
                                        <option value="0">Semmi</option>
                                        <option value="1">Növekvő</option>
                                        <option value="2">Csökkenő</option>
                                    </select>
                                </div>
                                <label for="customRange2" class="form-label">Értékelés szerinti rendezés:</label>
                                <div class="d-flex align-items-center">
                                    <select class="selectpicker" name="rendezesert" style="width: 100%;">
                                        <option value="0">Semmi</option>
                                        <option value="1">Növekvő</option>
                                        <option value="2">Csökkenő</option>
                                        
                                    </select>
                                </div>
                                <label for="customRange2" class="form-label">Minimum ár:</label>
                                <p class="center" id="mintext">{{ $minprice }} Ft</p>
                                <input type="range" class="form-range" style="width: 100%;" min="{{ $minprice }}"
                                    max="{{ $maxprice }}" id="minimum" name="min" value="{{ $minprice }}">
                                <label for="customRange2" class="form-label">Maximum ár:</label>
                                <p class="center" id="maxtext">{{ $maxprice }} Ft</p>
                                <input type="range" style="width: 100%;" class="form-range" min="{{ $minprice }}"
                                    max="{{ $maxprice }}" id="maximum" name="max" value="{{ $maxprice }}">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="akcio"
                                        for="akcio" id="akcio">
                                    <label class="form-check-label" for="akcio">
                                        Csak az akciós
                                    </label>
                                </div>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Kategória:
                                </label>
                                <select multiple class="form-control" name="fajta[]">
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->category }}">{{ $cat->category }}</option>
                                    @endforeach
                                </select>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Származási helye:
                                </label>
                                <select multiple class="form-control" name="orszag[]">
                                    @foreach ($country as $cat)
                                        <option value="{{ $cat->country }}">{{ $cat->country }}</option>
                                    @endforeach
                                </select>

                                <label for="customRange2" class="form-label">Minimum kapacitás:</label>
                                <p class="center" id="mincapacity">{{ $mincapacity }} Liter</p>
                                <input type="range" class="form-range" style="width: 100%;" min="{{ $mincapacity }}"
                                    max="{{ $maxcapacity }}" step="0.01" id="minimumcapacity" name="minimumurtartalom"
                                    value="{{ $mincapacity }}">

                                <label for="customRange2" class="form-label">Maximum kapacitás:</label>
                                <p class="center" id="maxcapacity">{{ $maxcapacity }} Liter</p>
                                <input type="range" step="0.01" style="width: 100%;" class="form-range"
                                    min="{{ $mincapacity }}" max="{{ $maxcapacity }}" id="maximumcapacity"
                                    name="maximumurtartalom" value="{{ $maxcapacity }}">


                                <button type="submit"
                                    class="btn btn-outline-secondary btn-block  mt-1 mb-1">Szűrés</button>
                            </form>
                            <script>
                                const minimumInput = document.getElementById("minimum");
                                const maximumInput = document.getElementById("maximum");
                                const minimumcapacityInput = document.getElementById("minimumcapacity");
                                const maximumcapacityInput = document.getElementById("maximumcapacity");
                                const minText = document.getElementById("mintext");
                                const maxText = document.getElementById("maxtext");
                                const mincapacity = document.getElementById("mincapacity");
                                const maxcapacity = document.getElementById("maxcapacity");
                                const paragraphs = document.getElementsByTagName("p");
                                const searchParams = new URLSearchParams(window.location.search);


                                if (searchParams.has('maximumurtartalom')) {
                                    maximumcapacityInput.value = searchParams.get('maximumurtartalom');
                                    maxcapacity.innerHTML = maximumcapacityInput.value + " Liter";
                                }

                                if (searchParams.has('minimumurtartalom')) {
                                    minimumcapacityInput.value = searchParams.get('minimumurtartalom');
                                    mincapacity.innerHTML = minimumcapacityInput.value + " Liter";
                                }

                                if (searchParams.has('fajta[]')) {
                                    var selectedCategories = searchParams.getAll('fajta[]');
                                    $('select[name="fajta[]"]').val(selectedCategories);
                                }

                                if (searchParams.has('orszag[]')) {
                                    var selectedCategories = searchParams.getAll('orszag[]');
                                    $('select[name="orszag[]"]').val(selectedCategories);
                                }

                                if (searchParams.has('max')) {
                                    maximumInput.value = searchParams.get('max');
                                    maxText.innerHTML = maximumInput.value + " Ft";
                                }

                                if (searchParams.has('min')) {
                                    minimumInput.value = searchParams.get('min');
                                    minText.innerHTML = minimumInput.value + " Ft";
                                }
                                if (searchParams.has('akcio')) {
                                    var x = document.getElementById("akcio");
                                    if (searchParams.get('akcio') == 1) {
                                        x.checked = true;
                                    } else {
                                        x.checked = false;
                                    }
                                }

                                maximumcapacityInput.addEventListener("input", function() {
                                    maxcapacity.innerHTML = maximumcapacityInput.value + " Liter";
                                    for (let i = 0; i < paragraphs.length; i++) {
                                        if (paragraphs[i].id === "maxcapacity") {
                                            paragraphs[i].innerHTML = maximumcapacityInput.value + " Liter";
                                        }
                                    }
                                    if (maximumcapacityInput.value < minimumcapacityInput.value) {
                                        minimumcapacityInput.value = maximumcapacityInput.value;
                                        mincapacity.innerHTML = maximumcapacityInput.value + " Liter";
                                    }
                                });

                                minimumcapacityInput.addEventListener("input", function() {
                                    mincapacity.innerHTML = minimumcapacityInput.value + " Liter";
                                    for (let i = 0; i < paragraphs.length; i++) {
                                        if (paragraphs[i].id === "mincapacity") {
                                            paragraphs[i].innerHTML = minimumcapacityInput.value + " Liter";
                                        }
                                    }
                                    if (minimumcapacityInput.value > maximumcapacityInput.value) {
                                        maximumcapacityInput.value = minimumcapacityInput.value;
                                        maxcapacity.innerHTML = minimumcapacityInput.value + " Liter";
                                    }
                                });

                                minimumInput.addEventListener("input", function() {
                                    minText.innerHTML = minimumInput.value + " Ft";
                                    for (let i = 0; i < paragraphs.length; i++) {
                                        if (paragraphs[i].id === "mintext") {
                                            paragraphs[i].innerHTML = minimumInput.value + " Ft";
                                        }
                                    }
                                    if (parseInt(minimumInput.value) > parseInt(maximumInput.value)) {
                                        maximumInput.value = minimumInput.value;
                                        maxText.innerHTML = minimumInput.value + " Ft";
                                    }
                                });

                                maximumInput.addEventListener("input", function() {
                                    maxText.innerHTML = maximumInput.value + " Ft";
                                    for (let i = 0; i < paragraphs.length; i++) {
                                        if (paragraphs[i].id === "maxtext") {
                                            paragraphs[i].innerHTML = maximumInput.value + " Ft";
                                        }
                                    }
                                    if (parseInt(maximumInput.value) < parseInt(minimumInput.value)) {
                                        minimumInput.value = maximumInput.value;
                                        minText.innerHTML = maximumInput.value + " Ft";
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            @foreach ($se as $sor)
                                <div class="col-md-4">
                                    <div href="/termekek/{{ $sor->link }}" class="card card-product-grid">
                                        <a href="/termekek/{{ $sor->link }}" class="img-wrap"> <img
                                                src="{{ $sor->file }}"> </a>
                                        <figcaption class="info-wrap">
                                            <a href="/termekek/{{ $sor->link }}"
                                                class="title">{{ $sor->name }}</a>
                                            @if ($sor->db != 0)
                                                <div class="rating-wrap">
                                                    <ul class="rating-stars">
                                                        <li style="width:{{ $sor->points }}%" class="stars-active">
                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i>
                                                        </li>
                                                    </ul>
                                                    <span class="label-rating text-muted"> {{ $sor->db }}db
                                                        értékelés</span>
                                                </div>
                                            @else
                                                <div class="rating-wrap">
                                                    <ul class="rating-stars">
                                                        <li style="width:0%" class="stars-active">
                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                class="fa fa-star"></i>
                                                        </li>
                                                    </ul>
                                                    <span class="label-rating text-muted"> 0db értékelés</span>
                                                </div>
                                            @endif


                                            @if ($sor->actionprice != 0)
                                                <div class="price-old mt-1 ">{{ $sor->price }} ft</div>
                                                <!-- price-wrap.// -->
                                                <div class="price mt-1 ">{{ $sor->actionprice }} ft</div>
                                                <!-- price-wrap.// -->
                                            @else
                                                <div class="price mt-1 ">{{ $sor->price }} ft</div>
                                                <!-- price-wrap.// -->
                                            @endif
                                        </figcaption>
                                    </div>
                                </div> <!-- col.// -->
                            @endforeach
                        </div>
                        @if ($se->hasPages())
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $se->appends(Request::except('oldal'))->url(1) }}">
                                            << </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $se->appends(Request::except('oldal'))->previousPageUrl() }}">
                                            < </a>
                                    </li>
                                    @php
                                        $currentPage = $se->currentPage();
                                        $lastPage = $se->lastPage();
                                        $b = max($currentPage - 3, 1);
                                        $c = min($currentPage + 3, $lastPage);
                                        if ($currentPage <= 3 && $lastPage > 7) {
                                            $c = 7;
                                        } elseif ($currentPage >= $lastPage - 3 && $lastPage > 7) {
                                            $b = $lastPage - 6;
                                        }
                                    @endphp
                                    @for ($x = $b; $x <= $c; $x++)
                                        <li class="page-item {{ $x == $se->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $se->appends(Request::except('oldal'))->url($x) }}">{{ $x }}
                                                <span class="sr-only"></span></a>
                                        </li>
                                    @endfor
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $se->appends(Request::except('oldal'))->nextPageUrl() }}">></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $se->appends(Request::except('oldal'))->url($se->lastPage()) }}">>></a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
