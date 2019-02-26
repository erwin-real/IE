@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Transactions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/dashboard">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/reports">Reports</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/forecasts">Forecast</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/forecasts/{{$forecast->id}}">Year {{$forecast->year + 3}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Actual Sales</li>
                </ol>
            </nav>

            @include('includes.messages')

            @if(isset($success))
                <div class="alert alert-success">
                    {{$success}}
                </div>
            @endif

            <div class="button-holder text-right">
                @if ($forecast->actualSales != null)
                    <a href="/forecasts/sales/{{$forecast->id}}/edit" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> Update Actual Sales</a>
                @else
                    <a href="/forecasts/sales/{{$forecast->id}}/create" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> Add Actual Sales</a>
                @endif
            </div>

            <div class="bottom-dashboard mt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Hollow Blocks Size 4</h5>

                            <div class="lists-table table-responsive mt-3">
                                <table class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">Seasonality </th>
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

                        </div>
                    </div>
                </div>
            </div>

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Month</th>
                            <th scope="col">Seasonality Forecast Size 4</th>
                            <th scope="col">Change</th>

                            @if(Auth::user()->type == 'admin')
                                <th scope="col">Capital</th>
                                <th scope="col">Income</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td><a href="/transactions/{{$transaction->id}}">{{date('D M d,Y h:i A', strtotime($transaction->created_at))}}</a></td>
                                    <td>{{$transaction->total}}</td>
                                    <td>{{$transaction->money_received}}</td>
                                    <td>{{$transaction->change}}</td>

                                    @if(Auth::user()->type == 'admin')
                                        <td>{{$transaction->capital}}</td>
                                        <td>{{$transaction->income}}</td>
                                    @endif

                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="7">No transactions found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection