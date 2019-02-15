<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\MyChart;
use App\Transaction;
//use DB;

class ReportsController extends Controller
{

    private $format;

    public function __construct() { $this->middleware('auth'); }

    public function test() {
        if ($this->isUserType('admin'))
            return view('pages.reports.test');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function calculate(Request $request) {
            $year = $request->input('year') + 2;
            $dates = [
                'Jan '.$year, 'Feb '.$year, 'Mar '.$year,
                'Apr '.$year, 'May '.$year, 'Jun '.$year,
                'Jul '.$year, 'Aug '.$year, 'Sept '.$year,
                'Oct '.$year, 'Nov '.$year, 'Dec '.$year
            ];

            $size4Raw = $request->input('size4');
            $size5Raw = $request->input('size5');

//            $average4 = 0;
//            for ($i = 3; $i < 15; $i++) $average4 += $size4Raw[$i];

            $size4MAF = collect();
            $size5MAF = collect();
            $size4ESF = collect();
//            $size4SF = collect();
            for ($i = 0; $i < 12; $i++) {
                $size4MAF->push(($size4Raw[$i] + $size4Raw[$i+1] + $size4Raw[$i+2]) / 3);
                $size5MAF->push(($size5Raw[$i] + $size5Raw[$i+1] + $size5Raw[$i+2]) / 3);
                if ($i == 0) $size4ESF->push($size4Raw[$i+3] + 0);
                else $size4ESF->push(ceil((0.2*$size4Raw[$i+3]) + (0.8*$size4ESF[$i-1])));
//                $size4SF->push(ceil(($size4Raw[$i+3] / (($average4)/12))*));
            }
            $data = array(
                'size4MAF' => $size4MAF,
                'size4ESF' => $size4ESF
//                'size4SF' => $size4SF
            );

//            dd($request, $size4, $size5, $size4ESF);

            $chart = new MyChart;
            $chart->labels($dates);
            $chart->dataset('Moving Average Forecast 3 Months', 'line', $data['size4MAF'])->options(['color' => '#3490dc']);
            $chart->dataset('Exponential Smoothing Forecast', 'line', $data['size4ESF'])->options(['color' => '#6c757d']);
//            $chart->dataset('Capital', 'line', $data['capitals'])->options(['color' => '#6c757d']);
//            $chart->dataset('Income', 'line', $data['incomes'])->options(['color' => '#38c172']);

            return view('pages.reports.result')
                ->with('chart', $chart);
//                ->with('transactions', Transaction::all())

    }

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
            'capitals' => $capitals
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
