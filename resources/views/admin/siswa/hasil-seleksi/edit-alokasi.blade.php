<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">✏️ Alokasikan Siswa</h2>
                <p class="text-gray-600 mt-1">Alokasikan siswa waitlist ke peminatan yang diinginkan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Info -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-8 text-white mb-6">
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">NIS</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nis }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">Nama Siswa</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nama }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">Kelas Asal</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->kelas_asal }}</p>
                    </div>
                </div>
            </div>

            <!-- Pilihan Peminatan dengan Skor -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Pilihan Peminatan Siswa</h3>

                <div class="space-y-4 mb-6">
                    @if($siswa->pilihan_peminatan_1)
                        <div class="border-l-4 border-green-500 pl-4 py-2">
                            <p class="text-sm font-semibold text-gray-600">Pilihan 1</p>
                            <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan1->nama ?? 'N/A' }}</p>
                            <p class="text-sm text-green-600 font-semibold">Skor: {{ round($skors[1] ?? 0, 4) }}</p>
                        </div>
                    @endif

                    @if($siswa->pilihan_peminatan_2)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <p class="text-sm font-semibold text-gray-600">Pilihan 2</p>
                            <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan2->nama ?? 'N/A' }}</p>
                            <p class="text-sm text-blue-600 font-semibold">Skor: {{ round($skors[2] ?? 0, 4) }}</p>
                        </div>
                    @endif

                    @if($siswa->pilihan_peminatan_3)
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <p class="text-sm font-semibold text-gray-600">Pilihan 3</p>
                            <p class="text-lg font-bold text-gray-900">{{ $siswa->pilihanPeminatan3->nama ?? 'N/A' }}</p>
                            <p class="text-sm text-purple-600 font-semibold">Skor: {{ round($skors[3] ?? 0, 4) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Alokasi -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">✅ Alokasikan ke Peminatan</h3>

                <form action="{{ route('admin.siswa.hasil-seleksi.store-alokasi', $siswa->id) }}" method="POST"
                    class="space-y-4">
                    @csrf

                    <!-- Peminatan Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Peminatan</label>
                        <select name="peminatan_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Peminatan --</option>
                            @foreach($peminatans as $peminatan)
                                <option value="{{ $peminatan->id }}">{{ $peminatan->nama }}</option>
                            @endforeach
                        </select>
                        @error('peminatan_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 justify-end pt-4">
                        <a href="{{ route('admin.siswa.hasil-seleksi') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                            ← Batal
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ✅ Simpan Alokasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>