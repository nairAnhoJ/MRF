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

        @yield('content')

        <script>
            $(document).ready(function () {
                var tab = 1;

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

                jQuery(document).on( "click", ".listOption li", function(){
                    $('.content').addClass('hidden');
                    $('.selectSearch').val('');
                    var value = $(".selectSearch").val().toLowerCase();
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

                jQuery('.resultsTable').on("click", ".editButton", function(e){
                    e.stopPropagation();
                });
                
                jQuery(document).on( "click", ".autoResize", function(){
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            });
        </script>

        @livewireScripts
    </body>
</html>
