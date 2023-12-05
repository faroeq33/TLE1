@php
    # Normaal zou je dit in de controller doen, maar omdat we in dit geval de navigatie op meerdere pagina's gebruiken, is het handiger om het hier te doen.
$menuItems = [
    [
        'name' => 'Home',
        'route' => 'home',
        'active' => true,
    ],
    [
        'name' => 'Tour overzicht',
        'route' => 'overview',
        'active' => true,
    ],
    [
        'name' => 'Admin user',
        'route' => 'admin.user',
        'active' => true,
        ],
    ];
@endphp
<nav class="bg-white shadow" x-data="{
    open: false,
    mobileOpen: true,
}">
    <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="relative flex justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="mobileOpen = !mobileOpen"
                    class="relative inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>


                    <svg class="w-6 h-6 " :class="open ? 'hidden' : 'block'" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                    <svg class="hidden w-6 h-6 " :class="open ? 'hidden' : 'block'" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
                <div class="flex items-center flex-shrink-0 p-4 m-4 ">
                    <a href="{{ route('home') }}">
                        <p class="uppercase font-primary">IP-car</p>
                    </a>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @foreach ($menuItems as $menuItem)
                        <a href="{{ route($menuItem['route']) }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-tertiary hover:text-gray-700">{{ $menuItem['name'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                <!-- Profile dropdown -->
                <div class="relative ml-3 profile-dropdown ">
                    <button type="button" @click="open = !open"
                        class="relative flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        {{-- profile icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                    </button>


                    <div class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">

                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <ul class="relative flex flex-col items-start pl-0 mb-0 list-reset ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="">
                                        <a class="inline-block px-4 py-2 no-underline"
                                            href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="">
                                        <a class="inline-block px-4 py-2 no-underline"
                                            href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                                    @csrf
                                    <a class="px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="user-menu-item-2"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        href="{{ route('logout') }}">
                                        {{ __('Uitloggen') }}
                                    </a>
                                </form>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobiele navigatie --}}
    <div class="sm:hidden" id="mobile-menu" x-show="mobileOpen">
        <div class="pt-2 pb-4 space-y-1">
            @foreach ($menuItems as $menuItem)
                <a href="{{ route($menuItem['route']) }}"
                    class="block py-2 pl-3 pr-4 text-base font-medium text-gray-500 border-l-4 border-transparent hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">{{ $menuItem['name'] }}</a>
            @endforeach
        </div>
    </div>
</nav>
