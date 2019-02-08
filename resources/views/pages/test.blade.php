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

            {!! Form::open(['action' => 'ReportsController@calculate', 'method' => 'POST', 'class' => 'mt-4']) !!}

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
                            <tr>
                                <td>1</td>
                                <td class="m-auto">
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
                                <td>October</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2015</td>
                                <td>November</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>2015</td>
                                <td>December</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2016</td>
                                <td>January</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>2016</td>
                                <td>February</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>2016</td>
                                <td>March</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>2016</td>
                                <td>April</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>2016</td>
                                <td>May</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>2016</td>
                                <td>June</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>2016</td>
                                <td>July</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>2016</td>
                                <td>August</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>2016</td>
                                <td>September</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>2016</td>
                                <td>October</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>2016</td>
                                <td>November</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>2016</td>
                                <td>December</td>
                                <td><input type="number" id="size4[]" name="size4[]" required/></td>
                                <td><input type="number" id="size5[]" name="size5[]" required/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-4">
                        {{Form::submit('Save', ['class' => 'btn btn-outline-primary'])}}
                    </div>

                </div>

            {!! Form::close() !!}

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Report Summary</h5>
                            <div class="panel-body pt-4">
                                {{--{!! $chart->container() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateYear(r) {
            let node = r.parentNode.parentNode.parentNode.children;
            for (let i = 1; i < 3; i++) node[i].children[1].innerText = r.value;
            for (let i = 3; i < 15; i++) node[i].children[1].innerText = parseInt(r.value) + 1;
        }
    </script>
@endsection