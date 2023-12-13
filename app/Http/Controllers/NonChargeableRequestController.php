<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\NonChargeableRequest;
use App\Models\NonChargeableRequestParts;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonChargeableRequestController extends Controller
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
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '1':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '2':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('site', Auth::user()->site)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '3':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
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

                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    // ->where('is_verified', 1)
                    ->whereIn('area', $area)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '5':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('is_service_approved', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '6':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('is_service_approved', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '7':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('is_mri_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '8':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('is_edoc_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            case '9':
                $results = NonChargeableRequest::whereRaw("CONCAT_WS(' ', number, customer_name, customer_address, customer_area, fleet_number, brand, model, serial_number, fsrr_number) LIKE ?", ['%' . $search . '%'])
                    ->where('is_dr_number_encoded', 1)
                    // ->where('is_deleted', 0)
                    ->orderBy('id', 'desc')
                    ->paginate(25);
                break;

            default:
                break;
        }

        return view('user.non-chargeable.index', compact('results', 'rental_request', 'search'));
    }






















    






    public function add(){
        $brands = Brand::where('is_deleted', 0)->orderBy('id', 'asc')->get();
        $customers = Customer::where('is_deleted', 0)->get();
        $site = Site::where('id', Auth::user()->site)->first()->name;
        $brand = '';
        $model = '';
        $models = [];
        $partsInfo = [];
        
        return view('user.non-chargeable.add', compact('customers', 'brands', 'models', 'site', 'brand', 'model', 'partsInfo'));
    }































    public function view(Request $request){
        $id = $request->id;
        $viewDetails = '';
        $status = '';

        $rental_request = NonChargeableRequest::with('siteDetails')->where('id', $id)->first();
        // $fsrr_fileExt = pathinfo($rental_request->fsrr_path, PATHINFO_EXTENSION);
        $allParts = NonChargeableRequestParts::where('rental_request_id', $id)->get();
        // $fleetHistory = NonChargeableRequest::where('fleet_number', $rental_request->fleet_number)->where('is_cancelled', 0)->where('id', '!=', $rental_request->id)->get();

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
            }else if($rental_request->is_verified == 1 && $rental_request->is_mri_number_encoded == 0){
                $status = 'Verified (For Encoding of MRI Number)';
            }else if($rental_request->is_service_approved == 1 && $rental_request->is_mri_number_encoded == 0){
                $status = 'Service Approved (For Encoding of MRI Number)';
            }else if($rental_request->is_mri_number_encoded == 1 && $rental_request->is_edoc_number_encoded == 0){
                $status = 'MRI Number Encoded (For Encoding of eDoc Number)';
            }else if($rental_request->is_edoc_number_encoded == 1 && $rental_request->is_dr_number_encoded == 0){
                $status = 'eDoc Number Encoded (For Encoding of DR Number)';
            }else if($rental_request->is_dr_number_encoded == 1 && $rental_request->is_confirmed == 0){
                $status = 'DR Number Encoded (For Signatories Confirmation)';
            }else if($rental_request->is_confirmed == 1){
                $status = 'Completed';
            }
        // Status
        
        // Encoded
            $encoded = '';
            if($rental_request->is_mri_number_encoded == 1){
                $encoded .= '
                    <div class="flex items-center w-full mb-2">
                        <p class="w-44">MRI Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->mri_number.'</p>
                    </div>
                ';
            }
            if($rental_request->is_edoc_number_encoded == 1){
                $encoded .= '
                    <div class="flex items-center w-full mb-2">
                        <p class="w-44">eDoc Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->edoc_number.'</p>
                    </div>
                ';
            }
            if($rental_request->is_dr_number_encoded == 1){
                $encoded .= '
                    <div class="flex items-center w-full">
                        <p class="w-44">DR Number: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->dr_number.'</p>
                    </div>
                ';
            }
            if($rental_request->is_mri_number_encoded == 1){
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
            if (($rental_request->is_service_approved == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_service_approved != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Service Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->service_remarks.'</textarea>
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
            if (($rental_request->is_edoc_number_encoded == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_edoc_encoded != null){
                if ($rental_request->serial_numbers != null){
                    $remarks .= '
                        <div class="flex items-start w-full pr-2 mb-2">
                            <p id="viewSerialNumbers" class="text-blue-600 cursor-pointer w-44 hover:underline">eDoc Encoder Remarks: </p>
                            <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->edoc_remarks.'</textarea>
                        </div>
                    ';
                }else{
                    $remarks .= '
                        <div class="flex items-start w-full pr-2 mb-2">
                            <p class="w-44">eDoc Encoder Remarks: </p>
                            <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->edoc_remarks.'</textarea>
                        </div>
                    ';
                }
            }
            if (($rental_request->is_dr_number_encoded == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_dr_encoded != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">DR Encoder Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->dr_remarks.'</textarea>
                    </div>
                ';
            }
            if (($rental_request->is_confirmed == 1 || $rental_request->is_returned == 1) && $rental_request->datetime_confirmed != null){
                $remarks .= '
                    <div class="flex items-start w-full pr-2 mb-2">
                        <p class="w-44">Signatory Remarks: </p>
                        <textarea style="resize:none;" class="w-full h-12 overflow-y-hidden border rounded-lg outline-none autoResize" readonly>'.$rental_request->signatory_remarks.'</textarea>
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
                        <a type="button" class="inline-flex items-center justify-center h-8 px-2 ml-auto text-sm text-blue-500 bg-transparent rounded-lg hover:bg-gray-200 hover:text-blue-600 hover:underline">
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
                elseif (Auth::user()->role == 4 && $rental_request->is_verified == 1 && $rental_request->is_service_approved == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">APPROVE</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 6 && $rental_request->is_service_approved == 1 && $rental_request->is_mri_number_encoded == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold  px-4 whitespace-nowrap py-2.5 hover:text-white focus:z-10">ENCODE MRI</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }
                elseif (Auth::user()->role == 7 && $rental_request->is_mri_number_encoded == 1 && $rental_request->is_edoc_number_encoded == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE EDOC Number</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }elseif (Auth::user()->role == 8 && $rental_request->is_edoc_number_encoded == 1 && $rental_request->is_dr_number_encoded == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">ENCODE DR Number</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
                    ';
                }elseif (Auth::user()->role == 9 && $rental_request->is_dr_number_encoded == 1 && $rental_request->is_confirmed == 0){
                    $controls2 = '
                        <button type="button" class="approveButton text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">CONFIRM REQUEST</button>
                        <button id="returnButton" type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-white focus:z-10 whitespace-nowrap px-4">RETURN REQUEST</button>
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
                                <h1 class="mb-10 text-2xl font-bold text-neutral-800">Request Details</h1>
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
                                    <div class="flex items-center w-full mt-6 mb-2">
                                        <p class="w-44">Request for: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->for.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Order Type: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->order_type.'</p>
                                    </div>
                                    <div class="flex items-center w-full mb-2">
                                        <p class="w-44">Date Needed: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->date_needed.'</p>
                                    </div>
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
                                    <div class="flex items-center w-full">
                                        <p class="w-44">Delivery Type: </p><p class="ml-1 font-bold w-[calc(100%-176px)] text-lg">'.$rental_request->delivery_type.'</p>
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

    public function viewFSRR(Request $request){
        $id = $request->id;
        $rental_request = NonChargeableRequest::with('siteDetails')->where('id', $id)->first();
        $fsrr_fileExt = pathinfo($rental_request->fsrr_path, PATHINFO_EXTENSION);

        if ($fsrr_fileExt == 'jpeg' || $fsrr_fileExt == 'jpg' || $fsrr_fileExt == 'png'){
            echo '<img src="'.$rental_request->fsrr_path.'" class="w-full h-auto">';
        }else{
            echo '<embed src="'.$rental_request->fsrr_path.'" type="application/pdf" class="w-full h-full">';
        }
    }

    public function viewHistory(Request $request){
        $id = $request->id;
        $rental_request = NonChargeableRequest::with('siteDetails')->where('id', $id)->first();
        $fleetHistory = NonChargeableRequest::where('fleet_number', $rental_request->fleet_number)->where('is_cancelled', 0)->where('id', '!=', $rental_request->id)->get();
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
                $oldParts = NonChargeableRequestParts::where('rental_request_id', $fleetHistory[0]->id)->get();
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
        $oldParts = NonChargeableRequestParts::where('rental_request_id', $id)->get();
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

    public function validateRequest(Request $request){
        $id = $request->id;

        $thisRequest = NonChargeableRequest::where('id', $id)->first();
        $thisRequest->is_validated = 1;
        $thisRequest->validator = Auth()->user()->name;
        $thisRequest->datetime_validated = date('Y-m-d h:i:s');
        $thisRequest->is_returned = 0;
        $thisRequest->is_returned_by_parts = 0;
        $thisRequest->save();

        NonChargeableRequestParts::where('rental_request_id', $id)->update([
            'with_error' => 0
        ]);
        
        return redirect()->route('nchargeable')->with('success', 'Request Has Been Validated Successfully!');
    }

    public function verifyRequest(Request $request){
        $id = $request->id;
        $remarks = $request->remarks;

        $thisRequest = NonChargeableRequest::where('id', $id)->first();

        $thisRequest->is_verified = 1;
        $thisRequest->verifier = Auth()->user()->name;
        $thisRequest->datetime_verified = date('Y-m-d h:i:s');
        $thisRequest->verifier_remarks = $remarks;

        $thisRequest->is_returned = 0;

        $thisRequest->save();

        NonChargeableRequestParts::where('rental_request_id', $id)->update([
            'with_error' => 0
        ]);
        
        return redirect()->route('nchargeable')->with('success', 'Request Has Been Validated Successfully!');
    }

    public function approveRequest(Request $request){
        $thisRequest = NonChargeableRequest::where('id', $request->id)->first();
        $thisRequest->is_returned = 0;

        switch (Auth::user()->role) {
            case '4':
                $thisRequest->is_service_approved = 1;
                $thisRequest->service_approver = Auth()->user()->name;
                $thisRequest->datetime_service_approved = date('Y-m-d h:i:s');
                $thisRequest->service_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('nchargeable')->with('success', 'Request Has Been Approved Successfully!');

                break;

            // case '5':
            //     $thisRequest->is_rental_approved = 1;
            //     $thisRequest->rental_approver = Auth()->user()->name;
            //     $thisRequest->datetime_rental_approved = date('Y-m-d h:i:s');
            //     $thisRequest->rental_remarks = $this->remarks;
            //     request()->session()->flash('success', 'Request Has Been Approved Successfully!');

            //     break;

            case '6':
                $request->validate([
                    'encode_input' => 'required'
                ]);
                $thisRequest->is_mri_number_encoded = 1;
                $thisRequest->mri_number = $request->encode_input;
                $thisRequest->mri_encoder = Auth()->user()->name;
                $thisRequest->datetime_mri_encoded = date('Y-m-d h:i:s');
                $thisRequest->mri_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('nchargeable')->with('success', 'MRI Number Has Been Encoded Successfully!');

                break;

            case '7':
                $request->validate([
                    'encode_input' => 'required'
                ]);
                $thisRequest->is_edoc_number_encoded = 1;
                $thisRequest->edoc_number = $request->encode_input;
                $thisRequest->serial_numbers = $request->serial_numbers;
                $thisRequest->edoc_encoder = Auth()->user()->name;
                $thisRequest->datetime_edoc_encoded = date('Y-m-d h:i:s');
                $thisRequest->edoc_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('nchargeable')->with('success', 'eDoc Number Has Been Encoded Successfully!');

                break;

            case '8':
                $request->validate([
                    'encode_input' => 'required'
                ]);
                $thisRequest->is_dr_number_encoded = 1;
                $thisRequest->dr_number = $request->encode_input;
                $thisRequest->dr_encoder = Auth()->user()->name;
                $thisRequest->datetime_dr_encoded = date('Y-m-d h:i:s');
                $thisRequest->dr_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('nchargeable')->with('success', 'DR Number Has Been Encoded Successfully!');

                break;

            case '9':
                $thisRequest->is_confirmed = 1;
                $thisRequest->signatory = Auth()->user()->name;
                $thisRequest->datetime_confirmed = date('Y-m-d h:i:s');
                $thisRequest->signatory_remarks = $request->remarks;
                $thisRequest->save();
                return redirect()->route('nchargeable')->with('success', 'Request Has Been Confirmed Successfully!');

                break;
            default:
                break;
        }


    }

    public function viewSerialNumbers(Request $request){
        $id = $request->id;
        $thisRequest = NonChargeableRequest::where('id', $request->id)->first();
        echo $thisRequest->serial_numbers;
    }

    public function returnParts(Request $request){
        $id = $request->id;
        $allParts = NonChargeableRequestParts::where('rental_request_id', $id)->get();
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
        $thisRequest = NonChargeableRequest::where('id', $id)->first();

        $thisRequest->is_validated = 0;
        $thisRequest->is_verified = 0;
        $thisRequest->is_service_approved = 0;
        $thisRequest->is_mri_number_encoded = 0;
        $thisRequest->is_edoc_number_encoded = 0;
        $thisRequest->is_dr_number_encoded = 0;

        $thisRequest->is_returned = 1;

        if(Auth::user()->role == 3){
            $thisRequest->is_returned_by_parts = 1;
        }

        $thisRequest->returned_by = Auth()->user()->name;
        $thisRequest->datetime_returned = date('Y-m-d h:i:s');
        $thisRequest->returned_remarks = $return_remarks;

        $thisRequest->save();

        if(Auth::user()->role == 3){
            foreach($request->selectedParts as $partID => $value){
                $selectPartVar = 'selectedPartsRemarks'.$value;
                $thisPart = NonChargeableRequestParts::where('id', $value)->first();
                $thisPart->with_error = 1;
                $thisPart->remarks = $request->$selectPartVar;
                $thisPart->save();
            }
        }
        
        return redirect()->route('nchargeable')->with('success', 'Request Has Been returned Successfully!');
    }

    public function viewReturnParts(Request $request){
        $id = $request->id;
        $allParts = NonChargeableRequestParts::where('rental_request_id', $id)->get();
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
