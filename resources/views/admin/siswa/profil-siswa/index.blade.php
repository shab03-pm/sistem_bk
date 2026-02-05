<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">👤 Profil Siswa</h2>
                <p class="text-gray-600 mt-1">Kelola dan monitoring data pribadi seluruh siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                    <p class="text-blue-600 text-sm font-semibold uppercase">Total Siswa</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $stats['total'] }}</p>
                </div>

                @foreach($stats['per_kelas'] as $kelas)
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                        <p class="text-purple-600 text-sm font-semibold uppercase">{{ $kelas->kelas_asal }}</p>
                        <p class="text-4xl font-bold text-purple-900 mt-2">{{ $kelas->total }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari (NIS/Nama/Email)</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Ketik NIS, nama, atau email..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>

                        <!-- Filter Kelas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Kelas</label>
                            <select name="kelas"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas }}" {{ request('kelas') === $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.siswa.profil') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Siswa -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NIS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Kelas Asal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ ($siswas->currentPage() - 1) * 15 + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $siswa->nis }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $siswa->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->kelas_asal ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $siswa->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('admin.siswa.show', $siswa->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        ✏️ Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">📭 Tidak ada data siswa</p>
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