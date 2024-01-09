@extends('layouts.app')
@section('title','Users')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

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
    
        {{-- DELETE MODAL --}}
            <div id="deleteModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div class="bg-white rounded-lg max-w-[500px]">
                    <!-- Modal content -->
                    <div class="relative h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                DELETE USER
                            </h3>
                            <button type="button" id="closeDeleteModal" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="w-full px-5 py-4 overflow-x-hidden overflow-y-auto text-center">
                            Are you sure you want to delete this user?
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 text-center border-t border-gray-200 rounded-b">
                            <a id="confirmDelete" href="" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold w-1/2 py-2.5 focus:z-10">DELETE</a>
                            <button type="button" id="closeDeleteModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold w-1/2 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- DELETE MODAL// --}}
    
        {{-- RESET MODAL --}}
            <div id="resetModal" class="hidden absolute top-0 left-0 w-screen h-screen bg-gray-900 z-[109] !bg-opacity-50 overflow-hidden flex items-center justify-center p-10">
                <div class="bg-white rounded-lg max-w-[500px]">
                    <!-- Modal content -->
                    <div class="relative h-full bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                RESET PASSWORD
                            </h3>
                            <button type="button" id="closeResetModal" class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="w-full px-5 py-4 overflow-x-hidden overflow-y-auto text-center">
                            Are you sure you want to reset the password of this user?
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 space-x-2 text-center border-t border-gray-200 rounded-b">
                            <a id="confirmReset" href="" class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold w-1/2 py-2.5 focus:z-10">RESET</a>
                            <button type="button" id="closeResetModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-bold w-1/2 py-2.5 hover:text-gray-900 focus:z-10">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- RESET MODAL// --}}

        {{-- CONTROLS --}}
            <div class="flex items-center justify-between w-full h-12">
                <div class="h-full">
                    {{-- ADD USER --}}
                        <a href="{{ route('users.add') }}" class="flex items-center h-full px-8 text-lg font-bold text-white bg-blue-500 rounded-lg loading">ADD</a>
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

        {{-- USER LIST --}}
            <div class="w-full h-[calc(100vh-152px)] mt-4">
                <div class="w-full h-[calc(100vh-206px)] overflow-y-auto overflow-x-hidden rounded-lg">
                    <table class="w-full rounded-lg">
                        <thead class="sticky top-0 tracking-wide bg-gray-300">
                            <tr>
                                <th class="px-5 py-1 text-left">ID Number</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Site/Branch</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-left bg-gray-100 cursor-pointer even:bg-gray-200 hover:bg-gray-400">
                                    <td class="px-5 py-1">{{ $user->id_number }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td class="text-center">
                                        @if ($user->role == 0)
                                            Admin
                                        @elseif ($user->role == 1)
                                            Admin Staff
                                        @elseif ($user->role == 2)
                                            Technician Team Leader / Supervisor
                                        @elseif ($user->role == 3)
                                            Parts Supervisor
                                        @elseif ($user->role == 4)
                                            Operations Head / Parts and Service Manager / On-site Senior Supervisor
                                        @elseif ($user->role == 5)
                                            Rental Staff / Team Leader / Head
                                        @elseif ($user->role == 6)
                                            MRI Encoder
                                        @elseif ($user->role == 7)
                                            Edoc Encoder
                                        @elseif ($user->role == 8)
                                            DR Encoder
                                        @elseif ($user->role == 9)
                                            Signatories
                                        @elseif ($user->role == 10)
                                            Service Encoder
                                        @elseif ($user->role == 11)
                                            Adviser
                                        @elseif ($user->role == 12)
                                            Invoicing Encoder
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $user->siteDetails->name }}</td>
                                    <td class="font-semibold text-center">
                                        <a href="{{ route('users.edit', ['key' => $user->key]) }}" class="text-blue-500 hover:underline">EDIT</a> | 
                                        <button type="button" data-key="{{ $user->key }}" class="text-orange-500 hover:underline resetButton">RESET</button> | 
                                        <button type="button" data-key="{{ $user->key }}" class="text-red-500 hover:underline deleteButton">DELETE</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <div class="w-full mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        {{-- USER LIST --}}
        
    </div>
</div> 

<script>
    $(document).ready(function () {
        jQuery(document).on("click", ".deleteButton", function() {
            var key = $(this).data('key');
            var newHref = "{{ route('users.delete', ['key' => ':newKey']) }}".replace(':newKey', key);
            $('#confirmDelete').attr('href', newHref);
            $('#deleteModal').removeClass('hidden');
        });
        
        jQuery(document).on("click", "#closeDeleteModal", function() {
            $('#deleteModal').addClass('hidden');

        });
        
        jQuery(document).on("click", ".resetButton", function() {
            var key = $(this).data('key');
            var newHref = "{{ route('users.reset', ['key' => ':newKey']) }}".replace(':newKey', key);
            $('#confirmReset').attr('href', newHref);
            $('#resetModal').removeClass('hidden');
        });
        
        jQuery(document).on("click", "#closeResetModal", function() {
            $('#resetModal').addClass('hidden');

        });
    });
</script>

@endsection