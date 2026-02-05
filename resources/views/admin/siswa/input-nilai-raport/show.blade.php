<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">📊 Detail Nilai Raport</h2>
                <p class="text-gray-600 mt-1">Informasi lengkap nilai siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-lg mb-6">
                    <p class="text-sm opacity-90">NIS: {{ $siswa->nis }}</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $siswa->nama }}</h3>
                    <p class="text-sm opacity-90 mt-1">{{ $siswa->kelas_asal }}</p>
                </div>

                <!-- Data Section -->
                <div class="space-y-6">
                    <!-- Informasi Dasar -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📌 NIS</label>
                            <p class="text-lg text-gray-900">{{ $siswa->nis }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">👤 Nama Lengkap</label>
                            <p class="text-lg text-gray-900">{{ $siswa->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🏫 Kelas Asal</label>
                            <p class="text-lg text-gray-900">{{ $siswa->kelas_asal ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">✉️ Email</label>
                            <p class="text-lg text-gray-900">{{ $siswa->email }}</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Nilai Raport Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">📝 Nilai Raport</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Matematika -->
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Matematika</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $siswa->nilai_matematika ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Mat</p>
                            </div>

                            <!-- Fisika -->
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Fisika</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $siswa->nilai_fisika ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Fis</p>
                            </div>

                            <!-- Kimia -->
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Kimia</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $siswa->nilai_kimia ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Kim</p>
                            </div>

                            <!-- Biologi -->
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Biologi</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ $siswa->nilai_biologi ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Bio</p>
                            </div>

                            <!-- TIK -->
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">TIK</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ $siswa->nilai_tik ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">TIK</p>
                            </div>

                            <!-- B. Inggris -->
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">B. Inggris</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ $siswa->nilai_binggris ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Ing</p>
                            </div>

                            <!-- Sosiologi -->
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Sosiologi</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $siswa->nilai_sosiologi ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Sos</p>
                            </div>

                            <!-- Ekonomi -->
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Ekonomi</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $siswa->nilai_ekonomi ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Eko</p>
                            </div>

                            <!-- Geografi -->
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase">Geografi</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $siswa->nilai_geografi ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Geo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rata-rata -->
                    @php
                        $nilaiArray = [
                            $siswa->nilai_matematika,
                            $siswa->nilai_fisika,
                            $siswa->nilai_kimia,
                            $siswa->nilai_biologi,
                            $siswa->nilai_tik,
                            $siswa->nilai_binggris,
                            $siswa->nilai_sosiologi,
                            $siswa->nilai_ekonomi,
                            $siswa->nilai_geografi,
                        ];
                        $nilaiTerisi = array_filter($nilaiArray, fn($n) => !is_null($n));
                        $rataRata = count($nilaiTerisi) > 0 ? round(array_sum($nilaiTerisi) / count($nilaiTerisi), 2) : 0;
                    @endphp
                    <div class="bg-yellow-50 p-4 rounded-lg border-2 border-yellow-400">
                        <p class="text-sm text-gray-600 font-semibold uppercase">Rata-rata Nilai</p>
                        <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $rataRata }}</p>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- File Raport -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📄 File Raport</label>
                        @if($siswa->file_raport)
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <span class="text-2xl">📄</span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $siswa->file_raport }}</p>
                                    <a href="{{ route('admin.siswa.raport', $siswa->id) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-semibold mt-1 inline-block">
                                        ⬇️ Download File
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada file raport yang diupload</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.siswa.input-nilai.edit', $siswa->id) }}"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ✏️ Edit Nilai
                    </a>
                    <form method="POST" action="{{ route('admin.siswa.input-nilai.delete', $siswa->id) }}"
                        class="flex-1" onsubmit="return confirm('Yakin ingin menghapus data nilai siswa ini?');">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            🗑️ Hapus Data
                        </button>
                    </form>
                    <a href="{{ route('admin.siswa.input-nilai') }}"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>