@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>{{$product->name}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->id}}</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/products/{{$product->id}}/edit" class="btn btn-outline-primary mt-1"><i class="fas fa-pencil-alt"></i> Edit</a>

                @if($product->stocks != 0)
                    <a href="/loss/create/{{$product->id}}" class="btn btn-outline-secondary mt-1"><i class="fas fa-exclamation-triangle"></i> Loss</a>
                @endif

                @if(Auth::user()->type == 'admin')
                    <form id="delete" method="POST" action="{{ action('ProductsController@destroy', $product->id) }}" class="float-right mt-1 ml-1">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                @endif
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-4 mt-4 panel-body">
                    <p><b>Name</b>: {{$product->name}}</p>
                    <p><b>Type</b>: {{$product->type}}</p>
                    <p><b>Desc</b>: {{$product->desc}}</p>
                    @if(Auth::user()->type == 'admin')
                        <p><b>Price</b>: {{$product->price}}</p>
                    @endif
                    <p><b>SRP</b>: {{$product->srp}}</p>
                    <p><b>Sold by</b>: {{$product->sold_by}}</p>
                    <p><b>Source</b>: {{$product->source}}</p>
                    <p><b>Contact</b>: {{$product->contact}}</p>
                    <p><b>Expiration Date</b>: {{date('D M d,Y', strtotime($product->expired_at))}}</p>
                    <p><b>Stocks</b>: {{$product->stocks}}</p>
                    <p><b>Procurement</b>: {{$product->procurement}}</p>
                    <p><b>Created at</b>: {{date('D M d,Y', strtotime($product->created_at))}}</p>
                    <p><b>Updated at</b>: {{date('D M d,Y', strtotime($product->updated_at))}}</p>
                </div>

                <div class="col-sm-12 col-md-8 mt-4 panel-body">
                    <img src="/storage/cover_images/{{$product->cover_image}}" alt="" style="width: 100%;
">
                </div>
            </div>

            <a href="/products" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#delete").on("submit", function () {
                return confirm("Are you sure you want to delete this product?");
            });
        });
    </script>

@endsection