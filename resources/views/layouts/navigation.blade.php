<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Logo / Nama Aplikasi -->
            <div class="flex items-center">
                <a href="{{ route('home') }}"
                   class="text-xl font-bold text-blue-700">
                    Lapak Aduan
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">

                <a href="{{ route('home') }}"
                   class="text-sm font-medium text-gray-700 hover:text-blue-700">
                    Beranda
                </a>

                {{-- HANYA TAMPIL UNTUK PENGGUNA BIASA (BUKAN ADMIN) --}}
                @unless(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <a href="{{ route('aduan.tracking') }}"
                       class="text-sm font-medium text-gray-700 hover:text-blue-700">
                        Cek Status
                    </a>
                @endunless

                {{-- JIKA SUDAH LOGIN --}}
                @auth
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            >
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg
                                        class="fill-current h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Link Profil -->
                            <x-dropdown-link :href="route('profile.dashboard')">
                                Profil Saya
                            </x-dropdown-link>

                            {{-- Menu khusus admin di dropdown --}}
                            @if(strtolower(auth()->user()->role) === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    🛡️ Kelola Aduan
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                >
                                    Keluar
                                </x-dropdown-link>
                            </form>

                        </x-slot>
                    </x-dropdown>
                @endauth

                {{-- JIKA BELUM LOGIN (GUEST) --}}
                @guest
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-md transition">
                                Daftar
                            </a>
                        @endif
                    </div>
                @endguest

            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                >
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open}"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                        <path
                            :class="{'hidden': ! open, 'inline-flex': open}"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>

    </div>

    <!-- Mobile Menu -->
    <div
        :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden border-t border-gray-100"
    >

        <div class="pt-2 pb-3 space-y-1">

            <a
                href="{{ route('home') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
            >
                Beranda
            </a>

            {{-- HANYA TAMPIL UNTUK PENGGUNA BIASA DI MOBILE --}}
            @unless(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                @auth
                    <a
                        href="{{ route('aduan.create') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Buat Aduan
                    </a>
                @endauth

                <a
                    href="{{ route('aduan.tracking') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >
                    Cek Status
                </a>
            @endunless

        </div>

        {{-- JIKA SUDAH LOGIN DI MOBILE --}}
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">

                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a
                        href="{{ route('profile.dashboard') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Profil Saya
                    </a>

                    @if(strtolower(auth()->user()->role) === 'admin')
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        >
                            🛡️ Kelola Aduan
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        >
                            Keluar
                        </button>
                    </form>

                </div>

            </div>
        @endauth

        {{-- JIKA BELUM LOGIN DI MOBILE --}}
        @guest
            <div class="pt-4 pb-3 border-t border-gray-200 space-y-2 px-4">
                <a
                    href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-2 text-sm font-medium text-blue-700 border border-blue-700 rounded-md hover:bg-blue-50"
                >
                    Masuk
                </a>
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800"
                    >
                        Daftar
                    </a>
                @endif
            </div>
        @endguest

    </div>
</nav>