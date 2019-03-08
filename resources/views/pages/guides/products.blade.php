@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Product's Guide</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>

            <div class="container-fluid">
                <div class="row">

                    <div class=" col-md-5">

                        <h3>♦ Add new product</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Click the "Add" button.</li>
                                <li>Fill all the fields needed, especially those who has red asterisk (<span class="text-danger">*</span>).</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Search products</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Click the "Search" button.</li>
                                <li>Type anything in the search field.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        @if(Auth::user()->type == 'admin')
                            <h3>♦ Import a file</h3>
                            <div class="mx-2">
                                <ol>
                                    <li>Go to <a href="/products">Products Page</a>.</li>
                                    <li>Click the "Import File" button.</li>
                                    <li>Please do read the guidelines before importing a file.</li>
                                    <li>Click the "Choose File" button.</li>
                                    <li>Select the excel file that you want to import.</li>
                                    <li>Click the "Submit" button.</li>
                                    <li>Finish!</li>
                                </ol>
                            </div>
                        @endif

                        <h3>♦ Add/Update an image for a product</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Simply click the "Name" of the product in the table.</li>
                                <li>Click the "Edit" button.</li>
                                <li>Click the "Choose File" button of the last field.</li>
                                <li>Select the image appropriate for the product. The size of the image file should be less than or equalt to 2 MB.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                    <div class="col-md-5 offset-md-1">

                        <h3>♦ View a product</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Simply click the "Name" of the product in the table.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Edit a product</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Simply click the "Name" of the product in the table.</li>
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
                                    <li>Go to <a href="/products">Products Page</a>.</li>
                                    <li>Simply click the "Name" of the product in the table.</li>
                                    <li>Click the "Delete" button.</li>
                                    <li>Click "OK" in the alertbox that will show up.</li>
                                    <li>Finish!</li>
                                </ol>
                            </div>
                        @endif

                        <h3>♦ Sort products</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/products">Products Page</a>.</li>
                                <li>Simply click the column's name in the table to sort products in ascending/descending order.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection