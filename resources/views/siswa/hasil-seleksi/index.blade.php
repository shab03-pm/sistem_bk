<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Hasil Seleksi Peminatan</h2>
                <p class="text-gray-600 mt-1">Berdasarkan Algoritma SAW (Simple Additive Weighting)</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if($alokasi)
                <!-- Hasil Diterima -->
                <div class="space-y-6">
                    <!-- Header Selamat -->
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg shadow-md p-8 border border-green-200">
                        <div class="text-center">
                            <div
                                class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <svg class="w-14 h-14 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>

                            <h3 class="text-3xl font-bold text-green-900 mb-2">Selamat! 🎉</h3>
                            <p class="text-green-700 mb-6 text-lg">Anda diterima di peminatan:</p>

                            <div class="mt-6 p-8 bg-white border-2 border-green-300 rounded-lg shadow-md">
                                <p class="text-3xl font-bold text-green-700">{{ $alokasi->peminatan->nama }}</p>
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-600 mb-1">Skor SAW</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ number_format($alokasi->skor_saw, 4) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Penerimaan -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-300">📋 Detail
                            Penerimaan</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIS -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">NIS</p>
                                <p class="text-lg font-bold text-gray-900">{{ auth()->user()->nis ?? '-' }}</p>
                            </div>

                            <!-- Nama -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $alokasi->siswa->nama ?? auth()->user()->name ?? '-' }}
                                </p>
                            </div>

                            <!-- Kelas Asal -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Kelas Asal</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $alokasi->siswa->kelas_asal ?? auth()->user()->kelas_asal ?? '-' }}
                                </p>
                            </div>

                            <!-- Tanggal Diterima -->
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <p class="text-xs font-semibold text-blue-600 uppercase mb-2">📅 Tanggal Diterima</p>
                                <p class="text-lg font-bold text-blue-900">
                                    {{ $alokasi->created_at->setTimezone('Asia/Jakarta')->format('d F Y') }}
                                </p>
                                <p class="text-sm text-blue-700 mt-1">
                                    {{ $alokasi->created_at->setTimezone('Asia/Jakarta')->format('H:i:s') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pilihan -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-purple-300">🎯 Pilihan
                            Peminatan Anda</h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- P1 -->
                            <div
                                class="p-4 rounded-lg {{ $alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_1 ? 'bg-green-50 border-2 border-green-400' : 'bg-gray-50 border border-gray-300' }}">
                                <p class="text-sm font-semibold text-gray-600 mb-2">Pilihan 1</p>
                                <p class="font-bold text-gray-900">
                                    {{ $alokasi->siswa->pilihanPeminatan1->nama ?? '-' }}
                                </p>
                                @if($alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_1)
                                    <p class="text-xs text-green-700 mt-2 font-semibold">✓ DITERIMA</p>
                                @endif
                                <p class="text-xs text-gray-600 mt-2">Skor:
                                    {{ number_format($alokasi->skor_pilihan_1 ?? 0, 4) }}
                                </p>
                            </div>

                            <!-- P2 -->
                            <div
                                class="p-4 rounded-lg {{ $alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_2 ? 'bg-green-50 border-2 border-green-400' : 'bg-gray-50 border border-gray-300' }}">
                                <p class="text-sm font-semibold text-gray-600 mb-2">Pilihan 2</p>
                                <p class="font-bold text-gray-900">
                                    {{ $alokasi->siswa->pilihanPeminatan2->nama ?? '-' }}
                                </p>
                                @if($alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_2)
                                    <p class="text-xs text-green-700 mt-2 font-semibold">✓ DITERIMA</p>
                                @endif
                                <p class="text-xs text-gray-600 mt-2">Skor:
                                    {{ number_format($alokasi->skor_pilihan_2 ?? 0, 4) }}
                                </p>
                            </div>

                            <!-- P3 -->
                            <div
                                class="p-4 rounded-lg {{ $alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_3 ? 'bg-green-50 border-2 border-green-400' : 'bg-gray-50 border border-gray-300' }}">
                                <p class="text-sm font-semibold text-gray-600 mb-2">Pilihan 3</p>
                                <p class="font-bold text-gray-900">
                                    {{ $alokasi->siswa->pilihanPeminatan3->nama ?? '-' }}
                                </p>
                                @if($alokasi->peminatan_id == $alokasi->siswa->pilihan_peminatan_3)
                                    <p class="text-xs text-green-700 mt-2 font-semibold">✓ DITERIMA</p>
                                @endif
                                <p class="text-xs text-gray-600 mt-2">Skor:
                                    {{ number_format($alokasi->skor_pilihan_3 ?? 0, 4) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6">
                        <p class="text-sm text-blue-900">
                            <span class="font-semibold">ℹ️ Informasi:</span> Alokasi Anda berdasarkan algoritma SAW. Jika
                            Anda diterima sebagai Waiting List, Anda akan dialokasikan ke peminatan alternatif yang
                            tersedia.
                        </p>
                    </div>
                </div>
            @else
                <!-- Belum Ada Hasil -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div
                        class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-14 h-14 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-2">⏳ Belum Ada Hasil Seleksi</h3>
                    <p class="text-gray-600 mb-6">Hasil seleksi akan muncul setelah Guru BK menjalankan proses SAW.</p>

                    <div class="space-y-4">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800 font-semibold mb-2">📊 Status Data Anda:</p>
                            <p class="text-sm text-gray-700 mt-1">
                                @php
                                    $lengkap = (auth()->user()->nilai_matematika !== null &&
                                        auth()->user()->pilihan_peminatan_1 !== null);
                                @endphp
                                @if($lengkap)
                                    <span
                                        class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        ✓ Data lengkap, menunggu proses SAW
                                    </span>
                                @else
                                    <span
                                        class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        ⚠️ Data belum lengkap
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if(!$lengkap)
                            <a href="{{ route('siswa.input-nilai-raport.index') }}"
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition shadow-md">
                                Lengkapi Data Anda
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>