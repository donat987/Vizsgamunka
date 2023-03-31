@extends('admin.layout')
@section('admincontent')
<div class="col-lg-4 col-md-6 mt-4 mb-4">
    <div class="card z-index-2  ">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
          <div class="chart">
            <canvas id="chart-line" class="chart-canvas" height="170" width="279" style="display: block; box-sizing: border-box; height: 170px; width: 279.3px;"></canvas>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0 "> Daily Sales </h6>
        <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales. </p>
        <hr class="dark horizontal">
        <div class="d-flex ">
          <i class="material-icons text-sm my-auto me-1">schedule</i>
          <p class="mb-0 text-sm"> updated 4 min ago </p>
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-body p-3">
      <div class="chart">
        <canvas id="line-chart" class="chart-canvas" height="300px"></canvas>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/plugins/chartjs.min.js')}}"></script>
  <script>


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["{{$sql[0]->month}}", "{{$sql[1]->month}}", "{{$sql[2]->month}}", "{{$sql[3]->month}}", "{{$sql[4]->month}}", "{{$sql[5]->month}}", "{{$sql[6]->month}}", "{{$sql[7]->month}}"],
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
                data: [{{$sql[0]->revenue}}, {{$sql[1]->revenue}}, {{$sql[2]->revenue}}, {{$sql[3]->revenue}}, {{$sql[4]->revenue}}, {{$sql[5]->revenue}}, {{$sql[6]->revenue}}, {{$sql[7]->revenue}}],
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
