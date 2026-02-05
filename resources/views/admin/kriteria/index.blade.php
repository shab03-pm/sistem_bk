<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-bold text-gray-900">Kelola Kriteria Bobot</h2>
                <p class="text-gray-600 mt-2 text-lg">Atur bobot mata pelajaran untuk setiap paket peminatan</p>
            </div>
            <a href="{{ route('admin.kriteria.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kriteria
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                <p class="text-red-800">{{ $errors->first() }}</p>
            </div>
        @endif

        <!-- Daftar Peminatan dengan Kriteria -->
        @if($peminatans->count() > 0)
            @foreach($peminatans as $peminatan)
                <div class="bg-white rounded-lg shadow-lg mb-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">{{ $peminatan->nama }}</h3>
                        <p class="text-purple-100 text-sm">Total Kuota: {{ $peminatan->kuota_maksimal }}</p>
                    </div>
                    
                    @if($peminatan->kriterias->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mata Pelajaran</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Bobot</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($peminatan->kriterias as $index => $kriteria)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold capitalize">{{ $kriteria->mapel }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold text-sm">
                                                {{ number_format($kriteria->bobot, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.kriteria.edit', $kriteria) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <form action="{{ route('admin.kriteria.destroy', $kriteria) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-8 text-center text-gray-500">
                            <p>Belum ada kriteria bobot untuk paket peminatan ini.</p>
                            <a href="{{ route('admin.kriteria.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 font-medium">
                                Tambah Kriteria Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <p class="text-gray-600">Belum ada paket peminatan. Buat paket peminatan terlebih dahulu.</p>
                <a href="{{ route('admin.peminatan.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Buat Paket Peminatan
                </a>
            </div>
        @endif
    </div>
</x-app-layout>