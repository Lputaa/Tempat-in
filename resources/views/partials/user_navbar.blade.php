<nav class="bg-white dark:bg-gray-800 shadow-md">
     **@php
        $activeClass = 'bg-indigo-600 border-l-4 border-indigo-400';
        $linkClass = 'flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200';
    @endphp**
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <a class="text-gray-800 dark:text-white text-xl font-bold md:text-2xl hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('user.dashboard') }}">
                    Tempat-In
                </a>
            </div>

            <div class="flex md:hidden">
                <button id="user-mobile-menu-button" type="button" class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>

            <div id="user-nav-links" class="hidden md:flex md:items-center">
                <div class="flex flex-col md:flex-row md:mx-6">
                    <a class="my-1 text-sm text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 md:mx-4 md:my-0" href="{{ route('restaurants.index') }}">Browse Restoran</a>
<a class="my-1 text-sm text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 md:mx-4 md:my-0" href="{{ route('reservations.history') }}">Riwayat Reservasi</a>                </div>

                <div class="relative">
                    <button id="user-dropdown-button" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                        <span class="text-sm text-gray-700">Halo, {{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>

                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 py-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-xl z-20">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600">Profil Saya</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="user-mobile-menu" class="hidden md:hidden">
            <a href="{{ route('restaurants.index') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 dark:hover:bg-gray-700">Browse Restoran</a>
            <a href="{{ route('admin.reservations.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.reservations.*') ? $activeClass : '' }}">
            <hr class="my-2 border-gray-200 dark:border-gray-700">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="block py-2 px-4 text-sm text-red-500 hover:bg-gray-200 dark:hover:bg-gray-700">
                    Logout
                </a>
            </form>
        </div>
    </div>
</nav>