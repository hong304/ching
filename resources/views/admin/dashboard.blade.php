@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section>
        <h3 class="admin-panel-title">Dashboard</h3>
        <div class="row no-gutters">
            <div class="col-md-12">
                <h4>User Statistic</h4>
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="card card-inverse card-green">
                            <div class="card-block">
                                <h3 class="card-title pb-3">Registrations</h3>
                                <div class="row text-center text-white ">
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Week</h6>
                                        <h2 class="pt-2">{{$data['registerWeekCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Month</h6>
                                        <h2 class="pt-2">{{$data['registerMonthCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Total</h6>
                                        <h2 class="pt-2">{{$data['registerTotalCount']}}</h2>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="card card-inverse card-yellow">
                            <div class="card-block">
                                <h3 class="card-title pb-3">Activations</h3>
                                <div class="row text-center text-white ">
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Week</h6>
                                        <h2 class="pt-2">{{$data['activationWeekCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Month</h6>
                                        <h2 class="pt-2">{{$data['activationMonthCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Total</h6>
                                        <h2 class="pt-2">{{$data['activationTotalCount']}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="card card-inverse card-red">
                            <div class="card-block">
                                <h3 class="card-title pb-3">Active Users</h3>
                                <div class="row text-center text-white ">
                                    <div class="col-6">
                                        <h6 class="card-subtitle">Week</h6>
                                        <h2 class="pt-2">{{$data['activeUserWeekCount']}}</h2>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="card-subtitle">Month</h6>
                                        <h2 class="pt-2">{{$data['activeUserMonthCount']}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="card card-inverse card-blue">
                            <div class="card-block">
                                <h3 class="card-title pb-3">Login Using Facebook</h3>
                                <div class="row text-center text-white justify-content-md-center">
                                    <div class="col-6">
                                        <h6 class="card-subtitle">Total</h6>
                                        <h2 class="pt-2">{{$data['facebookLoginCount']}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-4">
                        <div class="card card-inverse card-lightblue">
                            <div class="card-block">
                                <h3 class="card-title pb-3">Subscription</h3>
                                <div class="row text-center text-white ">
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Week</h6>
                                        <h2 class="pt-2">{{$data['subscriptionWeekCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Month</h6>
                                        <h2 class="pt-2">{{$data['subscriptionMonthCount']}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="card-subtitle">Total</h6>
                                        <h2 class="pt-2">{{$data['subscriptionTotalCount']}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6 col-12">
                <canvas id="registerChart" width="400" height="400"></canvas>
            </div>
            <div class="col-xl-6 col-md-6 col-12">
                <canvas id="activationChart" width="400" height="400"></canvas>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <script type="application/javascript">
      var ctx1 = document.getElementById("registerChart").getContext('2d');
      var ctx2 = document.getElementById("activationChart").getContext('2d');
      var registerLabels = {!! json_encode($data['registerPerMonthXLabels']) !!};
      var rData = {!! $data['registerPerMonth'] !!};
      var activationLabels = {!! json_encode($data['activationPerMonthXLabels']) !!};
      var aData = {!! $data['activationPerMonth'] !!};

      var rChart = new Chart(ctx1, {
        type: 'line',
        data: {
          labels: registerLabels,
          datasets: [{
            label: 'Registered Users per Month',
            data: rData
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });

      var aChart = new Chart(ctx2, {
        type: 'line',
        data: {
          labels: activationLabels,
          datasets: [{
            label: 'Activated Users per Month',
            data: aData
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });
    </script>
@endsection