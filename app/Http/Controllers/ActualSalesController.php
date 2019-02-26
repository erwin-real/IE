<?php

namespace App\Http\Controllers;

use App\Forecast;
use App\User;
use Illuminate\Http\Request;

class ActualSalesController extends Controller
{

    public function show($id) {
        if ($this->isUserType('admin'))
            return view('pages.sales.show')->with('forecast', Forecast::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function create($id) {
        if ($this->isUserType('admin')) {
            $forecast = Forecast::find($id);
            return view('pages.sales.create')
                ->with('forecast', $forecast)
                ->with('seasons', $forecast->seasons);
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function store(Request $request) {
        dd($request);
    }

    public function edit($id) {
        if ($this->isUserType('admin'))
            return view('pages.sales.edit')->with('forecasts', Forecast::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }
}
