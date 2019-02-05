<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(odd) {background-color: #f2f2f2;}
    th {
        background-color: #4CAF50;
        color: white;
        font-weight: bolder;
    }
</style>
<body>
<div style="float: right;">
    <h1>RECEIPT</h1>
</div>
<div style="">
    <h2>2VE General Merchandise</h2>
    <h4>(Office Supplies & Convenient Store)</h4>
</div>

<div style="margin-top: 30px;">
    <h4>Date: <b>{{date('D M d, Y', strtotime($transaction->created_at))}}</b></h4>
    <h4 style="margin-bottom: 50px;">Time: <b>{{date('H:i', strtotime($transaction->created_at))}}</b></h4>
    <div class="card-body mt-2" style="overflow-x: auto;">
        <table class="table table-hover table-responsive-lg">
            <tr>
                <th>Product Name</th>
                <th>Type</th>
                <th>Description | Sold per</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
            @foreach($transaction->singleTransactions as $singleTransaction)
                <tr>
                    <td>{{ $singleTransaction->name }}</td>
                    <td>{{ $singleTransaction->type }}</td>
                    <td>{{ $singleTransaction->desc}}</td>
                    <td>{{ $singleTransaction->quantity}}</td>
                    <td>{{ $singleTransaction->orig_srp}}</td>
                    <td>{{ $singleTransaction->total}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div style="margin-top: 20px; float: right;">
        <h4><b>Total: P {{$transaction->total}}</b></h4>
        <h4><b>Money Received: P {{$transaction->money_received}}</b></h4>
        <h4><b>Change: P {{$transaction->change}}</b></h4>
    </div>
</div>

</body>