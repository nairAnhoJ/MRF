<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\ChargeableRequest;
use App\Models\ChargeableRequestParts;
use App\Models\Customer;
use App\Models\Part;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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

    public function viewFSRR(Request $request){
        $id = $request->id;
        if($id != 0){
            $rental_request = ChargeableRequest::with('siteDetails')->where('id', $id)->first();
            $fsrr_fileExt = pathinfo($rental_request->fsrr_path, PATHINFO_EXTENSION);
    
            if ($fsrr_fileExt == 'jpeg' || $fsrr_fileExt == 'jpg' || $fsrr_fileExt == 'png'){
                echo '<img src="'.url($rental_request->fsrr_path).'" class="w-full h-auto">';
            }else{
                echo '<embed src="'.url($rental_request->fsrr_path).'" type="application/pdf" class="w-full h-full">';
            }
        }else{
            $file = $request->file('fsrrFile');
            $fsrr_fileExt = $file->getClientOriginalExtension();
            $folder = 'temporary_files/'.Auth::user()->id;
            File::cleanDirectory(public_path($folder));
            $file->move(public_path($folder), $file->getClientOriginalName());
            
            if ($fsrr_fileExt == 'jpeg' || $fsrr_fileExt == 'jpg' || $fsrr_fileExt == 'png'){
                echo '<img src="'.asset($folder.'/'.$file->getClientOriginalName()).'" class="w-full h-auto">';
            }else{
                echo '<embed src="'.asset($folder.'/'.$file->getClientOriginalName()).'" type="application/pdf" class="w-full h-full">';
            }
        }
    }

    public function viewHistory(Request $request){
        $id = $request->id;
        $rental_request = ChargeableRequest::with('siteDetails')->where('id', $id)->first();
        if($id == 0){
            $fleet_number = $request->fleet_number;
        }else{
            $fleet_number = $rental_request->fleet_number;
        }

        $fleetHistory = ChargeableRequest::where('fleet_number', $fleet_number)->where('is_cancelled', 0)->where('id', '!=', $id)->get();
        $history = '';
        $parts = '';

        // History
            if ($fleetHistory->count() != 0){
                foreach ($fleetHistory as $index => $each){
                    $bg = '';
                    if($index == 0){
                        $bg = 'bg-gray-100';
                    }
                    $history .= '
                        <tr id="viewOldRequest" data-id="'.$each->id.'" class="!border-b '.$bg.' cursor-pointer hover:bg-gray-100 last:border-0">
                            <td class="px-8 border-r whitespace-nowrap">
                                '.$each->number.'
                            </td>
                            <td class="px-8 border-r whitespace-nowrap">
                                '.date('F j, Y', strtotime($each->date_requested)).'
                            </td>
                            <td class="px-8 border-r whitespace-nowrap">
                                '.date('F j, Y', strtotime($each->date_needed)).'
                            </td>
                            <td class="px-8 border-r whitespace-nowrap">
                                '.$each->for.'
                            </td>
                            <td class="px-8 border-r whitespace-nowrap">
                                '.$each->order_type.'
                            </td>
                            <td class="px-8 whitespace-nowrap">
                                '.$each->requestor.'
                            </td>
                        </tr>
                    ';
                }
            }else{
                $history .= '
                    <tr class="border-b">
                        <td colspan="6">
                            No data.
                        </td>
                    </tr>
                ';
            }
        // History

        // Parts
            if ($fleetHistory->count() != 0){
                $oldParts = ChargeableRequest::where('request_id', $fleetHistory[0]->id)->get();
                foreach ($oldParts as $index => $each){
                    $parts .= '
                        <tr class="border-b">
                            <th class="px-2 border-r whitespace-nowrap">'.($index + 1).'</th>
                            <td class="px-2 border-r whitespace-nowrap">'.$each->part_number.'</td>
                            <td class="px-2 border-r whitespace-nowrap">'.$each->part_name.'</td>
                            <td class="px-2 text-center border-r whitespace-nowrap">'.$each->brand.'</td>
                            <td class="px-2 py-2 text-center border-r whitespace-nowrap">
                                '.$each->quantity.'
                            </td>
                            <td class="px-2 text-right border-r whitespace-nowrap">
                                '.str_replace(",", "", $each->price).'
                            </td>
                            <td class="px-2 text-right whitespace-nowrap">
                                '.number_format((str_replace(",", "", $each->price) * $each->quantity), 2, '.', ',').'
                            </td>
                        </tr>
                    ';
                }
            }else{
                $parts .= '
                    <tr class="border-b">
                        <td colspan="7">
                            No data.
                        </td>
                    </tr>
                ';
            }
        // Parts

        $res = '
            <div class="grid w-full h-full grid-cols-1 grid-rows-2 gap-y-4">
                <div class="h-full overflow-auto border">
                    <table class="w-full">
                        <thead class="">
                            <tr class="sticky top-0 bg-white border-b">
                                <th class="border-r">
                                    Request Number
                                </th>
                                <th class="border-r">
                                    Date Requested
                                </th>
                                <th class="border-r">
                                    Date Needed
                                </th>
                                <th class="border-r">
                                    Request For
                                </th>
                                <th class="border-r">
                                    Order Type
                                </th>
                                <th>
                                    Requested By
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            '.$history.'
                        </tbody>
                    </table>
                </div>
                <div class="h-full overflow-auto border">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="border-r">
                                    #
                                </th>
                                <th class="border-r">
                                    Part Number
                                </th>
                                <th class="border-r">
                                    Description
                                </th>
                                <th class="border-r">
                                    Brand
                                </th>
                                <th class="border-r">
                                    Quantity
                                </th>
                                <th class="border-r">
                                    Unit Price(₱)
                                </th>
                                <th>
                                    Total Price(₱)
                                </th>
                            </tr>
                        </thead>
                        <tbody id="HistoryParts" class="text-center">
                            '.$parts.'
                        </tbody>
                    </table>
                </div>
            </div>
        ';

        echo $res;
    }

    public function viewHistoryParts(Request $request){
        $id = $request->id;
        $oldParts = ChargeableRequestParts::where('request_id', $id)->get();
        $parts = '';
        
        // Parts
            if ($oldParts->count() != 0){
                foreach ($oldParts as $index => $each){
                    $parts .= '
                        <tr class="border-b">
                            <th class="px-2 border-r whitespace-nowrap">'.($index + 1).'</th>
                            <td class="px-2 border-r whitespace-nowrap">'.$each->part_number.'</td>
                            <td class="px-2 border-r whitespace-nowrap">'.$each->part_name.'</td>
                            <td class="px-2 text-center border-r whitespace-nowrap">'.$each->brand.'</td>
                            <td class="px-2 py-2 text-center border-r whitespace-nowrap">
                                '.$each->quantity.'
                            </td>
                            <td class="px-2 text-right border-r whitespace-nowrap">
                                '.str_replace(",", "", $each->price).'
                            </td>
                            <td class="px-2 text-right whitespace-nowrap">
                                '.number_format((str_replace(",", "", $each->price) * $each->quantity), 2, '.', ',').'
                            </td>
                        </tr>
                    ';
                }
            }else{
                $parts .= '
                    <tr class="border-b">
                        <td colspan="7">
                            No data.
                        </td>
                    </tr>
                ';
            }
        // Parts

        echo $parts;
    }

    public function getModels(Request $request){
        $models = BrandModel::where('brand_id', $request->id)->get();
        $res = '';

        foreach($models as $bmodel){
            $res .= '
                <li data-name="'.$bmodel->name.'" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-200">'.$bmodel->name.'</li>
            ';
        }
        echo $res;
    }

    public function getParts(Request $request){
        $search = $request->search;
        $selectedParts = json_decode($request->selectedParts, true);
        $parts = Part::with('part_brand')->whereRaw("CONCAT_WS(' ', partno, partname) LIKE ?", ['%' . $search . '%'])->where('status', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->take(30)->get();
        $res = '';

        foreach($parts as $rpart){
            if($selectedParts != null){
                if (in_array($rpart->id, $selectedParts)) {
                    $res .= '
                        <tr data-id="'.$rpart->id.'" class="text-center border-b cursor-pointer hover:bg-gray-100 selectPart">
                            <td><input checked type="checkbox" class="rounded cursor-pointer"></td>
                            <td>'.$rpart->partno.'</td>
                            <td>'.$rpart->partname.'</td>
                            <td>'.$rpart->part_brand->name.'</td>
                            <td>'.number_format(str_replace(",", "", $rpart->price), 2, ".", ",").'</td>
                        </tr>
                    ';
                } else {
                    $res .= '
                        <tr data-id="'.$rpart->id.'" class="text-center border-b cursor-pointer hover:bg-gray-100 selectPart">
                            <td><input type="checkbox" class="rounded cursor-pointer"></td>
                            <td>'.$rpart->partno.'</td>
                            <td>'.$rpart->partname.'</td>
                            <td>'.$rpart->part_brand->name.'</td>
                            <td>'.number_format(str_replace(",", "", $rpart->price), 2, ".", ",").'</td>
                        </tr>
                    ';
                }
            }else{
                $res .= '
                    <tr data-id="'.$rpart->id.'" class="text-center border-b cursor-pointer hover:bg-gray-100 selectPart">
                        <td><input type="checkbox" class="rounded cursor-pointer"></td>
                        <td>'.$rpart->partno.'</td>
                        <td>'.$rpart->partname.'</td>
                        <td>'.$rpart->part_brand->name.'</td>
                        <td>'.number_format(str_replace(",", "", $rpart->price), 2, ".", ",").'</td>
                    </tr>
                ';
            }
        }
        
        echo $res;
    }

    public function updateSelected(Request $request){
        $tab = $request->tab;
        $selectedParts = json_decode($request->selectedParts, true);
        $quantities = json_decode($request->quantities, true);
        $prices = json_decode($request->prices, true);
        $res = '';

        if($tab == 2){
            foreach($selectedParts as $index => $selectedPart){
                $part = Part::where('id', $selectedPart)->first();
                $res .= '
                    <tr class="border-b">
                        <th class="px-2">'.($index + 1).'</th>
                        <td>'.$part->partno.'</td>
                        <td>'.$part->partname.'</td>
                        <td>'.$part->brand.'</td>
                        <td class="py-2">
                            <input type="text" name="partQuantity'.($index + 1).'" class="w-16 text-sm text-center rounded-lg lowestOne partQuantity numberOnly text-neutral-700" value="1">
                        </td>
                        <td>
                            <input type="text" name="partPrice'.($index + 1).'" class="text-sm text-center rounded-lg w-28 partPrice lowestOne numberOnly text-neutral-700" value="'.str_replace(",", "", $part->price).'">
                        </td>
                        <td class="partTotal">'.number_format((str_replace(",", "", $part->price)), 2, ".", ",").'</td>
                        <td>
                            <button data-id="'.$part->id.'" type="button" class="mt-1 text-red-500 hover:text-red-600 partDelete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 -960 960 960" fill=currentColor>
                                    <path d="m363-289 117-118 118 118 60-60-117-119 117-119-60-61-118 119-117-119-60 61 117 119-117 119 60 60ZM253-95q-39.462 0-67.231-27.475Q158-149.95 158-189v-553h-58v-94h231v-48h297v48h232v94h-58v553q0 39.05-27.769 66.525Q746.463-95 707-95H253Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                ';
            }
        }else{
            foreach($selectedParts as $index => $selectedPart){
                $part = Part::where('id', $selectedPart)->first();
                $res .= '
                    <tr class="border-b">
                        <th class="px-2 whitespace-nowrap">'.($index + 1).'</th>
                        <td class="px-2 whitespace-nowrap">'.$part->partno.'</td>
                        <td class="px-2 whitespace-nowrap">'.$part->partname.'</td>
                        <td class="px-2 text-center whitespace-nowrap">'.$part->brand.'</td>
                        <td class="px-2 py-2 text-center whitespace-nowrap">
                            '.$quantities[$index].'
                        </td>
                        <td class="px-2 text-center whitespace-nowrap">
                            '.number_format((str_replace(",", "", $prices[$index])), 2, ".", ",").'
                        </td>
                        <td class="px-2 text-center whitespace-nowrap">
                            '.number_format((str_replace(",", "", $prices[$index]) * $quantities[$index]), 2, ".", ",").'
                        </td>
                    </tr>
                ';
            }
        }


        echo $res;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'brand' => 'required',
            'model' => 'required', 
            'serial_number' => 'required',
            'fleet_number' => 'required',
            'fsrr_number' => 'required',
            'fsrrFile' => 'required|mimes:jpeg,jpg,png,pdf',
            'technician' => 'required',
            'hm' => 'required',
            'disc' => 'required',
            'working_environment' => 'required',
            'status' => 'required',
            'date_received' => 'required|date|before:now',
        ]);

        $customMessages = [
            'customer_name.required' => 'Please select an option from the list.',
            'brand.required' => 'Please select an option from the list.',
            'model.required' => 'Please select an option from the list.',
            'serial_number.required' => 'Please provide the required information.',
            'fleet_number.required' => 'Please provide the required information.',
            'fsrr_number.required' => 'Please provide the required information.',
            'fsrrFile.required' => 'Please choose a file for upload.',
            'fsrrFile.mimes' => 'Please upload a file with the correct format (.jpeg, .jpg, .png, .pdf).',
            'technician.required' => 'Please provide the required information.',
            'hm.required' => 'Please provide the required information.',
            'disc.required' => 'Please provide the required information.',
            'working_environment.required' => 'Please select an option from the list.',
            'status.required' => 'Please select an option from the list.',
            'date_received.required' => 'Please select a date.',
            'date_received.date' => 'Invalid date format. Please use the calendar to select a valid date.',
            'date_received.before' => 'The selected date is invalid. Please choose a date before today.',
        ];

        $validator->setCustomMessages($customMessages);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer_name = $request->customer_name;
        $customer_address = $request->customer_address;
        $customer_area = $request->customer_area;
        
        $brand = Brand::where('id', $request->brand)->first()->name;
        $model = $request->model;
        $fleet_number = $request->fleet_number;
        $fsrr_number = $request->fsrr_number;
        $requestor_remarks = $request->requestor_remarks;
        $serial_number = $request->serial_number;
        $fsrrFile = $request->file('fsrrFile');
        $fsrr_fileExt = $fsrrFile->getClientOriginalExtension();
        
        $technician = $request->technician;
        $hm = $request->hm;
        $disc = $request->disc;
        $working_environment = $request->working_environment;
        $status = $request->status;
        $date_received = $request->date_received;
        
        $selectedParts = array_map('floatval', explode(",", $request->selectedParts));
        $selectedPartsQuantity = array_map('floatval', explode(",", $request->selectedPartsQuantity));
        $selectedPartsPrice = array_map('floatval', explode(",", $request->selectedPartsPrice));

        $request_id = ChargeableRequest::select('id')->max('id') + 1;

        $fileName = date('Ymd') . '_' . $request_id . '.' . $fsrr_fileExt;
        $fsrrFile->storeAs('storage/attachments/non-chargeable', $fileName, 'public_uploads');

        $fsrrPath = 'storage/attachments/non-chargeable/' . $fileName;

        $new_request = new ChargeableRequest();
        $new_request->number = 'CR-' . date('y') . substr($customer_name, 0, 1) . date('md') . '-' . $request_id;
        $new_request->site = Auth::user()->site;
        $new_request->area = Auth::user()->area;
        $new_request->customer_name = $customer_name;
        $new_request->customer_address = $customer_address;
        $new_request->customer_area = $customer_area;
        $new_request->fleet_number = $fleet_number;
        $new_request->brand = $brand;
        $new_request->model = $model;
        $new_request->serial_number = $serial_number;
        $new_request->fsrr_number = $fsrr_number;
        $new_request->fsrr_path = $fsrrPath;
        $new_request->technician = $technician;
        $new_request->hm = $hm;
        $new_request->disc = $disc;
        $new_request->working_environment = $working_environment;
        $new_request->status = $status;
        $new_request->fsrr_date_received = $date_received;
        $new_request->date_requested = date('Y-m-d h:i:s');
        $new_request->requestor = Auth::user()->name;
        $new_request->requestor_remarks = $requestor_remarks;
        $new_request->save();

        foreach ($selectedParts as $index => $selectedPart) {
            $sPart = Part::with('part_brand')->where('id', $selectedPart)->first();
            $perPart = new ChargeableRequestParts();
            $perPart->request_id = $new_request->id;
            $perPart->part_id = $selectedPart;
            $perPart->part_number = $sPart->partno;
            $perPart->part_name = $sPart->partname;
            $perPart->brand = $sPart->part_brand->name;
            $perPart->quantity = $selectedPartsQuantity[$index];
            $perPart->price = $selectedPartsPrice[$index];
            $perPart->total_price = (float)$selectedPartsPrice[$index] * (float)$selectedPartsQuantity[$index];
            $perPart->save();
        }
        
        return redirect()->route('chargeable')->with('success', 'Request Has Been Added Successfully!');
    }
}
