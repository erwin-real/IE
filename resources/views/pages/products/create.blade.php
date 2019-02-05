@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">

            <h1>Add Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                </ol>
            </nav>

            @include('includes.messages')

            <span class="text-danger">* required</span>

            {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'mt-4']) !!}

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('name', 'Product Name')}} <span class="text-danger">*</span>
                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('type', 'Product Type')}} <span class="text-danger">*</span>
                    {{Form::text('type', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Type', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('desc', 'Product Description')}}
                    {{Form::text('desc', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Description'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('price', 'Price')}} <span class="text-danger">*</span>
                    {{Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Enter Price per piece', 'step' => '0.0001', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('srp', 'SRP')}} <span class="text-danger">*</span>
                    {{Form::number('srp', '', ['class' => 'form-control', 'placeholder' => 'Enter SRP', 'step' => '0.0001', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('sold_by', 'Sold Per')}} <span class="text-danger">*</span>
                    {{Form::text('sold_by', '', ['class' => 'form-control', 'placeholder' => 'Piece, Pack, Kilogram, etc...'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('src', 'Source of Supply')}}
                    {{Form::text('src', '', ['class' => 'form-control', 'placeholder' => 'Enter Product\'s Source of Supply'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('contact', 'Contact Number')}}
                    {{Form::number('contact', '', ['class' => 'form-control', 'placeholder' => 'Enter Contact Number'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('exp', 'Expiration Date')}}
                    {{Form::date('exp', '', ['class' => 'form-control', 'placeholder' => 'Enter Expiration Date'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('stocks', 'Stocks')}} <span class="text-danger">*</span>
                    {{Form::number('stocks', '', ['class' => 'form-control', 'placeholder' => 'Enter No. of Stocks', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('pro', 'Procurement Level')}} <span class="text-danger">*</span>
                    {{Form::number('pro', '', ['class' => 'form-control', 'placeholder' => 'Enter Procurement Level', 'required' => 'required'])}}

                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    <label for="cover_image" class="control-label">Product Image</label>
                    {{Form::file('cover_image', ['class' => 'form-control'])}}

                    <div class="text-center mt-4">
                        {{Form::submit('Save', ['class' => 'btn btn-outline-primary'])}}
                    </div>

                </div>

            {!! Form::close() !!}

            <a href="/products" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

@endsection