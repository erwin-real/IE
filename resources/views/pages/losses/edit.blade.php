@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Edit Loss Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/loss">Loss</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Loss Product</li>
                </ol>
            </nav>
            {!! Form::open(['action' => ['LossController@update', $loss->id], 'method' => 'POST']) !!}

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::hidden('product_id', $loss->id, ['class' => 'form-control'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('name', 'Product Name')}}
                {{Form::text('name', $loss->product->name, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-6 col-md-5 col-sm-8">
                {{Form::label('type', 'Product Type')}}
                {{Form::text('type', $loss->product->type, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-6 col-md-5 col-sm-8">
                {{Form::label('desc', 'Product Description')}}
                {{Form::text('desc', $loss->product->desc, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            @if(Auth::user()->type == 'admin')
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('price', 'Price')}}
                    {{Form::number('price', $loss->product->price, ['class' => 'form-control', 'disabled' => 'disabled'])}}
                </div>
            @endif

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('srp', 'SRP')}}
                {{Form::number('srp', $loss->product->srp, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('src', 'Source of Supply')}}
                {{Form::text('src', $loss->product->source, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('contact', 'Contact Number')}}
                {{Form::number('contact', $loss->product->contact, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('exp', 'Expiration Date')}}
                {{Form::date('exp', date('Y-m-d', strtotime($loss->product->expired_at)), ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('stocks', 'Stocks')}}
                {{Form::number('stocks', $loss->product->stocks, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('pro', 'Procurement Level')}}
                {{Form::number('pro', $loss->product->procurement, ['class' => 'form-control', 'disabled' => 'disabled'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('quantity', 'Quantity')}} <span class="text-danger">*</span>
                {{Form::number('quantity', $loss->quantity, ['class' => 'form-control', 'placeholder' => 'Enter Quantity', 'required' => 'required'])}}
            </div>

            <div class="form-group col-12 col-md-5 col-sm-8">
                {{Form::label('reason', 'Reason')}} <span class="text-danger">*</span>
                {{Form::text('reason', $loss->reason, ['class' => 'form-control', 'placeholder' => 'Enter Reason', 'required' => 'required'])}}

                <div class="text-center mt-4">
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::submit('Submit', ['class' => 'btn btn-outline-primary'])}}
                </div>
            </div>

        {!! Form::close() !!}


        </div>
    </div>

@endsection