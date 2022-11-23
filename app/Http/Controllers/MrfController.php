<?php

namespace App\Http\Controllers;

use App\Http\Services\GoogleSheetsServices;
use App\Models\mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MrfController extends Controller
{
    public function rentalIndex(){

        $brands = DB::table('brands')->orderBy('name', 'asc')->get();
        $models = DB::table('brand_models')->where('brand_id', $brands[0]->id)->orderBy('name', 'asc')->get();

        return view('create-mrf/for-rental-unit', compact('brands', 'models'));
    }

    public function rentalGetModel(Request $request){
        $brand = $request->brandVal;
        $models = DB::table('brand_models')->where('brand_id', $brand)->orderBy('name', 'asc')->get();

        $output = '';

        if($models->count() > 0){
            foreach($models as $model){
                $output .= '<option value="'.$model->id.'">'.$model->name.'</option>';
            }
        }else{
            $output = '<option class="hidden">No Data</option>';
        }

        echo $output;
    }

    public function store(Request $request){
        $area = auth()->user()->area;
        $cus_name = $request->cus_name;
        $cus_add = $request->cus_address;
        $fleet_no = $request->fleet_no;
        $brand = $request->brand;
        $model = $request->model;
        $serial_no = $request->serial_no;
        $fsrr_no = $request->fsrr_no;
        $delivery_type = $request->delivery_type;
        $remarks = $request->site_remarks;
        $request_for = $request->req_for;
        $order_type = $request->order_type;
        $date_needed = date("Y-m-d", strtotime($request->date_needed));
        
        if($brand == 1){
            $brandName = 'TOYOTA';
        }else if($brand == 2){
            $brandName = 'BT';
        }else if($brand == 3){
            $brandName = 'RAYMOND';
        }

        $request->validate([
            'cus_name' => 'required',
            'cus_address' => 'required',
            'fleet_no' => 'required',
            'model' => 'required',
            'serial_no' => 'required',
            'fsrr_no' => 'required',
            'delivery_type' => 'required',
            'delivery_type' => 'required',
            'req_for' => 'required',
            'order_type' => 'required',
            'date_needed' => 'required',
        ]);

        $mrf = new mrf();
        $mrf->area = $area;
        $mrf->customer_name = $cus_name;
        $mrf->customer_address = $cus_add;
        $mrf->fleet_no = $fleet_no;
        $mrf->brand_id = $brand;
        $mrf->model_id = $model;
        $mrf->serial_no = $serial_no;
        $mrf->fsrr_no = $fsrr_no;
        $mrf->delivery_type = $delivery_type;
        $mrf->remarks = $remarks;
        $mrf->supervisor_id = 'Pending';
        $mrf->requester = $area;
        $mrf->request_for = $request_for;
        $mrf->order_type = $order_type;
        $mrf->date_needed = $date_needed;
        $mrf->save();

        (new GoogleSheetsServices())->appendSheet([
            [
                date('m-d-Y'),
                $date_needed,
                $area,
                $cus_name,
                $cus_add,
                $fleet_no,
                $brandName,
                $model,
                $serial_no,
                $fsrr_no,
                $delivery_type,
                'Pending',
                '',
                '',
                '',
                '',
                '',
                '',
                auth()->user()->name,
                $request_for,
                $order_type,
                '',
                '',
                ''
            ]
        ]);

        return redirect()->route('dashboard');






    }
}
