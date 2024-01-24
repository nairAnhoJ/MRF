@extends('layouts.app')
@section('title','Chargeable Requests')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

        <div class="hidden overflow-x-hidden overflow-y-auto h-[calc(100%-72px)] pr-2 bg-neutral-100 border-neutral-400 hover:border-neutral-200"></div>

        {{-- SUCCESS ALERT --}}
            @if (session('success'))
                <div class="absolute flex items-center p-4 mb-4 text-green-800 -translate-x-1/2 border border-green-700 rounded-lg left-1/2 top-20 bg-green-50">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="pr-5 ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 hideAlert">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif
        {{-- SUCCESS ALERT// --}}
    
        {{-- VIEW MODAL --}}
            <div id="viewModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[90] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div id='viewDetails' class="w-full h-full bg-white rounded-lg">
                </div>
            </div>
        {{-- VIEW MODAL// --}}
    
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
    
        {{-- ATTACHMENTS MODAL --}}
            <div id="attachmentsModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div class="w-5/6 h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Attachment Preview
                            </h3>
                            <button type="button" id="closeAttachmentsModal" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div id="attachmentsModalContent" class="py-4 px-10 h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex items-start justify-center">
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="button" id="closeAttachmentsModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ATTACHMENTS MODAL// --}}
    
        {{-- VALIDATE MODAL --}}
            <div id="validateModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[99] !bg-opacity-50 overflow-hidden flex items-center justify-center p-5">
                <div class="w-1/3 bg-white rounded-lg">
                    <!-- Modal content -->
                    <form action="{{ route('chargeable.validateRequest') }}" method="POST" class="relative bg-white rounded-lg shadow">
                        @csrf
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Validate Request
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 validateCloseModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 text-left">
                            <input type="hidden" id="validateID" name="id">
                            <p class="italic">Are you sure you want to validate this request?</p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="submit" id="validateRequest" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm py-2.5 text-center w-24">YES</button>
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-gray-900 focus:z-10 w-24 validateCloseModal">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        {{-- VALIDATE MODAL// --}}
    
        {{-- VERIFY MODAL --}}
            <div id="verifyModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[99] !bg-opacity-50 overflow-hidden flex items-center justify-center p-5">
                <div class="w-1/3 bg-white rounded-lg">
                    <!-- Modal content -->
                    <form action="{{ route('chargeable.verifyRequest') }}" method="POST" class="relative bg-white rounded-lg shadow">
                        @csrf
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Verify Request
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 verifyCloseModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 text-left">
                            <input type="hidden" id="verifyID" name="id">
                            <div class="w-full mb-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                <textarea style="resize: none;" name='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                            </div>
                            <p class="italic">Are you sure you want to verify this request?</p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="submit" id='verifyRequest' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm py-2.5 text-center w-24">YES</button>
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-gray-900 focus:z-10 w-24 verifyCloseModal">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        {{-- VERIFY MODAL// --}}
    
        {{-- APPROVE MODAL --}}
            <div id="approveModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[99] !bg-opacity-50 overflow-hidden flex items-center justify-center p-5">
                <div class="w-1/3 bg-white rounded-lg">
                    <!-- Modal content -->
                    <form action="{{ route('chargeable.approveRequest') }}" method="POST" class="relative bg-white rounded-lg shadow">
                        @csrf
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                @if (Auth::user()->role == 10 || Auth::user()->role == 6 || Auth::user()->role == 12)
                                    Encode
                                @elseif(Auth::user()->role == 9)
                                    Confirm
                                @else
                                    Approve
                                @endif
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 approveCloseModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 text-left">
                            <input type="hidden" id="approveID" name="id">
                            @if (Auth::user()->role == 10)
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">SQ Number</label>
                                    <input type="text" id="encode_input" name='encode_input' id='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The SQ Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                            @elseif (Auth::user()->role == 6)
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">MRI Number</label>
                                    <input type="text" id="encode_input" name='encode_input' id='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The MRI Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                            @elseif (Auth::user()->role == 12)
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">Reference Number</label>
                                    <input type="text" id="encode_input" name='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="dr_input" class="block text-sm font-medium text-gray-900">DR Number</label>
                                    <input type="text" id="dr_input" name='dr_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('dr_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="si_input" class="block text-sm font-medium text-gray-900">SI Number</label>
                                    <input type="text" id="si_input" name='si_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('si_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="bs_input" class="block text-sm font-medium text-gray-900">BS Number</label>
                                    <input type="text" id="bs_input" name='bs_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('bs_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                            
                            @elseif (Auth::user()->role == 9)
                                <div class="w-full mb-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                                <p class="italic">Are you sure you want to confirm this request?</p>
                            @else
                                <div class="w-full mb-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                                <p class="italic">Are you sure you want to approve this request?</p>
                            @endif
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm py-2.5 text-center w-24">SUBMIT</button>
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-gray-900 focus:z-10 w-24 approveCloseModal">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        {{-- APPROVE MODAL// --}}
    
        {{-- RETURN MODAL --}}
            <div id="returnModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[99] !bg-opacity-50 overflow-hidden flex items-center justify-center p-5">
                <div class="w-1/3 bg-white rounded-lg">
                    <!-- Modal content -->
                    <form action="{{ route('chargeable.returnRequest') }}" method="POST" class="relative h-full bg-white rounded-lg shadow">
                        @csrf
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Return Request
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 returnCloseModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 text-left max-h-[calc(100%-140px)] overflow-y-auto">
                            <input type="hidden" id="returnID" name="id">
                            <div id="returnParts" class="w-full mb-2"></div>
                            <div class="w-full mb-2">
                                <div class="w-full mb-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" id="return_remarks" name="return_remarks" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                                <p class="italic">Are you sure you want to return this request?</p>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-sm py-2.5 text-center w-24">YES</button>
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold py-2.5 hover:text-gray-900 focus:z-10 w-24 returnCloseModal">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        {{-- RETURN MODAL// --}}
    
        {{-- PARTS REMARKS MODAL --}}
            <div id="partsRemarksModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div class="w-1/2 max-h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Parts Remarks
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 closePartsRemarksModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div id="returnPartsContent" class="py-4 px-10 max-h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex flex-col items-start">
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10 closePartsRemarksModal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- PARTS REMARKS MODAL// --}}
    
        {{-- SERIAL NUMBERS MODAL --}}
            <div id="serialNumbersModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div class="w-1/2 min-w-[400px] max-h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Serial Numbers
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 closeSerialNumbers">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="py-4 px-10 max-h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex flex-col items-start">
                            <textarea style="resize:none;" id="serialNumberContent" class="w-full overflow-y-hidden border rounded-lg outline-none h-60 autoResize" readonly></textarea>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10 closeSerialNumbers">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- SERIAL NUMBERS MODAL// --}}

        {{-- CONTROLS --}}
            <div class="flex items-center justify-between w-full h-12">
                <div class="h-full">
                    {{-- ADD USER --}}
                        @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                            <a href="{{ route('chargeable.add') }}" class="flex items-center h-full px-8 text-lg font-bold text-white bg-blue-500 rounded-lg loading">ADD</a>
                        @endif
                    {{-- ADD USER --}}
                </div>
                    {{-- SEARCH --}}
                        <form action="{{ route('chargeable') }}" method="GET" class="w-96">
                            @csrf
                            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="search" name="search" value="{{ $search }}" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg !pl-9 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..." autocomplete="off">
                                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                            </div>
                        </form>
                    {{-- SEARCH --}}
            </div>
        {{-- CONTROLS// --}}

        {{-- TABLE LIST --}}
            <div class="w-full h-[calc(100vh-152px)] mt-4">
            
                <div class="w-full h-[calc(100vh-206px)] overflow-y-auto overflow-x-hidden rounded-lg">
                    <table class="w-full rounded-lg">
                        <thead class="sticky top-0 tracking-wide bg-gray-300">
                            <tr>
                                <th>Request Number</th>
                                <th class="p-2">Customer</th>
                                <th>Site</th>
                                <th>Fleet Number</th>
                                <th>Status</th>
                                <th>Requestor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr data-id="{{ $result->id }}" class="text-center bg-gray-100 cursor-pointer even:bg-gray-200 hover:bg-gray-400 resultsTable viewRequest">
                                    <td>{{ $result->number }}</td>
                                    <td class="p-2">{{ $result->customer_name }}</td>
                                    <td>{{ $result->siteDetails->name }}</td>
                                    <td>{{ $result->fleet_number }}</td>
                                    <td class="
                                        @if ($result->is_confirmed == 1)
                                            text-emerald-600
                                        @elseif ($result->is_returned == 1 || $result->is_cancelled == 1)
                                            text-red-600
                                        @endif
                                    ">
                                        {{-- Status --}}
                                            @if ($result->is_cancelled == 1)
                                                Cancelled
                                            @elseif ($result->is_validated == 0)
                                                @if ($result->is_returned == 1)
                                                    Returned (For Supervisor Validation)
                                                @else
                                                    For Supervisor Validation
                                                @endif
                                            @elseif ($result->is_validated == 1 && $result->is_verified == 0)
                                                Validated (For Parts Verification)
                                            @elseif ($result->is_verified == 1 && $result->is_service_approved == 0)
                                                Verified (For Service Approval)
                                            @elseif ($result->is_service_approved == 1 && $result->is_sq_number_encoded == 0)
                                                Service Approved (For Encoding of SQ Number)
                                            @elseif ($result->is_sq_number_encoded == 1 && $result->is_adviser_approved == 0)
                                                SQ Number Encoded (For Adviser Approval)
                                            @elseif ($result->is_adviser_approved == 1 && $result->is_mri_number_encoded == 0)
                                                Adviser-Approved (For Encoding of MRI Number)
                                            @elseif ($result->is_mri_number_encoded == 1 && $result->is_invoice_encoded == 0)
                                                MRI Number Encoded (For Encoding of Invoicing)
                                            @elseif ($result->is_invoice_encoded == 1 && $result->is_confirmed == 0)
                                                Invoicing Encoded (For Signatories Confirmation)
                                            @elseif ($result->is_confirmed == 1)
                                                Completed
                                            @endif
                                        {{-- Status --}}
                                    </td>
                                    <td>{{ $result->requestor }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <div class="w-full mt-4">
                    {{ $results->links() }}
                </div>
            </div>
        
    </div>
</div> 

<script>
    $(document).ready(function () {
        var id;
        var _token = $('input[name="_token"]').val();
        var role = "{{ Auth::user()->role }}";
        
        jQuery(document).on("click", ".viewRequest", function() {
            $('#loading').removeClass('hidden');
            id = $(this).data('id');
            var status;
            
            $.ajax({
                url:"{{ route('chargeable.view') }}",
                method:"POST",
                dataType: "json",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#viewDetails').html(response.viewDetails);
                    $('#viewModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                    $('.autoResize').click();
                }
            });
        });
        
        jQuery(document).on("click", "#closeViewModal", function() {
            $('#viewModal').addClass('hidden');
        });
        
        jQuery(document).on("click", "#viewFSRR", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewFSRR') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
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
        
        jQuery(document).on("click", "#viewHistory", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewHistory') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#historyModalContent').html(response);
                    $('#historyModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
        });
        
        jQuery(document).on("click", "#closeHistoryModal", function() {
            $('#historyModal').addClass('hidden');
        });
        
        jQuery(document).on("click", "#viewOldRequest", function() {
            $('#loading').removeClass('hidden');
            var req_id = $(this).data('id');
            $.ajax({
                url:"{{ route('chargeable.viewHistoryParts') }}",
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
        
        jQuery(document).on("click", "#validateButton", function() {
            jQuery('#validateModal').removeClass('hidden');
            jQuery('#validateID').val(id);
        });
        
        jQuery(document).on("click", ".validateCloseModal", function() {
            jQuery('#validateModal').addClass('hidden');
        });

        jQuery(document).on("click", "#verifyButton", function() {
            jQuery('#verifyModal').removeClass('hidden');
            jQuery('#verifyID').val(id);
        });
        
        jQuery(document).on("click", ".verifyCloseModal", function() {
            jQuery('#verifyModal').addClass('hidden');
        });

        jQuery(document).on("click", ".approveButton ", function() {
            jQuery('#approveModal').removeClass('hidden');
            jQuery('#approveID').val(id);
        });
        
        jQuery(document).on("click", ".approveCloseModal", function() {
            jQuery('#approveModal').addClass('hidden');
        });

        jQuery(document).on("click", "#returnButton", function() {
            if(role == 3){
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('chargeable.returnParts') }}",
                    method:"POST",
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        $('#returnParts').html(response);
                        $('#returnModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            }else{
                $('#returnModal').removeClass('hidden');
            }
            jQuery('#returnID').val(id);
        });
        
        jQuery(document).on("click", ".returnCloseModal", function() {
            jQuery('#returnModal').addClass('hidden');
        });

        jQuery(document).on("click", "#viewReturnedPartsButton", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewReturnParts') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#returnPartsContent').html(response);
                    $('#partsRemarksModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
            jQuery('#returnID').val(id);
        });

        jQuery(document).on("click", ".closePartsRemarksModal", function() {
            jQuery('#partsRemarksModal').addClass('hidden');
        });

        jQuery(document).on("click", "#viewSerialNumbers", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewSerialNumbers') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#serialNumberContent').html(response);
                    $('#serialNumbersModal').removeClass('hidden');
                    $('.autoResize').click();
                    $('#loading').addClass('hidden');
                }
            });
        });

        jQuery(document).on("click", ".closeSerialNumbers", function() {
            jQuery('#serialNumbersModal').addClass('hidden');
        });

        jQuery(document).on("click", "#viewAttachments", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewSerialNumbers') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#serialNumberContent').html(response);
                    $('#serialNumbersModal').removeClass('hidden');
                    $('.autoResize').click();
                    $('#loading').addClass('hidden');
                }
            });
        });
    });
</script>

@endsection