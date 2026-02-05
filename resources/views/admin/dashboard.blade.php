<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-gray-600 mt-2">Kelola sistem bimbingan karir dengan dashboard admin yang komprehensif.
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Siswa Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa ?? 0 }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M10.5 1.5v8m0 0H2m8.5 0h8.5">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-3 border-t border-blue-100">
                        <p class="text-xs text-blue-600 font-semibold">📊 Data Lengkap</p>
                    </div>
                </div>

                <!-- Siswa Lengkap Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Siswa Lengkap</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $siswaLengkap ?? 0 }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-6 py-3 border-t border-green-100">
                        <p class="text-xs text-green-600 font-semibold">✅ Siap SAW</p>
                    </div>
                </div>

                <!-- Total Paket Peminatan Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Paket Peminatan</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPeminatan ?? 0 }}</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-3 border-t border-purple-100">
                        <p class="text-xs text-purple-600 font-semibold">📚 Program Pilihan</p>
                    </div>
                </div>

                <!-- Total Kriteria Card -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Kriteria Bobot</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKriteria ?? 0 }}</p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 px-6 py-3 border-t border-orange-100">
                        <p class="text-xs text-orange-600 font-semibold">⚙️ Parameter SAW</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">⚡ Aksi Cepat</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.peminatan.index') }}"
                                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 transition">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Paket Peminatan</span>
                            </a>
                            <a href="{{ route('admin.kriteria.index') }}"
                                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-purple-50 hover:border-purple-300 transition">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Kriteria Bobot</span>
                            </a>
                            <a href="{{ route('guru.jalankan-saw.index') }}"
                                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-300 transition">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Jalankan SAW</span>
                            </a>
                            <a href="{{ route('guru.hasil-alokasi.index') }}"
                                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-300 transition">
                                <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Hasil Alokasi</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📋 Status Sistem</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">Database</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                Terhubung
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">SAW Algorithm</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                Siap
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">Data Kriteria</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                {{ $totalKriteria > 0 ? 'Lengkap' : 'Belum Setup' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-gray-700 font-medium">Siswa Siap SAW</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $siswaLengkap > 0 ? 'green' : 'yellow' }}-100 text-{{ $siswaLengkap > 0 ? 'green' : 'yellow' }}-800">
                                <span
                                    class="w-2 h-2 bg-{{ $siswaLengkap > 0 ? 'green' : 'yellow' }}-600 rounded-full mr-2"></span>
                                {{ $siswaLengkap > 0 ? 'Ya' : 'Belum' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity / Info Box -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">ℹ️ Informasi Penting</h3>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-blue-800">
                            <strong>👤 User Info:</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <p class="text-xs text-blue-600 font-semibold uppercase mb-2">📊 Total Data</p>
                            <p class="text-2xl font-bold text-blue-900">
                                {{ ($totalSiswa ?? 0) + ($totalPeminatan ?? 0) + ($totalKriteria ?? 0) }}</p>
                            <p class="text-xs text-blue-700 mt-1">Siswa + Paket + Kriteria</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <p class="text-xs text-green-600 font-semibold uppercase mb-2">✅ Completion Rate</p>
                            <p class="text-2xl font-bold text-green-900">
                                {{ $totalSiswa > 0 ? round(($siswaLengkap / $totalSiswa) * 100) : 0 }}%
                            </p>
                            <p class="text-xs text-green-700 mt-1">Siswa data lengkap</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>