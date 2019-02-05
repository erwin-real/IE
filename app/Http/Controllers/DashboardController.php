<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\MyChart;
use App\Product;
use App\User;
use App\Transaction;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ($this->isUserType('admin')) {
            return view('dashboard')
                ->with('transactions', Transaction::all())
                ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get())
                ->with('chart', $this->createChart());
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }
    
    public function createChart() {
        $data = app('App\Http\Controllers\ReportsController')->getData('daily');

        $chart = new MyChart;
        $chart->labels(array_slice($data['dates']->toArray(), -7));
        $chart->dataset('Total', 'line', array_slice($data['totals']->toArray(), -7))->options(['color' => '#3490dc',]);
        $chart->dataset('Capital', 'line', array_slice($data['capitals']->toArray(), -7))->options(['color' => '#6c757d',]);
        $chart->dataset('Income', 'line', array_slice($data['incomes']->toArray(), -7))->options(['color' => '#38c172',]);

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


    //////////////////////////////////////////////////////////////////////////
    // USERS
    //////////////////////////////////////////////////////////////////////////

    public function users() {
        if ($this->isUserType('admin')) {
            return view('pages.users.users')
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(10));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function addUser() {
        if ($this->isUserType('admin'))
            return view('pages.users.create');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function saveUser(Request $request) {
        if ($this->isUserType('admin')) {

            $validatedData = $request->validate([
                'name' => 'required',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $user = new User(array(
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']),
                'remember_token' => $request->get('_token')
            ));

            if ($request->get('email') == null) $user->email = null;
            else {
                $validateEmail = $request->validate([ 'email' => 'max:255|unique:users' ]);
                $user->email = $validateEmail['email'];
            }

            $user->type = 'seller';
            $user->save();

            return redirect('/users')
                ->with('success', 'Added new user '. $validatedData['name'])
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function showUser($id) {
        if ($this->isUserType('admin'))
            return view('pages.users.show')->with('user', User::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function editUser($id) {
        if ($this->isUserType('admin')) {
            return view('pages.users.edit')
                ->with('user', User::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function updateUser(Request $request, $id) {
        if ($this->isUserType('admin')) {
            $user = User::find($id);

            if ($request->get('email') != $user->email && $request->get('username') != $user->username) {
                $validatedData = $request->validate([
                    'email' => 'string|email|max:255|unique:users',
                    'username' => 'required|string|max:255|unique:users'
                ]);
                $user->email = $validatedData['email'];
                $user->username = $validatedData['username'];
            } else if ($request->get('email') != $user->email) {
                $validatedData = $request->validate([ 'email' => 'string|email|max:255|unique:users' ]);
                $user->email = $validatedData['email'];
            } else if ($request->get('username') != $user->username) {
                $validatedData = $request->validate([ 'username' => 'required|string|max:255|unique:users' ]);
                $user->username = $validatedData['username'];
            }

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->remember_token = $request->get('_token');

            $user->save();

            return redirect('/users')
                ->with('success', 'Updated user '. $user->name)
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function destroyUser($id) {
        if ($this->isUserType('admin')) {
            $user = User::find($id);
            $user->delete();

            return redirect('/users')
                ->with('success', 'Deleted user ' . $user->name)
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }

}
