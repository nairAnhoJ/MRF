<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MRF - System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css"  rel="stylesheet" />
        <style>
            ::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 2px grey;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: #4B5563;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: rgb(95, 95, 110);
            }

            [role="navigation"] > div:nth-child(2) {
                width: 100%;
            }
        </style>

        <!-- Script -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    </head>
    
    <body class="antialiased">

        @if(Auth::user())
            @if(Auth::user()->first_time_login == '0')
                @include('layouts.navigation')
            @else
                <div class="absolute top-0 flex justify-end w-full p-2 bg-red-400 h-14">
                    <a href="{{ route('logout') }}" type="button" class="inline-flex items-center p-2 text-sm text-red-400 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                            <path xmlns="http://www.w3.org/2000/svg" d="M189-95q-39.05 0-66.525-27.475Q95-149.95 95-189v-582q0-39.463 27.475-67.231Q149.95-866 189-866h296v95H189v582h296v94H189Zm467-174-67-66 97-98H354v-94h330l-97-98 67-66 212 212-210 210Z"/>
                        </svg>
                        <span class="ml-1 font-medium">Logout</span>
                    </a>
                </div>
            @endif
        @endif

        {{-- LOADING --}}
            <div id="loading" class="hidden fixed top-0 left-0 flex items-center justify-center w-screen h-screen bg-neutral-700 z-[999] bg-opacity-30 gap-x-2">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-50 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                </div>
                <span class="font-bold">Loading . . .</span>
            </div>
        {{-- LOADING// --}}

        @yield('content')

        <script>
            $(document).ready(function () {
                jQuery(document).on( "input", ".numberOnly", function(){
                    var inputValue = $(this).val();
                    inputValue = inputValue.replace(/[^0-9.]/g, '');
                    var periods = inputValue.split('.');
                    if (periods.length > 2) {
                        inputValue = periods[0] + '.' + periods.slice(1).join('');
                    }
                    $(this).val(inputValue);
                });

                jQuery(document).on( "click", ".hideAlert", function(){
                    $(this).parent('div').addClass('hidden');
                });

                jQuery(document).on( "click", ".select-btn", function(e){
                    $('.content').not($(this).closest('.wrapper').find('.content')).addClass('hidden');
                    $(this).closest('.wrapper').find('.content').toggleClass('hidden');
                    $(this).closest('.wrapper').find('.uil-angle-down').toggleClass('-rotate-180');
                    $('#loading').addClass('hidden');
                    e.stopPropagation();
                });

                function searchFilter(searchInput){
                    $(".listOption li").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchInput) > -1)
                    });
                }

                jQuery(document).on( "click", ".content", function(e){
                    e.stopPropagation();
                });

                jQuery(document).on( "input", ".selectSearch", function(){
                    var value = $(this).val().toLowerCase();
                    searchFilter(value);
                });

                jQuery(document).on( "click", function(){
                    $('.content').addClass('hidden');
                    $('.uil-angle-down').removeClass('-rotate-180');
                });




                jQuery(document).on("input", ".partSearch", function(){
                    var value = $(this).val().toLowerCase();
                    $('#part_search').val(value);
                });
                
                jQuery(document).on( "click", ".autoResize", function(){
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                
                jQuery(document).on( "click", ".loading", function(){
                    $('#loading').removeClass('hidden');
                });
            });
        </script>
    </body>
</html>
