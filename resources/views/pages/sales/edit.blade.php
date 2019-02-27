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
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/forecasts/sales/{{$forecast->id}}">Actual Sales</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>

            @include('includes.messages')

            @if(isset($success))
                <div class="alert alert-success">
                    {{$success}}
                </div>
            @endif

            {!! Form::open(['action' => ['ActualSalesController@update', $forecast->id], 'method' => 'POST', 'class' => 'mt-4']) !!}
            <input type="hidden" value="{{$forecast->year + 3}}" name="year">

                {{--SIZE 4--}}
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
                                            @php
                                                $months = ['January', 'February', 'March', 'April', 'May', 'June',
                                                 'July', 'August', 'September', 'October', 'November', 'December'];
                                                 for ($i = 0; $i < 12; $i++) {
                                                     echo '<tr>';
                                                        echo '<td class="m-auto p-0">'. ($forecast->year + 3) .'</td>';
                                                        echo '<td class="m-auto p-0">'. $months[$i] .'</td>';
                                                        echo '<td class="m-auto p-0">'. $forecast->seasons[$i + $i]->value .'</td>';
                                                        echo '<td class="m-auto p-0"><input name="size4[]" type="number"
                                                         onkeypress="update(this)" onkeyup="update(this)" value="'.$forecast->actualSales[$i + $i]->sale.'" required/></td>';
                                                        echo '<td class="m-auto p-0">'. ($forecast->seasons[$i + $i]->value - $forecast->actualSales[$i + $i]->sale) .'</td>';
                                                        if ($i == 0) echo '<td class="m-auto p-0"></td>';
                                                        else echo '<td class="m-auto p-0">'. ($forecast->seasons[$i+$i]->value - (($forecast->seasons[$i+$i-2]->value - $forecast->actualSales[$i+$i-2]->sale))) .'</td>';
                                                     echo '</tr>';
                                                 }
                                            @endphp
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{--SIZE 5--}}
                <div class="bottom-dashboard mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-2">
                                <h5 class="card-title report-title">Hollow Blocks Size 5</h5>

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
                                            @php
                                                $months = ['January', 'February', 'March', 'April', 'May', 'June',
                                                 'July', 'August', 'September', 'October', 'November', 'December'];
                                                 for ($i = 0; $i < 12; $i++) {
                                                     echo '<tr>';
                                                        echo '<td class="m-auto p-0">'. ($forecast->year + 3) .'</td>';
                                                        echo '<td class="m-auto p-0">'. $months[$i] .'</td>';
                                                        echo '<td class="m-auto p-0">'. $forecast->seasons[$i + $i + 1]->value .'</td>';
                                                        echo '<td class="m-auto p-0"><input name="size5[]" type="number"
                                                         onkeypress="update(this)" onkeyup="update(this)" value="'.$forecast->actualSales[$i + $i + 1]->sale.'" required/></td>';
                                                        echo '<td class="m-auto p-0">'. ($forecast->seasons[$i + $i + 1]->value - $forecast->actualSales[$i + $i + 1]->sale) .'</td>';
                                                        if ($i == 0) echo '<td class="m-auto p-0"></td>';
                                                        else echo '<td class="m-auto p-0">'. ($forecast->seasons[$i+$i+1]->value - (($forecast->seasons[$i+$i-2+1]->value - $forecast->actualSales[$i+$i-2+1]->sale))) .'</td>';
                                                     echo '</tr>';
                                                 }
                                            @endphp
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    {{Form::hidden('_method', 'PUT')}}
                    <button id="submit" type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-check"></i> {{ __('Save') }}
                    </button>
                </div>

            {!! Form::close() !!}
            <a href="/forecasts" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back to forecasts</a>

        </div>
    </div>

    <script>
        function update(r) {
            let node = r.parentNode.parentNode;
            let index = node.rowIndex;
            let forecast = node.children[2].innerText;
            let sale = node.children[3].children[0].value;
            if (!(parseInt(forecast) - parseInt(sale))) node.children[4].innerText = forecast;
            else node.children[4].innerText = (parseInt(forecast) - parseInt(sale));

            if (index > 1) node.children[5].innerText = forecast - node.parentNode.children[index-2].children[4].innerText;

            if (index < 12 && node.parentNode.children[index].children[5].innerText.length > 0) {
                node.parentNode.children[index].children[5].innerText
                    = node.parentNode.children[index].children[2].innerText - node.children[4].innerText;
            }
        }


    </script>

@endsection