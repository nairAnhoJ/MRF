<x-app-layout>

    <style>
        .datepicker-picker{
            background-color: #fff;
            color: black;
        }
        .datepicker-cell{
            color: rgb(17, 24, 39);
        }
        .datepicker-controls button{
            background-color: #fff;
            color: rgb(17, 24, 39);
        }
        .datepicker-controls button:hover{
            background-color: rgb(209 213 219);
            color: rgb(17, 24, 39);
        }
        .datepicker-cell:hover{
            background-color: rgb(209 213 219);
            color: rgb(17, 24, 39);
        }
        .datepicker-grid .focused{
            background-color: rgb(156 163 175);
            color: black;
        }
        .bg-gray-900{
            opacity: 40%;
        }
    </style>

    <div style="height: calc(100vh - 64px);" class="w-screen h-screen p-3 flex flex-col-reverse">





        <div class="mb-3 mr-10">
            <div class="flex flex-row justify-end order-2 pr-5">
                <button id="btnBack" type="button" class="hidden text-white bg-blue-700 hover:bg-blue-800 border border-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center w-28">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" class="mr-2 -ml-1 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>                      
                    <span id="txtBack" style="color: white;">Back</span>
                </button>
                <button id="btnNext" type="button" class="text-white bg-blue-700 hover:bg-blue-800 border border-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center w-28">
                    <span id="txtNext" style="color: white;">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" class="ml-2 -mr-1 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>                                           
                </button>
            </div>


            <ul class="hidden flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="request-details-tab" data-tabs-target="#request_details" type="button" role="tab" aria-controls="request_details" aria-selected="false">Profile</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="parts-info-tab" data-tabs-target="#parts_info" type="button" role="tab" aria-controls="parts_info" aria-selected="false">Dashboard</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="confirmation-tab" data-tabs-target="#confirmation" type="button" role="tab" aria-controls="confirmation" aria-selected="false">Settings</button>
                </li>
            </ul>
        </div>










        
        {{-- ////////////////////////////////////////// TABS ////////////////////////////////////////// --}}
        <div style="height: calc(100vh - 148px);" id="myTabContent" class="p-3">


























            {{-- ////////////////////////////////////////// REQUEST DETAILS ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-50 rounded-lg h-full" id="request_details" role="tabpanel" aria-labelledby="request-details-tab">
                <form method="POST" action="{{ route('rental.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-2 mb-3 md:grid-cols-2">
                        <div class="pr-10">
                            <label for="req_for" class="block text-sm font-medium text-gray-900">Request For</label>
                            <select id="req_for" name="req_for" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                                <option value="pm">FOR PM</option>
                                <option value="repair">FOR REPAIR</option>
                            </select>
                        </div>
                        <div class="pr-10">
                            <label for="fleet_no" class="block text-sm font-medium text-gray-900">Fleet Number</label>
                            <input type="text" id="fleet_no" name="fleet_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                        </div>
                        <div class="pr-10">
                            <label for="order_type" class="block text-sm font-medium text-gray-900">Order Type</label>
                            <select id="order_type" name="order_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                                <option value="in_stock">IN STOCK</option>
                                <option value="req_parts">REQUEST PARTS</option>
                            </select>
                        </div>
                        <div class="pr-10">
                            <label for="brand" class="block text-sm font-medium text-gray-900">Brand</label>
                            <select id="brand" name="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                                @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pr-10">
                            <label for="area" class="block text-sm font-medium text-gray-900">Area</label>
                            <input type="text" id="area" name="area" value="{{auth()->user()->area}}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                        </div>
                        <div class="pr-10">
                            <label for="model" class="block text-sm font-medium text-gray-900">Model</label>
                            <select id="model" name="model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                                @foreach ($models as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pr-10">
                            <label for="date_needed" class="block text-sm font-medium text-gray-900">Date Needed</label>
                                <div class="relative"><div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input datepicker datepicker-autohide type="text" id="date_needed" name="date_needed" value="{{ date("m/d/Y") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                                </div>
                            </div>
                        </div>
                        <div class="pr-10">
                            <label for="serial_no" class="block text-sm font-medium text-gray-900">Serial Number</label>
                            <input type="text" id="serial_no" name="serial_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                        </div>
                        <div class="pr-10">
                            <label for="cus_name" class="block text-sm font-medium text-gray-900">Customer Name</label>
                            <input type="text" id="cus_name" name="cus_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                        </div>
                        <div class="pr-0">
                            <label for="fsrr_no" class="block text-sm font-medium text-gray-900">FSRR Number</label>
                            <input style="width: calc(100% - 258px);" type="text" id="fsrr_no" name="fsrr_no" class="inline bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-2.5 mr-2" required>
                            {{-- <input id="fsrr_upload" name="fsrr_upload" type="file" class="hidden" required/> --}}
                            <button type="button" id="btnUploadFSRR" class="inline text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 mr-2 w-24">Upload</button>
                            <button type="button" id="btnViewFSRR" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 mr-2 w-24">View</button>
                        </div>
                        <div class="pr-10">
                            <label for="cus_address" class="block text-sm font-medium text-gray-900">Customer Address</label>
                            <input type="text" id="cus_address" name="cus_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                        </div>
                        <div class="pr-10">
                            <label for="delivery_type" class="block text-sm font-medium text-gray-900">Delivery Type <span class="ml-5 text-gray-500 text-xs">*If others, please specify on 'Site Remarks'</span></label>
                            <select id="delivery_type" name="delivery_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                                <option value="Regular">Regular</option>
                                <option value="Same Day">Same Day</option>
                                <option value="Pickup">Pickup</option>
                                <option value="Air">Air</option>
                                <option value="Sea">Sea</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="pr-10">
                        <label for="site_remarks" class="block text-sm font-medium text-gray-900">Site Remarks</label>
                        <textarea id="site_remarks" name="site_remarks" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5"></textarea>
                    </div>
                    <input type="submit" id="btnSubmitMRF" class="hidden">
                </form>
            </div>














































            {{-- ////////////////////////////////////////// PARTS INFORMATION ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="parts_info" role="tabpanel" aria-labelledby="parts-info-tab">
                PARTS INFORMATION
            </div>















            {{-- ////////////////////////////////////////// CONFIRMATION ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-100 rounded-lg" id="confirmation" role="tabpanel" aria-labelledby="confirmation-tab">
                CONFIRMATION

                <!-- Modal toggle -->
                <button id="btnConfirmModal" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button" data-modal-toggle="confirmationModal">
                    Toggle modal
                </button>
                
                <!-- Main modal -->
                <div style="background: transparent;" id="confirmationModal" data-modal-backdrop="static" tabindex="1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
                    <div class="relative w-full max-w-md h-full md:h-auto">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="flex justify-between items-start p-4 rounded-t border-b">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Create MRF
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="confirmationModal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <p class="text-base text-center leading-relaxed text-gray-500">
                                    Are you sure?
                                </p>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200">
                                <button data-modal-toggle="confirmationModal" type="button" id="btnConfirmMRF" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center font-bold tracking-widest">Confirm</button>
                                <button data-modal-toggle="confirmationModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 font-bold tracking-widest">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>
  
  
            </div>













        </div>
    </div>

    <script>
        $(document).ready(function(){
            var tab = 1;
            $('#btnNext').click(function(){
                tab++;
                if(tab == 2){
                    $('#btnBack').removeClass('hidden');
                    $('#parts-info-tab').click();
                }else if(tab == 3){
                    $('#txtNext').html('Create');
                    $('#confirmation-tab').click();
                }else if(tab > 3){
                    tab = 3;
                    $('#btnConfirmModal').click();
                }
            });
            $('#btnBack').click(function(){
                tab--;
                if(tab == 1){
                    $('#btnBack').addClass('hidden');
                    $('#request-details-tab').click();
                }else if(tab == 2){
                    $('#btnBack').removeClass('hidden');
                    $('#txtNext').html('Next');
                    $('#parts-info-tab').click();
                }
            });

            $('#btnConfirmMRF').click(function(){
                $('#btnSubmitMRF').click();
            });

            

            $('#brand').change(function(){
                var brandVal = $('#brand option:selected').val();
                var _token = $('input[name="_token"]').val();
                    
                $.ajax({
                    url: "{{ route('rental.getModel') }}",
                    method: "POST",
                    data: {
                        brandVal: brandVal,
                        _token: _token
                    },
                    success:function(res){
                        $('#model').html(res);
                    }
                })
            });
        });
    </script>
</x-app-layout>
