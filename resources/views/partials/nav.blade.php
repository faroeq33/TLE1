@if(!in_array(request()->route()->getName(), ['kijker_livestream', 'gids_livestream', 'ip_car_livestream']))
<img src="{{ asset('img/header-museum.png') }}" alt="" class="object-cover w-full h-48">
@if( auth()->check() )
    <nav class="bg-white shadow" x-data="{
    open: false,
    mobileOpen: true,
}">
        <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative flex justify-between h-16">
                <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
                    <div class="flex items-center flex-shrink-0 p-4 m-4 ">
                        <a href="{{ route('overview') }}">
                            <p class="uppercase font-primary">StreamTeam</p>
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Nav Links -->
                        <a href="{{ route('overview') }}"
                           class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-tertiary hover:text-gray-700">Tours</a>

                        @if(auth()->user()->is_admin)
                            <!-- Nav Links only for Admins -->
                            <a href="{{ route('admin.view_user') }}"
                               class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-tertiary hover:text-gray-700">Gebruikers</a>
                        @endif
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                    <!-- Profile dropdown -->
                    <div class="relative ml-3 profile-dropdown ">
                        <button type="button" @click="open = !open"
                                class="relative flex items-center text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <span class="text-lg font-medium mr-2 capitalize">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>



                        <div class="absolute right-0 z-10 w-30 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                             x-show="open" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">

                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <ul class="relative flex flex-col items-start pl-0 mb-0 list-reset ms-auto">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                                    @csrf
                                    <a class="px-4 py-2 text-medium text-red-600" role="menuitem" tabindex="-1"
                                       id="user-menu-item-2"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       href="{{ route('logout') }}">
                                        {{ __('Uitloggen') }}
                                    </a>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endif
@endif
