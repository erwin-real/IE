@extends('layouts.app')

@section('content')
    @include('includes.sidenav')
    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Create</h1>
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
                            <a href="/forecasts">Forecasts</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    @endif
                </ol>
            </nav>

            {!! Form::open(['action' => 'ForecastController@store', 'method' => 'POST', 'class' => 'mt-4']) !!}

                <div class="lists-table table-responsive mt-3">
                    <table class="table table-hover table-striped py-3 text-center">
                        <thead>
                        <tr>
                            <th scope="col">Period</th>
                            <th scope="col">Year</th>
                            <th scope="col">Month</th>
                            <th scope="col">Size 4 Hollow Blocks' Previous Demand</th>
                            <th scope="col">Size 5 Hollow Blocks' Previous Demand</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php

                            echo '
                            <tr class="p-0 bg-primary text-white">
                                <td class="p-0">1</td>
                                <td class="m-auto p-0">
                                    <select id="year" name="year" required onchange="updateYear(this)">
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2033">2033</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                    </select>
                                </td>
                                <td class="p-0">January</td>
                                <td class="p-0"><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td class="p-0"><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>';

                                $months = ['January', 'February', 'March', 'April', 'May', 'June',
                                 'July', 'August', 'September', 'October', 'November', 'December'];

                                for($i = 0; $i < 3; $i++) {
                                    for($j = 0; $j < 12; $j++) {
                                        if ($i == 0 && $j <= 10) {
                                            echo
                                            '<tr class="p-0">
                                                <td class="p-0">'. ($j+2) .'</td>
                                                <td class="p-0">'. ($i+2015) .'</td>
                                                <td class="p-0">'. $months[$j+1].'</td>
                                                <td class="p-0"><input type="number" id="size4[]" name="size4[]" required/></td>
                                                <td class="p-0"><input type="number" id="size5[]" name="size5[]" required/></td>
                                            </tr>';
                                        } elseif ($i == 0 && $j == 11) break;

                                        else {

                                            echo
                                            '<tr class="p-0 ';


                                            echo ($j == 0) ? "bg-primary text-white" : "";
                                            echo '">
                                                <td class="p-0">'. ($j+1) .'</td>
                                                <td class="p-0">'. ($i+2015) .'</td>
                                                <td class="p-0">'. $months[$j].'</td>
                                                <td class="p-0"><input type="number" id="size4[]" name="size4[]" required/></td>
                                                <td class="p-0"><input type="number" id="size5[]" name="size5[]" required/></td>
                                            </tr>';
                                        }
                                    }
                                }
                            @endphp
                        </tbody>
                    </table>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                {{Form::label('lead', 'Lead Time')}}
                                {{Form::number('lead', '', ['class' => 'form-control', 'placeholder' => 'Enter Lead Time', 'required' => 'required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                {{Form::label('days', 'Working Days per year')}}
                                {{Form::number('days', '', ['class' => 'form-control', 'placeholder' => 'Enter Working Days', 'required' => 'required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                {{Form::label('holding', 'Holding Cost')}}
                                {{Form::number('holding', '', ['class' => 'form-control', 'placeholder' => 'Enter Holding Cost', 'required' => 'required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                {{Form::label('ordering', 'Ordering Cost')}}
                                {{Form::number('ordering', '', ['class' => 'form-control', 'placeholder' => 'Enter Ordering Cost', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button id="submit" type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-check"></i> {{ __('Save') }}
                        </button>
                    </div>

                </div>

            {!! Form::close() !!}
            <a href="/forecasts" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back to forecasts</a>

        </div>
    </div>

    <script>
        var years = [];

        @foreach($forecasts as $forecast)
            years.push('{{$forecast->year}}');
        @endforeach

        for (let i = 0; i < years.length; i++) {
            if (years[i] === document.getElementById('year').value) document.getElementById('submit').disabled = true;
        }

        function updateYear(r) {
            document.getElementById('submit').disabled = false;
            for (let i = 0; i < years.length; i++) {
                if (years[i] === r.value) document.getElementById('submit').disabled = true;
            }

            let node = r.parentNode.parentNode.parentNode.children;
            for (let i = 1; i < 12; i++) node[i].children[1].innerText = r.value;
            for (let i = 12; i < 24; i++) node[i].children[1].innerText = parseInt(r.value) + 1;
            for (let i = 24; i < 36; i++) node[i].children[1].innerText = parseInt(r.value) + 2;
        }
    </script>
@endsection