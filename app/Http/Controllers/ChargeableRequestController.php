<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use App\Models\Brand;
use App\Models\ChargeableRequest;
use App\Models\Customer;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChargeableRequestController extends Controller
{
    public function index(Request $request){
        if($request->search == null){
            $search = '';
        }else{
            $search = $request->search;
        }
        $rental_request = '';

        switch (Auth::user()->role) {
            case '0':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '1':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '2':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '3':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_validated', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25); 
                break;

            case '4':
                $area = [];
                $myareas = Approver::where('for', 'SERVICE')->where('user_id', Auth::user()->id)->get();

                foreach ($myareas as $myarea) {
                    $area[] = $myarea->condition;
                }

                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    // ->where('is_verified', 1)
                    ->whereIn('area', $area)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '5':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_service_approved', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '6':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_service_approved', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '7':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_mri_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '8':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_edoc_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '9':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_dr_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            default:
                break;
        }

        return view('user.chargeable.index', compact('results', 'rental_request', 'search'));
    }






















    






    public function add(){
        $brands = Brand::where('is_deleted', 0)->orderBy('id', 'asc')->get();
        $customers = Customer::where('is_deleted', 0)->get();
        $site = Site::where('id', Auth::user()->site)->first()->name;
        $brand = '';
        $model = '';
        $models = [];
        $partsInfo = [];
        
        return view('user.chargeable.add', compact('customers', 'brands', 'models', 'site', 'brand', 'model', 'partsInfo'));
    }
}
