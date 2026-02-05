<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">🎓 Pilih Peminatan</h2>
                <p class="text-gray-600 mt-1">Monitoring pilihan peminatan siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                    <p class="text-green-600 text-sm font-semibold uppercase">Total Siswa</p>
                    <p class="text-4xl font-bold text-green-900 mt-2">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                    <p class="text-blue-600 text-sm font-semibold uppercase">✓ Sudah Pilih</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $stats['sudah'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border border-red-200">
                    <p class="text-red-600 text-sm font-semibold uppercase">✗ Belum Pilih</p>
                    <p class="text-4xl font-bold text-red-900 mt-2">{{ $stats['belum'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                    <p class="text-purple-600 text-sm font-semibold uppercase">Persentase</p>
                    <p class="text-4xl font-bold text-purple-900 mt-2">{{ $stats['persentase'] }}%</p>
                </div>
            </div>

            <!-- Distribusi Pilihan Peminatan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($stats['distribusi'] as $peminatan => $jumlah)
                    <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-pink-500">
                        <p class="text-gray-600 text-sm font-semibold uppercase">{{ $peminatan }}</p>
                        <p class="text-3xl font-bold text-pink-600 mt-2">{{ $jumlah }}</p>
                        <p class="text-xs text-gray-500 mt-1">dipilih siswa</p>
                    </div>
                @endforeach
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari (NIS/Nama)</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Ketik NIS atau nama..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pilihan</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Semua Status --</option>
                                <option value="sudah" {{ request('status') === 'sudah' ? 'selected' : '' }}>✓ Sudah Pilih
                                </option>
                                <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>✗ Belum Pilih
                                </option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.siswa.pilih-peminatan') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Pilihan Peminatan -->
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-pink-600 to-pink-700 text-white sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NIS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 1 (Utama)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 2 (Kedua)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 3 (Ketiga)</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal Pilih</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($siswas as $index => $siswa)
                            @php
                                $status = ($siswa->pilihan_peminatan_1 && $siswa->pilihan_peminatan_2 && $siswa->pilihan_peminatan_3) ? 'Lengkap' : 'Belum Lengkap';
                                $statusColor = $status === 'Lengkap' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ ($siswas->currentPage() - 1) * 15 + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $siswa->nis }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->nama }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $status === 'Lengkap' ? '✓' : '✗' }} {{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $siswa->pilihanPeminatan1?->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $siswa->pilihanPeminatan2?->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $siswa->pilihanPeminatan3?->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $siswa->updated_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('admin.siswa.pilih-peminatan.show', $siswa->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ route('admin.siswa.pilih-peminatan.edit', $siswa->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        ✏️ Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">📭 Tidak ada data pilihan peminatan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-md p-4">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>