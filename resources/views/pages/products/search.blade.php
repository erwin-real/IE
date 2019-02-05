@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Search</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>

            <div class="mt-4 panel-body">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Product">
                </div>

                <div class="lists-table table-responsive mt-3">
                    <h4 align="center">Total Product: <span id="total_records"></span></h4>
                    <table class="table table-hover table-striped py-3 text-center">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Description</th>
                                <th scope="col">SRP</th>
                                <th scope="col">Sold per</th>
                                <th scope="col">Source</th>
                                <th scope="col">Contact #</th>
                                <th scope="col">Expiration Date</th>
                                <th scope="col">Stocks</th>
                                <th scope="col">Procurement</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="/products" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            fetch_product_data();

            function fetch_product_data(query = '') {
                $.ajax({
                url:"{{ route('products.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                    {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    },error:function(data) {
                    console.log(data);
                }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_product_data(query);
            });

        });

    </script>

@endsection