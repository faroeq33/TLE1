<div class="relative">
    <img src="{{ asset('img/header-museum.png') }}" alt="" class="object-cover w-full h-48">

    <nav class="absolute inset-x-0 top-0 flex items-center justify-between p-4">
        <div class="flex items-center text-white space-x-2">
            <!-- IP Car text on the left -->
            <span class="text-lg font-bold">IP Car</span>
        </div>

        <!-- Dropdown menu -->
        <div x-data="{ isOpen: false }" class="flex items-center text-white space-x-4 relative">
            <!-- Button to toggle dropdown -->
            <button @click="isOpen = !isOpen" class="text-lg font-bold focus:outline-none flex items-center">
                <!-- Username -->
                <span class="text-lg font-medium">{{ Auth::user()->name }}</span>

                <!-- Profile icon -->
                <div class="w-8 h-8 ml-2 overflow-hidden bg-gray-300 rounded-full">
                    <!-- Add your profile image or icon here -->
                </div>

                <!-- Down arrow -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown content -->
            <div x-show="isOpen" class="absolute right-0 mt-80 space-y-2 bg-white border rounded-md shadow-md">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Logout
                </a>
                @if ( auth()->user()->is_admin )
                    <a href="{{ route('admin.view_user') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        User Overview
                    </a>
                @endif
            </div>
        </div>
    </nav>
</div>
