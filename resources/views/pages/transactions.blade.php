@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Transactions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                </ol>
            </nav>

            @include('includes.messages')

            @if(isset($success))
                <div class="alert alert-success">
                    {{$success}}
                </div>
            @endif

            <div class="button-holder text-right">
                <a href="/transactions/create" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> New Transaction</a>
                <a href="/guide/transactions" class="btn btn-outline-dark mt-1"><i class="fas fa-info-circle"></i> Guide</a>
            </div>

            {{$transactions->links()}}
            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Money Received</th>
                            <th scope="col">Change</th>

                            @if(Auth::user()->type == 'admin')
                                <th scope="col">Capital</th>
                                <th scope="col">Income</th>
                                {{--<th scope="col">Delete</th>--}}
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td><a href="/transactions/{{$transaction->id}}">{{date('D M d,Y H:i', strtotime($transaction->created_at))}}</a></td>
                                    <td>{{$transaction->total}}</td>
                                    <td>{{$transaction->money_received}}</td>
                                    <td>{{$transaction->change}}</td>

                                    @if(Auth::user()->type == 'admin')
                                        <td>{{$transaction->capital}}</td>
                                        <td>{{$transaction->income}}</td>

                                        {{--<td class="icons">--}}
                                            {{--{!!Form::open(['action' => ['TransactionsController@destroy', $transaction->id], 'method' => 'POST', 'class' => 'delete'])!!}--}}
                                                {{--{{Form::hidden('_method', 'DELETE')}}--}}
                                                {{--{!! Form::button('<i class="fa fa-trash"></i>', ['class'=>'del-btn', 'type'=>'submit']) !!}--}}
                                            {{--{!!Form::close()!!}--}}
                                        {{--</td>--}}
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

    <script>
        $(document).ready(function() {
            $(".delete").on("submit", function () {
                return confirm("Are you sure you want to delete this transaction?");
            });
        });
    </script>

@endsection