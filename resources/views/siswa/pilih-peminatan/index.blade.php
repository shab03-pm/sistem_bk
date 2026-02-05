<x-app-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Pilih 3 Peminatan</h2>
                <p class="text-gray-600 mt-1">Pilih 3 paket peminatan yang Anda inginkan sesuai preferensi (urutan
                    penting!)</p>
            </div>
        </div>
    </x-slot>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <h4 class="text-sm font-semibold text-red-800 mb-2">Terjadi Kesalahan:</h4>
            <ul class="text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-600 font-semibold">✓ {{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <p class="text-sm text-red-600 font-semibold">⚠ {{ session('error') }}</p>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ambil data dari tabel siswas -->
            @php
                $siswa = \App\Models\Siswa::where('nis', auth()->user()->nis)->first();
                $pilihan1 = $siswa ? $siswa->pilihan_peminatan_1 : null;
                $pilihan2 = $siswa ? $siswa->pilihan_peminatan_2 : null;
                $pilihan3 = $siswa ? $siswa->pilihan_peminatan_3 : null;
                $sudahPilih = ($pilihan1 && $pilihan2 && $pilihan3) ? 'Sudah Dipilih' : 'Belum Lengkap';
                $totalKuota = $peminatans->sum('kuota_maksimal');
            @endphp

            <!-- Statistik Peminatan -->
            @if($peminatans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Peminatan Card -->
                    <div
                        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">Total Peminatan Tersedia</p>
                                    <p class="text-4xl font-bold mt-2">{{ $peminatans->count() }}</p>
                                    <p class="text-blue-100 text-xs mt-2">Paket pilihan</p>
                                </div>
                                <div class="text-5xl opacity-20">📦</div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pilihan Card -->
                    <div
                        class="bg-gradient-to-br {{ $sudahPilih == 'Sudah Dipilih' ? 'from-green-500 to-green-600' : 'from-yellow-500 to-yellow-600' }} rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-white text-opacity-90 text-sm font-medium">Status Pilihan</p>
                                    <p class="text-3xl font-bold mt-2">{{ $sudahPilih }}</p>
                                    <p class="text-white text-opacity-75 text-xs mt-2">
                                        @if($sudahPilih == 'Sudah Dipilih')
                                            Semua pilihan lengkap ✓
                                        @else
                                            Masih perlu
                                            {{ 3 - ($pilihan1 ? 1 : 0) - ($pilihan2 ? 1 : 0) - ($pilihan3 ? 1 : 0) }} pilihan
                                        @endif
                                    </p>
                                </div>
                                <div class="text-5xl">
                                    @if($sudahPilih == 'Sudah Dipilih')
                                        ✓
                                    @else
                                        ⚠
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kuota Tersedia Card -->
                    <div
                        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm font-medium">Total Kuota</p>
                                    <p class="text-4xl font-bold mt-2">{{ $totalKuota }}</p>
                                    <p class="text-purple-100 text-xs mt-2">Kursi yang tersedia</p>
                                </div>
                                <div class="text-5xl opacity-20">👥</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($peminatans->count() == 0)
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 6a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Paket Peminatan</h3>
                        <p class="text-gray-600 mb-6">Admin belum membuat paket peminatan. Silakan cek kembali nanti.</p>
                        <a href="{{ route('siswa.dashboard') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                @else
                    <form action="{{ route('siswa.pilih-peminatan.store') }}" method="POST" id="peminatanForm">
                        @csrf

                        <div class="p-6">
                            <!-- Info Box -->
                            <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                                <div class="flex gap-3">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Memilih Peminatan</h4>
                                        <p class="text-xs text-blue-700">Pilih peminatan sesuai minat dan prestasi Anda.
                                            Urutan penting karena akan digunakan sebagai preferensi dalam alokasi.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilihan Peminatan -->
                            <div class="space-y-6">
                                <!-- Pilihan 1 -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        1️⃣
                                    </div>
                                    <div
                                        class="ml-4 p-6 border-2 border-blue-200 rounded-lg hover:border-blue-400 hover:shadow-md transition bg-gradient-to-br from-blue-50 to-white">
                                        <label
                                            class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                            <span class="text-xl">🎯</span>
                                            Pilihan 1 - Prioritas Utama
                                        </label>
                                        <select name="pilihan_1"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition font-medium text-gray-900 @error('pilihan_1') border-red-500 @enderror"
                                            required onchange="validateDuplicates()">
                                            <option value="">-- Pilih Paket Peminatan --</option>
                                            @foreach($peminatans as $peminatan)
                                                <option value="{{ $peminatan->id }}" {{ old('pilihan_1', $pilihan1) == $peminatan->id ? 'selected' : '' }}>
                                                    {{ $peminatan->nama }}
                                                    @if($peminatan->kuota_maksimal)
                                                        ({{ $peminatan->kuota_maksimal }} Kuota)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($pilihan1)
                                            <p class="mt-3 text-xs text-green-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Pilihan sudah tersimpan
                                            </p>
                                        @endif
                                        @error('pilihan_1')
                                            <p class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded">⚠ {{ $message }}</p>
                                        @enderror
                                        <div id="error_pilihan_1"
                                            class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded hidden"></div>
                                    </div>
                                </div>

                                <!-- Pilihan 2 -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        2️⃣
                                    </div>
                                    <div
                                        class="ml-4 p-6 border-2 border-amber-200 rounded-lg hover:border-amber-400 hover:shadow-md transition bg-gradient-to-br from-amber-50 to-white">
                                        <label
                                            class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                            <span class="text-xl">🥈</span>
                                            Pilihan 2 - Prioritas Kedua
                                        </label>
                                        <select name="pilihan_2"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition font-medium text-gray-900 @error('pilihan_2') border-red-500 @enderror"
                                            required onchange="validateDuplicates()">
                                            <option value="">-- Pilih Paket Peminatan --</option>
                                            @foreach($peminatans as $peminatan)
                                                <option value="{{ $peminatan->id }}" {{ old('pilihan_2', $pilihan2) == $peminatan->id ? 'selected' : '' }}>
                                                    {{ $peminatan->nama }}
                                                    @if($peminatan->kuota_maksimal)
                                                        ({{ $peminatan->kuota_maksimal }} Kuota)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($pilihan2)
                                            <p class="mt-3 text-xs text-green-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Pilihan sudah tersimpan
                                            </p>
                                        @endif
                                        @error('pilihan_2')
                                            <p class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded">⚠ {{ $message }}</p>
                                        @enderror
                                        <div id="error_pilihan_2"
                                            class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded hidden"></div>
                                    </div>
                                </div>

                                <!-- Pilihan 3 -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        3️⃣
                                    </div>
                                    <div
                                        class="ml-4 p-6 border-2 border-orange-200 rounded-lg hover:border-orange-400 hover:shadow-md transition bg-gradient-to-br from-orange-50 to-white">
                                        <label
                                            class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                            <span class="text-xl">🥉</span>
                                            Pilihan 3 - Prioritas Ketiga
                                        </label>
                                        <select name="pilihan_3"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition font-medium text-gray-900 @error('pilihan_3') border-red-500 @enderror"
                                            required onchange="validateDuplicates()">
                                            <option value="">-- Pilih Paket Peminatan --</option>
                                            @foreach($peminatans as $peminatan)
                                                <option value="{{ $peminatan->id }}" {{ old('pilihan_3', $pilihan3) == $peminatan->id ? 'selected' : '' }}>
                                                    {{ $peminatan->nama }}
                                                    @if($peminatan->kuota_maksimal)
                                                        ({{ $peminatan->kuota_maksimal }} Kuota)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($pilihan3)
                                            <p class="mt-3 text-xs text-green-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Pilihan sudah tersimpan
                                            </p>
                                        @endif
                                        @error('pilihan_3')
                                            <p class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded">⚠ {{ $message }}</p>
                                        @enderror
                                        <div id="error_pilihan_3"
                                            class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-gray-200 bg-gray-50 p-6 flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                                Simpan Pilihan
                            </button>
                            <a href="{{ route('siswa.dashboard') }}"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition text-center flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.707 7.293a1 1 0 010 1.414L5.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm5.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L14.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Detail Peminatan (Optional - untuk referensi) -->
            @if($peminatans->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z">
                            </path>
                        </svg>
                        Daftar Paket Peminatan Tersedia
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($peminatans as $peminatan)
                            <div
                                class="p-4 border-2 border-gray-200 rounded-lg hover:border-purple-400 hover:shadow-md transition bg-white">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $peminatan->nama }}</h4>
                                    <span
                                        class="inline-flex items-center gap-1 bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-1 rounded-full">
                                        👥 {{ $peminatan->kuota_maksimal ?? 'Unlimited' }}
                                    </span>
                                </div>
                                @if($peminatan->deskripsi)
                                    <p class="text-xs text-gray-600 line-clamp-2">{{ $peminatan->deskripsi }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function validateDuplicates() {
            const pilihan1 = document.querySelector('select[name="pilihan_1"]').value;
            const pilihan2 = document.querySelector('select[name="pilihan_2"]').value;
            const pilihan3 = document.querySelector('select[name="pilihan_3"]').value;

            // Clear previous errors
            document.getElementById('error_pilihan_1').textContent = '';
            document.getElementById('error_pilihan_2').textContent = '';
            document.getElementById('error_pilihan_3').textContent = '';
            document.getElementById('error_pilihan_1').classList.add('hidden');
            document.getElementById('error_pilihan_2').classList.add('hidden');
            document.getElementById('error_pilihan_3').classList.add('hidden');

            let isValid = true;

            // Check for duplicates
            if (pilihan1 && pilihan2 && pilihan1 === pilihan2) {
                document.getElementById('error_pilihan_2').textContent = 'Tidak boleh sama dengan pilihan 1';
                document.getElementById('error_pilihan_2').classList.remove('hidden');
                isValid = false;
            }

            if (pilihan1 && pilihan3 && pilihan1 === pilihan3) {
                document.getElementById('error_pilihan_3').textContent = 'Tidak boleh sama dengan pilihan 1';
                document.getElementById('error_pilihan_3').classList.remove('hidden');
                isValid = false;
            }

            if (pilihan2 && pilihan3 && pilihan2 === pilihan3) {
                document.getElementById('error_pilihan_3').textContent = 'Tidak boleh sama dengan pilihan 2';
                document.getElementById('error_pilihan_3').classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }

        // Validate on form submit
        document.getElementById('peminatanForm').addEventListener('submit', function (e) {
            if (!validateDuplicates()) {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>