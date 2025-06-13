<aside id="sidebar" class="w-64 bg-gray-800 text-gray-200 flex-shrink-0 hidden md:block">
    <div class="p-6">
        <a href="{{ route('superadmin.dashboard') }}" class="text-white text-2xl font-semibold">Tempat-In</a>
        <p class="text-sm text-yellow-400">Super Admin Panel</p>
    </div>
    <nav class="mt-6">
        {{-- Helper untuk link aktif --}}
        @php
            $activeClass = 'bg-indigo-600 border-l-4 border-indigo-400';
            $linkClass = 'flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200';
        @endphp

        <a href="{{ route('superadmin.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('superadmin.dashboard') ? $activeClass : '' }}">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span class="mx-4">Dashboard</span>
        </a>
        
        <a href="{{ route('superadmin.users.index') }}" class="{{ $linkClass }} {{ request()->routeIs('superadmin.users.*') ? $activeClass : '' }}">
            <i class="fas fa-users-cog w-6"></i>
            <span class="mx-4">Manajemen Pengguna</span>
        </a>
        
        <a href="{{ route('superadmin.restaurants.index') }}" class="{{ $linkClass }} {{ request()->routeIs('superadmin.restaurants.*') ? $activeClass : '' }}">
            <i class="fas fa-building w-6"></i>
            <span class="mx-4">Manajemen Restoran</span>
        </a>
    </nav>

    <div class="absolute bottom-0 w-full">
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="{{ $linkClass }} w-full">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="mx-4">Logout</span>
            </a>
        </form>
    </div>
</aside>