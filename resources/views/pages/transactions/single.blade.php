@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Single Transaction</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/transactions">Transactions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$transaction->id}}</li>
                </ol>
            </nav>

            @include('includes.messages')

            @if(Auth::user()->type == 'admin')
                <div class="button-holder float-right">
                    {!!Form::open(['action' => ['TransactionsController@destroy', $transaction->id], 'method' => 'POST', 'id' => 'delete'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {!! Form::button('<i class="fas fa-trash"></i> Delete',
                        ['class'=>'btn btn-outline-danger mt-1', 'type'=>'submit'])
                     !!}
                    {!!Form::close()!!}
                </div>
            @endif

            <p>Date of Transaction: {{date('D M d,Y H:i', strtotime($transaction->created_at))}}</p>
            <span>Total: {{$transaction->total}}</span><br>

            @if(Auth::user()->type == 'admin')
                <span>Capital: {{$transaction->capital}}</span><br>
                <span>Income: {{$transaction->income}}</span>
            @endif

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description | Sold Per</th>

                            @if(Auth::user()->type == 'admin')
                                <th scope="col">Price</th>
                            @endif

                            <th scope="col">SRP</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->singleTransactions as $singleTransaction)
                            <tr>
                                <td>{{$singleTransaction->name}}</td>
                                <td>{{$singleTransaction->type}}</td>
                                <td>{{$singleTransaction->desc}}</td>

                                @if(Auth::user()->type == 'admin')
                                    <td>{{$singleTransaction->orig_price}}</td>
                                @endif

                                <td>{{$singleTransaction->orig_srp}}</td>
                                <td>{{$singleTransaction->quantity}}</td>
                                <td>{{$singleTransaction->total}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="w-100 text-center">
                <a href="/transactions/export/{{$transaction->id}}" target="_blank" class="btn btn-outline-success"><i class="fa fa-file-invoice"></i> EXPORT</a>
            </div>

            <a href="/transactions" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#delete").on("submit", function () {
                return confirm("Are you sure you want to delete this transaction?");
            });
        });
    </script>

@endsection