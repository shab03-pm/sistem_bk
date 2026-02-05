<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Hasil Alokasi</h2>
                <p class="text-gray-600 mt-1">Daftar siswa yang telah dialokasikan ke peminatan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-gray-600 text-sm">Total Diterima</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalDiterima }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <p class="text-gray-600 text-sm">Belum Diterima</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $belumDiterima }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-gray-600 text-sm">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalSiswa }}</p>
                </div>
            </div>

            <!-- Filter dan Search -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <form method="GET" action="{{ route('guru.hasil-alokasi.index') }}"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Siswa</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIS"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter Peminatan</label>
                        <select name="peminatan_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Peminatan</option>
                            @foreach($peminatans as $peminatan)
                                <option value="{{ $peminatan->id }}" {{ request('peminatan_id') == $peminatan->id ? 'selected' : '' }}>
                                    {{ $peminatan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter Kelas</label>
                        <select name="kelas_asal"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ request('kelas_asal') == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                            Filter
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('guru.hasil-alokasi.export-excel') }}"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition text-center"
                            title="Export hasil alokasi System 3 dengan skor breakdown (P1, P2, P3) untuk setiap siswa">
                            📊 Export System 3 + Skor
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Hasil Alokasi -->
            @if($alokasis->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIS</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Siswa</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kelas Asal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilihan 1</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilihan 2</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilihan 3</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Diterima di</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Skor SAW</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($alokasis as $index => $alokasi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $alokasis->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $alokasi->siswa->nis ?? '-' }}
                                        </td>
                                        <!-- Nama Siswa -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($alokasi->siswa)
                                                {{ $alokasi->siswa->nama ?? '-' }}
                                            @else
                                                <span class="text-red-500">Siswa tidak ditemukan</span>
                                            @endif
                                        </td>

                                        <!-- Kelas Asal -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($alokasi->siswa)
                                                {{ $alokasi->siswa->kelas_asal ?? '-' }}
                                            @else
                                                <span class="text-red-500">-</span>
                                            @endif
                                        </td>

                                        <!-- Pilihan 1 -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(!$alokasi->siswa)
                                                <span class="text-red-500 text-xs">Siswa tidak ditemukan</span>
                                            @elseif(!$alokasi->siswa->pilihan_peminatan_1)
                                                <span class="text-orange-500 text-xs">Belum pilih</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $alokasi->siswa->pilihanPeminatan1?->nama ?? 'Error' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Pilihan 2 -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(!$alokasi->siswa)
                                                <span class="text-red-500 text-xs">Siswa tidak ditemukan</span>
                                            @elseif(!$alokasi->siswa->pilihan_peminatan_2)
                                                <span class="text-orange-500 text-xs">Belum pilih</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $alokasi->siswa->pilihanPeminatan2?->nama ?? 'Error' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Pilihan 3 -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(!$alokasi->siswa)
                                                <span class="text-red-500 text-xs">Siswa tidak ditemukan</span>
                                            @elseif(!$alokasi->siswa->pilihan_peminatan_3)
                                                <span class="text-orange-500 text-xs">Belum pilih</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $alokasi->siswa->pilihanPeminatan3?->nama ?? 'Error' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Diterima di -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($alokasi->siswa && $alokasi->peminatan)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $alokasi->peminatan->nama ?? '-' }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($alokasi->skor_saw, 4) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $alokasi->created_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $alokasis->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white p-12 rounded-lg shadow-sm text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 6a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Hasil Alokasi</h3>
                    <p class="mt-2 text-gray-500">Jalankan proses SAW terlebih dahulu untuk melihat hasil alokasi.</p>
                    <a href="{{ route('guru.jalankan-saw.index') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Jalankan SAW
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>