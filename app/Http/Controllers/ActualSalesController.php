<?php

namespace App\Http\Controllers;

use App\ActualSale;
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

    public function store(Request $request, $id) {
        if ($this->isUserType('admin')) {
            $forecast = Forecast::find($id);

            foreach ($forecast->actualSales as $item) {
                $item = ActualSale::find($item->id);
                $item->delete();
            }

            for ($i = 0; $i < 12; $i++) {
                $actualSale = new ActualSale;
                $actualSale->forecast_id = $id;
                $actualSale->year = $request->input('year');
                $actualSale->month = $i+1;
                $actualSale->size = 4;
                $actualSale->sale = $request->input('size4')[$i];
                $actualSale->save();

                $actualSale = new ActualSale;
                $actualSale->forecast_id = $id;
                $actualSale->year = $request->input('year');
                $actualSale->month = $i+1;
                $actualSale->size = 5;
                $actualSale->sale = $request->input('size5')[$i];
                $actualSale->save();
            }

            return redirect('/forecasts/sales/'.$id)
                ->with('forecast', $forecast)
                ->with('success', 'Added Actual Sales for year '. $request->input('year') .' Successfully');
        }


        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function edit($id) {
        if ($this->isUserType('admin'))
            return view('pages.sales.edit')
                ->with('forecast', Forecast::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function update(Request $request, $id) {
        if ($this->isUserType('admin')) {
            $forecast = Forecast::find($id);

            foreach ($forecast->actualSales as $item) {
                $item = ActualSale::find($item->id);
                $item->delete();
            }

            for ($i = 0; $i < 12; $i++) {
                $actualSale = new ActualSale;
                $actualSale->forecast_id = $id;
                $actualSale->year = $request->input('year');
                $actualSale->month = $i+1;
                $actualSale->size = 4;
                $actualSale->sale = $request->input('size4')[$i];
                $actualSale->save();

                $actualSale = new ActualSale;
                $actualSale->forecast_id = $id;
                $actualSale->year = $request->input('year');
                $actualSale->month = $i+1;
                $actualSale->size = 5;
                $actualSale->sale = $request->input('size5')[$i];
                $actualSale->save();
            }

            return redirect('/forecasts/sales/'.$id)
                ->with('forecast', $forecast)
                ->with('success', 'Updated Actual Sales for year '. $request->input('year') .' Successfully');
        }


        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $forecast = Forecast::find($id);

            foreach ($forecast->actualSales as $item) {
                $item = ActualSale::find($item->id);
                $item->delete();
            }

            return redirect('/forecasts/sales/'.$forecast->id)->with('success', 'Deleted Actual Sales for year '.($forecast->year + 3).' Successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }
}
