<?php

namespace App\Http\Controllers;

use App\Charts\MyChart;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct() { $this->middleware('auth'); }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() { return view('dashboard')->with('chart', $this->chart()); }

    public function chart() {
        $chart = new MyChart;
        $chart->labels([0,1,2,3]);
        $chart->dataset('Total', 'line', [30,10,15,12])->options(['color' => '#3490dc']);
        $chart->dataset('Capital', 'line', [40,20,30,10])->options(['color' => '#6c757d']);
        $chart->dataset('Income', 'line', [15,60,45,50])->options(['color' => '#38c172']);
        return $chart;
    }


    //////////////////////////////////////////////////////////////////////////
    // RESET PASSWORD
    //////////////////////////////////////////////////////////////////////////

    public function showResetPasswordForm($id){
        if ($this->isUserType('admin')) {
            return view('auth.passwords.reset')
                ->with('user', User::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function resetPassword(Request $request){
        if ($this->isUserType('admin')) {
            $validatedData = $request->validate([ 'password' => 'required|string|min:6|confirmed' ]);
            //Change Password
            $user = User::find($request->get('id'));
            $user->password = bcrypt($validatedData['password']);
            $user->save();
            return redirect('/users')->with("success","Password changed successfully !");
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }


    public function products() { return view('pages.products.index'); }
    public function transactions() { return view('pages.transactions.index'); }
    public function procurement() { return view('pages.procurement.index'); }
    public function loss() { return view('pages.loss.index'); }
    public function reports() { return view('pages.reports.index')->with('chart', $this->chart()); }
}
