@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Loss</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Loss</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/guide/loss" class="btn btn-outline-dark mt-1"><i class="fas fa-info-circle"></i> Guide</a>
            </div>

            <div class="lists-table table-responsive mt-3">
                <h4>Total Loss: {{count($losses)}}</h4>
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">SRP</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Loss Money</th>
                            <th scope="col">Reason</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if(count($losses) > 0)
                            @foreach($losses as $loss)
                                <tr>
                                    <td style="cursor: pointer;" onclick="window.location = '/loss/{{$loss->id}}'">{{$loss->product->name}}</td>
                                    <td>{{$loss->product->type}}</td>
                                    <td>{{$loss->product->desc}}</td>
                                    <td>{{$loss->product->srp}}</td>
                                    <td>{{$loss->quantity}}</td>
                                    <td>{{$loss->loss_money}}</td>
                                    <td>{{$loss->reason}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="13">No loss products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection