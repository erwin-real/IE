@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>{{$loss->product->name}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/loss">Loss</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$loss->id}}</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/loss/{{$loss->id}}/edit" class="btn btn-outline-primary mt-1 mr-2"><i class="fas fa-pencil-alt"></i> Edit</a>

                @if(Auth::user()->type == 'admin')
                    <div class="float-right">
                        {!!Form::open(['action' => ['LossController@destroy', $loss->id], 'method' => 'POST', 'id' => 'delete'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {!! Form::button('<i class="fas fa-trash"></i> Delete',
                            ['class'=>'btn btn-outline-danger mt-1', 'type'=>'submit'])
                         !!}
                        {!!Form::close()!!}
                    </div>
                @endif

            </div>

            <div class="row">
                <div class="col-4 mt-4 panel-body">
                    <p><b>Name</b>: {{$loss->product->name}}</p>
                    <p><b>Type</b>: {{$loss->product->type}}</p>
                    <p><b>Description</b>: {{$loss->product->desc}}</p>
                    @if(Auth::user()->type == 'admin')
                        <p><b>Price</b>: {{$loss->product->price}}</p>
                    @endif
                    <p><b>Quantity</b>: {{$loss->quantity}}</p>
                    <p><b>Reason</b>: {{$loss->reason}}</p>
                    <p><b>SRP</b>: {{$loss->product->srp}}</p>
                    <p><b>Loss Money</b>: {{$loss->loss_money}}</p>
                    <p><b>Sold by</b>: {{$loss->product->sold_by}}</p>
                    <p><b>Source</b>: {{$loss->product->source}}</p>
                    <p><b>Contact</b>: {{$loss->product->contact}}</p>
                    <p><b>Expiration Date</b>: {{date('D M d,Y', strtotime($loss->product->expired_at))}}</p>
                    <p><b>Stocks</b>: {{$loss->product->stocks}}</p>
                    <p><b>Procurement</b>: {{$loss->product->procurement}}</p>
                    <p><b>Created at</b>: {{date('D M d,Y', strtotime($loss->product->created_at))}}</p>
                    <p><b>Updated at</b>: {{date('D M d,Y', strtotime($loss->product->updated_at))}}</p>
                </div>

                <div class="col-8 mt-4 panel-body">
                    <img src="/storage/cover_images/{{$loss->product->cover_image}}" alt="" style="width: 100%;
">
                </div>
            </div>

            <a href="/loss" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#delete").on("submit", function () {
                return confirm("Are you sure you want to delete this Loss Product?");
            });
        });
    </script>

@endsection