<?php
/** @var \App\Models\User $user */
$user = Auth::user();
?>
<x-app-layout>
    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen py-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Dashboard Sistem BK</h1>
                    <p class="text-gray-600 mt-2">Selamat datang kembali, {{ $user->name }}!</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ now()->format('d M Y') }}</p>
                    <p class="text-sm text-gray-500">{{ now()->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">245</p>
                            <p class="text-green-600 text-xs mt-2">↑ 12 bulan ini</p>
                        </div>
                        <div class="bg-indigo-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Alokasi Selesai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">156</p>
                            <p class="text-green-600 text-xs mt-2">↑ 8 bulan ini</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-pink-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Pending Review</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">34</p>
                            <p class="text-orange-600 text-xs mt-2">Perlu perhatian</p>
                        </div>
                        <div class="bg-pink-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 1 1 0 000 2h10a1 1 0 000-2 2 2 0 00-2 2v6a1 1 0 001 1h1a1 1 0 100-2v-1a1 1 0 10-2 0v1a1 1 0 100 2h1a1 1 0 001-1v-6a4 4 0 00-4-4H8a4 4 0 00-4 4v6a1 1 0 001 1h1a1 1 0 100-2v-1a1 1 0 10-2 0v1a1 1 0 001 1H4V5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Tingkat Kepuasan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">87%</p>
                            <p class="text-green-600 text-xs mt-2">Sangat baik</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 9V5a2 2 0 012-2h6a2 2 0 012 2v4M4 9a2 2 0 002 2h8a2 2 0 002-2m-10 8a2 2 0 11-4 0 2 2 0 014 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Main Card - Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Statistik Alokasi 12 Bulan Terakhir</h2>
                    <div
                        class="h-80 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg flex items-end justify-around p-6">
                        <!-- Simple bar chart -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-indigo-600 w-8 rounded-t" style="height: 180px;"></div>
                            <p class="text-xs text-gray-600">Jan</p>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-indigo-600 w-8 rounded-t" style="height: 200px;"></div>
                            <p class="text-xs text-gray-600">Feb</p>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-indigo-600 w-8 rounded-t" style="height: 160px;"></div>
                            <p class="text-xs text-gray-600">Mar</p>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-purple-600 w-8 rounded-t" style="height: 220px;"></div>
                            <p class="text-xs text-gray-600">Apr</p>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-purple-600 w-8 rounded-t" style="height: 190px;"></div>
                            <p class="text-xs text-gray-600">May</p>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-purple-600 w-8 rounded-t" style="height: 240px;"></div>
                            <p class="text-xs text-gray-600">Jun</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Quick Links -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Menu Cepat</h2>
                    <div class="space-y-4">
                        <a href="#"
                            class="flex items-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition">
                            <svg class="w-6 h-6 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 3a2 2 0 012-2h6a2 2 0 012 2v12a1 1 0 110 2h-6a1 1 0 110-2V5a1 1 0 10-2 0v10a1 1 0 110 2H7a2 2 0 01-2-2V3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">Data Siswa</span>
                        </a>
                        <a href="#"
                            class="flex items-center p-4 rounded-lg bg-purple-50 hover:bg-purple-100 transition">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16.243 15.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM10 18a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zM5.757 16.243a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM5.757 5.757a1 1 0 000-1.414L5.05 3.636a1 1 0 10-1.414 1.414l.707.707z">
                                </path>
                            </svg>
                            <span class="text-gray-900 font-medium">Alokasi</span>
                        </a>
                        <a href="#" class="flex items-center p-4 rounded-lg bg-pink-50 hover:bg-pink-100 transition">
                            <svg class="w-6 h-6 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">Laporan</span>
                        </a>
                        <a href="#" class="flex items-center p-4 rounded-lg bg-green-50 hover:bg-green-100 transition">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">Pengaturan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
                <div class="space-y-4">
                    <div class="flex items-center p-4 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">Alokasi siswa batch 01 selesai</p>
                            <p class="text-gray-500 text-sm">2 jam yang lalu</p>
                        </div>
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Selesai</span>
                    </div>
                    <div class="flex items-center p-4 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">Data siswa baru diimport</p>
                            <p class="text-gray-500 text-sm">5 jam yang lalu</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Proses</span>
                    </div>
                    <div class="flex items-center p-4">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a1 1 0 001 1h12a1 1 0 001-1V6a2 2 0 00-2-2H4zm12 12H4a2 2 0 01-2-2v-4a1 1 0 00-1-1H.5a1.5 1.5 0 011.5 1.5v4A4.5 4.5 0 004 21h12a4.5 4.5 0 004-1.5V17a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">Laporan bulanan siap didownload</p>
                            <p class="text-gray-500 text-sm">1 hari yang lalu</p>
                        </div>
                        <span
                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>