
@extends('base/base')

@section('content')

<div id="content">

    <div class="container-fluid" style="width: 98%">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Painel</h3></div>
            @auth
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Earnings (monthly)</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span>$40,000</span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Earnings (annual)</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span>$215,000</span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Tasks</span></div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="text-dark font-weight-bold h5 mb-0 mr-3"><span>50%</span></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"><span class="sr-only">50%</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Pending Requests</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span>18</span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary font-weight-bold m-0">Earnings Overview</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div role="menu" class="dropdown-menu shadow dropdown-menu-right animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a role="presentation" class="dropdown-item" href="#"> Action</a><a role="presentation" class="dropdown-item" href="#"> Another action</a>
                                            <div class="dropdown-divider"></div><a role="presentation" class="dropdown-item" href="#"> Something else here</a></div>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="chart-container" style="position: relative;"><canvas id='graph' style="padding:3px" ></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary font-weight-bold m-0">Revenue Sources</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div role="menu" class="dropdown-menu shadow dropdown-menu-right animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a role="presentation" class="dropdown-item" href="#"> Action</a><a role="presentation" class="dropdown-item" href="#"> Another action</a>
                                            <div class="dropdown-divider"></div><a role="presentation" class="dropdown-item" href="#"> Something else here</a></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas height="320" style="display: block; width: 495px; height: 320px;" width="495"></canvas></div>
                                    <div class="text-center small mt-4"><span class="mr-2"><i class="fas fa-circle text-primary"></i> Direct</span><span class="mr-2"><i class="fas fa-circle text-success"></i> Social</span><span class="mr-2"><i class="fas fa-circle text-info"></i> Refferal</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endauth
            @guest
                    <div class="col-lg-20 mb-4" style="width: 98%">
                        <div class="card shadow mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class=" align-text-center text-primary font-weight-bold m-0">Ainda não possui cadastro ?</h6>

                            </div>
                            <div class="card-body">
                                <div><h3><b><a href="{{url('register')}}">
                                    - Cadastro
                                    </a>

                                </b></h3></div>
                            </div>
                        </div>
                    </div>

                </div>

            @endguest
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script>

        var ctx = document.getElementById('graph').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Empreendimentos',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</div>
@endsection
