@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                @if(Auth::user()->type == 'admin')
                <a href="/products/create" class="btn btn-outline-primary mt-1"><i class="fas fa-plus"></i> Add</a>
                @endif
                <a href="/products/search" class="btn btn-outline-primary mt-1"><i class="fas fa-search"></i> Search</a>
                @if(Auth::user()->type == 'admin')
                    <a href="/products/import" class="btn btn-outline-primary mt-1"><i class="fas fa-file-alt"></i> Import File</a>
                @endif
                <a href="/guide/products" class="btn btn-outline-dark mt-1"><i class="fas fa-info-circle"></i> Guide</a>
            </div>

            <div class="lists-table table-responsive mt-3">
            <h4>Total: {{$total}}</h4>
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">@sortablelink('name', 'Name',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('type', 'Type',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('desc', 'Description',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>

                            @if(Auth::user()->type == 'admin')
                                <th scope="col">@sortablelink('price', 'Price',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            @endif

                            <th scope="col">@sortablelink('srp', 'SRP',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('sold_by', 'Sold per',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('source', 'Source',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('expired_at', 'Expiration Date',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('stocks', 'Stocks',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('procurement', 'Procurement',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                <tr>
                                    <td><a href="/products/{{$product->id}}">{{$product->name}}</a></td>
                                    <td>{{$product->type}}</td>
                                    <td>{{$product->desc}}</td>

                                    @if(Auth::user()->type == 'admin')
                                        <td>{{$product->price}}</td>
                                    @endif

                                    <td>{{$product->srp}}</td>
                                    <td>{{$product->sold_by}}</td>
                                    <td>{{$product->source}}</td>
                                    @if($product->expired_at != null)
                                        <td>{{date('D M d,Y', strtotime($product->expired_at))}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{$product->stocks}}</td>
                                    <td>{{$product->procurement}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="10">No products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
                {!! $products->appends(\Request::except('page'))->render() !!}
            </div>

        </div>
    </div>

@endsection