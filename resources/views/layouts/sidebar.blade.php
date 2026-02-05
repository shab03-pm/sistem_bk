@if(auth()->check())
    <aside
        class="fixed left-0 top-0 h-screen w-64 bg-gradient-to-b from-indigo-600 via-purple-600 to-purple-800 text-white shadow-2xl z-50 overflow-y-auto">
        <!-- Header -->
        <div
            class="p-6 border-b border-purple-400 sticky top-0 bg-gradient-to-r from-indigo-600 to-purple-700 bg-opacity-95 backdrop-blur-sm">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent">Sistem BK
            </h1>
            <p class="text-purple-100 text-sm font-medium mt-1">🎯 Bimbingan Karir</p>
        </div>

        <!-- User Info -->
        <div
            class="px-6 py-5 bg-gradient-to-r from-purple-700 to-indigo-700 m-4 rounded-xl shadow-lg border border-purple-400 border-opacity-30">
            <p class="text-xs text-purple-200 font-semibold uppercase tracking-wider">Pengguna Aktif</p>
            <p class="font-bold text-white truncate text-lg mt-2">
                {{ auth()->user()->nama ?? auth()->user()->name ?? 'Guest' }}
            </p>
            <div
                class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white">
                {{ str_replace('_', ' ', auth()->user()->role ?? 'unknown') }}
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-8 px-4 space-y-2 pb-20">
            <!-- Dashboard - untuk semua -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-amber-400 to-orange-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-purple-500 hover:bg-opacity-40' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                    </path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Menu -->
                <div class="mt-8">
                    <p class="px-4 py-2 text-purple-200 text-xs font-bold uppercase tracking-wider">Konfigurasi Sistem</p>

                    <a href="{{ route('admin.peminatan.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.peminatan.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                        </svg>
                        <span class="font-medium">Paket Peminatan</span>
                    </a>

                    <a href="{{ route('admin.kriteria.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.kriteria.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Kriteria Bobot</span>
                    </a>

                    <a href="{{ route('reset-password-siswa.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('reset-password-siswa.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Reset Password</span>
                    </a>

                    <p class="px-4 py-3 mt-4 text-purple-200 text-xs font-bold uppercase tracking-wider">Proses SAW</p>

                    <a href="{{ route('guru.jalankan-saw.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.jalankan-saw.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Jalankan SAW</span>
                    </a>

                    <a href="{{ route('guru.hasil-alokasi.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.hasil-alokasi.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                            </path>
                        </svg>
                        <span class="font-medium">Hasil Alokasi</span>
                    </a>

                    <a href="{{ route('guru.waitinglist.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.waitinglist.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Waitinglist</span>
                    </a>

                    <p class="px-4 py-3 mt-4 text-purple-200 text-xs font-bold uppercase tracking-wider">Monitoring Siswa</p>

                    <a href="{{ route('admin.siswa.profil') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.siswa.profil') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l4 4v-4h3a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l-4 4v-4H2a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Profil Siswa</span>
                    </a>

                    <a href="{{ route('admin.siswa.input-nilai') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.siswa.input-nilai') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Input Nilai Raport</span>
                    </a>

                    <a href="{{ route('admin.siswa.pilih-peminatan') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.siswa.pilih-peminatan') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 012-2h8a2 2 0 012 2v9a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Pilih Peminatan</span>
                    </a>

                    <a href="{{ route('admin.siswa.hasil-seleksi') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.siswa.hasil-seleksi') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.757a1 1 0 01-.940 1.997h-1.348l-.305 1.352a1 1 0 01-.940.748H9.85a1 1 0 01-.94-.748l-.305-1.352H5.491a1 1 0 01-.940-1.997V6.517a3.066 3.066 0 012.812-3.062zM9 7a1 1 0 100 2 1 1 0 000-2zm5 0a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Hasil Seleksi</span>
                    </a>

                    <a href="{{ route('admin.siswa.skor-saw') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.siswa.skor-saw') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V5a1 1 0 100 2 2 2 0 01-2 2H4zm9 4a1 1 0 100 2 1 1 0 000-2zm0 4a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Skor SAW</span>
                    </a>
                </div>

            @elseif(auth()->user()->role === 'guru_bk')
                <!-- BK/Guru BK Menu -->
                <div class="mt-8">
                    <a href="{{ route('guru.jalankan-saw.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.jalankan-saw.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Jalankan SAW</span>
                    </a>

                    <a href="{{ route('guru.hasil-alokasi.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.hasil-alokasi.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                            </path>
                        </svg>
                        <span class="font-medium">Hasil Alokasi</span>
                    </a>

                    <a href="{{ route('guru.waitinglist.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('guru.waitinglist.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Waitinglist</span>
                    </a>
                </div>

            @elseif(auth()->user()->role === 'siswa')
                <!-- Siswa Menu -->
                <div class="mt-8">
                    <a href="{{ route('siswa.input-nilai-raport.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('siswa.input-nilai-raport.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Input Nilai</span>
                    </a>

                    <a href="{{ route('siswa.pilih-peminatan.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('siswa.pilih-peminatan.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 012-2h8a2 2 0 012 2v9a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Pilih Peminatan</span>
                    </a>

                    <a href="{{ route('siswa.hasil-seleksi.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('siswa.hasil-seleksi.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.757a1 1 0 01-.940 1.997h-1.348l-.305 1.352a1 1 0 01-.940.748H9.85a1 1 0 01-.94-.748l-.305-1.352H5.491a1 1 0 01-.940-1.997V6.517a3.066 3.066 0 012.812-3.062zM9 7a1 1 0 100 2 1 1 0 000-2zm5 0a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Hasil Seleksi</span>
                    </a>

                    <a href="{{ route('siswa.skor-saw.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('siswa.skor-saw.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                            </path>
                        </svg>
                        <span class="font-medium">Skor SAW</span>
                    </a>

                    <a href="{{ route('siswa.ubah-password.edit') }}"
                        class="flex items-center px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('siswa.ubah-password.*') ? 'bg-yellow-400 text-gray-900 shadow-lg font-bold' : 'hover:bg-blue-500' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Ubah Password</span>
                    </a>
                </div>
            @endif

            <!-- Logout Section -->
            <div class="mt-8 pt-6 border-t border-blue-500 px-4">
                <a href="{{ route('logout.get') }}"
                    class="w-full flex items-center justify-center px-4 py-3 rounded-lg bg-red-500 hover:bg-red-600 active:bg-red-700 text-white font-semibold transition-all duration-200 shadow-lg hover:shadow-xl"
                    onclick="return confirm('Yakin ingin keluar?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>

        <!-- Footer -->
        <div
            class="px-4 py-4 bg-blue-900 bg-opacity-50 border-t border-blue-500 text-sm text-blue-100 text-center sticky bottom-0">
            <p>© 2026 Sistem BK</p>
        </div>
    </aside>
@endif