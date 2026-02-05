<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900">Edit Kriteria Bobot</h2>
            <a href="{{ route('admin.kriteria.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.kriteria.update', $kriteria) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="peminatan_id" class="block text-sm font-medium text-gray-700 mb-2">Paket Peminatan *</label>
                    <select id="peminatan_id" name="peminatan_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('peminatan_id') border-red-500 @enderror" required>
                        <option value="">Pilih Paket Peminatan</option>
                        @foreach($peminatans as $p)
                            <option value="{{ $p->id }}" {{ old('peminatan_id', $kriteria->peminatan_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('peminatan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="mapel" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran *</label>
                    <select id="mapel" name="mapel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mapel') border-red-500 @enderror" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel }}" {{ old('mapel', $kriteria->mapel) == $mapel ? 'selected' : '' }}>{{ ucfirst($mapel) }}</option>
                        @endforeach
                    </select>
                    @error('mapel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="bobot" class="block text-sm font-medium text-gray-700 mb-2">Bobot *</label>
                    <input type="number" 
                           id="bobot" 
                           name="bobot" 
                           value="{{ old('bobot', $kriteria->bobot) }}" 
                           step="0.01"
                           min="0"
                           max="1"
                           placeholder="Contoh: 0.25"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bobot') border-red-500 @enderror"
                           required>
                    @error('bobot')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Bobot harus antara 0 - 1. Total bobot untuk satu peminatan sebaiknya = 1.</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition">
                        Update
                    </button>
                    <a href="{{ route('admin.kriteria.index') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-8 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>