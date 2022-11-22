<x-app-layout>
    <div style="height: calc(100vh - 64px);" class="w-screen h-screen p-3 flex flex-col-reverse">
        <div class="mb-3 border-b border-gray-200">
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
        <div style="height: calc(100vh - 148px);" id="myTabContent" class="p-3">
            {{-- ////////////////////////////////////////// REQUEST DETAILS ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-50 rounded-lg h-full" id="request_details" role="tabpanel" aria-labelledby="request-details-tab">
                <form>
                    <div class="grid gap-2 mb-6 md:grid-cols-2">
                        <div class="pr-60">
                            <label for="req_for" class="block text-sm font-medium text-gray-900">Request For</label>
                            <select id="req_for" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                                <option value="pm">FOR PM</option>
                                <option value="repair">FOR REPAIR</option>
                            </select>
                        </div>
                        <div class="pr-60">
                            <label for="fleet_no" class="block text-sm font-medium text-gray-900">Fleet Number</label>
                            <input type="text" id="fleet_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                            {{-- <p class="text-sm text-red-600"><span class="font-medium">Oh, snapp!</span> Some error message.</p> --}}
                        </div>
                        <div class="pr-60">
                            <label for="order_type" class="block text-sm font-medium text-gray-900">Order Type</label>
                            <select id="order_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                                <option value="in_stock">IN STOCK</option>
                                <option value="req_parts">REQUEST PARTS</option>
                            </select>
                        </div>
                        <div class="pr-60">
                            <label for="brand" class="block text-sm font-medium text-gray-900">Brand</label>
                            <select id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                                @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pr-60">
                            <label for="area" class="block text-sm font-medium text-gray-900">Area</label>
                            <input type="text" id="area" value="{{auth()->user()->area}}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5" required>
                            {{-- <p class="text-sm text-red-600"><span class="font-medium">Oh, snapp!</span> Some error message.</p> --}}
                        </div>
                        <div class="pr-60">
                            <label for="model" class="block text-sm font-medium text-gray-900">Model</label>
                            <select id="model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                                <option>- - -</option>
                            </select>
                        </div>












                        {{-- <div>
                            <label for="error" class="block mb-2 text-sm font-medium text-red-700">Your name</label>
                            <input type="text" id="error" class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5" placeholder="Error input">
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oh, snapp!</span> Some error message.</p>
                        </div>
                        <div>
                            <label for="error" class="block mb-2 text-sm font-medium text-red-700">Your name</label>
                            <input type="text" id="error" class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5" placeholder="Error input">
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oh, snapp!</span> Some error message.</p>
                        </div> --}}
                    </div>
                </form>
            </div>

            {{-- ////////////////////////////////////////// PARTS INFORMATION ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="parts_info" role="tabpanel" aria-labelledby="parts-info-tab">
                <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-800">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
            </div>

            {{-- ////////////////////////////////////////// CONFIRMATION ////////////////////////////////////////// --}}
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="confirmation" role="tabpanel" aria-labelledby="confirmation-tab">
                <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-800">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
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
        });
    </script>
</x-app-layout>
