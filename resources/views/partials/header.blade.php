<nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="#" class="font-bold text-2xl text-gray-800 dark:text-white">Tempat-In</a>

            <div class="flex items-center">
                
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">Cara Kerja</a>
                    <a href="#restaurants" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">Restoran</a>
                    <a href="#partner" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">Jadi Mitra</a>
                    <a href="/login" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Login</a>
                </div>

                <button id="theme-toggle" type="button" class="ml-4 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.121-3.536a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.464-4.95l-.707-.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 101.414-1.414zm-2.121-3.536a1 1 0 010-1.414l.707-.707a1 1 0 111.414 1.414l-.707-.707a1 1 0 01-1.414 0zM3.536 6.464l.707-.707a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414z"></path></svg>
                </button>

                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button" class="ml-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden mt-4">
            <a href="#features" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Cara Kerja</a>
            <a href="#restaurants" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Restoran</a>
            <a href="#partner" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Jadi Mitra</a>
            <a href="/login" class="block mt-2 text-center w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Login</a>
        </div>
    </div>
</nav>