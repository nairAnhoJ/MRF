@extends('layouts.app')
@section('title','Non-Chargeable Request Form')
@section('content')

    
    {{-- HISTORY MODAL --}}
        <div id="historyModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-5">
            <div class="w-5/6 h-full bg-white rounded-lg">
                <!-- Modal content -->
                <div class="relative h-full bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            History
                        </h3>
                        <button type="button" id="closeHistoryModal" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="!m-0 overflow-scroll sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div id="historyModalContent" class="py-4 px-10 h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex items-start justify-center">
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" id="closeHistoryModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- HISTORY MODAL// --}}
    
    {{-- FSRR MODAL --}}
        <div id="fsrrModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
            <div class="w-5/6 h-full bg-white rounded-lg">
                <!-- Modal content -->
                <div class="relative h-full bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Attachment Preview
                        </h3>
                        <button type="button" id="closeFsrrModal" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div id="fsrrModalContent" class="py-4 px-10 h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex items-start justify-center">
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" id="closeFsrrModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- FSRR MODAL// --}}

    {{-- FSRR MODAL --}}
        <div id="fsrrModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
            <div class="w-5/6 h-full bg-white rounded-lg">
                <!-- Modal content -->
                <form wire:submit='update' class="relative h-full bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Attachment Preview
                        </h3>
                        <button type="button" wire:click='closeFsrrModal' class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div id="fsrrModalContent" class="py-4 px-10 h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex items-start justify-center">
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" wire:click='closeFsrrModal' class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    {{-- FSRR MODAL --}}

    {{-- PARTS MODAL --}}
        <div id="partsModal" class="hidden fixed top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
            <div class="w-5/6 h-full bg-white rounded-lg">
                <!-- Modal content -->
                <form class="relative h-full bg-white rounded-lg shadow">
                    @csrf
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add Parts
                        </h3>
                        <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg addSelectedParts hover:bg-gray-200 hover:text-gray-900">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 h-[calc(100%-140px)] overflow-hidden">
                        <div class="flex items-center justify-between h-11">
                            <h1 class="text-lg font-medium text-neutral-700 whitespace-nowrap">
                            </h1>
                            <div class="relative w-1/2 h-full mb-2">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id='partSearch' class="block w-full h-full pl-10 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Part Number or Part Name ..." autocomplete="off">
                            </div>
                        </div>
                        <div class="h-[calc(100%-52px)] w-full overflow-y-auto">
                            <table class="w-full">
                                <thead class="sticky top-0 py-1 bg-white">
                                    <tr class="border-b">
                                        <th></th>
                                        <th>Part Number</th>
                                        <th>Part Name</th>
                                        <th>Part Brand</th>
                                        <th>Part Price(₱)</th>
                                    </tr>
                                </thead>
                                <tbody id="partsBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="button" class="addSelectedParts text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    {{-- PARTS MODAL --}}

    {{-- CONTENT --}}
        <div class="w-screen h-screen pt-14">
            <form action="{{ route('nchargeable.store') }}" method="POST" enctype="multipart/form-data" id="requestForm" class="relative h-full">
                @csrf
                <!-- body -->
                <div class="p-4 h-[calc(100%-75px)] overflow-hidden">
                    <div id="tab-container" class="w-[400%] h-full transition-all duration-1000 ease-in flex -translate-x-0">
                        <div id="tab1" class="w-1/4 h-full mr-4 space-y-4 overflow-x-hidden overflow-y-auto">
                            <h1 class="text-xl font-bold text-neutral-800">Request Info</h1>

                            <div class="flex gap-x-4">
                                <div class="w-full">
                                    <label for="for" class="block text-sm font-medium text-gray-900">Request For</label>
                                    <select id="for" name='for' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" hidden>Select Request For</option>
                                        <option value="FOR PM" {{ (old('for') == 'FOR PM') ? 'selected' : '' }}>For PM</option>
                                        <option value="FOR REPAIR" {{ (old('for') == 'FOR REPAIR') ? 'selected' : '' }}>For Repair</option>
                                    </select>
                                    @error('for')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="order_type" class="block text-sm font-medium text-gray-900">Order Type</label>
                                    <select id="order_type" name='order_type'" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" hidden>Select Order Type</option>
                                        <option value="IN STOCK" {{ (old('order_type') == 'IN STOCK') ? 'selected' : '' }}>In Stock</option>
                                        <option value="REQUEST PARTS" {{ (old('order_type') == 'REQUEST PARTS') ? 'selected' : '' }}>Request Parts</option>
                                    </select>
                                    @error('order_type')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="date_needed" class="block text-sm font-medium text-gray-900">Date Needed</label>
                                    <input type="date" name='date_needed' id="date_needed" value="{{ old('date_needed') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('date_needed')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="site" class="block text-sm font-medium text-gray-900">Site</label>
                                    <input type="text" id="site" value='{{ $site }}' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off" disabled>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block mt-3 text-sm font-medium text-gray-900">Customer</label>
                                <div class="relative w-full wrapper">
                                    <div class="flex items-center justify-between p-2.5 border border-gray-300 rounded-md cursor-pointer bg-gray-50 select-btn h-[42px]">
                                        <span id="customer_name">{{ (old('customer_name') == '') ? 'Select Customer' : old('customer_name') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full text-gray-700 transition-transform duration-300" viewBox="0 -960 960 960" fill='currentColor'><path d="M480-322 216-586l67-67 197 198 197-197 67 67-264 263Z"/></svg>
                                    </div>
                                    <div class="absolute z-50 hidden w-full p-3 mt-1 border border-gray-300 rounded-md bg-gray-50 content">
                                        <div class="relative search">
                                            <i class="absolute leading-9 text-gray-500 uil uil-search left-3"></i>
                                            <input type="text" class="w-full leading-9 text-gray-900 rounded-md outline-none selectSearch pl-9 h-9" placeholder="Search">
                                        </div>
                                        <ul class="mt-2 overflow-y-auto customerOption listOption options max-h-64">
                                            @foreach ($customers as $customer)
                                                <li data-name="{{ $customer->name }}" data-address="{{ $customer->address }}" data-area="{{ $customer->area }}" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-200 customerSelected"><span>{{ $customer->name }}</span><span class="ml-2">📌{{ $customer->address }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name='customer_name' value="{{ old('customer_name') }}">
                                </div>
                                @error('customer_name')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="flex gap-x-4">
                                <div class="w-full">
                                    <label for="customer_address" class="block text-sm font-medium text-gray-900">Address</label>
                                    <input type="text" id="customer_address" name='customer_address' value="{{ old('customer_address') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                                    @error('customer_address')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class=" w-96">
                                    <label for="customer_area" class="block text-sm font-medium text-gray-900">Area</label>
                                    <input type="text" id="customer_area" name='customer_area' value="{{ old('customer_area') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                                    @error('customer_area')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex gap-x-4">
                                <div class="w-full">
                                    <label for="brand" class="block text-sm font-medium text-gray-900">Brand</label>
                                    <select id="brand" name='brand' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" hidden>Select Brand</option>
                                        @foreach ($brands as $brandOption)
                                            <option data-name="{{ $brandOption->name }}" value="{{ $brandOption->id }}" {{ (old('brand') == $brandOption->id) ? 'selected' : '' }}>{{ $brandOption->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-900">Model</label>
                                    <div class="relative w-full wrapper">
                                        <div id="modelSelect" class="flex items-center justify-between p-2.5 border border-gray-300 rounded-md bg-gray-50  h-[42px] opacity-60">
                                            <span id="model">{{ (old('model') == '') ? 'Select Model' : old('model') }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full text-gray-700 transition-transform duration-300" viewBox="0 -960 960 960" fill='currentColor'><path d="M480-322 216-586l67-67 197 198 197-197 67 67-264 263Z"/></svg>
                                        </div>
                                        <div class="absolute z-50 hidden w-full p-3 mt-1 border border-gray-300 rounded-md bg-gray-50 content">
                                            <div class="relative search">
                                                <i class="absolute leading-9 text-gray-500 uil uil-search left-3"></i>
                                                <input type="text" class="w-full leading-9 text-gray-900 rounded-md outline-none selectSearch pl-9 h-9" placeholder="Search">
                                            </div>
                                            <ul class="mt-2 overflow-y-auto listOption modelOptions options max-h-64">
                                                {{-- @foreach ($models as $modelrow)
                                                    <li data-name="{{ $modelrow->name }}" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-200">{{ $modelrow->name }}</li>
                                                @endforeach --}}
                                            </ul>
                                        </div>
                                        <input type="hidden" name='model' value="{{ old('model') }}">
                                    </div>
                                    @error('model')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="serial_number" class="block text-sm font-medium text-gray-900">Serial Number</label>
                                    <input type="text" id="serial_number" name='serial_number' value="{{ old('serial_number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('serial_number')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="fleet_number" class="block text-sm font-medium text-gray-900">Fleet Number</label>
                                    <div class="flex gap-x-2">
                                        <input type="text" name='fleet_number' id="fleet_number" value="{{ old('fleet_number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                        <button type="button" id="viewHistoryButton" disabled class="disabled:pointer-events-none disabled:opacity-60 h-[42px] bg-gray-100 border rounded-lg border-gray-300 aspect-square p-[6px] text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill=currentColor>
                                                <path d="M476.056-95Q315-95 203.795-207.427 92.591-319.853 94-481h94q1.152 121.3 84.005 206.65Q354.859-189 476-189q122 0 208-86.321t86-209.5Q770-605 683.627-688T476-771q-60 0-113.5 24.5T268-680h84v73H123v-227h71v95q55-59 127.5-93T476-866q80 0 150.5 30.5t123.74 82.511q53.241 52.011 83.5 121.5Q864-562 864-482t-30.26 150.489q-30.259 70.489-83.5 123Q697-156 626.5-125.5 556-95 476.056-95ZM600-311 446-463v-220h71v189l135 131-52 52Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('fleet_number')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-x-4">
                                <div class="w-full">
                                    <label for="fsrr_number" class="block text-sm font-medium text-gray-900">FSRR Number</label>
                                    <input type="text" id="fsrr_number" name='fsrr_number' value="{{ old('fsrr_number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('fsrr_number')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="fsrrFile" class="block text-sm font-medium text-gray-900">Upload FSRR</label>
                                    <div class="flex gap-x-2">
                                        <input type="file" id='fsrrFile' name="fsrrFile" value="{{ old('fsrrFile') }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" accept=".jpeg, .jpg, .png, .pdf">
                                        <button {{ (old('fsrrFile') == null) ? 'disabled' : '' }} type="button" id='viewFsrrButton' class="disabled:pointer-events-none disabled:opacity-60 h-[42px] bg-gray-100 border rounded-lg border-gray-300 aspect-square p-[6px] text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill=currentColor>
                                                <path xmlns="http://www.w3.org/2000/svg" d="M480.118-330Q551-330 600.5-379.618q49.5-49.617 49.5-120.5Q650-571 600.382-620.5q-49.617-49.5-120.5-49.5Q409-670 359.5-620.382q-49.5 49.617-49.5 120.5Q310-429 359.618-379.5q49.617 49.5 120.5 49.5ZM480-404q-40 0-68-28t-28-68q0-40 28-68t68-28q40 0 68 28t28 68q0 40-28 68t-68 28Zm0 227q-154 0-278-90T17-500q61-143 185-233t278-90q154 0 278 90t185 233q-61 143-185 233t-278 90Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('fsrrFile')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="delivery_type" class="block text-sm font-medium text-gray-900">Delivery Type</label>
                                    <select id="delivery_type" name='delivery_type' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" hidden>Select Order Type</option>
                                        <option value="REGULAR" {{ (old('delivery_type') == 'REGULAR') ? 'selected' : '' }}>Regular</option>
                                        <option value="SAME DAY" {{ (old('delivery_type') == 'SAME DAY') ? 'selected' : '' }}>Same Day</option>
                                        <option value="PICKUP" {{ (old('delivery_type') == 'PICKUP') ? 'selected' : '' }}>Pick Up</option>
                                        <option value="AIR" {{ (old('delivery_type') == 'AIR') ? 'selected' : '' }}>Air</option>
                                        <option value="SEA" {{ (old('delivery_type') == 'SEA') ? 'selected' : '' }}>Sea</option>
                                        <option value="OTHERS" {{ (old('delivery_type') == 'OTHERS') ? 'selected' : '' }}>Others</option>
                                    </select>
                                    @error('delivery_type')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full">
                                <label for="requestor_remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                <textarea style="resize: none;" id='requestor_remarks' name='requestor_remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-32" autocomplete="off">{{ old('requestor_remarks') }}</textarea>
                            </div>
                            
                        </div>
                        <div id="tab2" class="w-1/4 h-full mr-4 overflow-x-hidden overflow-y-auto">
                            <div class="sticky top-0 flex items-center justify-between pb-4 bg-white">
                                <h1 class="text-xl font-bold text-neutral-800">Parts Info</h1>
                                <button id='addParts' type="button" class="text-blue-500 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 -960 960 960" fill=currentColor>
                                        <path d="M447-274h72v-166h167v-72H519v-174h-72v174H274v72h173v166Zm33.404 219q-88.872 0-166.125-33.084-77.254-33.083-135.183-91.012-57.929-57.929-91.012-135.119Q55-391.406 55-480.362q0-88.957 33.084-166.285 33.083-77.328 90.855-134.809 57.772-57.482 135.036-91.013Q391.238-906 480.279-906q89.04 0 166.486 33.454 77.446 33.453 134.853 90.802 57.407 57.349 90.895 134.877Q906-569.34 906-480.266q0 89.01-33.531 166.247-33.531 77.237-91.013 134.86-57.481 57.623-134.831 90.891Q569.276-55 480.404-55Z"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" id="selectedParts" name="selectedParts">
                            <input type="hidden" id="selectedPartsQuantity" name="selectedPartsQuantity">
                            <input type="hidden" id="selectedPartsPrice" name="selectedPartsPrice">
                            <div class="w-full">
                                <div class="w-full ">
                                    <table class="w-full text-center">
                                        <thead class="sticky text-sm bg-white border-b shadow top-14 text-neutral-700">
                                            <tr>
                                                <th class="pb-2">#</th>
                                                <th class="pb-2 text-left">Part Number</th>
                                                <th class="pb-2">Description</th>
                                                <th class="pb-2">Brand</th>
                                                <th class="pb-2">Quantity</th>
                                                <th class="pb-2">Unit Price(₱)</th>
                                                <th class="pb-2">Total Price(₱)</th>
                                                <th class="pb-2">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selectedPartsBody" class="text-sm">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab3" class="flex w-1/4 h-full space-y-4 overflow-hidden">
                            <div class="w-full pr-4 border-r">
                                <h1 class="mb-10 text-xl font-bold text-neutral-800">Confirmation</h1>
                                <div class="w-full h-[calc(100%-64px)] overflow-x-hidden overflow-y-auto pr-4">
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Customer: </p><p id="con_customer_name" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Address: </p><p class="ml-1 font-bold w-[calc(100%-144px)] text-lg"><span id="con_customer_address"></span><span class=" whitespace-nowrap">〈 <span id="con_customer_area"></span> 〉</span></p>
                                    </div>
                                    <div class="flex w-full mb-5">
                                        <p class="w-36">Site: </p><p class="ml-1 font-bold w-[calc(100%-144px)] text-lg">{{ $site }}</p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Request for: </p><p id="con_for" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Order Type: </p><p id="con_order_type" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Date Needed: </p><p id="con_date_needed" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Brand: </p><p id="con_brand" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36 w-">Model: </p><p id="con_model" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Serial Number: </p><p id="con_serial_number" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Fleet Number: </p><p id="con_fleet_number" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">FSRR Number: </p><p id="con_fsrr_number" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Delivery Type: </p><p id="con_delivery_type" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p>
                                    </div>
                                    <div class="flex w-full mb-2">
                                        <p class="w-36">Remarks: </p>
                                        <textarea style="resize:none;" id="con_requestor_remarks" class="w-full h-10 overflow-y-hidden rounded-lg outline-none autoResize" readonly></textarea>
                                        
                                        {{-- <p id="con_requestor_remarks" class="ml-1 font-bold w-[calc(100%-144px)] text-lg"></p> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="w-full pl-4 !m-0 h-full overflow-auto">
                                <div class="w-full">
                                    <table class="w-full">
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
                                        <tbody id="con_selectedPartsBody" class="text-sm">
                                            {{-- @foreach ($partsInfo as $index => $partInfo)
                                                <tr class="border-b">
                                                    <th class="px-2 whitespace-nowrap">{{ $index + 1 }}</th>
                                                    <td class="px-2 whitespace-nowrap">{{ $partInfo->partno }}</td>
                                                    <td class="px-2 whitespace-nowrap">{{ $partInfo->partname }}</td>
                                                    <td class="px-2 text-center whitespace-nowrap">{{ $partInfo->brand }}</td>
                                                    <td class="px-2 py-2 text-center whitespace-nowrap">
                                                        {{ $partInfo->quantity }}
                                                    </td>
                                                    <td class="px-2 text-center whitespace-nowrap">
                                                        {{ str_replace(",", "", $partInfo->price) }}
                                                    </td>
                                                    <td class="px-2 text-center whitespace-nowrap">
                                                        {{ number_format((str_replace(",", "", $partInfo->price) * $partInfo->quantity), 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer -->
                <div class="flex items-center justify-between p-4 space-x-2 border-t border-gray-200 rounded-b">
                    <a href="{{ route('nchargeable') }}" class="text-gray-500 loading text-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium py-2.5 hover:text-gray-900 focus:z-10 ml-2 w-24">CANCEL</a>
                    <div>
                        <button id="backBtn" type="button" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 text-center w-24">BACK</button>
                        <button id="nextBtn" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 text-center w-24">NEXT</button>
                        <button id="submitBtn" type="submit" class="hidden loading text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 text-center w-24">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    {{-- CONTENT --}}

    <script>
        $(document).ready(function () {
            var tab = 1;
            var _token = $('input[name="_token"]').val();
            var delayTimer;
            var selectedParts = [];

            function searchFilter(searchInput){
                $(".listOption li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchInput) > -1)
                });
            }

            jQuery(document).on( "click", ".customerOption li", function(){
                var name = $(this).data('name');
                var address = $(this).data('address');
                var area = $(this).data('area');

                $('input[name="customer_name"]').val(name);
                $('#customer_name').html(name);
                $('input[name="customer_address"]').val(address);
                $('input[name="customer_area"]').val(area);

                $('.content').addClass('hidden');
                $('.selectSearch').val('');
                var value = $(".selectSearch").val().toLowerCase();
                searchFilter(value);
            });

            jQuery(document).on( "change", "#brand", function(){
                var id = $(this).val();
                var name = $(this).find(':selected').data('name');
                $('#con_brand').html(name);
                
                $.ajax({
                    url:"{{ route('nchargeable.add.getModels') }}",
                    method:"POST",
                    data:{
                        id: id,
                        _token: _token
                    },
                    success:function(result){
                        console.log(result);
                        $('.modelOptions').html(result);
                        
                        $('#modelSelect').removeClass('opacity-60');
                        $('#modelSelect').addClass('select-btn cursor-pointer');

                        $('.selectSearch').val('');
                        var value = $(".selectSearch").val().toLowerCase();
                        searchFilter(value);
                    }
                })
            });
            
            jQuery(document).on( "click", ".modelOptions li", function(){
                var name = $(this).data('name');

                $('input[name="model"]').val(name);
                $('#model').html(name);

                $('.content').addClass('hidden');
                $('.selectSearch').val('');
                var value = $(".selectSearch").val().toLowerCase();
                searchFilter(value);
            });
            
            jQuery(document).on("keyup", "#fleet_number", function(){
                var val = $(this).val();
                if(val != ''){
                    $('#viewHistoryButton').prop('disabled', false);
                }else{
                    $('#viewHistoryButton').prop('disabled', true);
                }
            });
            
            jQuery(document).on( "click", "#viewHistoryButton", function(){
                var fleet_number = $('#fleet_number').val();
                var id = 0;
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('nchargeable.viewHistory') }}",
                    method:"POST",
                    data: {
                        id: id,
                        fleet_number: fleet_number,
                        _token: _token,
                    },
                    success: function (response) {
                        $('#historyModalContent').html(response);
                        $('#historyModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            });
        
            jQuery(document).on("click", "#viewOldRequest", function() {
                $('#loading').removeClass('hidden');
                var req_id = $(this).data('id');
                $.ajax({
                    url:"{{ route('nchargeable.viewHistoryParts') }}",
                    method:"POST",
                    data: {
                        id: req_id,
                        _token: _token,
                    },
                    success: function (response) {
                        jQuery('#HistoryParts').html(response);
                        $('#loading').addClass('hidden');
                    }
                });
            });
        
            jQuery(document).on("click", "#closeHistoryModal", function() {
                $('#historyModal').addClass('hidden');
            });
            
            $('input[name="fsrrFile"]').change(function() {
                if (this.files.length > 0) {
                    $('#viewFsrrButton').prop('disabled', false);
                } else {
                    $('#viewFsrrButton').prop('disabled', true);
                }
            });
        
            jQuery(document).on("click", "#viewFsrrButton", function() {
                $('#loading').removeClass('hidden');
                var id = 0;
                var formData = new FormData();
                formData.append('fsrrFile', $('input[name="fsrrFile"]')[0].files[0]);
                formData.append('id', id);
                formData.append('_token', _token);

                var fsrrFile = $('input[name="fsrrFile"]').val();
                $.ajax({
                    url:"{{ route('nchargeable.viewFSRR') }}",
                    method:"POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#fsrrModalContent').html(response);
                        $('#fsrrModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            });
        
            jQuery(document).on("click", "#closeFsrrModal", function() {
                $('#fsrrModal').addClass('hidden');
            });
        
            jQuery(document).on("click", "#nextBtn", function() {
                if(tab == 1){
                    tab = 2;
                    $('#tab-container').removeClass('-translate-x-0');
                    $('#tab-container').removeClass('-translate-x-[calc(25%+16px)]');
                    $('#tab-container').removeClass('-translate-x-[calc(50%+32px)]');
                    $('#tab-container').addClass('-translate-x-[calc(25%+16px)]');
                    $('#backBtn').removeClass('hidden');
                }else if(tab== 2){
                    $('#loading').removeClass('hidden');
                    tab = 3;
                    
                    var customer_name = $('input[name="customer_name"]').val();
                    $('#con_customer_name').html(customer_name);

                    var customer_address = $('input[name="customer_address"]').val();
                    $('#con_customer_address').html(customer_address);

                    var customer_area = $('input[name="customer_area"]').val();
                    $('#con_customer_area').html(customer_area);

                    var cfor = $('#for').val();
                    $('#con_for').html(cfor);

                    var order_type = $('#order_type').val();
                    $('#con_order_type').html(order_type);

                    var date_needed = $('input[name="date_needed"]').val();
                    $('#con_date_needed').html(date_needed);

                    var model = $('input[name="model"]').val();
                    $('#con_model').html(model);

                    var serial_number = $('input[name="serial_number"]').val();
                    $('#con_serial_number').html(serial_number);

                    var fleet_number = $('input[name="fleet_number"]').val();
                    $('#con_fleet_number').html(fleet_number);

                    var fsrr_number = $('input[name="fsrr_number"]').val();
                    $('#con_fsrr_number').html(fsrr_number);

                    var delivery_type = $('#delivery_type').val();
                    $('#con_delivery_type').html(delivery_type);

                    var requestor_remarks = $('#requestor_remarks').val();
                    $('#con_requestor_remarks').val(requestor_remarks);

                    $('.autoResize').click();

                    var quantities = [];
                    var prices = [];

                    jQuery('#selectedPartsBody tr').each(function(index, row) {
                        var quantity = $(row).find('.partQuantity').val();
                        var price = $(row).find('.partPrice').val();

                        quantities.push(quantity);
                        prices.push(price);
                    });

                    $('#selectedPartsQuantity').val(quantities);
                    $('#selectedPartsPrice').val(prices);

                    $.ajax({
                        url:"{{ route('nchargeable.add.updateSelected') }}",
                        method:"POST",
                        data:{
                            tab: tab,
                            quantities: JSON.stringify(quantities),
                            prices: JSON.stringify(prices),
                            selectedParts: JSON.stringify(selectedParts),
                            _token: _token
                        },
                        success:function(result){
                            $('#con_selectedPartsBody').html(result);
                            $('#selectedParts').val(selectedParts);

                            $('#partsModal').addClass('hidden');
                        }
                    })

                    $('#tab-container').removeClass('-translate-x-0');
                    $('#tab-container').removeClass('-translate-x-[calc(25%+16px)]');
                    $('#tab-container').removeClass('-translate-x-[calc(50%+32px)]');
                    $('#tab-container').addClass('-translate-x-[calc(50%+32px)]');
                    $('#nextBtn').addClass('hidden');
                    $('#submitBtn').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
        
            jQuery(document).on("click", "#backBtn", function() {
                if(tab == 2){
                    tab = 1;
                    $('#tab-container').removeClass('-translate-x-0');
                    $('#tab-container').removeClass('-translate-x-[calc(25%+16px)]');
                    $('#tab-container').removeClass('-translate-x-[calc(50%+32px)]');
                    $('#tab-container').addClass('-translate-x-0');
                    $('#backBtn').addClass('hidden');
                }else if(tab == 3){
                    tab = 2;
                    $('#tab-container').removeClass('-translate-x-0');
                    $('#tab-container').removeClass('-translate-x-[calc(25%+16px)]');
                    $('#tab-container').removeClass('-translate-x-[calc(50%+32px)]');
                    $('#tab-container').addClass('-translate-x-[calc(25%+16px)]');
                    $('#nextBtn').removeClass('hidden');
                    $('#submitBtn').addClass('hidden');
                }
            });
        
            jQuery(document).on("click", "#addParts", function() {
                $('#loading').removeClass('hidden');
                $('#partsModal').removeClass('hidden');
                var search = '';
                
                $.ajax({
                    url:"{{ route('nchargeable.add.getParts') }}",
                    method:"POST",
                    data:{
                        search: search,
                        _token: _token
                    },
                    success:function(result){
                        $('#partsBody').html(result);
                        $('#loading').addClass('hidden');
                    }
                })
            });
            
            jQuery(document).on("keyup", "#partSearch", function(){
                clearTimeout(delayTimer);
                var search = $(this).val();

                delayTimer = setTimeout(function() {
                    $.ajax({
                        url:"{{ route('nchargeable.add.getParts') }}",
                        method:"POST",
                        data:{
                            selectedParts: JSON.stringify(selectedParts),
                            search: search,
                            _token: _token
                        },
                        success:function(result){
                            $('#partsBody').html(result);
                        }
                    })
                }, 300);
            });

            jQuery(document).on("click", ".selectPart", function() {
                var id = $(this).data('id');
                var cb = $(this).find('input[type="checkbox"]');
                cb.prop('checked', !cb.prop('checked'));

                var index = selectedParts.indexOf(id);
                if (index === -1) {
                    selectedParts.push(id);
                } else {
                    selectedParts.splice(index, 1);
                }
            });

            jQuery(document).on("click", ".addSelectedParts", function() {
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('nchargeable.add.updateSelected') }}",
                    method:"POST",
                    data:{
                        tab: tab,
                        selectedParts: JSON.stringify(selectedParts),
                        _token: _token
                    },
                    success:function(result){
                        $('#selectedPartsBody').html(result);
                        $('#selectedParts').val(selectedParts);

                        $('#loading').addClass('hidden');
                        $('#partsModal').addClass('hidden');
                    }
                })
            });
            
            jQuery(document).on("keyup", '.partQuantity, .partPrice', function(){
                var row = $(this).closest('tr');
                var partQuantity = row.find('.partQuantity').val();
                var partPrice = row.find('.partPrice').val();
                var total = (partQuantity * partPrice).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
                total = total.replace('$', '');
                row.find('.partTotal').html(total);
            });
            
            // jQuery(document).on("click", "#submitBtn", function() {
            //     $('#requestForm').submit();
            // });
        });
    </script>
@endsection