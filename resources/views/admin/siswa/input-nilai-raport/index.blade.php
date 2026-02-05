<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">📊 Input Nilai Raport</h2>
                <p class="text-gray-600 mt-1">Monitoring dan verifikasi nilai siswa</p>
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
                    <p class="text-blue-600 text-sm font-semibold uppercase">✓ Sudah Input</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $stats['lengkap'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border border-red-200">
                    <p class="text-red-600 text-sm font-semibold uppercase">✗ Belum Input</p>
                    <p class="text-4xl font-bold text-red-900 mt-2">{{ $stats['belum'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                    <p class="text-purple-600 text-sm font-semibold uppercase">Persentase</p>
                    <p class="text-4xl font-bold text-purple-900 mt-2">{{ $stats['persentase'] }}%</p>
                </div>
            </div>

            <!-- Rata-rata Nilai per Mapel -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($stats['rata_rata'] as $mapel => $nilai)
                    <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-indigo-500">
                        <p class="text-gray-600 text-sm font-semibold uppercase">
                            {{ ucfirst(str_replace('_', ' ', str_replace('nilai_', '', $mapel))) }}
                        </p>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $nilai }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Info Alert -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-blue-800 text-sm">
                    <strong>ℹ️ Informasi:</strong> Kolom "File Raport" menampilkan status upload file raport siswa.
                    Siswa yang belum melakukan upload file akan menampilkan status "Belum Upload".
                </p>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pengisian</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Semua Status --</option>
                                <option value="lengkap" {{ request('status') === 'lengkap' ? 'selected' : '' }}>✓ Sudah
                                    Lengkap</option>
                                <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>✗ Belum
                                    Lengkap</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.siswa.input-nilai') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Nilai -->
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">NIS</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                            <th class="px-4 py-3 text-center font-semibold">Mat</th>
                            <th class="px-4 py-3 text-center font-semibold">Fis</th>
                            <th class="px-4 py-3 text-center font-semibold">Kim</th>
                            <th class="px-4 py-3 text-center font-semibold">Bio</th>
                            <th class="px-4 py-3 text-center font-semibold">TIK</th>
                            <th class="px-4 py-3 text-center font-semibold">Ing</th>
                            <th class="px-4 py-3 text-center font-semibold">Sos</th>
                            <th class="px-4 py-3 text-center font-semibold">Eko</th>
                            <th class="px-4 py-3 text-center font-semibold">Geo</th>
                            <th class="px-4 py-3 text-center font-semibold">Rata-rata</th>
                            <th class="px-4 py-3 text-center font-semibold">File Raport</th>
                            <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($siswas as $index => $siswa)
                            @php
                                $nilaiArray = [
                                    $siswa->nilai_matematika,
                                    $siswa->nilai_fisika,
                                    $siswa->nilai_kimia,
                                    $siswa->nilai_biologi,
                                    $siswa->nilai_tik,
                                    $siswa->nilai_binggris,
                                    $siswa->nilai_sosiologi,
                                    $siswa->nilai_ekonomi,
                                    $siswa->nilai_geografi,
                                ];
                                $nilaiTerisi = array_filter($nilaiArray, fn($n) => !is_null($n));
                                $rataRata = count($nilaiTerisi) > 0 ? round(array_sum($nilaiTerisi) / count($nilaiTerisi), 2) : 0;
                                $statusLengkap = count($nilaiTerisi) === 9 ? '✓' : '✗';
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-700">{{ ($siswas->currentPage() - 1) * 15 + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $siswa->nis }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $siswa->nama }}</td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_matematika ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_matematika ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_fisika ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_fisika ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_kimia ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_kimia ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_biologi ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_biologi ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_tik ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_tik ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_binggris ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_binggris ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_sosiologi ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_sosiologi ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_ekonomi ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_ekonomi ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center {{ $siswa->nilai_geografi ? 'bg-green-100 font-semibold' : 'bg-red-100 text-red-600' }}">
                                    {{ $siswa->nilai_geografi ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center font-bold {{ count($nilaiTerisi) === 9 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $rataRata }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($siswa->file_raport)
                                        <a href="{{ route('admin.siswa.raport', $siswa->id) }}"
                                            title="Download raport {{ $siswa->nis }}"
                                            class="text-blue-600 hover:text-blue-800 font-semibold">📄 Lihat</a>
                                    @else
                                        <span
                                            class="inline-block bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs font-semibold">
                                            Belum Upload
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <a href="{{ route('admin.siswa.input-nilai.show', $siswa->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold transition">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs font-semibold transition">
                                        ✏️ Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">📭 Tidak ada data nilai</p>
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