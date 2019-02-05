<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\MyChart;
use App\Transaction;
use App\Loss;
//use DB;

class ReportsController extends Controller
{

    private $format;

    public function __construct() { $this->middleware('auth'); }
    
    public function index(Request $request) {
        if ($this->isUserType('admin')) {
            $type = ($request->input('type')) ? $request->input('type') : 'daily';
            $data = $this->getData($type);

            $chart = new MyChart;
            $chart->labels($data['dates']);
            $chart->dataset('Total', 'line', $data['totals'])->options(['color' => '#3490dc']);
            $chart->dataset('Capital', 'line', $data['capitals'])->options(['color' => '#6c757d']);
            $chart->dataset('Income', 'line', $data['incomes'])->options(['color' => '#38c172']);

            return view('pages.reports')
                ->with('chart', $chart)
                ->with('transactions', Transaction::all())
                ->with('losses', Loss::all())
                ->with('type', $type);
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function getData($type) {
        if ($type == 'daily') $this->format = 'D. M d, Y';
        else if ($type == 'weekly') $this->format = 'W Y';
        else if ($type == 'monthly') $this->format = 'M Y';
        else $this->format = 'Y';

        $groups = $this->period();

        $incomes = collect();
        $totals = collect();
        $capitals = collect();
        $dates = collect();

        foreach ($groups as $transactions) {
            $income = 0;
            $capital = 0;
            $total = 0;

            if ($type == 'weekly') $dates->push($transactions[0]->created_at->format('D. M d, Y'));
            else $dates->push($transactions[0]->created_at->format($this->format));

            foreach ($transactions as $transaction) {
                $income += $transaction->income;
                $capital += $transaction->capital;
                $total += $transaction->total;
            }
            $incomes->push($income);
            $totals->push($total);
            $capitals->push($capital);
        }

        return array(
            'dates' => $dates,
            'incomes' => $incomes,
            'totals' => $totals,
            'capitals' => $capitals,
        );
    }

    public function period() {
        return Transaction::orderBy('created_at','asc')->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format($this->format); // grouping by format w/ year
            });
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }

//    public function daily() {
//        $transactions = Transaction::all();
//        $date = new DateTime();
//        $days = Transaction::select(array(
//            DB::raw('DATE(`created_at`) as `date`'),
//            DB::raw('COUNT(*) as `count`')
//        ))->where('created_at', '<', $date)
//            ->groupBy('date')
//            ->orderBy('date', 'ASC')
//            ->pluck('count', 'date');
//
//        $incomes = collect();
//        $totals = collect();
//        $capitals = collect();
//        $dates = collect();
//
//        foreach($days as $date=>$count) {
//            $income = 0;
//            $capital = 0;
//            $total = 0;
//            foreach($transactions as $transaction) {
//                if($date === $transaction->created_at->format('Y-m-d')) {
//                    $income += $transaction->income;
//                    $capital += $transaction->capital;
//                    $total += $transaction->total;
//                }
//            }
//            $dates->push(Carbon::parse($date)->format('D M d,Y'));
//            $incomes->push($income);
//            $totals->push($total);
//            $capitals->push($capital);
//        }
//
//        return array(
//            'transactions' => $transactions,
//            'dates' => $dates,
//            'incomes' => $incomes,
//            'totals' => $totals,
//            'capitals' => $capitals,
//        );
//    }

}
