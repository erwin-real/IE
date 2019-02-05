<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { $this->middleware('auth'); }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.guides.products');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function transactions() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.guides.transactions');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function loss() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.guides.loss');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function users() {
        if ($this->isUserType('admin'))
            return view('pages.guides.users');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }
}
