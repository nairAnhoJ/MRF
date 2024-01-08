@extends('layouts.app')
@section('title','Users')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

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
                                        <a href="#" class="text-blue-500 hover:underline">EDIT</a> | 
                                        <a href="#" class="text-orange-500 hover:underline">RESET</a> | 
                                        <a href="#" class="text-red-500 hover:underline">DELETE</a>
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

    });
</script>

@endsection