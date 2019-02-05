@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Import File</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Import File</li>
                </ol>
            </nav>

            @include('includes.messages')

            {!! Form::open(['action' => 'ProductsController@uploadCSVFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    <div class="alert alert-danger">
                        <p>
                            <span class="font-weight-bold">Please read and follow these guides before importing a file:</span>
                            <ol class="">
                                <li>The file must be in <span class="font-weight-bold">.csv</span> or
                                    <span class="font-weight-bold">.xls</span> or
                                    <span class="font-weight-bold">.xlsx</span> file extension.</li>
                                <li>The file must have all the following columns:
                                    <ol>
                                        <li>Name, Type, Description, Price, SRP, Sold per, Source, Contact, Expired at, Stocks, Procurement</li>
                                    </ol>
                                </li>
                                <li>The <span class="font-weight-bold">"Expired at"</span> column in the file must have a date format of
                                    <span class="font-weight-bold">yyyy-mm-dd</span>. Example: 2020-04-15</li>
                                <li>If a product in the file has the same
                                    <span class="font-weight-bold">"Name", "Type", and "Description"</span> in the
                                    records of products, the product will only increase in the number of
                                    <span class="font-weight-bold">stocks.</span></li>
                                <li>You can add the image of the product individually after importing the file.</li>
                            </ol>
                        </p>
                    </div>
                    <label for="csv_file" class="col-md-4 control-label">Upload File <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        {{Form::file('csv_file', ['class' => 'form-control', 'required'])}}
                    </div>

                    <div class="text-left ml-3 mt-4">
                        {{Form::submit('Submit', ['class' => 'btn btn-outline-success'])}}
                    </div>
                </div>

            {!! Form::close() !!}

            <a href="/products" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

@endsection