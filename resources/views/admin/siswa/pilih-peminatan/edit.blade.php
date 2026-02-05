<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">✏️ Edit Pilihan Peminatan</h2>
                <p class="text-gray-600 mt-1">Perbarui pilihan peminatan siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 font-semibold mb-2">❌ Validasi Error:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700 text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Header Info -->
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 text-white p-6 rounded-lg mb-6">
                    <p class="text-sm opacity-90">NIS: {{ $siswa->nis }}</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $siswa->nama }}</h3>
                    <p class="text-sm opacity-90 mt-1">{{ $siswa->kelas_asal }}</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('admin.siswa.pilih-peminatan.update', $siswa->id) }}"
                    class="space-y-6">
                    @csrf

                    <!-- Pilihan 1 -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🎯 Pilihan 1 (Utama)</label>
                        <select name="pilihan_peminatan_1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">-- Pilih Peminatan --</option>
                            @foreach($peminatans as $peminatan)
                                <option value="{{ $peminatan->id }}" {{ old('pilihan_peminatan_1', $siswa->pilihan_peminatan_1) == $peminatan->id ? 'selected' : '' }}>
                                    {{ $peminatan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pilihan_peminatan_1')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilihan 2 -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🎯 Pilihan 2 (Kedua)</label>
                        <select name="pilihan_peminatan_2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">-- Pilih Peminatan --</option>
                            @foreach($peminatans as $peminatan)
                                <option value="{{ $peminatan->id }}" {{ old('pilihan_peminatan_2', $siswa->pilihan_peminatan_2) == $peminatan->id ? 'selected' : '' }}>
                                    {{ $peminatan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pilihan_peminatan_2')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilihan 3 -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🎯 Pilihan 3 (Ketiga)</label>
                        <select name="pilihan_peminatan_3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">-- Pilih Peminatan --</option>
                            @foreach($peminatans as $peminatan)
                                <option value="{{ $peminatan->id }}" {{ old('pilihan_peminatan_3', $siswa->pilihan_peminatan_3) == $peminatan->id ? 'selected' : '' }}>
                                    {{ $peminatan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pilihan_peminatan_3')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            ✅ Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.siswa.pilih-peminatan.show', $siswa->id) }}"
                            class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                            ← Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>