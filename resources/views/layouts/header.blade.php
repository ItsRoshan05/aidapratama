<header class="bg-[#111e6c] shadow-md p-4 flex justify-between items-center relative">
    <h1 class="text-xl font-semibold text-white"></h1>

    <!-- Dropdown Admin -->
    <div class="relative">
        <button id="dropdownButton" class="flex items-center space-x-2 text-white hover:text-gray-300 focus:outline-none">
            <span>{{ Auth::user()->name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

<!-- Dropdown Menu -->
<div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow z-10 transition-all duration-300 origin-top-right transform scale-95 opacity-0">
    <a href="{{ route('admin.password.change') }}" class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m0 4h.01M17 8V7a5 5 0 0 0-10 0v1m12 0H5m14 0a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h14z" />
        </svg>
        Ganti Password
    </a>

    <form method="POST" action="{{ route('logout') }}" class="p-2">
        @csrf
        <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H9m0 0l3-3m-3 3l3 3" />
            </svg>
            Logout
        </button>
    </form>
</div>

    </div>

    <!-- Dropdown toggle script -->
    <script>
        const button = document.getElementById('dropdownButton');
        const menu = document.getElementById('dropdownMenu');
        button.addEventListener('click', () => {
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-95', 'opacity-0');
                    menu.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        });
    </script>
</header>
