@extends('layouts.profil')
@section('profilcontent')
    <div class="col-lg-12">
        <h2>Aktív rendelések</h2>
        @foreach ($orders as $order)
            <div class="card card-stepper mb-3">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between">
                        <div class="d-lg-flex align-items-center">
                            <i class="fa fa-paper-plane fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                        </div>
                        <div class="d-lg-flex align-items-center">
                            <i class="fa fa fa-box-open fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                        </div>
                        <div class="d-lg-flex align-items-center">
                            <i class="fa fa-truck-loading fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                        </div>
                        <div class="d-lg-flex align-items-center">
                            <i class="fa fa-truck-moving fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                        </div>
                        <div class="d-lg-flex align-items-center">
                            <i class="fas fa-check fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                        </div>
                    </div>
                    <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                        @if ($order[0]['statesid'] >= 1)
                            <li class="step0 active text-center" id="step1"></li>
                        @else
                            <li class="step0 text-center" id="step1"></li>
                        @endif
                        @if ($order[0]['statesid'] >= 2)
                            <li class="step0 active text-center" id="step2"></li>
                        @else
                            <li class="step0 text-center" id="step2"></li>
                        @endif
                        @if ($order[0]['statesid'] >= 3)
                            <li class="step0 active  text-center" id="step3"></li>
                        @else
                            <li class="step0 text-center" id="step3"></li>
                        @endif
                        @if ($order[0]['statesid'] >= 4)
                            <li class="step0 active text-center" id="step4"></li>
                        @else
                            <li class="step0 text-center" id="step4"></li>
                        @endif
                        @if ($order[0]['statesid'] >= 5)
                            <li class="step0 active text-center" id="step5"></li>
                        @else
                            <li class="step0 text-center" id="step5"></li>
                        @endif
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h5 class="mb-0">Rendelési azonosító: <span
                                    class="text-primary font-weight-bold">#{{ $order[0]['ordersid'] }}</span>
                            </h5>
                            <p class="mb-0">Állapot: <span>{{ $order[0]['states'] }}</span></p>
                            <h5 class="mb-0">Szállítási cím:</h5>
                            <p class="mb-0">Név: <span>{{ $order[0]['name'] }}</span></p>
                            <p class="mb-0">Cím: <span>{{ $order[0]['zipcode'] }} {{ $order[0]['city'] }}
                                    {{ $order[0]['street'] }} {{ $order[0]['house_number'] }}</span></p>
                            <p class="mb-0">Egyéb: <span>{{ $order[0]['other'] }}</span></p>
                            <p class="mb-0">Mobil: <span>{{ $order[0]['mobile_number'] }}</span></p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0">Rendelési dátum: <span>{{ $order[0]['date'] }}</span></p>
                            @if ($order[0]['box_number'] != '')
                                <p class="mb-0">Csomagszám: <span
                                        class="font-weight-bold">{{ $order[0]['box_number'] }}</span></p>
                            @endif
                            <h5 class="mb-0">Számlázási cím:</h5>
                            @if ($order[0]['tax_number'] != '')
                                <p class="mb-0">Adószám: <span>{{ $order[0]['tax_number'] }}</span></p>
                            @endif
                            @if ($order[0]['company_name'] != '')
                                <p class="mb-0">Név: <span>{{ $order[0]['company_name'] }}</span></p>
                            @else
                                <p class="mb-0">Név: <span>{{ $order[0]['name'] }}</span></p>
                            @endif
                            @if ($order[0]['company_zipcode'] != '')
                                <p class="mb-0">Cím: <span>{{ $order[0]['company_zipcode'] }}
                                        {{ $order[0]['company_city'] }}
                                        {{ $order[0]['company_street'] }} {{ $order[0]['company_house_number'] }}</span>
                                </p>
                            @else
                                <p class="mb-0">Cím: <span>{{ $order[0]['zipcode'] }} {{ $order[0]['city'] }}
                                        {{ $order[0]['street'] }} {{ $order[0]['house_number'] }}</span></p>
                            @endif
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Termék neve</th>
                                <th class="text-center">Darabár ár</th>
                                <th class="text-center">Darabszám</th>
                                <th class="text-center">Teljes összeg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $allprice = 0;@endphp
                            @foreach ($order as $o)
                                <tr>
                                    <td><img width="100px" src="{{ $o['file'] }}"></td>
                                    <td class="align-middle">{{ $o['products_name'] }}</td>
                                    <td class="align-middle text-center">{{ $o['gross_amount'] }} Ft</td>
                                    <td class="align-middle text-center">{{ $o['price'] }} db</td>
                                    <td class="align-middle text-center">{{ $o['price'] * $o['gross_amount'] }} Ft</td>
                                    @php $allprice += $o['price'] * $o['gross_amount'];@endphp
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="align-middle" style="width:50%"></td>
                                <td class="align-middle text-right">Szállítás:</td>
                                <td class="align-middle text-center">{{ $order[0]['shippingprice'] }} Ft</td>
                            </tr>
                            @php $allprice += $o['shippingprice'] ;@endphp
                            <tr>
                                <td class="align-middle" style="width:50%"><button class="btn btn-primary"
                                    onclick="window.location.href='/profil/modositas'">Rendelés lemodása</button></td>
                                <td class="align-middle text-right">Fözetendő összeg:</td>
                                <td class="align-middle text-center">{{$allprice}} Ft</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        @endforeach
    </div>
@endsection
