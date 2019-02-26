@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Actual Sales Year {{$forecast->year + 3}}</h1>
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
                @if ($forecast->actualSales != null && count($forecast->actualSales) > 0)
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
                                            <th scope="col">Seasonality Forecast</th>
                                            <th scope="col">Actual Sales</th>
                                            <th scope="col">Ending Inventory</th>
                                            <th scope="col">To Be Produced</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($forecast->actualSales != null && count($forecast->actualSales) > 0)
                                            @php
                                                $months = ['January', 'February', 'March', 'April', 'May', 'June',
                                                 'July', 'August', 'September', 'October', 'November', 'December'];
                                                 for ($i = 0; $i < 12; $i++) {
                                                 echo '<tr>';
                                                    echo '<td>'.($forecast->year + 3).'</td>';
                                                    echo '<td>'. $months[$i] .'</td>';
                                                 echo '</tr>';
                                                 }
                                            @endphp
                                        @else
                                            <tr class="text-center">
                                                <th colspan="6">No actual sales recorded</th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection