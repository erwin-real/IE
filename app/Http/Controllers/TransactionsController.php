<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Product;
use PDF;
use App\SingleTransaction;
use App\Transaction;

class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            return view('pages.transactions')
                ->with('transactions', Transaction::orderBy('created_at', 'desc')->paginate(20));
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.transactions.create');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $capital = 0;
            $income = 0;

            $transaction = new Transaction;
            $transaction->total = $request->get('total');
            $transaction->money_received = $request->get('money');
            $transaction->change = $request->get('change');
            $transaction->capital = $capital;
            $transaction->income = $income;
            $transaction->save();

            foreach ($request->get('transactions') as $transac) {
                $singleTransaction = new SingleTransaction;
                $singleTransaction->transaction_id = $transaction->id;
                $singleTransaction->product_id = $transac['product_id'];
                $singleTransaction->quantity = $transac['quantity'];
                $singleTransaction->total = $transac['subtotal'];
                $singleTransaction->capital = $transac['quantity'] * $singleTransaction->product->price;
                $singleTransaction->income = $transac['subtotal'] - $singleTransaction->capital;
                $singleTransaction->orig_price = $singleTransaction->product->price;
                $singleTransaction->orig_srp = $singleTransaction->product->srp;

                $product = Product::find($singleTransaction->product_id);
                $singleTransaction->name = $product->name;
                $singleTransaction->type = $product->type;
                $singleTransaction->desc = $product->desc . " | " . $product->sold_by;
                $singleTransaction->save();
                $product->stocks -= $singleTransaction->quantity;
                $product->save();

                $capital += $singleTransaction->capital;
                $income += $singleTransaction->income;
            }

            $transaction = Transaction::find($transaction->id);
            $transaction->capital = $capital;
            $transaction->income = $income;
            $transaction->save();

            $data = array(
                'text' => "success",
                'id' => $transaction->id
            );

            return json_encode($data);
        }


        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.transactions.single')->with('transaction', Transaction::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')){
            $transaction = Transaction::find($id);
            $transaction->delete();

            return redirect('/transactions')->with('success', 'Transaction Deleted');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function get(Request $request) {
        if ($request->ajax()) return $this->store($request);
    }

    public function success() {
        if ($this->isUserType('admin') || $this->isUserType('seller')){
            return view('pages.transactions')
                ->with('success', 'Added Transaction Successfully')
                ->with('transactions', Transaction::orderBy('created_at', 'desc')->paginate(15));
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function export($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $transaction = Transaction::find($id);
            $pdf = PDF::loadView('pages.transactions.export',
                compact('transaction'));
            return $pdf->stream($transaction->created_at.'.pdf');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }
}
