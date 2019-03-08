@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Contact Lists</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/products/create" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> Add Product</a>
                <a href="/contacts/import" class="btn btn-outline-primary mt-1"><i class="fas fa-file-alt"></i> Import CSV File</a>
            </div>

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stocks Remaining</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <th colspan="6">No lists found</th>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection