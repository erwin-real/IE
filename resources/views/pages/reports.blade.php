@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Reports</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </nav>


            <div class="top-dashboard">
                <div class="row">

                    <div class="col-6 col-sm-6 col-xl-3">
                        <div class="campaign-summary">
                            <div class="card bg-secondary mb-3">
                                <div class="card-body text-center">
                                    <h2>{{$transactions->sum('capital')}}</h2>
                                    <p>Capital</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-3">
                        <div class="campaign-summary">
                            <div class="card bg-success mb-3">
                                <div class="card-body text-center">
                                    <h2>{{$transactions->sum('income')}}</h2>
                                    <p>Income</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="campaign-summary" onclick="window.location='/transactions'" style="cursor: pointer;">
                            <div class="card bg-info mb-3">
                                <div class="card-body text-center">
                                    <h2>{{count($transactions)}}</h2>
                                    <p>Transactions</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="campaign-summary" onclick="window.location='/loss'" style="cursor: pointer;">
                            <div class="card orange mb-3">
                                <div class="card-body text-center">
                                    <h2>{{$losses->sum('quantity')}}</h2>
                                    <p>Loss Products</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="campaign-summary" onclick="window.location='/loss'" style="cursor: pointer;">
                            <div class="card bg-danger mb-3">
                                <div class="card-body text-center">
                                    <h2>{{$losses->sum('loss_money')}}</h2>
                                    <p>Total Loss Money</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <a href="/reports?type=daily" class="btn btn-outline-primary">Daily</a>
                <a href="/reports?type=weekly" class="btn btn-outline-primary">Weekly</a>
                <a href="/reports?type=monthly" class="btn btn-outline-primary">Monthly</a>
                <a href="/reports?type=yearly" class="btn btn-outline-primary">Yearly</a>
            </div>

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">{{ucfirst($type)}} Report Summary</h5>
                            <div class="panel-body pt-4">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<script src="/js/vue.js"></script>
<script src="/js/echarts-en.min.js"></script>
{!! $chart->script() !!}

<script src="/js/highcharts.js"></script>
@endsection