@extends('layouts.app')
@section('title','Users - Add')

@section('content')

<div class="w-screen h-screen pt-14">
    <div class="w-full h-full p-4">

        <form action="{{ route('users.store') }}" method="POST" class="w-1/2">
            @csrf
            <div class="mb-2">
                <label for="for" class="block text-sm font-medium text-gray-900">For</label>
                <select id="for" name='for' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option hidden>Select For</option>
                    <option value="SERVICE">Service</option>
                </select>
                @error('for')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-2">
                <label for="condition" class="block text-sm font-medium text-gray-900">Condition</label>
                <select disabled id="condition" name='condition' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option hidden>Select Condition</option>
                    {{-- @foreach ($conditions as $condition)
                        <option value="{{ $condition }}">{{ $condition }}</option>
                    @endforeach --}}
                </select>
                @error('condition')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="user" class="block text-sm font-medium text-gray-900">User</label>
                <select disabled id="user" name='user' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option hidden>Select User</option>
                    {{-- @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach --}}
                </select>
                @error('user')
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