<?php
/** @var \App\Models\Siswa $user */
$user = Auth::user();
?>
<x-app-layout>
    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Saya</h1>
                <p class="text-gray-600 text-sm mt-1">Kelola data akademik dan peminatan karir Anda</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <h2 class="text-4xl font-bold mb-2">Selamat Datang! 👋</h2>
                <p class="text-lg text-indigo-100">{{ $user->name }}, siapkan diri Anda untuk masa depan yang
                    cemerlang</p>
            </div>

            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Profile Status -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Status Profile</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Lengkapi</p>
                            <p class="text-xs text-gray-500 mt-2">Data pribadi Anda</p>
                        </div>
                        <div class="text-4xl">📋</div>
                    </div>
                </div>

                <!-- Academic Status -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Nilai Akademik</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Input</p>
                            <p class="text-xs text-gray-500 mt-2">Nilai rapor Anda</p>
                        </div>
                        <div class="text-4xl">📊</div>
                    </div>
                </div>

                <!-- Major Selection -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-pink-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Peminatan Karir</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Pilih</p>
                            <p class="text-xs text-gray-500 mt-2">Minat dan bakat Anda</p>
                        </div>
                        <div class="text-4xl">🎯</div>
                    </div>
                </div>
            </div>

            <!-- Menu Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Lengkapi Profile Card -->
                <a href="{{ route('siswa.profile') }}"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 border border-gray-100 hover:border-indigo-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-3xl mb-3">👤</div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition">Lengkapi
                                Profil</h3>
                            <p class="text-gray-600 text-sm mt-2">Perbarui data pribadi Anda termasuk alamat, nomor
                                telepon, dan informasi penting lainnya untuk profil yang lebih lengkap</p>
                        </div>
                        <div class="text-gray-300 group-hover:text-indigo-500 transition text-2xl">→</div>
                    </div>
                    <div
                        class="flex items-center text-indigo-600 text-sm font-medium group-hover:translate-x-1 transition">
                        Kelola Profil <span class="ml-2">›</span>
                    </div>
                </a>

                <!-- Input Nilai Card -->
                <a href="{{ route('siswa.input-nilai-raport.index') }}"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 border border-gray-100 hover:border-purple-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-3xl mb-3">📈</div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition">Input
                                Nilai Rapor</h3>
                            <p class="text-gray-600 text-sm mt-2">Masukkan nilai akademik Anda dari berbagai mata
                                pelajaran untuk membantu sistem dalam memberikan rekomendasi peminatan terbaik</p>
                        </div>
                        <div class="text-gray-300 group-hover:text-purple-500 transition text-2xl">→</div>
                    </div>
                    <div
                        class="flex items-center text-purple-600 text-sm font-medium group-hover:translate-x-1 transition">
                        Input Nilai <span class="ml-2">›</span>
                    </div>
                </a>

                <!-- Pilih Peminatan Card -->
                <a href="{{ route('siswa.pilih-peminatan.index') }}"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 border border-gray-100 hover:border-pink-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-3xl mb-3">🎓</div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-pink-600 transition">Pilih
                                Peminatan</h3>
                            <p class="text-gray-600 text-sm mt-2">Tentukan pilihan peminatan karir Anda berdasarkan
                                minat, bakat, dan hasil analisis sistem bimbingan karir kami</p>
                        </div>
                        <div class="text-gray-300 group-hover:text-pink-500 transition text-2xl">→</div>
                    </div>
                    <div
                        class="flex items-center text-pink-600 text-sm font-medium group-hover:translate-x-1 transition">
                        Pilih Sekarang <span class="ml-2">›</span>
                    </div>
                </a>

                <!-- Lihat Hasil SAW Card -->
                <a href="{{ route('siswa.skor-saw.index') }}"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 border border-gray-100 hover:border-orange-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-3xl mb-3">🏆</div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition">Hasil
                                Analisis</h3>
                            <p class="text-gray-600 text-sm mt-2">Lihat hasil analisis sistem dan rekomendasi peminatan
                                yang telah diperhitungkan berdasarkan data akademik dan preferensi Anda</p>
                        </div>
                        <div class="text-gray-300 group-hover:text-orange-500 transition text-2xl">→</div>
                    </div>
                    <div
                        class="flex items-center text-orange-600 text-sm font-medium group-hover:translate-x-1 transition">
                        Lihat Hasil <span class="ml-2">›</span>
                    </div>
                </a>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="text-2xl mr-4">ℹ️</div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-2">Informasi Penting</h4>
                        <p class="text-blue-800 text-sm">Lengkapi semua data Anda untuk mendapatkan rekomendasi
                            peminatan yang akurat. Tim bimbingan karir kami siap membantu Anda menemukan jalur karir
                            yang tepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>