@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Procurement</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Procurement</li>
                </ol>
            </nav>

            @include('includes.messages')
            <div class="button-holder text-right">
                <a href="/procurement/track" class="btn btn-outline-info mt-1"><i class="fas fa-map-marker-alt"></i> Track Products</a>
            </div>

            <div class="lists-table table-responsive mt-3">
            <h4>Total Procurement: {{count($procurements)}}</h4>
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>

                            @if(Auth::user()->type == 'admin')
                                <th scope="col">Price</th>
                            @endif

                            <th scope="col">SRP</th>
                            <th scope="col">Source</th>
                            <th scope="col">Contact #</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col">Stocks</th>
                            <th scope="col">Procurement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($procurements) > 0)
                            @foreach($procurements as $procurement)
                                <tr>
                                    <td onclick="window.location = '/products/{{$procurement->id}}'" style="cursor: pointer">{{$procurement->name}}</td>
                                    <td>{{$procurement->type}}</td>
                                    <td>{{$procurement->desc}}</td>

                                    @if(Auth::user()->type == 'admin')
                                        <td>{{$procurement->price}}</td>
                                    @endif

                                    <td>{{$procurement->srp}}</td>
                                    <td>{{$procurement->source}}</td>
                                    <td>{{$procurement->contact}}</td>
                                    <td>{{date('D M d\'y', strtotime($procurement->expired_at))}}</td>
                                    <td>{{$procurement->stocks}}</td>
                                    <td>{{$procurement->procurement}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="14">No products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection