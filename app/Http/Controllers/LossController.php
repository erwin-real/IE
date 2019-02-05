<?php

namespace App\Http\Controllers;

use App\Loss;
use App\User;
use Illuminate\Http\Request;
use App\Product;

class LossController extends Controller
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
            return view('pages.loss')
                ->with('losses', Loss::orderBy('created_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $product = Product::find($id);
            return ($product->stocks != 0) ? view('pages.losses.create')->with('product', $product) : redirect('/products');
        }
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
            $this->validate($request, [
                'quantity' => 'required',
                'reason' => 'required'
            ]);

            $loss = new Loss;
            $loss->product_id = $request->input('product_id');
            $loss->quantity = $request->input('quantity');
            $loss->reason = $request->input('reason');
            $loss->loss_money = $loss->product->srp * $loss->quantity;
            $loss->save();

            $product = Product::find($loss->product_id);
            $product->stocks = $product->stocks - $loss->quantity;
            $product->save();

            return redirect('/loss')->with('success', 'Loss Product Added');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            return view('pages.losses.show')
                ->with('loss', Loss::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.losses.edit')->with('loss', Loss::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $this->validate($request, [
                'quantity' => 'required',
                'reason' => 'required'
            ]);

            $loss = Loss::find($id);
            $loss->reason = $request->input('reason');

            $quantity = $request->input('quantity');
            $product = Product::find($loss->product_id);

            if($quantity > $loss->quantity) {
                $quantity -= $loss->quantity;
                $product->stocks -= $quantity;
            } else if($quantity < $loss->quantity) {
                $quantity = $loss->quantity - $quantity;
                $product->stocks += $quantity;
            }

            $loss->quantity = $request->input('quantity');
            $loss->loss_money = $loss->product->srp * $loss->quantity;
            $loss->save();
            $product->save();

            return redirect('/loss')->with('success', 'Loss Product Updated');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')){
            $loss = Loss::find($id);
            $loss->delete();

            return redirect('/loss')->with('success', 'Loss Product Deleted');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }
}
