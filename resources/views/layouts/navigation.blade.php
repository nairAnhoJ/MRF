<div class="absolute top-0 flex justify-between w-full p-2 bg-red-400 h-14">
    <div class="flex items-center">
        <button data-drawer-target="navigation-sidebar" data-drawer-toggle="navigation-sidebar" aria-controls="navigation-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-red-400 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
        <span class="ml-2 text-2xl font-bold text-white">@yield('title')</span>
    </div>
    <div class="flex items-center gap-x-4">
        <p class="text-xl font-bold tracking-wide text-white">{{ Auth::user()->name }}</p>
        <a href="{{ route('logout') }}" type="button" class="inline-flex items-center p-2 text-sm text-red-400 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                <path xmlns="http://www.w3.org/2000/svg" d="M189-95q-39.05 0-66.525-27.475Q95-149.95 95-189v-582q0-39.463 27.475-67.231Q149.95-866 189-866h296v95H189v582h296v94H189Zm467-174-67-66 97-98H354v-94h330l-97-98 67-66 212 212-210 210Z"/>
            </svg>
            <span class="ml-1 font-medium">Logout</span>
        </a>
    </div>
</div>

<aside id="navigation-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full w-72" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:text-gray-700 hover:bg-gray-200 group">
                    <svg class="text-gray-600 transition duration-75 w-7 h-7 group-hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 group hover:bg-gray-200" aria-controls="requestDd" data-collapse-toggle="requestDd">
                    <svg class="flex-shrink-0 text-gray-600 transition duration-75 w-7 h-7 group-hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                        <path xmlns="http://www.w3.org/2000/svg" d="M319-248h322v-71H319v71Zm0-170h322v-71H319v71ZM229-55q-39.05 0-66.525-27.475Q135-109.95 135-149v-662q0-39.463 27.475-67.231Q189.95-906 229-906h363l234 234v523q0 39.05-27.769 66.525Q770.463-55 731-55H229Zm313-570v-186H229v662h502v-476H542ZM229-811v186-186 662-662Z"/>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Requests</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <ul id="requestDd" class="hidden py-2 space-y-2">
                    @if (Auth::user()->role != 5 && Auth::user()->role != 7 && Auth::user()->role != 8)
                        <li>
                            <a href="{{ route('chargeable') }}" class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 pl-11 group hover:bg-gray-200">Chargeable</a>
                        </li>
                    @endif
                    @if (Auth::user()->role != 10 && Auth::user()->role != 11 && Auth::user()->role != 12)
                        <li>
                            <a href="{{ route('nchargeable') }}" class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 pl-11 group hover:bg-gray-200">Non-Chargeable</a>
                        </li>
                    @endif
                </ul>
            </li>
            @if (Auth::user()->role == 0)
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 group hover:bg-gray-200" aria-controls="systemDd" data-collapse-toggle="systemDd">
                        <svg class="flex-shrink-0 text-gray-600 transition duration-75 w-7 h-7 group-hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 -960 960 960">
                            <path xmlns="http://www.w3.org/2000/svg" d="M692.382-270q26.383 0 44.5-19Q755-308 755-333.882q0-25.883-18.618-44Q717.765-396 692.882-396 666-396 647.5-377.882q-18.5 18.117-18.5 44Q629-308 647.5-289q18.5 19 44.882 19Zm-.882 125q33.5 0 59.882-13.5Q777.765-172 798-198q-27-14-53.137-21.5t-53.325-7.5Q664-227 637-219.5q-27 7.5-52 21.5 19 26 45.313 39.5Q656.627-145 691.5-145ZM480-54Q331.231-88.81 233.116-220.804 135-352.798 135-522.171v-256.314L480-907l346 129v302q-23-15-46.721-24.594Q755.557-510.188 731-513v-199.861L480-805l-251 91.831v190.735Q229-444 254-381.5t62.5 108Q354-228 397-199t79 40q7 24 26 48.5T542-74q-15 8-31 12t-31 8Zm212.5-26Q615-80 560-135.5T505-267q0-78.435 54.99-133.717Q614.98-456 693-456q77 0 132.5 55.283Q881-345.435 881-267q0 76-55.5 131.5T692.5-80ZM480-482Z"/>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">System Management</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="systemDd" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('users.index') }}" class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 pl-11 group hover:bg-gray-200">Users</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('approvers.index') }}" class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg hover:text-gray-700 pl-11 group hover:bg-gray-200">Approver Setup</a>
                        </li> --}}
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</aside>
