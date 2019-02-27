@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Forecasts' Guide</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Forecasts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>

            <div class="container-fluid">
                <div class="row">

                    <div class=" col-md-5">

                        <h3>♦ Create new forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Click the "Create" button.</li>
                                <li>Fill all of the fields.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ View a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Edit a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Click the "Edit" button.</li>
                                <li>Edit all desired fields.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        @if(Auth::user()->type == 'admin')
                            <h3>♦ Delete a product</h3>
                            <div class="mx-2">
                                <ol>
                                    <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                    <li>Simply click the "Years" of the forecast in the table.</li>
                                    <li>Click the "Delete" button.</li>
                                    <li>Click "OK" in the alertbox that will show up.</li>
                                    <li>Finish!</li>
                                </ol>
                            </div>
                        @endif

                        <h3>♦ Show actual sales of a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Click the "Show Actual Sales" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                    <div class="col-md-5 offset-md-1">

                        <h3>♦ Add actual sales of a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Click the "Show Actual Sales" button.</li>
                                <li>Click the "Add Actual Sales" button.</li>
                                <li>Fill all of the fields.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Update actual sales of a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Click the "Show Actual Sales" button.</li>
                                <li>Click the "Update Actual Sales" button.</li>
                                <li>Update all of the fields.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Delete actual sales of a forecast</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/forecasts">Forecasts Page</a>.</li>
                                <li>Simply click the "Years" of the forecast in the table.</li>
                                <li>Click the "Show Actual Sales" button.</li>
                                <li>Click the "Delete Records" button.</li>
                                <li>Click "OK" in the alertbox that will show up.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection