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
                    <h1 class="text-4xl font-bold text-gray-900">Dashboard Guru BK</h1>
                    <p class="text-gray-600 mt-2">Selamat datang, {{ $user->name }}! 👋</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ now()->format('d M Y') }}</p>
                    <p class="text-sm text-gray-500">{{ now()->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-pink-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">📋 Laporan Menunggu</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">7</p>
                            <p class="text-orange-600 text-xs mt-2">⏰ 3 hari deadline</p>
                        </div>
                        <div class="bg-pink-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">📊 Siswa Dialokasikan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">256/312</p>
                            <p class="text-green-600 text-xs mt-2">✨ 82% Selesai</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V9.414l-4.293 4.293a1 1 0 11-1.414-1.414L13.586 8H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <!-- Sidebar - Quick Menu -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">⚡ Menu Cepat</h2>
                    <div class="space-y-3">
                        <a href="#"
                            class="flex items-center justify-between p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition group">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:scale-110 transition mr-3"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-900 font-medium text-sm">🚀 Jalankan SAW</span>
                            </div>
                            <svg class="w-5 h-5 text-indigo-600 group-hover:translate-x-1 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="flex items-center justify-between p-4 rounded-lg bg-purple-50 hover:bg-purple-100 transition group">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-purple-600 group-hover:scale-110 transition mr-3"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-900 font-medium text-sm">📊 Hasil Alokasi</span>
                            </div>
                            <svg class="w-5 h-5 text-purple-600 group-hover:translate-x-1 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="flex items-center justify-between p-4 rounded-lg bg-pink-50 hover:bg-pink-100 transition group">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-pink-600 group-hover:scale-110 transition mr-3"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                    </path>
                                </svg>
                                <span class="text-gray-900 font-medium text-sm">⏳ Waiting List</span>
                            </div>
                            <svg class="w-5 h-5 text-pink-600 group-hover:translate-x-1 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="flex items-center justify-between p-4 rounded-lg bg-green-50 hover:bg-green-100 transition group">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-green-600 group-hover:scale-110 transition mr-3"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-900 font-medium text-sm">📚 Kriteria Bobot</span>
                            </div>
                            <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notes/Reminders -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">📋 Pengingat Penting</h2>
                    <div class="space-y-3">
                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium text-sm">⏰ Input Nilai Siswa</p>
                                    <p class="text-yellow-700 text-xs mt-1">Deadline: 31 Jan 2026</p>
                                </div>
                                <span
                                    class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">Segera</span>
                            </div>
                        </div>
                        <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium text-sm">🚨 Laporan Semester</p>
                                    <p class="text-red-700 text-xs mt-1">Deadline: 5 Februari 2026</p>
                                </div>
                                <span
                                    class="bg-red-200 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">Urgent</span>
                            </div>
                        </div>
                        <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium text-sm">✅ Proses SAW Selesai</p>
                                    <p class="text-green-700 text-xs mt-1">256 dari 312 siswa sudah dialokasikan</p>
                                </div>
                                <span
                                    class="bg-green-200 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Info</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>