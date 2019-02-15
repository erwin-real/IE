@extends('layouts.app')

@section('content')
    @include('includes.sidenav')
    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Result</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/reports">Reports</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/reports/forecast">Forecast</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Result</li>
                    @endif
                </ol>
            </nav>

            {{--SIZE 4--}}
            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Hollow Blocks Size 4 Forecast</h5>
                            <div class="panel-body pt-4">
                                {!! $size4Chart->container() !!}
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Moving Average Forecast (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['MAF4']}}</td>
                                        <td>{{$final['MAFNOY4']}}</td>
                                        <td>{{$final['MAFOC4']}}</td>
                                        <td>{{$final['MAFRP4']}}</td>
                                        <td>{{$final['MAFSS4']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Exponential Smoothing Forecast (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['ESF4']}}</td>
                                        <td>{{$final['ESFNOY4']}}</td>
                                        <td>{{$final['ESFOC4']}}</td>
                                        <td>{{$final['ESFRP4']}}</td>
                                        <td>{{$final['ESFSS4']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Linear Trend Forecasting (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['LTF4']}}</td>
                                        <td>{{$final['LTFNOY4']}}</td>
                                        <td>{{$final['LTFOC4']}}</td>
                                        <td>{{$final['LTFRP4']}}</td>
                                        <td>{{$final['LTFSS4']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Seasonality Forecasting (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['SF4']}}</td>
                                        <td>{{$final['SFNOY4']}}</td>
                                        <td>{{$final['SFOC4']}}</td>
                                        <td>{{$final['SFRP4']}}</td>
                                        <td>{{$final['SFSS4']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- SIZE 5 --}}
            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Hollow Blocks Size 5 Forecast</h5>
                            <div class="panel-body pt-4">
                                {!! $size5Chart->container() !!}
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Moving Average Forecast (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['MAF5']}}</td>
                                        <td>{{$final['MAFNOY5']}}</td>
                                        <td>{{$final['MAFOC5']}}</td>
                                        <td>{{$final['MAFRP5']}}</td>
                                        <td>{{$final['MAFSS5']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Exponential Smoothing Forecast (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['ESF5']}}</td>
                                        <td>{{$final['ESFNOY5']}}</td>
                                        <td>{{$final['ESFOC5']}}</td>
                                        <td>{{$final['ESFRP5']}}</td>
                                        <td>{{$final['ESFSS5']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Linear Trend Forecasting (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['LTF5']}}</td>
                                        <td>{{$final['LTFNOY5']}}</td>
                                        <td>{{$final['LTFOC5']}}</td>
                                        <td>{{$final['LTFRP5']}}</td>
                                        <td>{{$final['LTFSS5']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Seasonality Forecasting (to be ordered)</th>
                                        <th scope="col">Number of Order per Year</th>
                                        <th scope="col">Order Cycle (days)</th>
                                        <th scope="col">Reorder Point</th>
                                        <th scope="col">Safety Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$year}}</td>
                                        <td>{{$final['SF5']}}</td>
                                        <td>{{$final['SFNOY5']}}</td>
                                        <td>{{$final['SFOC5']}}</td>
                                        <td>{{$final['SFRP5']}}</td>
                                        <td>{{$final['SFSS5']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="/js/vue.js"></script>
    <script src="/js/echarts-en.min.js"></script>
    {!! $size4Chart->script() !!}
    {!! $size5Chart->script() !!}

    <script src="/js/highcharts.js"></script>
@endsection