<div class="w-screen h-screen overflow-hidden">
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="w-auto h-24 mx-auto" src="{{ asset('storage/images/logo/logo.png') }}" alt="Your Company">
            <h2 class="mt-10 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">Change Password</h2>
        </div>


        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            
            <div class="w-full p-4 mb-4 bg-blue-200 border-l-8 border-blue-600">
                <h1 class="text-sm">You are required to change your password before you login for the first time.</h1>
                <p class="mt-3 text-sm italic">Note: Password must be at least <span class="text-base font-semibold text-pink-600">8</span> characters.</p>
            </div>

            {{-- ERROR ALERT --}}
                @if (session('error'))
                    {{-- <div class="absolute flex justify-center w-screen top-5"> --}}
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    {{-- </div> --}}
                @endif
            {{-- ERROR ALERT --}}

            <form wire:submit='changePassword' class="pb-20 space-y-4 ">
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New Password</label>
                    <div class="">
                        <input id="password" wire:model="password" type="password" autocomplete="off" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    </div>
                    <div class="">
                        <input id="password_confirmation" wire:model="password_confirmation" type="password" autocomplete="off" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('password_confirmation')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-blue-500 px-3 py-1.5 text-sm font-bold leading-6 text-white shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
