<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">📈 Skor SAW</h2>
                <p class="text-gray-600 mt-1">Monitoring detail skor dan perhitungan Simple Additive Weighting</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                    <p class="text-blue-600 text-sm font-semibold uppercase">Total Terproses</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                    <p class="text-green-600 text-sm font-semibold uppercase">Rata-rata Skor</p>
                    <p class="text-4xl font-bold text-green-900 mt-2">{{ $stats['rata_rata'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 border border-orange-200">
                    <p class="text-orange-600 text-sm font-semibold uppercase">Skor Tertinggi</p>
                    <p class="text-4xl font-bold text-orange-900 mt-2">{{ $stats['tertinggi'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border border-red-200">
                    <p class="text-red-600 text-sm font-semibold uppercase">Skor Terendah</p>
                    <p class="text-4xl font-bold text-red-900 mt-2">{{ $stats['terendah'] }}</p>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari (NIS/Nama)</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Ketik NIS atau nama..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Status</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Semua Status --</option>
                                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>✓
                                    Diterima</option>
                                <option value="waitlist" {{ request('status') === 'waitlist' ? 'selected' : '' }}>⏳
                                    Waitlist</option>
                            </select>
                        </div>

                        <!-- Filter Peminatan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Peminatan</label>
                            <select name="peminatan_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Semua Peminatan --</option>
                                @foreach($peminatans as $peminatan)
                                    <option value="{{ $peminatan->id }}" {{ request('peminatan_id') == $peminatan->id ? 'selected' : '' }}>
                                        {{ $peminatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan Skor</label>
                            <select name="order"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="tertinggi" {{ request('order') === 'tertinggi' ? 'selected' : '' }}>
                                    Tertinggi ke Terendah</option>
                                <option value="terendah" {{ request('order') === 'terendah' ? 'selected' : '' }}>Terendah
                                    ke Tertinggi</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.siswa.skor-saw') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Skor SAW -->
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-orange-600 to-orange-700 text-white sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Ranking</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NIS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Peminatan</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Skor SAW</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($alokas as $index => $alokasi)
                            @php
                                $skorSaw = round($alokasi->skor_saw, 2);
                                $ranking = $rankingMap[$alokasi->id] ?? null;
                                $medalIcon = '';
                                switch ($ranking) {
                                    case 1:
                                        $medalIcon = '🥇';
                                        break;
                                    case 2:
                                        $medalIcon = '🥈';
                                        break;
                                    case 3:
                                        $medalIcon = '🥉';
                                        break;
                                    default:
                                        $medalIcon = '';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition {{ $ranking === 1 ? 'bg-yellow-50' : '' }}">
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                    {{ $medalIcon }} #{{ $ranking ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $alokasi->siswa?->nis ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $alokasi->siswa?->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-indigo-600">
                                    {{ $alokasi->peminatan?->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block px-4 py-2 bg-gradient-to-r from-orange-400 to-orange-500 text-white font-bold rounded-lg text-sm">
                                        {{ $skorSaw }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $status = $alokasi->status === 'diterima' ? 'Diterima' : 'Waitlist';
                                        $statusColor = $alokasi->status === 'diterima' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                                        $statusIcon = $alokasi->status === 'diterima' ? '✓' : '⏳';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $statusIcon }} {{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.siswa.skor-saw.show', $alokasi->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition inline-block">
                                        📊 Detail Skor
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">📭 Belum ada skor SAW</p>
                                    <p class="text-sm mt-2">Jalankan proses SAW terlebih dahulu untuk melihat hasil</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-md p-4">
                {{ $alokas->links() }}
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">ℹ️ Informasi Skor SAW:</h4>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Skor SAW merupakan hasil dari perhitungan metode Simple Additive Weighting</li>
                    <li>Skor berkisar antara 0-100 dengan bobot dari setiap mata pelajaran yang sudah ditentukan</li>
                    <li>Siswa dengan skor tertinggi akan mendapat prioritas alokasi peminatan</li>
                    <li>Klik tombol "Detail Skor" untuk melihat perhitungan detail dari setiap mata pelajaran</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>