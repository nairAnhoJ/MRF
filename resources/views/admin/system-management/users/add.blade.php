@extends('layouts.app')
@section('title','Users - Add')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

        <form action="{{ route('users.store') }}" method="POST" class="w-1/2">
            @csrf
            <div class="w-full mb-2">
                <label for="id_number" class="block text-sm font-medium text-gray-900">ID Number</label>
                <input type="text" id="id_number" name='id_number' value="{{ old('id_number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                @error('id_number')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full mb-2">
                <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                <input type="text" id="name" name='name' value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" autocomplete="off">
                @error('name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full mb-2">
                <label for="site" class="block text-sm font-medium text-gray-900">Site</label>
                <select id="site" name='site' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="" hidden>Select Site</option>
                    @foreach ($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
                @error('site')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full mb-4">
                <label for="role" class="block text-sm font-medium text-gray-900">Role</label>
                <select id="role" name='role' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="" hidden>Select Role</option>
                    <option value="1">Admin Staff</option>
                    <option value="2">Technician Team Leader / Supervisor</option>
                    <option value="3">Parts Supervisor</option>
                    <option value="4">Operations Head / Parts and Service Manager / On-site Senior Supervisor</option>
                    <option value="11">Adviser</option>
                    <option value="5">Rental Staff / Team Leader / Head</option>
                    <option value="6">MRI Encoder</option>
                    <option value="7">Edoc Encoder</option>
                    <option value="8">DR Encoder</option>
                    <option value="10">Service Encoder</option>
                    <option value="12">Invoicing Encoder</option>
                    <option value="9">Signatories</option>
                </select>
                @error('role')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('users.index') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">CANCEL</a>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">SUBMIT</button>
            </div>

        </form>
        
    </div>
</div> 

<script>
    $(document).ready(function () {

    });
</script>

@endsection