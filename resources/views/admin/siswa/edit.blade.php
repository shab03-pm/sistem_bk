<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">✏️ Edit Siswa</h2>
                <p class="text-gray-600 mt-1">Perbarui informasi data siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 font-semibold mb-2">❌ Validation Error:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700 text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}" class="space-y-6">
                    @csrf

                    <!-- NIS -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📌 NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            required />
                        @error('nis')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">👤 Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            required />
                        @error('nama')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">✉️ Email</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            required />
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas Asal -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🏫 Kelas Asal</label>
                        <input type="text" name="kelas_asal" value="{{ old('kelas_asal', $siswa->kelas_asal) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            required />
                        @error('kelas_asal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            ✅ Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.siswa.show', $siswa->id) }}"
                            class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                            ← Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>