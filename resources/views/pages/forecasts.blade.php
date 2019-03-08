@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Forecasts</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/dashboard">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/reports">Reports</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Forecasts</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/forecasts/create" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> Create</a>
                <a href="/guide/forecasts" target="_blank" class="btn btn-outline-dark mt-1"><i class="fas fa-info-circle"></i> Guide</a>
            </div>

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th>Years</th>
                            <th>Lead time</th>
                            <th>Working days</th>
                            <th>Holding cost</th>
                            <th>Ordering cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($forecasts) > 0)
                            @foreach($forecasts as $forecast)
                                <tr>
                                    <td><a href="/forecasts/{{$forecast->id}}">{{$forecast->year}} to {{$forecast->year + 2}}</a></td>
                                    <td>{{$forecast->lead}}</td>
                                    <td>{{$forecast->days}}</td>
                                    <td>{{$forecast->holding}}</td>
                                    <td>{{$forecast->ordering}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="5">No forecasts found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection