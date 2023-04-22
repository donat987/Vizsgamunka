@extends('admin.layout')
@section('admincontent')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">payments</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Mai bevétel</p>
                        <h4 class="mb-0">{{ $today }} Ft</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">@if ($dayftszaz < 0)
                        <span class="text-danger text-sm font-weight-bolder">{{$dayftszaz}}% </span>
                    @else
                    <span class="text-success text-sm font-weight-bolder">{{$dayftszaz}}% </span>
                    @endif
                     tegnapi naphoz képest</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Rendelések száma</p>
                        <h4 class="mb-0">{{ $todayp }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">@if ($daypszaz < 0)
                        <span class="text-danger text-sm font-weight-bolder">{{$daypszaz}}% </span>
                    @else
                    <span class="text-success text-sm font-weight-bolder">{{$daypszaz}}% </span>
                    @endif
                     tegnapi naphoz képest</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">shopping_basket</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Eladott termékek</p>
                        <h4 class="mb-0">{{ $todayt }} db</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">@if ($daytszaz < 0)
                        <span class="text-danger text-sm font-weight-bolder">{{$daytszaz}}% </span>
                    @else
                    <span class="text-success text-sm font-weight-bolder">{{$daytszaz}}% </span>
                    @endif
                     tegnapi naphoz képest</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">payments</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Aktuális hónap bevétel</p>
                        <h4 class="mb-0">{{$MonthRevenue}} Ft</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">@if ($monthbev < 0)
                        <span class="text-danger text-sm font-weight-bolder">{{$monthbev}}% </span>
                    @else
                    <span class="text-success text-sm font-weight-bolder">{{$monthbev}}% </span>
                    @endif
                     múlt hónaphoz képest</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="170" width="279"
                                style="display: block; box-sizing: border-box; height: 170px; width: 279.3px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 "> Bevétel havi bontásban</h6>
                    <hr class="dark horizontal">

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="mounthpiece" class="chart-canvas" height="170" width="279"
                                style="display: block; box-sizing: border-box; height: 170px; width: 279.3px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 "> Eladott termék havi bontásban </h6>
                    <hr class="dark horizontal">

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="daysprice" class="chart-canvas" height="170" width="279"
                                style="display: block; box-sizing: border-box; height: 170px; width: 279.3px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 "> Bevétel napi bontásban </h6>
                    <hr class="dark horizontal">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["{{ $monthft[0]['month'] }}", "{{ $monthft[1]['month'] }}", "{{ $monthft[2]['month'] }}",
                    "{{ $monthft[3]['month'] }}", "{{ $monthft[4]['month'] }}", "{{ $monthft[5]['month'] }}",
                    "{{ $monthft[6]['month'] }}", "{{ $monthft[7]['month'] }}"
                ],
                datasets: [{
                    label: "Bevétel",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [{{ $monthft[0]['revenue'] }}, {{ $monthft[1]['revenue'] }},
                        {{ $monthft[2]['revenue'] }},
                        {{ $monthft[3]['revenue'] }}, {{ $monthft[4]['revenue'] }},
                        {{ $monthft[5]['revenue'] }},
                        {{ $monthft[6]['revenue'] }}, {{ $monthft[7]['revenue'] }}
                    ],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx2 = document.getElementById("mounthpiece").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["{{ $monthft[0]['month'] }}", "{{ $monthft[1]['month'] }}",
                    "{{ $monthft[2]['month'] }}",
                    "{{ $monthft[3]['month'] }}", "{{ $monthft[4]['month'] }}", "{{ $monthft[5]['month'] }}",
                    "{{ $monthft[6]['month'] }}", "{{ $monthft[7]['month'] }}"
                ],
                datasets: [{
                    label: "Bevétel",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [{{ $datedb[0]->piece }}, {{ $datedb[1]->piece }}, {{ $datedb[2]->piece }},
                        {{ $datedb[3]->piece }}, {{ $datedb[4]->piece }}, {{ $datedb[5]->piece }},
                        {{ $datedb[6]->piece }}, {{ $datedb[7]->piece }}
                    ],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("daysprice").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["{{ $dayft[0]['days'] }}", "{{ $dayft[1]['days'] }}", "{{ $dayft[2]['days'] }}",
                    "{{ $dayft[3]['days'] }}", "{{ $dayft[4]['days'] }}", "{{ $dayft[5]['days'] }}",
                    "{{ $dayft[6]['days'] }}", "{{ $dayft[7]['days'] }}", "{{ $dayft[8]['days'] }}",
                    "{{ $dayft[9]['days'] }}", "{{ $dayft[10]['days'] }}", "{{ $dayft[11]['days'] }}",
                    "{{ $dayft[12]['days'] }}", "{{ $dayft[13]['days'] }}", "{{ $dayft[14]['days'] }}",
                    "{{ $dayft[15]['days'] }}", "{{ $dayft[16]['days'] }}", "{{ $dayft[17]['days'] }}"
                ],
                datasets: [{
                    label: "Bevétel",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [{{ $dayft[0]['revenue'] }}, {{ $dayft[1]['revenue'] }},
                        {{ $dayft[2]['revenue'] }},
                        {{ $dayft[3]['revenue'] }}, {{ $dayft[4]['revenue'] }},
                        {{ $dayft[5]['revenue'] }},
                        {{ $dayft[6]['revenue'] }}, {{ $dayft[7]['revenue'] }},
                        {{ $dayft[8]['revenue'] }},
                        {{ $dayft[9]['revenue'] }}, {{ $dayft[10]['revenue'] }},
                        {{ $dayft[11]['revenue'] }},
                        {{ $dayft[12]['revenue'] }}, {{ $dayft[13]['revenue'] }},
                        {{ $dayft[14]['revenue'] }},
                        {{ $dayft[15]['revenue'] }}, {{ $dayft[16]['revenue'] }},
                        {{ $dayft[17]['revenue'] }}
                    ],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endsection
