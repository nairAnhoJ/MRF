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
use App\Models\User;
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
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '1':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '2':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '3':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_validated', 1)
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
                    ->whereIn('area', $area)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '10':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_service_head_approved1', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '11':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_sq_number_encoded', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '6':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_adviser_approved', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '7':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_mri_number_encoded', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '12':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_edoc_number_encoded', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '9':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_invoice_encoded', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;
    
            case '13':
                $results = ChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, hm, brand, model, serial_number, fsrr_number, technician, working_environment, status, disc) LIKE ?", ['%' . $search . '%'])
                    ->where('is_adviser_approved', 1)
                    ->where('service_coordinator_id', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;
    
            default:
                return redirect()->route('dashboard');
                
                break;
        }

        return view('user.chargeable.index', compact('results', 'rental_request', 'search'));
    }













    






    public function add(){
        $brands = Brand::where('is_deleted', 0)->orderBy('id', 'asc')->get();
        $customers = Customer::where('is_deleted', 0)->get();
        $site = Site::where('id', Auth::user()->site)->first()->name;
        $coordinators = User::where('role', 13)->get();
        $brand = '';
        $model = '';
        $models = [];
        $partsInfo = [];
        
        return view('user.chargeable.add', compact('customers', 'brands', 'models', 'site', 'brand', 'model', 'partsInfo', 'coordinators'));
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
            $folder = 'temporary_files/chargeable/fsrr/'.Auth::user()->id;
            File::cleanDirectory(public_path($folder));
            $file->move(public_path($folder), $file->getClientOriginalName());
            
            if ($fsrr_fileExt == 'jpeg' || $fsrr_fileExt == 'jpg' || $fsrr_fileExt == 'png'){
                echo '<img src="'.asset($folder.'/'.$file->getClientOriginalName()).'" class="w-full h-auto">';
            }else{
                echo '<embed src="'.asset($folder.'/'.$file->getClientOriginalName()).'" type="application/pdf" class="w-full h-full">';
            }
        }
    }

    public function viewAttachments(Request $request){
        $id = $request->id;
        $chargeable_request = ChargeableRequest::where('id', $id)->first();
        $attachments = explode(",", $chargeable_request->attachments);
        $pics = '';

        $width = ((1/count($attachments))*100).'%';

        foreach($attachments as $index => $attachment){
            $pics .= '
                <div style="width: '.$width.';" class="w-['.$width.'] flex items-center justify-center h-full">
                    <img src="'.asset('storage/chargeable/'.$chargeable_request->id.'/request_attachments/'.$attachment).'" class="block h-full rounded-lg" alt="attachment'.($index+1).'">
                </div>
            ';
        }

        $width = (count($attachments)*100).'%';

        $result = '
            <div style="width: '.$width.';" id="attachmentCarousel" class="w-['.$width.'] flex h-full duration-500 ease-in-out transition-all">
                '.$pics.'
            </div>
        ';

        echo $result;
    }

    public function viewSQAttachments(Request $request){
        $id = $request->id;

        $chargeable_request = ChargeableRequest::where('id', $id)->first();
        
        echo '<img src="'.url($chargeable_request->sq_attachment).'" class="w-full h-auto">';
    }

    public function viewSCAttachments(Request $request){
        $id = $request->id;
        $chargeable_request = ChargeableRequest::where('id', $id)->first();
        
        $pics = '
            <div style="width: 50%;" class="w-[50%] flex items-center justify-center h-full">
                <img src="'.url($chargeable_request->matrix_attachment).'" class="block h-full rounded-lg" alt="matrix-attachment">
            </div>
            <div style="width: 50%;" class="w-[50%] flex items-center justify-center h-full">
                <img src="'.url($chargeable_request->po_attachment).'" class="block h-full rounded-lg" alt="matrix-attachment">
            </div>
        ';

        $result = '
            <div style="width: 200%;" id="scAttachmentCarousel" class="w-[200%] flex h-full duration-500 ease-in-out transition-all">
                '.$pics.'
            </div>
        ';

        echo $result;
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
                $oldParts = ChargeableRequestParts::where('request_id', $fleetHistory[0]->id)->get();
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

    public function attachmentsPreview(Request $request){
        $attachments = $request->file('attachments');
        $content = '';
        if($attachments == null){
            $creq = ChargeableRequest::where('id', $request->id)->first();
            $cattachments = explode(',', $creq->attachments);

            foreach($cattachments as $index => $attachment){
                
                $content .= '
                    <div class="flex items-center justify-center h-full border aspect-square">
                        <img src="'.asset('storage/chargeable/'.$creq->id.'/request_attachments/'.$attachment).'" alt="attachment'.($index+1).'" class="w-auto max-h-full">
                    </div>
                ';
            }
        }else{
            $folder = 'temporary_files/chargeable/attachment/'.Auth::user()->id;
            File::cleanDirectory(public_path($folder));

            foreach($attachments as $index => $attachment){
                $attachment->move(public_path($folder), $attachment->getClientOriginalName());

                $content .= '
                    <div class="flex items-center justify-center h-full border aspect-square">
                        <img src="'.asset($folder.'/'.$attachment->getClientOriginalName()).'" alt="attachment'.($index+1).'" class="w-auto max-h-full">
                    </div>
                ';
            }
        }

        echo $content;
    }



    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'date_needed' => 'required|date|after:now',
            'delivery_type' => 'required',
            'service_coordinator' => 'required',
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
            'date_needed.required' => 'Please select a date.',
            'date_needed.date' => 'Invalid date format. Please use the calendar to select a valid date.',
            'date_needed.after' => 'The selected date is invalid. Please choose a date after today.',
            'delivery_type.required' => 'Please select an option from the list.',
            'service_coordinator.required' => 'Please select an option from the list.',
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

        $date_needed = $request->date_needed;
        $delivery_type = $request->delivery_type;
        $service_coordinator = $request->service_coordinator;

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
        $attachments = $request->file('attachments');
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

        $fileName = date('Ymd') . '.' . $fsrr_fileExt;
        $fsrrFile->storeAs('storage/chargeable/'.$request_id.'/fsrr/', $fileName, 'public_uploads');
        $fsrrPath = 'storage/chargeable/'.$request_id.'/fsrr/'.$fileName;

        $new_request = new ChargeableRequest();
        $new_request->number = 'CR-' . date('y') . substr($customer_name, 0, 1) . date('md') . '-' . $request_id;
        $new_request->date_needed = $date_needed;
        $new_request->delivery_type = $delivery_type;
        $new_request->service_coordinator_id = $service_coordinator;
        $new_request->service_coordinator_name = User::where('id', $service_coordinator)->first()->name;
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

        $attachmentsArray = '';

        if($attachments != null){
            foreach($attachments as $index => $attachment){
                $attachmentsExt = $attachment->getClientOriginalExtension();
                $attachmentsName = ($index+1).'.'.$attachmentsExt;
                $attachment->storeAs('storage/chargeable/'.$request_id.'/request_attachments/', $attachmentsName, 'public_uploads');
                if($index == 0){
                    $attachmentsArray .= $attachmentsName;
                }else{
                    $attachmentsArray .= ','.$attachmentsName;
                }
            }
            $new_request->attachments = $attachmentsArray;
        }

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
        
        $folder = 'temporary_files/chargeable/attachment/'.Auth::user()->id;
        File::cleanDirectory(public_path($folder));

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




    public function getSQ(Request $request){
        $id = $request->id;
        $chargeable_request = ChargeableRequest::where('id', $id)->first();

        $result = array(
            'sq_number' => $chargeable_request->sq_number,
            // 'sq_attachment' => $chargeable_request->sq_attachment,
            'sq_remarks' => $chargeable_request->sq_remarks,
        );

        echo json_encode($result);
    }

    public function mriNumber(Request $request){
        $id = $request->id;
        $crequest = ChargeableRequest::where('id', $id)->first();

        $result = array(
            'mri_number' => $crequest->mri_number,
            'mri_remarks' => $crequest->mri_remarks,
        );

        echo json_encode($result);
    }

    public function edocParts(Request $request){
        $id = $request->id;
        $crequest = ChargeableRequest::where('id', $id)->first();
        $allParts = ChargeableRequestParts::where('request_id', $id)->where('edoc_number', '0')->get();
        $res = '<p class="mb-2 text-xs italic">*please select all the parts on this eDoc</p>';
        
        foreach ($allParts as $index => $eachPart){
            $res .= '
                <div class="mb-4">
                    <div class="flex items-center mb-1">
                        <input checked id="part'.$eachPart->id.'" name="selectedParts[]" type="checkbox" value="'.$eachPart->id.'" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="part'.$eachPart->id.'" class="text-xs font-medium text-gray-900 ms-2">'.$eachPart->part_number.' - '.$eachPart->part_name.'</label>
                    </div>
                </div>
            ';
        }

        $result = array(
            'content' => $res,
            'serial_numbers' => $crequest->serial_numbers,
            'edoc_remarks' => $crequest->edoc_remarks,
        );

        echo json_encode($result);
    }

    public function drNumber(Request $request){
        $id = $request->id;
        $request = ChargeableRequest::where('id', $id)->first();
        $edocList = ChargeableRequestParts::select('edoc_number', 'dr_number')
            ->where('request_id', $id)
            ->where('dr_number', '0')
            ->where('edoc_number', '!=', '0')
            ->distinct()
            ->get();
        $edocArray = explode(',', $request->edoc_number);
        $c = 0;

        $res = '<p class="mb-2 text-xs italic">*please select the eDoc Number</p>';
        
        foreach ($edocArray as $index => $eachEdoc){
            $thisEdocPart = ChargeableRequestParts::where('edoc_number', $eachEdoc)->first();
            if($thisEdocPart->dr_number == '0'){
                $c++;
                $res .= '
                    <div class="mb-4">
                        <div class="flex items-center mb-1">
                            <input '.(($c == 1) ? "checked" : "").' id="part'.$index.'" name="selectedEdocNumber" type="radio" value="'.$thisEdocPart->edoc_number.'" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="part'.$index.'" class="text-xs font-medium text-gray-900 ms-2">'.$thisEdocPart->edoc_number.'</label>
                        </div>
                    </div>
                ';
            }
        }

        $result = array(
            'content' => $res,
            'si_number' => $request->si_number,
            'bs_number' => $request->bs_number,
            'invoice_remarks' => $request->invoice_remarks,
        );

        echo json_encode($result);
    }



    


    
    public function view(Request $request){
        $id = $request->id;
        $viewDetails = '';
        $status = '';

        $rental_request = ChargeableRequest::with('siteDetails')->where('id', $id)->first();
        $allParts = ChargeableRequestParts::where('request_id', $id)->get();
        $edocparts = ChargeableRequestParts::where('request_id', $id)->where('edoc_number', '0')->count();
        $pendingEdoc = ChargeableRequestParts::where('request_id', $id)->where('dr_number', '0')->count();

        // Status
            if($rental_request->is_cancelled == 1){
                $status = 'Cancelled';
            }else if($rental_request->is_validated == 0){
                if($rental_request->is_returned == 1){
                    $status = 'Returned (For Supervisor Validation)';
                }else{
                    $status = 'For Supervisor Validation';
                }
            }else if($rental_request->is_validated == 1 && $rental_request->is_verified == 0){
                $status = 'Validated (For Parts Verification)';
            }else if($rental_request->is_verified == 1 && $rental_request->is_service_approved == 0){
                $status = 'Verified (For Service Approval)';
            }else if($rental_request->is_service_approved == 1 && $rental_request->is_sq_number_encoded == 0){
                $status = 'Service Approved (For Encoding of SQ Number)';
            }else if($rental_request->is_sq_number_encoded == 1 && $rental_request->is_adviser_approved == 0){
                $status = 'SQ Number Encoded (For Adviser Approval)';
            }else if($rental_request->is_adviser_approved == 1 && $rental_request->is_mri_number_encoded == 0){
                $status = 'Adviser-Approved (For Encoding of MRI Number)';
            }else if($rental_request->is_mri_number_encoded == 1 && $rental_request->is_invoice_encoded == 0){
                $status = 'MRI Number Encoded (For Encoding of Invoicing)';
            }else if($rental_request->is_invoice_encoded == 1 && $rental_request->is_confirmed == 0){
                $status = 'Invoicing Encoded (For Signatories Confirmation)';
            }else if($rental_request->is_confirmed == 1){
                $status = 'Completed';
            }
        // Status
        
        // Encoded
            $encoded = '';
            if($rental_request->is_sq_number_encoded == 1){
                $encoded .= '
                    <div class="flex items-center w-full mb-2">
                        <p class="w-44">SQ Number: </p><p id="viewSQAttachment" class="ml-1 cursor-pointer text-blue-600 font-bold w-[calc(100%-176px)] text-lg hover:underline hover:text-blue-700">'.$rental_request->sq_number.'</p>
                    </div>
                ';
            }
            if($rental_request->is_mri_number_encoded == 1){
                $encoded .= '
                    <div class="flex items-center w-full">
                        <p class="w-44">MRI Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->mri_number.'</p>
                    </div>
                    <div class="flex items-center w-full mb-5">
                        <p class="w-44">Importation: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.(($rental_request->is_importation == 1) ? "YES" : "NO").'</p>
                    </div>
                ';
            }
            if($edocparts < count($allParts)){
                $edocCount = '';
                // $edocArray = ChargeableRequestParts::select('edoc_number', 'dr_number')
                //     ->where('request_id', $id)
                //     ->where('edoc_number', '!=', '0')
                //     ->distinct()
                //     ->get();
                $edocArray = explode(',', $rental_request->edoc_number);
                $count = count($edocArray);
                
                foreach($edocArray as $index => $eachEdoc){
                    $count = $index + 1;
    
                    if (($count % 100) >= 11 && ($count % 100) <= 13) {
                        $suffix = 'th';
                    } else {
                        switch ($count % 10) {
                            case 1:
                                $suffix = 'st';
                                break;
                            case 2:
                                $suffix = 'nd';
                                break;
                            case 3:
                                $suffix = 'rd';
                                break;
                            default:
                                $suffix = 'th';
                                break;
                        }
                    }
    
                    $edocCount = $count . $suffix;

                    $thisEdocPart = ChargeableRequestParts::where('edoc_number', $eachEdoc)->first();
                    
                    $encoded .= '
                        <div class="flex items-center w-full '.(($thisEdocPart->dr_number == 0) ? 'mb-3' : '').'">
                            <p class="w-44">'.$edocCount.' eDoc Number: </p><p id="viewEdocPartsButton" data-edoc="'.$thisEdocPart->edoc_number.'" class="ml-1 cursor-pointer text-blue-600 font-bold w-[calc(100%-176px)] text-lg hover:underline hover:text-blue-700">'.$thisEdocPart->edoc_number.'</p>
                        </div>
                    ';

                    if($thisEdocPart->dr_number != 0){
                        $encoded .= '
                            <div class="flex items-center w-full mb-3">
                                <p class="w-44">DR Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$thisEdocPart->dr_number.'</p>
                            </div>
                        ';
                    }
                }
            }
            if($rental_request->si_number != null && $rental_request->bs_number != null){
                $encoded .= '
                    <div class="flex items-center w-full">
                        <p class="w-44">SI Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->si_number.'</p>
                    </div>
                    <div class="flex items-center w-full">
                        <p class="w-44">BS Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->bs_number.'</p>
                    </div>
                ';
            }
            if($rental_request->is_sq_number_encoded == 1){
                $encoded .= '
                    <hr class="my-6">
                ';
            }
        // Encoded

        // Remarks
            $remarks = '';
            if ($rental_request->is_cancelled == 1){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">'.$rental_request->cancelled_by.'<br>Cancelled Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->cancelled_remarks.'</textarea>
                    </div>
                ';
            }
            if ($rental_request->is_returned == 1){
                if($rental_request->is_returned_by_parts == 1){
                    $remarks .= '
                        <div class="flex items-start w-full pr-2 mb-2">
                            <p id="viewReturnedPartsButton" class="text-blue-600 cursor-pointer w-44 hover:underline">'.$rental_request->returned_by.'<br>Return Remarks: </p>
                            <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->returned_remarks.'</textarea>
                        </div>
                    ';
                }else{
                    $remarks .= '
                        <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">'.$rental_request->returned_by.'<br>Return Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->returned_remarks.'</textarea>
                        </div>
                    ';
                }
            }
            if (($rental_request->is_verified == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_verified != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="pt-2 w-44">Parts Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->verifier_remarks.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_service_head_approved1 == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_service_head_approved1 != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Service Head Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->service_head_remarks1.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_sq_number_encoded == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_sq_encoded != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">SQ Encoder Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->sq_remarks.'</textarea>
                    </div>
                ';

            }
            if (($rental_request->is_adviser_approved == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_adviser_approved != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Adviser Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->adviser_remarks.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_service_coordinator_approved == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_service_coordinator_approved != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Service Coordinator Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->service_coordinator_remarks.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_service_head_approved2 == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_service_head_approved2 != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Service Head Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->service_head_remarks2.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_mri_number_encoded == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_mri_encoded != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">MRI Encoder Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->mri_remarks.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_invoice_encoded == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_invoice_encoded != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Invoicing Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->invoice_remarks.'</textarea>
                    </div>
                ';
            }
        // Remarks

        // Controls
            $controls1 = '';
            $controls2 = '';
            if($rental_request->is_cancelled == 0){
                if ((Auth::user()->role == 1 || Auth::user()->role == 2) && $rental_request->is_validated == 0 ){
                    $controls1 = '
                        <a href="'.route('chargeable.edit', ['request_number' => $rental_request->number]).'" class="inline-flex items-center justify-center h-8 px-2 ml-auto text-sm text-blue-500 bg-transparent rounded-lg hover:bg-gray-200 hover:text-blue-600 hover:underline">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                                <path xmlns="http://www.w3.org/2000/svg" d="M181.913-182.152h44.239l459.804-458.804-43.761-44-460.282 459.043v43.761Zm-67.891 68.13V-253.5l574.521-573.761q8.239-8.478 19.803-13.217 11.563-4.74 24.11-4.74 11.479 0 22.957 4.74 11.478 4.739 21.196 12.978l51.891 51.174q9.239 9.717 13.478 21.315 4.24 11.598 4.24 23.315 0 11.718-4.74 23.696-4.739 11.978-12.978 20.457L253.739-114.022H114.022Zm661.152-618.674-41.239-41.478 41.239 41.478Zm-110.979 69.501-22-21.761 43.761 44-21.761-22.239Z"/>
                            </svg>
                            Edit
                        </a>

                        <a type="button" class="inline-flex items-center justify-center h-8 px-2 ml-auto text-sm text-red-500 bg-transparent rounded-lg hover:bg-gray-200 hover:text-red-600 hover:underline">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                                <path xmlns="http://www.w3.org/2000/svg" d="m361-299 119-121 120 121 47-48-119-121 119-121-47-48-120 121-119-121-48 48 120 121-120 121 48 48ZM261-120q-24 0-42-18t-18-42v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570Zm-438 0v570-570Z"/>
                            </svg>
                            Cancel
                        </a>
                    ';
                }
            }

            if($rental_request->is_cancelled == 0){
                if (Auth::user()->role == 2 && $rental_request->is_validated == 0 && $rental_request->site == Auth::user()->site){
                    $controls2 = '
                        <button id="validateButton" type="button" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">VALIDATE</button>
                    ';
                }
                elseif (Auth::user()->role == 3 && $rental_request->is_validated == 1 && $rental_request->is_verified == 0){
                    $controls2 = '
                        <button type="button" id="verifyButton" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">VERIFY</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 4 && (($rental_request->is_verified == 1 && $rental_request->is_service_head_approved1 == 0) || ($rental_request->is_service_coordinator_approved == 1 && $rental_request->is_service_head_approved2 == 0))){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">APPROVE</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 10 && $rental_request->is_service_head_approved1 == 1 && $rental_request->is_sq_number_encoded == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">ENCODE SQ NUMBER</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 11 && $rental_request->is_sq_number_encoded == 1 && $rental_request->is_adviser_approved == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">APPROVE</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 6 && $rental_request->is_service_head_approved2 == 1 && $rental_request->is_mri_number_encoded == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE MRI Number</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 7 && $rental_request->is_mri_number_encoded == 1 && $edocparts > 0){
                    if($rental_request->is_edoc_number_encoded == 0){
                        $controls2 = '
                            <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE EDOC Number</button>
                            <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST TO MRI ENCODER</button>
                        ';
                    }else{
                        $controls2 = '
                            <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE EDOC Number</button>
                        ';
                    }
                }
                elseif (Auth::user()->role == 12 && $rental_request->is_mri_number_encoded == 1 && $rental_request->is_invoice_encoded == 0 && $pendingEdoc > 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE</button>
                    ';
                }
                elseif (Auth::user()->role == 9 && $rental_request->is_invoice_encoded == 1 && $rental_request->is_confirmed == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">APPROVE</button>
                    ';
                }
                elseif (Auth::user()->role == 13 && $rental_request->is_adviser_approved == 1 && $rental_request->is_service_coordinator_approved == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">APPROVE</button>
                    ';
                }
            }
        // Controls

        // Parts
            $parts = '';
            foreach ($allParts as $index => $sparts) {
                $parts .= '
                    <tr class="border-b">
                        <th class="px-2 whitespace-nowrap">'.($index + 1).'</th>
                        <td class="px-2 whitespace-nowrap">'.$sparts->part_number.'</td>
                        <td class="px-2 whitespace-nowrap">'.$sparts->part_name.'</td>
                        <td class="px-2 text-center whitespace-nowrap">'.$sparts->brand.'</td>
                        <td class="px-2 py-2 text-center whitespace-nowrap">
                        '.$sparts->quantity.'
                        </td>
                        <td class="px-2 text-right whitespace-nowrap">
                        '.str_replace(",", "", $sparts->price).'
                        </td>
                        <td class="px-2 text-right whitespace-nowrap">
                        '.number_format((str_replace(",", "", $sparts->price) * $sparts->quantity), 2, '.', ',').'
                        </td>
                    </tr>
                ';
            }
        // Parts

        // Return Count
            $return_count = '';
            if($rental_request->returned_count > 0){
                $return_count = '
                    <div class="flex items-center w-full mb-2">
                        <p class="w-44">Return Count: </p><p class="ml-1 font-bold text-red-500 w-[calc(100%-176px)] text-lg">'.$rental_request->returned_count.'</p>
                    </div>
                ';
            }
        // Return Count

        // Attachment
            $attachmentButton = '';
            if($rental_request->attachments != null){
                $attachmentButton .= '
                    <button id="viewAttachments" class="px-4 py-1 border rounded bg-neutral-100 border-neutral-400 hover:border-neutral-200">Request Attachment/s</button>
                ';
            }
            if($rental_request->is_service_coordinator_approved == 1){
                $attachmentButton .= '
                    <button id="viewSCAttachments" class="px-4 py-1 border rounded bg-neutral-100 border-neutral-400 hover:border-neutral-200">Matrix/PO Attachment/s</button>
                ';
            }
        // Attachment

        $viewDetails = '
            <div class="relative h-full bg-white rounded-lg shadow">
                <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 id="viewNumber" class="text-2xl font-semibold text-gray-900 pt-0.5">'.$rental_request->number.'</h3>
                        <div class="flex items-center">
                            '.$controls1.'
                        </div>
                    </div>
                <!-- Modal header -->
                <!-- Modal body -->
                    <div class="py-4 px-10 h-[calc(100%-140px)] w-full overflow-hidden flex items-start justify-center">
                        <div class="flex w-full h-full space-y-4 overflow-hidden">
                            <div class="w-1/2 h-full pr-2 text-left border-r">
                                <div class="flex items-center justify-between">
                                    <h1 class="mb-10 text-2xl font-bold text-neutral-800">Request Details</h1>
                                    <h1 class="mb-10 text-lg font-bold text-neutral-800">Date: '.date('F j, Y H:i A', strtotime($rental_request->updated_at)).'</h1>
                                </div>
                                <div class="w-full h-[calc(100%-72px)] overflow-x-hidden overflow-y-auto">
                                    <div class="flex w-full mb-5">
                                        <p class="w-44">Status: </p>
                                        <p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$status.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Customer: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->customer_name.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Address: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">
                                            <span class="">'.$rental_request->customer_address.'</span>
                                            <span class="">〈 '.$rental_request->customer_area.' 〉</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center w-full mb-6">
                                        <p class="w-44">Site: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->siteDetails->name.'</p>
                                    </div>
                                    <hr class="my-6">
                                    '.$encoded.'
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Brand: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->brand.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44 w-">Model: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->model.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Serial Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->serial_number.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Fleet Number: </p><p id="viewHistory" class="ml-1 cursor-pointer text-blue-600 font-bold w-[calc(100%-176px)] text-lg hover:underline hover:text-blue-700">'.$rental_request->fleet_number.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                    <p class="w-44">FSRR Number: </p><p id="viewFSRR" class="ml-1 cursor-pointer text-blue-600 font-bold w-[calc(100%-176px)] text-lg hover:underline hover:text-blue-700">'.$rental_request->fsrr_number.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Technician: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->technician.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">HM: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->hm.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Disc: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->disc.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Working Environment: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->working_environment.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Status: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->status.'</p>
                                    </div>
                                    '.$return_count.'
                                    <div class="flex items-center w-full mb-2 gap-x-2">
                                        '.$attachmentButton.'
                                    </div>
                                    <hr class="my-6">
                                    <div class="flex items-start w-full pr-2 mb-2">
                                        <p class="w-44">Requestor Remarks: </p>
                                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->requestor_remarks.'</textarea>
                                    </div>
                                    '.$remarks.'
                                </div>
                            </div>
                            <div class="w-1/2 h-full pl-4 !m-0 overflow-auto">
                                <div class="min-w-full">
                                    <table class="min-w-full">
                                        <thead class="sticky top-0 text-sm bg-white border-b text-neutral-700">
                                            <tr>
                                                <th class="px-2 pb-2 whitespace-nowrap">#</th>
                                                <th class="px-2 pb-2 text-left whitespace-nowrap">Part Number</th>
                                                <th class="px-2 pb-2 whitespace-nowrap">Description</th>
                                                <th class="px-2 pb-2 whitespace-nowrap">Brand</th>
                                                <th class="px-2 pb-2 whitespace-nowrap">Quantity</th>
                                                <th class="px-2 pb-2 whitespace-nowrap">Unit Price(₱)</th>
                                                <th class="px-2 pb-2 whitespace-nowrap">Total Price(₱)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            '.$parts.'
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Modal body -->
                <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        '.$controls2.'
                        <button id="closeViewModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                    </div>
                <!-- Modal footer -->
            </div>
        ';

        $response = [
            "viewDetails" => $viewDetails,
        ];

        echo json_encode($response);
    }

    public function validateRequest(Request $request){
        $id = $request->id;

        $thisRequest = ChargeableRequest::where('id', $id)->first();
        $thisRequest->is_validated = 1;
        $thisRequest->validator = Auth()->user()->name;
        $thisRequest->datetime_validated = date('Y-m-d h:i:s');
        $thisRequest->save();
        
        return redirect()->route('chargeable')->with('success', 'Request Has Been Validated Successfully!');
    }

    public function verifyRequest(Request $request){
        $id = $request->id;
        $remarks = $request->remarks;

        $thisRequest = ChargeableRequest::where('id', $id)->first();

        $thisRequest->is_verified = 1;
        $thisRequest->verifier = Auth()->user()->name;
        $thisRequest->datetime_verified = date('Y-m-d h:i:s');
        $thisRequest->verifier_remarks = $remarks;

        $thisRequest->save();
        
        return redirect()->route('chargeable')->with('success', 'Request Has Been Validated Successfully!');
    }

    public function approveRequest(Request $request){
        $thisRequest = ChargeableRequest::where('id', $request->id)->first();

        switch (Auth::user()->role) {
            case '4':
                if($thisRequest->is_service_head_approved1 == 0){
                    $thisRequest->is_service_head_approved1 = 1;
                    $thisRequest->service_head_approver1 = Auth()->user()->name;
                    $thisRequest->datetime_service_head_approved1 = date('Y-m-d h:i:s');
                    $thisRequest->service_head_remarks1 = $request->remarks;
                    $thisRequest->save();
                }else{
                    $thisRequest->is_service_head_approved2 = 1;
                    $thisRequest->service_head_approver2 = Auth()->user()->name;
                    $thisRequest->datetime_service_head_approved2 = date('Y-m-d h:i:s');
                    $thisRequest->service_head_remarks2 = $request->remarks;
                    $thisRequest->save();
                }
                return redirect()->route('chargeable')->with('success', 'Request Has Been Approved Successfully!');

                break;

            case '10':
                $request->validate([
                    'encode_input' => 'required',
                    'sq_attachment' => 'required',
                ]);

                $sq_attachment = $request->file('sq_attachment');
                $sq_attachment_ext = $sq_attachment->getClientOriginalExtension();

                $fileName = date('Ymd') . '.' . $sq_attachment_ext;
                $sq_attachment->storeAs('storage/chargeable/'.$request->id.'/sq_attachment/', $fileName, 'public_uploads');
                $sq_attachment_path = 'storage/chargeable/'.$request->id.'/sq_attachment/'.$fileName;

                $thisRequest->is_sq_number_encoded = 1;
                $thisRequest->sq_number = $request->encode_input;
                $thisRequest->sq_attachment = $sq_attachment_path;
                $thisRequest->sq_encoder = Auth()->user()->name;
                $thisRequest->datetime_sq_encoded = date('Y-m-d h:i:s');
                $thisRequest->sq_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('chargeable')->with('success', 'SQ Number Has Been Encoded Successfully!');

                break;

            case '11':
                $thisRequest->is_adviser_approved = 1;
                $thisRequest->adviser_approver = Auth()->user()->name;
                $thisRequest->datetime_adviser_approved = date('Y-m-d h:i:s');
                $thisRequest->adviser_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('chargeable')->with('success', 'Request Has Been Approved Successfully!');

                break;

            case '13':
                $request->validate([
                    'matrix' => 'required',
                    'po_attachment' => 'required', 
                ]);

                $matrix = $request->file('matrix');
                $matrix_ext = $matrix->getClientOriginalExtension();

                $fileName = date('Ymd') . '.' . $matrix_ext;
                $matrix->storeAs('storage/chargeable/'.$request->id.'/matrix_attachment/', $fileName, 'public_uploads');
                $matrix_attachment_path = 'storage/chargeable/'.$request->id.'/matrix_attachment/'.$fileName;
                

                $po_attachment = $request->file('po_attachment');
                $po_attachment_ext = $po_attachment->getClientOriginalExtension();

                $fileName = date('Ymd') . '.' . $po_attachment_ext;
                $po_attachment->storeAs('storage/chargeable/'.$request->id.'/po_attachment/', $fileName, 'public_uploads');
                $po_attachment_path = 'storage/chargeable/'.$request->id.'/po_attachment/'.$fileName;

                $thisRequest->is_service_coordinator_approved = 1;
                $thisRequest->matrix_attachment = $matrix_attachment_path;
                $thisRequest->po_attachment = $po_attachment_path;
                $thisRequest->service_coordinator_approver = Auth()->user()->name;
                $thisRequest->datetime_service_coordinator_approved = date('Y-m-d h:i:s');
                $thisRequest->service_coordinator_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('chargeable')->with('success', 'Request Has Been Approved Successfully!');

                break;
            case '6':
                $request->validate([
                    'encode_input' => 'required'
                ]);
                $thisRequest->is_mri_number_encoded = 1;
                if($request->importation == 'YES'){
                    $thisRequest->is_importation = 1;
                    $thisRequest->is_edoc_number_encoded = 0;
                }else{
                    $thisRequest->is_importation = 0;
                    $thisRequest->is_edoc_number_encoded = 1;
                }
                $thisRequest->mri_number = $request->encode_input;
                $thisRequest->mri_encoder = Auth()->user()->name;
                $thisRequest->datetime_mri_encoded = date('Y-m-d h:i:s');
                $thisRequest->mri_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('chargeable')->with('success', 'MRI Number Has Been Encoded Successfully!');

                break;

            case '7':
                $request->validate([
                    'encode_input' => 'required'
                ]);
                
                foreach($request->selectedParts as $value){
                    $thisPart = ChargeableRequestParts::where('id', $value)->first();
                    $thisPart->edoc_number = $request->encode_input;
                    $thisPart->save();
                }
                
                $edocparts = ChargeableRequestParts::where('request_id', $request->id)->where('edoc_number', '0')->count();
                if($edocparts == 0){
                    $thisRequest->is_edoc_number_encoded = 1;
                }else{
                    $thisRequest->is_edoc_number_encoded = 2;
                }
                if($thisRequest->edoc_number != null){
                    $thisRequest->edoc_number = $thisRequest->edoc_number.','.$request->encode_input;
                }else{
                    $thisRequest->edoc_number = $request->encode_input;
                }
                $thisRequest->serial_numbers = $request->serial_numbers;
                $thisRequest->edoc_encoder = Auth()->user()->name;
                $thisRequest->datetime_edoc_encoded = date('Y-m-d h:i:s');
                $thisRequest->edoc_remarks = $request->remarks;
                $thisRequest->save();
                
                return redirect()->route('chargeable')->with('success', 'eDoc Number Has Been Encoded Successfully!');

                break;

            case '12':
                $request->validate([
                    'dr_input' => 'required',
                    'si_input' => 'required',
                    'bs_input' => 'required',
                ]);
                ChargeableRequestParts::where('edoc_number', $request->selectedEdocNumber)->update([
                    'dr_number' => $request->dr_input
                ]);

                $pendingEdoc = ChargeableRequestParts::where('request_id', $request->id)->where('dr_number', '0')->count();
                if($pendingEdoc == 0){
                    $thisRequest->is_invoice_encoded = 1;
                }
                $thisRequest->si_number = $request->si_input;
                $thisRequest->bs_number = $request->bs_input;
                $thisRequest->invoice_encoder = Auth()->user()->name;
                $thisRequest->datetime_invoice_encoded = date('Y-m-d h:i:s');
                $thisRequest->invoice_remarks = $request->remarks;
                $thisRequest->save();
                
                return redirect()->route('chargeable')->with('success', 'Encoded Successfully!');

                break;

            case '9':
                $thisRequest->is_confirmed = 1;
                $thisRequest->signatory = Auth()->user()->name;
                $thisRequest->datetime_confirmed = date('Y-m-d h:i:s');
                $thisRequest->signatory_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('chargeable')->with('success', 'Request Has Been Approved Successfully!');

                break;
            default:
                break;
        }


    }













    public function edit(Request $request){
        $c_request = ChargeableRequest::where('number', $request->request_number)->first();
        $c_request_parts = ChargeableRequestParts::where('request_id', $c_request->id)->get();
        $brand_id = Brand::where('name', $c_request->brand)->first()->id;
        $brands = Brand::where('is_deleted', 0)->orderBy('id', 'asc')->get();
        $customers = Customer::where('is_deleted', 0)->get();
        $site = Site::where('id', Auth::user()->site)->first()->name;
        $rbrand = Brand::where('name', $c_request->brand)->first();
        $coordinators = User::where('role', 13)->get();
        if($rbrand != null){
            $brand = $rbrand->id;
        }else{
            $brand = 0;
        }
        $models = BrandModel::where('brand_id', $brand_id)->where('is_deleted', 0)->get();
        $selectedParts = ChargeableRequestParts::where('request_id', $c_request->id)->get();
        
        return view('user.chargeable.edit', compact('c_request', 'c_request_parts', 'customers', 'brands', 'models', 'site', 'brand', 'selectedParts', 'coordinators'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'brand' => 'required',
            'model' => 'required', 
            'serial_number' => 'required',
            'fleet_number' => 'required',
            'fsrr_number' => 'required',
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

        $date_needed = $request->date_needed;
        $delivery_type = $request->delivery_type;
        $service_coordinator = $request->service_coordinator;
        
        $brand = Brand::where('id', $request->brand)->first()->name;
        $model = $request->model;
        $fleet_number = $request->fleet_number;
        $fsrr_number = $request->fsrr_number;
        $requestor_remarks = $request->requestor_remarks;
        $serial_number = $request->serial_number;
        $fsrrFile = $request->file('fsrrFile');
        $attachments = $request->file('attachments');
        
        $technician = $request->technician;
        $hm = $request->hm;
        $disc = $request->disc;
        $working_environment = $request->working_environment;
        $status = $request->status;
        $date_received = $request->date_received;
        
        $selectedParts = array_map('floatval', explode(",", $request->selectedParts));
        $selectedPartsQuantity = array_map('floatval', explode(",", $request->selectedPartsQuantity));
        $selectedPartsPrice = array_map('floatval', explode(",", $request->selectedPartsPrice));

        $c_request = ChargeableRequest::where('number', $request->number)->first();
        $c_request->date_needed = $date_needed;
        $c_request->delivery_type = $delivery_type;
        $c_request->service_coordinator_id = $service_coordinator;
        $c_request->service_coordinator_name = User::where('id', $service_coordinator)->first()->name;

        $c_request->fleet_number = $fleet_number;
        $c_request->brand = $brand;
        $c_request->model = $model;
        $c_request->serial_number = $serial_number;
        $c_request->fsrr_number = $fsrr_number;

        if($fsrrFile != null){
            $folder = 'storage/chargeable/'.$c_request->id.'/fsrr/';
            File::cleanDirectory(public_path($folder));

            $fsrr_fileExt = $fsrrFile->getClientOriginalExtension();

            $fileName = date('Ymd') . '.' . $fsrr_fileExt;
            $fsrrFile->storeAs('storage/chargeable/'.$c_request->id.'/fsrr/', $fileName, 'public_uploads');
            $fsrrPath = 'storage/chargeable/'.$c_request->id.'/fsrr/'.$fileName;

            $c_request->fsrr_path = $fsrrPath;
        }

        $attachmentsArray = '';

        if($attachments != null){
            $folder = 'storage/chargeable/'.$c_request->id.'/request_attachments/';
            File::cleanDirectory(public_path($folder));
            foreach($attachments as $index => $attachment){
                $attachmentsExt = $attachment->getClientOriginalExtension();
                $attachmentsName = ($index+1).'.'.$attachmentsExt;
                $attachment->storeAs('storage/chargeable/'.$c_request->id.'/request_attachments/', $attachmentsName, 'public_uploads');
                if($index == 0){
                    $attachmentsArray .= $attachmentsName;
                }else{
                    $attachmentsArray .= ','.$attachmentsName;
                }
            }
            $c_request->attachments = $attachmentsArray;
        }

        $c_request->technician = $technician;
        $c_request->hm = $hm;
        $c_request->disc = $disc;
        $c_request->working_environment = $working_environment;
        $c_request->status = $status;
        $c_request->fsrr_date_received = $date_received;
        $c_request->date_requested = date('Y-m-d h:i:s');
        $c_request->requestor_remarks = $requestor_remarks;
        $c_request->save();

        ChargeableRequestParts::where('request_id', $c_request->id)->delete();

        foreach ($selectedParts as $index => $selectedPart) {
            $sPart = Part::with('part_brand')->where('id', $selectedPart)->first();
            $perPart = new ChargeableRequestParts();
            $perPart->request_id = $c_request->id;
            $perPart->part_id = $selectedPart;
            $perPart->part_number = $sPart->partno;
            $perPart->part_name = $sPart->partname;
            $perPart->brand = $sPart->part_brand->name;
            $perPart->quantity = $selectedPartsQuantity[$index];
            $perPart->price = $selectedPartsPrice[$index];
            $perPart->total_price = (float)$selectedPartsPrice[$index] * (float)$selectedPartsQuantity[$index];
            $perPart->save();
        }
        
        return redirect()->route('chargeable')->with('success', 'Request Has Been Updated Successfully!');
    }











    




    

    public function returnParts(Request $request){
        $id = $request->id;
        $allParts = ChargeableRequestParts::where('request_id', $id)->get();
        $res = '<p class="mb-2 text-xs italic">*please select all the parts with error</p>';
        
        foreach ($allParts as $index => $eachPart){
            $res .= '
                <div class="mb-4">
                    <div class="flex items-center mb-1">
                        <input id="part'.$eachPart->id.'" name="selectedParts[]" type="checkbox" value="'.$eachPart->id.'" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="part'.$eachPart->id.'" class="text-xs font-medium text-gray-900 ms-2">'.$eachPart->part_number.' - '.$eachPart->part_name.'</label>
                    </div>
                    <input type="text" id="part'.$eachPart->id.'_remarks" name="selectedPartsRemarks'.$eachPart->id.'" maxlength="250" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500" placeholder="Remarks">
                </div>
            ';
        }

        echo $res;
    }

    public function returnRequest(Request $request){
        $id = $request->id;
        $return_remarks = $request->return_remarks;
        $thisRequest = ChargeableRequest::where('id', $id)->first();

        if(Auth::user()->role == 3){
            foreach($request->selectedParts as $partID => $value){
                $selectPartVar = 'selectedPartsRemarks'.$value;
                $thisPart = ChargeableRequestParts::where('id', $value)->first();
                $thisPart->with_error = 1;
                $thisPart->remarks = $request->$selectPartVar;
                $thisPart->save();
            }   
            
            $thisRequest->is_validated = 0;
            $thisRequest->is_verified = 0;

            $thisRequest->is_returned_by_parts = 1;
        }elseif(Auth::user()->role == 11){
            $thisRequest->is_sq_number_encoded = 0;
        }elseif(Auth::user()->role == 7){
            $thisRequest->is_mri_number_encoded = 0;
        }else{
            $thisRequest->is_validated = 0;
            $thisRequest->is_verified = 0;
            $thisRequest->returned_count++;
            $thisRequest->is_returned = 1;
        }

        $thisRequest->is_returned = 1;
        $thisRequest->returned_count++;
        $thisRequest->returned_by = Auth()->user()->name;
        $thisRequest->datetime_returned = date('Y-m-d h:i:s');
        $thisRequest->returned_remarks = $return_remarks;

        $thisRequest->save();
        
        return redirect()->route('chargeable')->with('success', 'Request Has Been returned Successfully!');
    }

    public function viewReturnParts(Request $request){
        $id = $request->id;
        $allParts = ChargeableRequestParts::where('request_id', $id)->get();
        $res = '';

        foreach ($allParts as $partInfo){
            if ($partInfo->with_error == 1){
                $res .= '
                    <div class="w-full mb-5">
                        <div class="font-medium">
                            '.$partInfo->part_number.' - '.$partInfo->part_name.'
                        </div>
                        <div class="w-full px-4 py-2 border border-gray-500 rounded-lg">
                            '.$partInfo->remarks.'
                        </div>
                    </div>
                ';
            }
        }

        echo $res;
    }
}
