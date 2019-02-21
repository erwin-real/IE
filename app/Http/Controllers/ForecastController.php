<?php

namespace App\Http\Controllers;

use App\Charts\MyChart;
use App\Forecast;
use App\SingleForecast;
use App\User;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ($this->isUserType('admin'))
            return view('pages.forecasts')->with('forecasts', Forecast::all());

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ($this->isUserType('admin'))
            return view('pages.forecasts.create');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($this->isUserType('admin')) {

            $size4Raw = $request->input('size4');
            $size5Raw = $request->input('size5');
            $year = $request->input('year');

            $forecast = new Forecast;
            $forecast->year = $year;
            $forecast->lead = $request->input('lead');
            $forecast->days = $request->input('days');
            $forecast->ordering = $request->input('ordering');
            $forecast->holding = $request->input('holding');
            $forecast->save();

            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 12; $j++) {
                    $singleForecast = new SingleForecast;
                    $singleForecast->forecast_id = $forecast->id;
                    $singleForecast->year = $year + $i;
                    $singleForecast->month = $j + 1;
                    $singleForecast->size = 4;
                    $singleForecast->demand = $size4Raw[($j + ($i * 12))];
                    $singleForecast->save();

                    $singleForecast = new SingleForecast;
                    $singleForecast->forecast_id = $forecast->id;
                    $singleForecast->year = $year + $i;
                    $singleForecast->month = $j + 1;
                    $singleForecast->size = 5;
                    $singleForecast->demand = $size5Raw[($j + ($i * 12))];
                    $singleForecast->save();
                }
            }

            $data = $this->calculate(
                $size4Raw, $size5Raw, $request->input('ordering'),
                $request->input('holding'), $request->input('days'),
                $request->input('lead'), ($year + 3)
            );

            return view('pages.forecasts.show')
                ->with('size4Chart', $data['size4Chart'])
                ->with('size5Chart', $data['size5Chart'])
                ->with('final', $data['final'])
                ->with('year', $data['year'])
                ->with('forecast', $forecast)
                ->with('success', 'Saved Forecast Successfully!');

        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin')) {
            $size4Raw = array();
            $size5Raw = array();
            $forecast = Forecast::find($id);
            $singleForecasts = $forecast->singleForecasts;

            for ($i = 0; $i < count($singleForecasts); $i++) {
                if ($i % 2 == 0) array_push($size4Raw, $singleForecasts[$i]->demand);
                else array_push($size5Raw, $singleForecasts[$i]->demand);
            }

            $data = $this->calculate(
                $size4Raw, $size5Raw, $forecast->ordering,
                $forecast->holding, $forecast->days,
                $forecast->lead, ($forecast->year + 3)
            );

            return view('pages.forecasts.show')
                ->with('size4Chart', $data['size4Chart'])
                ->with('size5Chart', $data['size5Chart'])
                ->with('final', $data['final'])
                ->with('year', $data['year'])
                ->with('forecast', $forecast);
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
        if ($this->isUserType('admin')) {
            $size4Raw = array();
            $size5Raw = array();
            $forecast = Forecast::find($id);
            $singleForecasts = $forecast->singleForecasts;

            for ($i = 0; $i < count($singleForecasts); $i++) {
                if ($i % 2 == 0) array_push($size4Raw, $singleForecasts[$i]->demand);
                else array_push($size5Raw, $singleForecasts[$i]->demand);
            }

            return view('pages.forecasts.edit')
                ->with('forecast', $forecast)
                ->with('size4Raw', $size4Raw)
                ->with('size5Raw', $size5Raw);
        }

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
        if ($this->isUserType('admin')){

            $size4Raw = $request->input('size4');
            $size5Raw = $request->input('size5');
            $year = $request->input('year');

            $forecast = Forecast::find($id);
            $forecast->year = $year;
            $forecast->lead = $request->input('lead');
            $forecast->days = $request->input('days');
            $forecast->ordering = $request->input('ordering');
            $forecast->holding = $request->input('holding');
            $forecast->save();

            foreach ($forecast->singleForecasts as $singleForecast) {
                $singleForecast = SingleForecast::find($singleForecast->id);
                $singleForecast->delete();
            }

            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 12; $j++) {
                    $singleForecast = new SingleForecast;
                    $singleForecast->forecast_id = $forecast->id;
                    $singleForecast->year = $year + $i;
                    $singleForecast->month = $j + 1;
                    $singleForecast->size = 4;
                    $singleForecast->demand = $size4Raw[($j + ($i * 12))];
                    $singleForecast->save();

                    $singleForecast = new SingleForecast;
                    $singleForecast->forecast_id = $forecast->id;
                    $singleForecast->year = $year + $i;
                    $singleForecast->month = $j + 1;
                    $singleForecast->size = 5;
                    $singleForecast->demand = $size5Raw[($j + ($i * 12))];
                    $singleForecast->save();
                }
            }

            $data = $this->calculate(
                $size4Raw, $size5Raw, $request->input('ordering'),
                $request->input('holding'), $request->input('days'),
                $request->input('lead'), ($year + 3)
            );

            return view('pages.forecasts.show')
                ->with('size4Chart', $data['size4Chart'])
                ->with('size5Chart', $data['size5Chart'])
                ->with('final', $data['final'])
                ->with('year', $data['year'])
                ->with('forecast', $forecast)
                ->with('success', 'Forecast Updated Successfully!');
        }


        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $forecast = Forecast::find($id);

            foreach ($forecast->singleForecasts as $singleForecast) {
                $singleForecast = SingleForecast::find($singleForecast->id);
                $singleForecast->delete();
            }

            $forecast->delete();
            return redirect('/forecasts')->with('success', 'Deleted forecast successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }


    public function calculate($size4Raw, $size5Raw, $ordering, $holding, $days, $lead, $year) {
        if ($this->isUserType('admin')) {
            $dates = [
                'Jan ' . $year, 'Feb ' . $year, 'Mar ' . $year,
                'Apr ' . $year, 'May ' . $year, 'Jun ' . $year,
                'Jul ' . $year, 'Aug ' . $year, 'Sept ' . $year,
                'Oct ' . $year, 'Nov ' . $year, 'Dec ' . $year
            ];

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

            $MAF4 = ceil(sqrt((2*$size4MAFSum*$ordering)/$holding));
            $MAF5 = ceil(sqrt((2*$size5MAFSum*$ordering)/$holding));

            $ESF4 = ceil(sqrt((2*$size4ESFSum*$ordering)/$holding));
            $ESF5 = ceil(sqrt((2*$size5ESFSum*$ordering)/$holding));

            $LTF4 = ceil(sqrt((2*$size4LRFSum*$ordering)/$holding));
            $LTF5 = ceil(sqrt((2*$size5LRFSum*$ordering)/$holding));

            $SF4 = ceil(sqrt((2*$size4SFSum*$ordering)/$holding));
            $SF5 = ceil(sqrt((2*$size5SFSum*$ordering)/$holding));

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

            $MAFOC4 = ceil(($MAF4/$size4MAFSum)*$days);
            $MAFOC5 = ceil(($MAF5/$size5MAFSum)*$days);

            $ESFOC4 = ceil(($ESF4/$size4ESFSum)*$days);
            $ESFOC5 = ceil(($ESF5/$size5ESFSum)*$days);

            $LTFOC4 = ceil(($LTF4/$size4LRFSum)*$days);
            $LTFOC5 = ceil(($LTF5/$size5LRFSum)*$days);

            $SFOC4 = ceil(($SF4/$size4SFSum)*$days);
            $SFOC5 = ceil(($SF5/$size5SFSum)*$days);

            $MAFRP4 = ceil(($size4MAFAverage/$days)*$lead);
            $MAFRP5 = ceil(($size5MAFAverage/$days)*$lead);

            $ESFRP4 = ceil(($size4ESFAverage/$days)*$lead);
            $ESFRP5 = ceil(($size5ESFAverage/$days)*$lead);

            $LTFRP4 = ceil(($size4LRFAverage/$days)*$lead);
            $LTFRP5 = ceil(($size5LRFAverage/$days)*$lead);

            $SFRP4 = ceil(($size4SFAverage/$days)*$lead);
            $SFRP5 = ceil(($size5SFAverage/$days)*$lead);

            $MAFSS4 = ceil((1.64*$lead)*($size4MAFAverage/$days));
            $MAFSS5 = ceil((1.64*$lead)*($size5MAFAverage/$days));

            $ESFSS4 = ceil((1.64*$lead)*($size4ESFAverage/$days));
            $ESFSS5 = ceil((1.64*$lead)*($size5ESFAverage/$days));

            $LTFSS4 = ceil((1.64*$lead)*($size4LRFAverage/$days));
            $LTFSS5 = ceil((1.64*$lead)*($size5LRFAverage/$days));

            $SFSS4 = ceil((1.64*$lead)*($size4SFAverage/$days));
            $SFSS5 = ceil((1.64*$lead)*($size5SFAverage/$days));

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

            return array(
                'size4Chart' => $size4Chart,
                'size5Chart' => $size5Chart,
                'final' => $final,
                'year' => $year,
            );

//            return view('pages.forecasts.show')
//                ->with('size4Chart', $size4Chart)
//                ->with('size5Chart', $size5Chart)
//                ->with('final', $final)
//                ->with('year', $year);
        }
    }


    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }
}
