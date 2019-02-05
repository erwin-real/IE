@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Transaction's Guide</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/transactions">Transactions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>

            <div>

                <h3>♦ Create new transaction</h3>
                <div class="mx-2">
                    <ol>
                        <li>Go to <a href="/transactions">Transactions Page</a>.</li>
                        <li>Click the "New Transaction" button.</li>
                        <li>Go to Products' section.</li>
                        <li>Search products by filling the search field.</li>
                        <li>To add the products to the Transaction Summary, just click the name of the products.</li>
                        <li>After selecting all products in the Products' section, go to Transactions' section</li>
                        <li>Input the quantity that was/will be sold to each product.</li>
                        <li>Input the value of money, that the customer gave, in the "Money" field.</li>
                        <li>Click the "Save" button.</li>
                        <li>Click "OK" in the alertbox that will show up.</li>
                        <li>Finish!</li>
                    </ol>
                    <span>*To delete a product in the Transaction summary, simply click the name of the product.</span>
                </div>

                <h3 class="mt-4">♦ View specific transaction</h3>
                <div class="mx-2">
                    <ol>
                        <li>Go to <a href="/transactions">Transactions Page</a>.</li>
                        <li>Click the specific date for the transaction in the table.</li>
                        <li>Finish!</li>
                    </ol>
                </div>

                @if(Auth::user()->type == 'admin')
                    <h3>♦ Delete a transaction</h3>
                    <div class="mx-2">
                        <ol>
                            <li>Go to <a href="/transactions">Transactions Page</a>.</li>
                            <li>Click the specific date for the transaction in the table.</li>
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