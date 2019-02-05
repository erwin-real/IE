@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Loss Products' Guide</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/loss">Loss</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>

            <div>

                <h3>♦ Add loss products </h3>
                <div class="mx-2">
                    <ol>
                        <li>Go to <a href="/products">Products Page</a>.</li>
                        <li>Simply click the "Name" of the product.</li>
                        <li>Click the "Loss" button.</li>
                        <li>Enter the number of loss products in the "Quantity" field.</li>
                        <li>Enter also the reason of losing some products in the "Reason" field.</li>
                        <li>Click the "Save" button.</li>
                        <li>Finish!</li>
                    </ol>
                </div>

                <h3>♦ View specific loss product</h3>
                <div class="mx-2">
                    <ol>
                        <li>Go to <a href="/loss">Loss Products Page</a>.</li>
                        <li>Click the name of the loss product in the table.</li>
                        <li>Finish!</li>
                    </ol>
                </div>

                <h3>♦ Edit a loss product</h3>
                <div class="mx-2">
                    <ol>
                        <li>Go to <a href="/loss">Loss Products Page</a>.</li>
                        <li>Simply click the "Name" of the loss product in the table.</li>
                        <li>Click the "Edit" button.</li>
                        <li>Edit all desired fields. You can only update the "Quantity" and "Reason" fields.</li>
                        <li>Click the "Save" button.</li>
                        <li>Finish!</li>
                    </ol>
                </div>

                @if(Auth::user()->type == 'admin')
                    <h3>♦ Delete a loss product</h3>
                    <div class="mx-2">
                        <ol>
                            <li>Go to <a href="/products">Products Page</a>.</li>
                            <li>Simply click the "Name" of the loss product in the table.</li>
                            <li>Click the "Delete" button.</li>
                            <li>Click "OK" in the alertbox that will show up.</li>
                            <li>Finish!</li>
                        </ol>
                    </div>
                @endif

            </div>


        </div>
    </div>

@endsection