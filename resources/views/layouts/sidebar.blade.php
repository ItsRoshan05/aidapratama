<aside x-data="{ open: window.innerWidth >= 768 ? true : false }" x-init="$watch('open', value => {})" class="bg-[#111e6c] border-r min-h-screen p-4 transition-all duration-300 w-64 relative" :class="open ? 'w-64' : 'w-20'">
    <!-- Burger Button -->
    <button @click="open = !open" class="absolute top-4 right-4 z-20 bg-white rounded-full shadow p-2 focus:outline-none md:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-700 transition-transform duration-300" :class="open ? '' : 'rotate-180'">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
    <!-- Logo -->
    <div class="text-1xl font-bold text-white mb-6 mt-2 transition-all duration-300" :class="open ? 'opacity-100 text-left pl-2' : 'opacity-0'">
        AIDA PRATAMA
    </div>
    <nav class="space-y-4 text-[#cbd5e1] text-sm">
        <!-- Section: Dashboard -->
        <div>
            <a href="{{ route('admin.dashboard.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.75z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Dashboard</span>
            </a>
        </div>
        @if(Auth::user()->role === 'owner')
        <!-- Section: User -->
        <div>
            <span x-show="open" class="text-xs uppercase tracking-wider text-[#64748b] px-3 transition-all duration-300">User</span>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0] mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.5 20.25a7.5 7.5 0 0 1 15 0v.75a.75.75 0 0 1-.75.75h-13.5a.75.75 0 0 1-.75-.75v-.75z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Data User</span>
            </a>
        </div>
        @endif
        <!-- Section: Master Data -->
        <div>
            <span x-show="open" class="text-xs uppercase tracking-wider text-[#64748b] px-3 transition-all duration-300">Master Data</span>
            @if(Auth::user()->role === 'owner')
            <a href="{{route('admin.products.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0] mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2h-4M4 17V7a2 2 0 0 1 2-2h4m4 0v6M4 17h16M4 21h16" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Produk</span>
            </a>
            @endif
            <a href="{{route('admin.customers.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 0 1 9 16h6a4 4 0 0 1 3.879 1.804M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Customer</span>
            </a>
            @if(Auth::user()->role === 'owner')
            <a href="{{route('admin.supliers.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 2a6 6 0 1 0 0 12A6 6 0 0 0 12 10z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Suplier</span>
            </a>
            @endif
        </div>
        <!-- Section: Transaksi -->
        <div>
            <span x-show="open" class="text-xs uppercase tracking-wider text-[#64748b] px-3 transition-all duration-300">Transaksi</span>
            <a href="{{ route('admin.sales.index') }}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0] mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h11L17 13M9 21a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Penjualan</span>
            </a>
            @if(Auth::user()->role === 'owner')
            <a href="{{route('admin.purchases.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4m0 0l4-4m-4 4l4 4" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Pembelian</span>
            </a>
            <a href="{{ route('admin.expenses.index') }}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0]">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Biaya</span>
            </a>
            @endif
        </div>
        <!-- Section: Laporan -->
        <div x-data="{ openLaporan: false }">
            <span x-show="open" class="text-xs uppercase tracking-wider text-[#64748b] px-3 transition-all duration-300">Laporan</span>
            <button type="button" @click="openLaporan = !openLaporan" class="flex items-center w-full space-x-3 py-2 px-3 rounded hover:bg-[#2333a0] mt-1 focus:outline-none">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 0 1 2-2h6m2-2H7m-4 4a9 9 0 1 1 18 0 9 9 0 0 1-18 0z" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Laporan</span>
                <svg x-show="open" :class="openLaporan ? 'rotate-180' : ''" class="w-4 h-4 ml-auto text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openLaporan" x-transition class="ml-8 mt-1 space-y-1" style="display: none;">
                <a href="{{ route('admin.laporan-penjualan.index') }}" class="flex items-center space-x-2 py-2 px-3 rounded hover:bg-[#2333a0]">
                    <span>Laporan Penjualan</span>
                </a>
                @if(Auth::user()->role === 'owner')
                <a href="{{ route('admin.laporan-pembelian.index')}}" class="flex items-center space-x-2 py-2 px-3 rounded hover:bg-[#2333a0]">
                    <span>Laporan Pembelian</span>
                </a>
                @endif
            </div>
                @if(Auth::user()->role === 'owner')

            <a href="{{ route('admin.laba-rugi.index')}}" class="flex items-center space-x-3 py-2 px-3 rounded hover:bg-[#2333a0] mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8" />
                </svg>
                <span x-show="open" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-4" class="transition-all duration-300">Laba Rugi</span>
            </a>
                @endif

        </div>
    </nav>
</aside>
