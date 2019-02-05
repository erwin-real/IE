<?php

namespace App\Http\Controllers;

use App\Track;
use App\User;
use Illuminate\Http\Request;
use App\Product;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
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
    public function index() {
        if ($this->isUserType('admin') || $this->isUserType('seller')){
            return view('pages.products')
                ->with('products', Product::sortable()->paginate(20))
                ->with('total', Product::all()->count());
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ($this->isUserType('admin')) return view('pages.products.create');

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
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
                'price' => 'required',
                'srp' => 'required',
                'stocks' => 'required',
                'pro' => 'required',
                'sold_by' => 'required',
                'cover_image' => 'image|nullable|max:1999'
            ]);

            //Handle File Upload
            if ($request->hasFile('cover_image')) {
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $fileNameToStore = $filename .'_'.time().'.'.$extension;
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            } else $fileNameToStore = 'noimage.jpg';

            $product = new Product;
            $product->name = $request->input('name');
            $product->type = $request->input('type');
            $product->desc = $request->input('desc');
            $product->price = $request->input('price');
            $product->srp = $request->input('srp');
            $product->sold_by = $request->input('sold_by');
            $product->source = $request->input('src');
            $product->contact = $request->input('contact');
            $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
            $product->procurement = $request->input('pro');
            $product->stocks = $request->input('stocks');
            $product->cover_image = $fileNameToStore;
            $product->save();

            $track = new Track;
            $track->product_id = $product->id;
            $track->name = $product->name;
            $track->product_type = $product->type;
            $track->desc = $product->desc;
            $track->updated = $product->stocks;
            $track->user_name = User::find(auth()->user()->id)->name;
            $track->date_modified = $product->updated_at;
            $track->save();

            return redirect('/products')->with('success', 'Product Added');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.show')->with('product', Product::find($id));

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
            return view('pages.products.edit')->with('product', Product::find($id));

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
                'name' => 'required',
                'type' => 'required',
                'srp' => 'required',
                'stocks' => 'required',
                'pro' => 'required',
                'sold_by' => 'required'
            ]);

            // Find Product instance
            $product = Product::find($id);

            // Initialize new Track model
            $track = new Track;
            $track->product_id = $id;
            $track->previous = $product->stocks;

            $product->name = $request->input('name');
            $product->type = $request->input('type');
            $product->desc = $request->input('desc');

            if (Auth::user()->type == 'admin') $product->price = $request->input('price');

            $product->srp = $request->input('srp');
            $product->sold_by = $request->input('sold_by');
            $product->source = $request->input('src');
            $product->contact = $request->input('contact');
            $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
            $product->procurement = $request->input('pro');
            $product->stocks = $request->input('stocks');

            //Handle File Upload
            if ($request->hasFile('cover_image')) {
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $fileNameToStore = $filename .'_'.time().'.'.$extension;
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
                $product->cover_image = $fileNameToStore;
            }

            $product->save();

            $track->name = $product->name;
            $track->product_type = $product->type;
            $track->desc = $product->desc;
            $track->updated = $product->stocks;
            $track->user_name = User::find(auth()->user()->id)->name;
            $track->date_modified = $product->updated_at;
            $track->save();

            return redirect('/products')->with('success', 'Product Updated');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminatsade\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $product = Product::find($id);

            if ($product->cover_image != 'noimage.jpg')
                Storage::delete('public/cover_images/'.$product->cover_image);

            foreach ($product->losses as $loss) $loss->delete();

            $product->delete();
            return redirect('/products')->with('success', 'Product Deleted');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function action(Request $request) {
        if ($request->ajax()) {
            $output='';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('products')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('type', 'like', '%'.$query.'%')
                        ->orWhere('desc', 'like', '%'.$query.'%')
                        ->orWhere('source', 'like', '%'.$query.'%')
                        ->orderBy('expired_at', 'desc')
                        ->get();
            } else {
                $data = DB::table('products')
                        ->orderBy('expired_at', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                    <tr id="product'. $row->id .'">
                        <td style="cursor:pointer;" onclick="window.location = \'/products/'. $row->id .'\'">'. $row->name .'</td>
                        <td>'. $row->type .'</td>
                        <td>'. $row->desc .'</td>
                        <td>'. $row->srp .'</td>
                        <td>'. $row->sold_by .'</td>
                        <td>'. $row->source .'</td>
                        <td>'. $row->contact .'</td>
                        <td>'
                    ;
                    
                    $output .= ($row->expired_at != null) ? date('D m-d-Y', strtotime($row->expired_at)) : 'N/A';
                    
                    $output .= '</td>
                        <td>'. $row->stocks .'</td>
                        <td>'. $row->procurement .'</td>
                    <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="15">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }

    public function transact(Request $request) {
        if ($request->ajax()) {
            $output='';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('products')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('desc', 'like', '%'.$query.'%')
                        ->orderBy('updated_at', 'desc')
                        ->get();
            } else {
                $data = DB::table('products')
                        ->orderBy('updated_at', 'desc')
                        ->get();
            }
            $data = $data->where('stocks', '>' , 0);
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                        <tr>
                            <td class="icons" onclick="
                                    addTransaction('.$row->id.', \''
                        .strval($row->name).'\', \''
                        .strval($row->desc).'\', \''
                        .strval($row->sold_by).'\', \''
                        .$row->srp.'\',  '
                        .$row->stocks.')
                                " style="cursor: pointer;">'. $row->name .'</td>
                            <td>'. $row->desc .'</td>
                            <td>'. $row->srp .'</td>
                            <td>'. $row->sold_by .'</td>
                            <td>'. $row->stocks .'</td>
                        <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="6">No Product Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }

    public function import() {
        if ($this->isUserType('admin'))
            return view('pages.products.import_csv');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function uploadCSVFile(Request $request) {
        if ($this->isUserType('admin')) {
            //validate the xls file
            $this->validate($request, array(
                'csv_file'      => 'required'
            ));

            if($request->hasFile('csv_file')){
                $extension = $request->file('csv_file')->getClientOriginalExtension();
                if ($extension === "xlsx" || $extension === "xls" || $extension === "csv") {

                    $path = $request->file('csv_file')->getRealPath();
                    $data = Excel::load($path, function($reader) {
                    })->get();
                    if(!empty($data) && $data->count()){

                        foreach ($data as $key => $value) {
                            try {
                                $product = Product::firstOrNew(['name'=>$value->name, 'type'=>$value->type, 'desc'=>$value->description]);

                                $track = new Track;
                                $track->product_id = $product->id;
                                $track->previous = $product->stocks;

                                $product->name = $value->name;
                                $product->type = $value->type;
                                $product->desc = $value->description;
                                $product->price = $value->price;
                                $product->srp = $value->srp;
                                $product->sold_by = $value->soldper ? $value->soldper : $value->sold_per;
                                $product->source = $value->source;
                                $product->contact = $value->contact;
                                $product->expired_at = ($value->expired_at == '') ? null : $value->expired_at;
                                $product->stocks += $value->stocks;
                                $product->procurement = $value->procurement;
                                $product->cover_image = $product->cover_image ? $product->cover_image : "noimage.jpg";
                                $product->save();

                                $track->name = $product->name;
                                $track->product_type = $product->type;
                                $track->desc = $product->desc;
                                $track->updated = $product->stocks;
                                $track->user_name = User::find(auth()->user()->id)->name;
                                $track->date_modified = $product->updated_at;
                                $track->save();

                            }catch (\Exception $ex) {
                                return redirect('/products/import')->with('error', 'Error inserting the data. Please check the values in the file before importing it.');
                            }catch (\Error $er) {
                                return redirect('/products/import')->with('error', 'Error inserting the data. Please check the values in the file before importing it.');
                            }
                        }

                        return redirect('/products')
                            ->with('success', 'Your products has successfully imported');
                    }

                    return back();

                }else {
                    return redirect('/products')
                        ->with('error', 'File is a '.$extension.' file.!! Please upload a valid xls/xlsx/csv file..!!');
                }
            }
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for searching a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.search');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function procurement() {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            return view('pages.procurement')
                ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get());
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function track() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.procurements.track')->with('tracks', Track::orderBy('date_modified','desc')->paginate(100));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function destroyTrack($id) {
        if ($this->isUserType('admin')) {
            $track = Track::find($id);
            $track->delete();
            return redirect('/procurement/track')->with('success', 'Track Product Deleted');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }
}
