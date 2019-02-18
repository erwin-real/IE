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

    public function forecast() {
        if ($this->isUserType('admin'))
            return view('pages.reports.forecast');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function calculate(Request $request) {
        if ($this->isUserType('admin')) {
            $year = $request->input('year') + 3;
            $dates = [
                'Jan ' . $year, 'Feb ' . $year, 'Mar ' . $year,
                'Apr ' . $year, 'May ' . $year, 'Jun ' . $year,
                'Jul ' . $year, 'Aug ' . $year, 'Sept ' . $year,
                'Oct ' . $year, 'Nov ' . $year, 'Dec ' . $year
            ];

            $size4Raw = $request->input('size4');
            $size5Raw = $request->input('size5');

            $size4MAF = collect();
            $size5MAF = collect();

            $size4ESF = collect();
            $size5ESF = collect();

            $size4LRF = collect();
            $size5LRF = collect();

            $size4SF = collect();
            $size5SF = collect();

            $xy1 = collect();
            $xy2 = collect();
            $x2 = collect();

            $xTotal = 0.0;
            $y1Total = 0.0;
            $y2Total = 0.0;
            $xy1Total = 0.0;
            $xy2Total = 0.0;
            $x2Total = 0.0;

            $size4MAFSum = 0;
            $size5MAFSum = 0;

            $size4ESFSum = 0;
            $size5ESFSum = 0;

            $size4LRFSum = 0;
            $size5LRFSum = 0;

            $size4SFSum = 0;
            $size5SFSum = 0;

            $seasonalityIndex4 = collect();
            $seasonalityIndex5 = collect();


            for ($i = 0; $i < 12; $i++) {

                // Moving Average Forecast
                $size4MAF->push(ceil(($size4Raw[$i] + $size4Raw[$i + 12] + $size4Raw[$i + 24]) / 3));
                $size5MAF->push(ceil(($size5Raw[$i] + $size5Raw[$i + 12] + $size5Raw[$i + 24]) / 3));


                // Exponential Smoothing Forecast
                if ($i == 0) {
                    $size4ESF->push($size4Raw[$i + 24]);
                    $size5ESF->push($size5Raw[$i + 24]);
                } else {
                    $size4ESF->push(ceil((0.2 * $size4Raw[$i + 24]) + (0.8 * $size4ESF[$i - 1])));
                    $size5ESF->push(ceil((0.2 * $size5Raw[$i + 24]) + (0.8 * $size5ESF[$i - 1])));
                }


                // Linear Regression Forecasting
                $xy1->push((($size4Raw[$i + 24]) * ($i+1)));
                $xy2->push((($size5Raw[$i + 24]) * ($i+1)));

                $x2->push(($i+1)*($i+1));
                $xTotal += ($i+1);

                $y1Total += $size4Raw[$i + 24];
                $y2Total += $size5Raw[$i + 24];

                $xy1Total += $xy1[$i];
                $xy2Total += $xy2[$i];

                $x2Total += $x2[$i];
            }

            $xBar = ($xTotal/12);
            $y1Bar = ($y1Total/12);
            $y2Bar = ($y2Total/12);

            $b1 = ( ($xy1Total-(12*$xBar*$y1Bar))/($x2Total-(12*$xBar*$xBar)) );
            $b2 = ( ($xy2Total-(12*$xBar*$y2Bar))/($x2Total-(12*$xBar*$xBar)) );

            $a1 = ($y1Bar-($b1*$xBar));
            $a2 = ($y2Bar-($b2*$xBar));

            for ($i = 1; $i <= 12; $i++) {
                $size4LRF->push(ceil($a1+($b1*$i)));
                $size5LRF->push(ceil($a2+($b2*$i)));

                $size4MAFSum += $size4MAF[$i-1];
                $size5MAFSum += $size5MAF[$i-1];
            }

            for ($i = 0; $i < 12; $i++) {
                $seasonalityIndex4->push($size4MAF[$i]/ceil($size4MAFSum/12));
                $seasonalityIndex5->push($size5MAF[$i]/ceil($size5MAFSum/12));

                $size4SF->push(ceil($size4LRF[$i]*$seasonalityIndex4[$i]));
                $size5SF->push(ceil($size5LRF[$i]*$seasonalityIndex5[$i]));

                $size4ESFSum += $size4ESF[$i];
                $size5ESFSum += $size5ESF[$i];

                $size4LRFSum += $size4LRF[$i];
                $size5LRFSum += $size5LRF[$i];

                $size4SFSum += $size4SF[$i];
                $size5SFSum += $size5SF[$i];
            }

            $MAF4 = ceil(sqrt((2*$size4MAFSum*$request->input('ordering'))/$request->input('holding')));
            $MAF5 = ceil(sqrt((2*$size5MAFSum*$request->input('ordering'))/$request->input('holding')));

            $ESF4 = ceil(sqrt((2*$size4ESFSum*$request->input('ordering'))/$request->input('holding')));
            $ESF5 = ceil(sqrt((2*$size5ESFSum*$request->input('ordering'))/$request->input('holding')));

            $LTF4 = ceil(sqrt((2*$size4LRFSum*$request->input('ordering'))/$request->input('holding')));
            $LTF5 = ceil(sqrt((2*$size5LRFSum*$request->input('ordering'))/$request->input('holding')));

            $SF4 = ceil(sqrt((2*$size4SFSum*$request->input('ordering'))/$request->input('holding')));
            $SF5 = ceil(sqrt((2*$size5SFSum*$request->input('ordering'))/$request->input('holding')));

            $size4MAFAverage = ceil($size4MAFSum/12);
            $size5MAFAverage = ceil($size5MAFSum/12);

            $size4ESFAverage = ceil($size4ESFSum/12);
            $size5ESFAverage = ceil($size5ESFSum/12);

            $size4LRFAverage = ceil($size4LRFSum/12);
            $size5LRFAverage = ceil($size5LRFSum/12);

            $size4SFAverage = ceil($size4SFSum/12);
            $size5SFAverage = ceil($size5SFSum/12);

            $MAFNOY4 = ceil($size4MAFSum/$MAF4);
            $MAFNOY5 = ceil($size5MAFSum/$MAF5);

            $ESFNOY4 = ceil($size4ESFSum/$ESF4);
            $ESFNOY5 = ceil($size5ESFSum/$ESF5);

            $LTFNOY4 = ceil($size4LRFSum/$LTF4);
            $LTFNOY5 = ceil($size5LRFSum/$LTF5);

            $SFNOY4 = ceil($size4SFSum/$SF4);
            $SFNOY5 = ceil($size5SFSum/$SF5);

            $MAFOC4 = ceil(($MAF4/$size4MAFSum)*$request->input('days'));
            $MAFOC5 = ceil(($MAF5/$size5MAFSum)*$request->input('days'));

            $ESFOC4 = ceil(($ESF4/$size4ESFSum)*$request->input('days'));
            $ESFOC5 = ceil(($ESF5/$size5ESFSum)*$request->input('days'));

            $LTFOC4 = ceil(($LTF4/$size4LRFSum)*$request->input('days'));
            $LTFOC5 = ceil(($LTF5/$size5LRFSum)*$request->input('days'));

            $SFOC4 = ceil(($SF4/$size4SFSum)*$request->input('days'));
            $SFOC5 = ceil(($SF5/$size5SFSum)*$request->input('days'));

            $MAFRP4 = ceil(($size4MAFAverage/$request->input('days'))*$request->input('lead'));
            $MAFRP5 = ceil(($size5MAFAverage/$request->input('days'))*$request->input('lead'));

            $ESFRP4 = ceil(($size4ESFAverage/$request->input('days'))*$request->input('lead'));
            $ESFRP5 = ceil(($size5ESFAverage/$request->input('days'))*$request->input('lead'));

            $LTFRP4 = ceil(($size4LRFAverage/$request->input('days'))*$request->input('lead'));
            $LTFRP5 = ceil(($size5LRFAverage/$request->input('days'))*$request->input('lead'));

            $SFRP4 = ceil(($size4SFAverage/$request->input('days'))*$request->input('lead'));
            $SFRP5 = ceil(($size5SFAverage/$request->input('days'))*$request->input('lead'));

            $MAFSS4 = ceil((1.64*$request->input('lead'))*($size4MAFAverage/$request->input('days')));
            $MAFSS5 = ceil((1.64*$request->input('lead'))*($size5MAFAverage/$request->input('days')));

            $ESFSS4 = ceil((1.64*$request->input('lead'))*($size4ESFAverage/$request->input('days')));
            $ESFSS5 = ceil((1.64*$request->input('lead'))*($size5ESFAverage/$request->input('days')));

            $LTFSS4 = ceil((1.64*$request->input('lead'))*($size4LRFAverage/$request->input('days')));
            $LTFSS5 = ceil((1.64*$request->input('lead'))*($size5LRFAverage/$request->input('days')));

            $SFSS4 = ceil((1.64*$request->input('lead'))*($size4SFAverage/$request->input('days')));
            $SFSS5 = ceil((1.64*$request->input('lead'))*($size5SFAverage/$request->input('days')));

            $final = array(
                'MAF4' => $MAF4,
                'MAF5' => $MAF5,

                'ESF4' => $ESF4,
                'ESF5' => $ESF5,

                'LTF4' => $LTF4,
                'LTF5' => $LTF5,

                'SF4' => $SF4,
                'SF5' => $SF5,

                'MAFNOY4' => $MAFNOY4,
                'MAFNOY5' => $MAFNOY5,

                'ESFNOY4' => $ESFNOY4,
                'ESFNOY5' => $ESFNOY5,

                'LTFNOY4' => $LTFNOY4,
                'LTFNOY5' => $LTFNOY5,

                'SFNOY4' => $SFNOY4,
                'SFNOY5' => $SFNOY5,

                'MAFOC4' => $MAFOC4,
                'MAFOC5' => $MAFOC5,

                'ESFOC4' => $ESFOC4,
                'ESFOC5' => $ESFOC5,

                'LTFOC4' => $LTFOC4,
                'LTFOC5' => $LTFOC5,

                'SFOC4' => $SFOC4,
                'SFOC5' => $SFOC5,

                'MAFRP4' => $MAFRP4,
                'MAFRP5' => $MAFRP5,

                'ESFRP4' => $ESFRP4,
                'ESFRP5' => $ESFRP5,

                'LTFRP4' => $LTFRP4,
                'LTFRP5' => $LTFRP5,

                'SFRP4' => $SFRP4,
                'SFRP5' => $SFRP5,

                'MAFSS4' => $MAFSS4,
                'MAFSS5' => $MAFSS5,

                'ESFSS4' => $ESFSS4,
                'ESFSS5' => $ESFSS5,

                'LTFSS4' => $LTFSS4,
                'LTFSS5' => $LTFSS5,

                'SFSS4' => $SFSS4,
                'SFSS5' => $SFSS5
            );

            $data = array(
                'size4MAF' => $size4MAF,
                'size5MAF' => $size5MAF,

                'size4ESF' => $size4ESF,
                'size5ESF' => $size5ESF,

                'size4LRF' => $size4LRF,
                'size5LRF' => $size5LRF,

                'size4SF' => $size4SF,
                'size5SF' => $size5SF
            );

//            dd($year, $data, $final);

            $size4Chart = new MyChart;
            $size4Chart->labels($dates);
            $size4Chart->dataset('Moving Average Forecast', 'line', $data['size4MAF'])->options(['color' => '#ffc107']);
            $size4Chart->dataset('Exponential Smoothing Forecast', 'line', $data['size4ESF'])->options(['color' => '#6c757d']);
            $size4Chart->dataset('Linear Regression Forecasting', 'line', $data['size4LRF'])->options(['color' => '#38c172']);
            $size4Chart->dataset('Seasonality Forecasting', 'line', $data['size4SF'])->options(['color' => '#00f']);

            $size5Chart = new MyChart;
            $size5Chart->labels($dates);
            $size5Chart->dataset('Moving Average Forecast', 'line', $data['size5MAF'])->options(['color' => '#ffc107']);
            $size5Chart->dataset('Exponential Smoothing Forecast', 'line', $data['size5ESF'])->options(['color' => '#6c757d']);
            $size5Chart->dataset('Linear Regression Forecasting', 'line', $data['size5LRF'])->options(['color' => '#38c172']);
            $size5Chart->dataset('Seasonality Forecasting', 'line', $data['size5SF'])->options(['color' => '#00f']);


            return view('pages.reports.result')
                ->with('size4Chart', $size4Chart)
                ->with('size5Chart', $size5Chart)
                ->with('final', $final)
                ->with('year', $year);
        }
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
