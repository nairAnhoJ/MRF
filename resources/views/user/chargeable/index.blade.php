@extends('layouts.app')
@section('title','Chargeable Requests')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

        <div class="hidden overflow-x-hidden overflow-y-auto h-[calc(100%-72px)] pr-2 bg-neutral-100 border-neutral-400 hover:border-neutral-200 duration-700 ease-in-out transition-all min-w-full"></div>

        <div id="transparentScreen" class="fixed top-0 left-0 hidden w-screen h-screen z-[500]"></div>

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
            <div id="attachmentsModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-36">
                <div class="w-4/6 h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative w-full h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Attachment Preview
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 closeAttachmentsModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="py-4 px-10 h-[calc(100%-140px)] w-full overflow-hidden flex items-start justify-center">
                            <div class="relative w-full h-full overflow=hidden">
                                <!-- Carousel wrapper -->
                                <div id="attachmentsModalContent" class="box-border relative w-full h-full overflow-hidden rounded-lg">
                                </div>
                                <button disabled type="button" id="previousAttachment" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer disabled:pointer-events-none start-0 group focus:outline-none">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                        <span class="sr-only">Previous</span>
                                    </span>
                                </button>
                                <button type="button" id="nextAttachment" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer disabled:pointer-events-none end-0 group focus:outline-none">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                        <span class="sr-only">Next</span>
                                    </span>
                                </button>
                                <h1 id="attachmentPage" data-page="1" class="absolute flex items-center justify-center text-lg italic font-bold text-white -translate-x-1/2 rounded-full w-14 aspect-square bottom-2 left-1/2 bg-neutral-900/80">1 / 3</h1>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b -trans">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10 closeAttachmentsModal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ATTACHMENTS MODAL// --}}
    
        {{-- SQ ATTACHMENTS MODAL --}}
            <div id="sqAttachmentsModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-36">
                <div class="w-4/6 h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative w-full h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                SQ Attachment Preview
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 closeSQAttachmentsModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div id="sqAttachmentsModalContent" class="py-4 px-10 h-[calc(100%-140px)] overflow-x-hidden overflow-y-auto flex items-start justify-center">
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b -trans">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10 closeSQAttachmentsModal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- SQ ATTACHMENTS MODAL// --}}
    
        {{-- MATRIX/PO ATTACHMENTS MODAL --}}
            <div id="scAttachmentsModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-36">
                <div class="w-4/6 h-full bg-white rounded-lg">
                    <!-- Modal content -->
                    <div class="relative w-full h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Matrix/PO Attachments
                            </h3>
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 closeSCAttachmentsModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="py-4 px-10 h-[calc(100%-140px)] w-full overflow-hidden flex items-start justify-center">
                            <div class="relative w-full h-full overflow=hidden">
                                <!-- Carousel wrapper -->
                                <div id="scAttachmentsModalContent" class="box-border relative w-full h-full overflow-hidden rounded-lg">
                                </div>
                                <button disabled type="button" id="previousSCAttachment" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer disabled:pointer-events-none start-0 group focus:outline-none rounded-s-lg hover:bg-neutral-500/20">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                        <span class="sr-only">Previous</span>
                                    </span>
                                </button>
                                <button type="button" id="nextSCAttachment" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer disabled:pointer-events-none end-0 group focus:outline-none hover:bg-neutral-500/20 rounded-e-lg">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                        <span class="sr-only">Next</span>
                                    </span>
                                </button>
                                <h1 id="scAttachmentPage" class="absolute flex items-center justify-center text-lg italic font-bold text-white -translate-x-1/2 rounded-full w-14 aspect-square bottom-2 left-1/2 bg-neutral-900/80"></h1>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b -trans">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium w-24 py-2.5 hover:text-gray-900 focus:z-10 closeSCAttachmentsModal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- MATRIX/PO ATTACHMENTS MODAL// --}}
    
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
                    <form action="{{ route('chargeable.approveRequest') }}" method="POST" enctype="multipart/form-data" class="relative bg-white rounded-lg shadow">
                        @csrf
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                @if (Auth::user()->role == 10 || Auth::user()->role == 6 || Auth::user()->role == 12)
                                    Encode
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
                                    <input type="text" id="encode_input" name='encode_input' id='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 sq-number" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The SQ Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <div class="w-full">
                                        <label for="sq_attachment" class="block text-sm font-medium text-gray-900">SQ Attachments</label>
                                        <div class="flex gap-x-2">
                                            <input type="file" id='sq_attachment' name="sq_attachment" value="{{ old('sq_attachment') }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" accept=".jpeg, .jpg, .png">
                                        </div>
                                        @error('sq_attachment')
                                            <span class="text-xs text-red-500">The SQ Attachment is required.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60 sq-remarks" autocomplete="off"></textarea>
                                </div>
                            @elseif (Auth::user()->role == 6)
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">MRI Number</label>
                                    <input type="text" id="encode_input" name='encode_input' id='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mri-number" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The MRI Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">Importation?</label>
                                    <div class="flex items-center gap-x-4">
                                        <div class="flex items-center">
                                            <input id="importation-yes" type="radio" value="YES" name="importation" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                            <label for="importation-yes" class="text-sm font-medium text-gray-900 ms-2">Yes</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input checked id="importation-no" type="radio" value="NO" name="importation" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                            <label for="importation-no" class="text-sm font-medium text-gray-900 ms-2">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60 mri-remarks" autocomplete="off"></textarea>
                                </div>
                            @elseif (Auth::user()->role == 7)
                                <div id="edoc_parts"></div>
                                <div class="w-full mb-2">
                                    <label for="encode_input" class="block text-sm font-medium text-gray-900">eDoc Number</label>
                                    <input type="text" id="encode_input" name='encode_input' id='encode_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('encode_input')
                                        <span class="text-xs text-red-500">The eDoc Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="serial_numbers" class="block text-sm font-medium text-gray-900">Serial Numbers</label>
                                    <textarea style="resize: none;" name='serial_numbers' id='serial_numbers' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='edoc_remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                            @elseif (Auth::user()->role == 12)
                                <div id="edoc_numbers"></div>
                                <div class="w-full mb-2">
                                    <label for="dr_input" class="block text-sm font-medium text-gray-900">DR Number</label>
                                    <input type="text" id="dr_input" name='dr_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                                    @error('dr_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="si_input" class="block text-sm font-medium text-gray-900">SI Number</label>
                                    <input type="text" id="si_input" name='si_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 si-number" autocomplete="off">
                                    @error('si_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full mb-2">
                                    <label for="bs_input" class="block text-sm font-medium text-gray-900">BS Number</label>
                                    <input type="text" id="bs_input" name='bs_input' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bs-number" autocomplete="off">
                                    @error('bs_input')
                                        <span class="text-xs text-red-500">The DR Number you entered is invalid.</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60 invoice-remarks" autocomplete="off"></textarea>
                                </div>
                            
                            @elseif (Auth::user()->role == 13)
                                <div class="w-full mb-2">
                                    <div class="w-full">
                                        <label for="matrix" class="block text-sm font-medium text-gray-900">Contract/PMS Matrix</label>
                                        <div class="flex gap-x-2">
                                            <input type="file" id='matrix' name="matrix" value="{{ old('matrix') }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" accept=".jpeg, .jpg, .png">
                                        </div>
                                        @error('matrix')
                                            <span class="text-xs text-red-500">The Contract/PMS Matrix is required.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full mb-2">
                                    <div class="w-full">
                                        <label for="po_attachment" class="block text-sm font-medium text-gray-900">PO Attachments</label>
                                        <div class="flex gap-x-2">
                                            <input type="file" id='po_attachment' name="po_attachment" value="{{ old('po_attachment') }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" accept=".jpeg, .jpg, .png">
                                        </div>
                                        @error('po_attachment')
                                            <span class="text-xs text-red-500">The PO Attachment is required.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full mb-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-900">Remarks</label>
                                    <textarea style="resize: none;" name='remarks' id='remarks' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60" autocomplete="off"></textarea>
                                </div>
                                <p class="italic">Are you sure you want to approve this request?</p>
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
                                        @elseif (($result->is_returned == 1 || $result->is_cancelled == 1) && $result->is_validated == 0)
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
                                            @elseif ($result->is_verified == 1 && $result->is_service_head_approved1 == 0)
                                                Verified (For Service Head Approval)
                                            @elseif ($result->is_service_head_approved1 == 1 && $result->is_sq_number_encoded == 0)
                                                Service Head Approved (For Encoding of SQ Number)
                                            @elseif ($result->is_sq_number_encoded == 1 && $result->is_adviser_approved == 0)
                                                SQ Number Encoded (For Adviser Approval)
                                            @elseif ($result->is_adviser_approved == 1 && $result->is_service_coordinator_approved == 0)
                                                Adviser-Approved (For Service Coordinator Approval)
                                            @elseif ($result->is_service_coordinator_approved == 1 && $result->is_service_head_approved2 == 0)
                                                Service Coordinator Approved (For Service Head Approval)
                                            @elseif ($result->is_service_head_approved2 == 1 && $result->is_mri_number_encoded == 0)
                                                Service Head Approved (For Encoding of MRI Number)
                                            @elseif ($result->is_mri_number_encoded == 1 && $result->is_edoc_number_encoded == 0)
                                                MRI Number Encoded (For Encoding of eDoc Number)
                                            @elseif ($result->is_edoc_number_encoded == 1 && $result->is_invoice_encoded == 0)
                                                @if ($result->is_importation == 0)
                                                    MRI Number Encoded (For Encoding of Invoicing)
                                                @else
                                                    eDoc Number Encoded (For Encoding of Invoicing)
                                                @endif
                                            @elseif ($result->is_invoice_encoded == 1 && $result->is_confirmed == 0)
                                                Invoice Encoded (For Approval of Signatory)
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
        var attachmentCount;
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
            $('#loading').removeClass('hidden');
            jQuery('#approveID').val(id);

            if(role == 10){
                $.ajax({
                    url:"{{ route('chargeable.getSQ') }}",
                    method:"POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        $('.sq-number').val(response.sq_number);
                        $('.sq-remarks').html(response.sq_remarks);
                        jQuery('#approveModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            }else if(role == 6){
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('chargeable.mriNumber') }}",
                    method:"POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        $('.mri-number').val(response.mri_number);
                        $('.mri-remarks').html(response.mri_remarks);
                        jQuery('#approveModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            }else if(role == 7){
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('chargeable.edocParts') }}",
                    method:"POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        $('#edoc_parts').html(response.content);
                        $('#serial_numbers').html(response.serial_numbers);
                        $('#edoc_remarks').html(response.edoc_remarks);
                        jQuery('#approveModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            }else if(role == 12){
                $('#loading').removeClass('hidden');
                $.ajax({
                    url:"{{ route('chargeable.drNumber') }}",
                    method:"POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        $('#edoc_numbers').html(response.content);
                        $('.si-number').val(response.si_number);
                        $('.bs-number').val(response.bs_number);
                        $('.invoice-remarks').html(response.invoice_remarks);
                        jQuery('#approveModal').removeClass('hidden');
                        $('#loading').addClass('hidden');
                    }
                });
            }else{
                jQuery('#approveModal').removeClass('hidden');
                $('#loading').addClass('hidden');
            }

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
                url:"{{ route('chargeable.viewAttachments') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#attachmentsModalContent').html(response);
                    $('#previousAttachment').attr('disabled', true);
                    $('#nextAttachment').attr('disabled', false);
                    
                    var classValue = jQuery('#attachmentCarousel').attr('class');
                    var percentageMatch = /w-\[(\d+)%\]/.exec(classValue);
                    attachmentCount = (percentageMatch ? parseInt(percentageMatch[1]) : null) / 100;

                    $('#attachmentPage').html('1 / ' + attachmentCount);
                    $('#attachmentPage').attr('data-page', '1');
                    
                    $('#attachmentsModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
        });

        jQuery(document).on("click", ".closeAttachmentsModal", function() {
            jQuery('#attachmentsModal').addClass('hidden');
        });

        jQuery(document).on("click", "#previousAttachment", function() {
            $('#transparentScreen').removeClass('hidden');
            var childWidth = jQuery('#attachmentCarousel').width();
            var classValue = jQuery('#attachmentCarousel').attr('class');
            var percentageMatch = /w-\[(\d+)%\]/.exec(classValue);
            attachmentCount = (percentageMatch ? parseInt(percentageMatch[1]) : null) / 100;
            var left = jQuery('#attachmentCarousel').position().left;
            var perAttachment = childWidth / attachmentCount;

            if(left < 0){
                var translationAmount = (parseInt(left.toFixed(0)) + parseInt(perAttachment.toFixed(0)));
                jQuery('#attachmentCarousel').css('transform', 'translateX(' + translationAmount + 'px)');
                var currentPage = $('#attachmentPage').attr('data-page');
                console.log(currentPage);
                $('#attachmentPage').html((currentPage - 1) + ' / ' + attachmentCount);
                $('#attachmentPage').attr('data-page', currentPage - 1);
            }
            setTimeout(function() {
                $('#transparentScreen').addClass('hidden');
                $('#nextAttachment').attr('disabled', false);
                
                var left = jQuery('#attachmentCarousel').position().left;
                if(left == 0){
                    $('#previousAttachment').attr('disabled', true);
                }
            }, 300);
        });

        jQuery(document).on("click", "#nextAttachment", function() {
            $('#transparentScreen').removeClass('hidden');
            var childWidth = jQuery('#attachmentCarousel').width();
            var classValue = jQuery('#attachmentCarousel').attr('class');
            var percentageMatch = /w-\[(\d+)%\]/.exec(classValue);
            attachmentCount = (percentageMatch ? parseInt(percentageMatch[1]) : null) / 100;
            var left = jQuery('#attachmentCarousel').position().left;
            var perAttachment = childWidth / attachmentCount;
            var right = (childWidth + left);

            if(right.toFixed(0) > perAttachment.toFixed(0)){
                var translationAmount = (left.toFixed(0) - perAttachment.toFixed(0));
                jQuery('#attachmentCarousel').css('transform', 'translateX(' + translationAmount + 'px)');
                var currentPage = $('#attachmentPage').attr('data-page');
                console.log(currentPage);
                $('#attachmentPage').html((parseInt(currentPage) + 1) + ' / ' + attachmentCount);
                $('#attachmentPage').attr('data-page', parseInt(currentPage) + 1);
            }
            setTimeout(function() {
                var left = jQuery('#attachmentCarousel').position().left;
                var perAttachment = childWidth / attachmentCount;
                var right = (childWidth + left);
                if(right.toFixed(0) == perAttachment.toFixed(0)){
                    $('#nextAttachment').attr('disabled', true);
                }

                $('#transparentScreen').addClass('hidden');
                $('#previousAttachment').attr('disabled', false);

            }, 300);
        });
        
        jQuery(document).on("click", "#viewSQAttachment", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewSQAttachments') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    $('#sqAttachmentsModalContent').html(response);
                    $('#sqAttachmentsModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
        });
        
        jQuery(document).on("click", ".closeSQAttachmentsModal", function() {
            $('#sqAttachmentsModal').addClass('hidden');
        });





        

        jQuery(document).on("click", "#viewSCAttachments", function() {
            $('#loading').removeClass('hidden');
            $.ajax({
                url:"{{ route('chargeable.viewSCAttachments') }}",
                method:"POST",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function (response) {
                    console.log(response);
                    $('#scAttachmentsModalContent').html(response);
                    $('#previousSCAttachment').attr('disabled', true);
                    $('#nextSCAttachment').attr('disabled', false);

                    $('#scAttachmentPage').html('1 / 2');
                    
                    $('#scAttachmentsModal').removeClass('hidden');
                    $('#loading').addClass('hidden');
                }
            });
        });

        jQuery(document).on("click", ".closeSCAttachmentsModal", function() {
            jQuery('#scAttachmentsModal').addClass('hidden');
        });

        jQuery(document).on("click", "#previousSCAttachment", function() {
            $('#transparentScreen').removeClass('hidden');
            var childWidth = jQuery('#scAttachmentCarousel').width();
            var left = jQuery('#scAttachmentCarousel').position().left;

            if(left != 0){
                jQuery('#scAttachmentCarousel').css('transform', 'translateX(0px)');
                $('#previousSCAttachment').attr('disabled', true);
                $('#scAttachmentPage').html('1 / 2');
            }

            setTimeout(function() {
                $('#nextSCAttachment').attr('disabled', false);
                $('#transparentScreen').addClass('hidden');
            }, 300);
        });

        jQuery(document).on("click", "#nextSCAttachment", function() {
            $('#transparentScreen').removeClass('hidden');
            var childWidth = jQuery('#scAttachmentCarousel').width();
            var left = jQuery('#scAttachmentCarousel').position().left;
            
            if(left == 0){
                jQuery('#scAttachmentCarousel').css('transform', 'translateX(-50%)');
                $('#nextSCAttachment').attr('disabled', true);
                $('#scAttachmentPage').html('2 / 2');
            }

            setTimeout(function() {
                $('#previousSCAttachment').attr('disabled', false);
                $('#transparentScreen').addClass('hidden');
            }, 300);
        });
    });
</script>

@endsection