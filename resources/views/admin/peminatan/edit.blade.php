<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900">Edit Paket Peminatan</h2>
            <a href="{{ route('admin.peminatan.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.peminatan.update', $peminatan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Peminatan *</label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama', $peminatan->nama) }}" 
                           placeholder="Contoh: MIPA, IPS, Keahlian"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                           required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kuota_maksimal" class="block text-sm font-medium text-gray-700 mb-2">Kuota Maksimal *</label>
                    <input type="number" 
                           id="kuota_maksimal" 
                           name="kuota_maksimal" 
                           value="{{ old('kuota_maksimal', $peminatan->kuota_maksimal) }}" 
                           min="1"
                           placeholder="Contoh: 100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kuota_maksimal') border-red-500 @enderror"
                           required>
                    @error('kuota_maksimal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition">
                        Update
                    </button>
                    <a href="{{ route('admin.peminatan.index') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-8 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>