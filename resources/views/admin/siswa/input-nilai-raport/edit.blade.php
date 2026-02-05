<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">✏️ Edit Nilai Raport</h2>
                <p class="text-gray-600 mt-1">Perbarui nilai raport siswa</p>
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
                <form method="POST" action="{{ route('admin.siswa.input-nilai.update', $siswa->id) }}"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Matematika -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📐 Matematika</label>
                            <input type="number" step="0.01" name="nilai_matematika"
                                value="{{ old('nilai_matematika', $siswa->nilai_matematika) }}"
                                placeholder="Nilai Matematika"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_matematika')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fisika -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">⚛️ Fisika</label>
                            <input type="number" step="0.01" name="nilai_fisika"
                                value="{{ old('nilai_fisika', $siswa->nilai_fisika) }}" placeholder="Nilai Fisika"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_fisika')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kimia -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🧪 Kimia</label>
                            <input type="number" step="0.01" name="nilai_kimia"
                                value="{{ old('nilai_kimia', $siswa->nilai_kimia) }}" placeholder="Nilai Kimia"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_kimia')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Biologi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🧬 Biologi</label>
                            <input type="number" step="0.01" name="nilai_biologi"
                                value="{{ old('nilai_biologi', $siswa->nilai_biologi) }}" placeholder="Nilai Biologi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_biologi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- TIK -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">💻 TIK</label>
                            <input type="number" step="0.01" name="nilai_tik"
                                value="{{ old('nilai_tik', $siswa->nilai_tik) }}" placeholder="Nilai TIK"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_tik')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- B. Inggris -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🌍 B. Inggris</label>
                            <input type="number" step="0.01" name="nilai_binggris"
                                value="{{ old('nilai_binggris', $siswa->nilai_binggris) }}"
                                placeholder="Nilai B. Inggris"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_binggris')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sosiologi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">👥 Sosiologi</label>
                            <input type="number" step="0.01" name="nilai_sosiologi"
                                value="{{ old('nilai_sosiologi', $siswa->nilai_sosiologi) }}"
                                placeholder="Nilai Sosiologi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_sosiologi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ekonomi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">💰 Ekonomi</label>
                            <input type="number" step="0.01" name="nilai_ekonomi"
                                value="{{ old('nilai_ekonomi', $siswa->nilai_ekonomi) }}" placeholder="Nilai Ekonomi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_ekonomi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Geografi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🗺️ Geografi</label>
                            <input type="number" step="0.01" name="nilai_geografi"
                                value="{{ old('nilai_geografi', $siswa->nilai_geografi) }}" placeholder="Nilai Geografi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" />
                            @error('nilai_geografi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            ✅ Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.siswa.input-nilai.show', $siswa->id) }}"
                            class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                            ← Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>