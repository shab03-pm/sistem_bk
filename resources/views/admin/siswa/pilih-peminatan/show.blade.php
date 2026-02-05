<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">🎯 Detail Pilihan Peminatan</h2>
                <p class="text-gray-600 mt-1">Informasi lengkap pilihan peminatan siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white p-6 rounded-lg mb-6">
                    <p class="text-sm opacity-90">NIS: {{ $siswa->nis }}</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $siswa->nama }}</h3>
                    <p class="text-sm opacity-90 mt-1">{{ $siswa->kelas_asal }}</p>
                </div>

                <!-- Data Section -->
                <div class="space-y-6">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ℹ️ Status</label>
                        @php
                            $sudahPilih = $siswa->pilihan_peminatan_1 && $siswa->pilihan_peminatan_2 && $siswa->pilihan_peminatan_3;
                        @endphp
                        @if($sudahPilih)
                            <span
                                class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                ✓ Lengkap
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                ✗ Belum Lengkap
                            </span>
                        @endif
                    </div>

                    <!-- Tanggal Pilih -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Tanggal Pilih</label>
                        <p class="text-lg text-gray-900">
                            @if($sudahPilih)
                                {{ $siswa->updated_at->format('d F Y H:i') }}
                            @else
                                <span class="text-gray-400">Belum dipilih</span>
                            @endif
                        </p>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Pilihan Peminatan -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">🎯 Pilihan Peminatan</h4>

                        <!-- Pilihan 1 -->
                        <div class="mb-4">
                            <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-400">
                                <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Pilihan 1 (Utama)</p>
                                @if($siswa->pilihanPeminatan1)
                                    <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan1->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-1">📊 Kode: {{ $siswa->pilihanPeminatan1->kode }}</p>
                                @else
                                    <p class="text-gray-400 italic">Belum dipilih</p>
                                @endif
                            </div>
                        </div>

                        <!-- Pilihan 2 -->
                        <div class="mb-4">
                            <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400">
                                <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Pilihan 2 (Kedua)</p>
                                @if($siswa->pilihanPeminatan2)
                                    <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan2->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-1">📊 Kode: {{ $siswa->pilihanPeminatan2->kode }}</p>
                                @else
                                    <p class="text-gray-400 italic">Belum dipilih</p>
                                @endif
                            </div>
                        </div>

                        <!-- Pilihan 3 -->
                        <div>
                            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-400">
                                <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Pilihan 3 (Ketiga)</p>
                                @if($siswa->pilihanPeminatan3)
                                    <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan3->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-1">📊 Kode: {{ $siswa->pilihanPeminatan3->kode }}</p>
                                @else
                                    <p class="text-gray-400 italic">Belum dipilih</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.siswa.pilih-peminatan.edit', $siswa->id) }}"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ✏️ Edit Pilihan
                    </a>
                    <a href="{{ route('admin.siswa.pilih-peminatan') }}"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>