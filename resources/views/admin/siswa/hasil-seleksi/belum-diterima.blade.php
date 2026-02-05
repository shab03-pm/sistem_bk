@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📋 Alokasi Manual Siswa ke PAKET 6</h1>
            <p class="text-gray-600 mt-2">Pilih siswa untuk dialokasikan ke PAKET 6 (GEOGRAFI,EKONOMI,SOSIOLOGI,TIK)</p>
            <p class="text-yellow-600 font-semibold mt-2">⚠️ Sisa Kursi PAKET 6: <span id="sisaKursi">42</span></p>
        </div>

        @if ($siswaBelumDiterima->total() == 0)
            <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-6">
                <p class="text-green-700">✅ Semua siswa sudah dialokasikan!</p>
            </div>
        @else
            <form action="{{ route('admin.siswa.simpan-alokasi-manual') }}" method="POST"
                class="bg-white rounded-lg shadow-md p-6">
                @csrf

                <div class="mb-4">
                    <button type="button" id="selectAll"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold">
                        ✓ Pilih Semua
                    </button>
                    <button type="button" id="clearAll"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-semibold ml-2">
                        ✕ Hapus Pilihan
                    </button>
                    <span id="countSelected" class="ml-4 text-gray-700">0 siswa dipilih</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" id="masterCheckbox" class="w-5 h-5 cursor-pointer">
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">NIS</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 1</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 2</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 3</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Skor SAW</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($siswaBelumDiterima as $index => $siswa)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}"
                                            class="siswa-checkbox w-5 h-5 cursor-pointer">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ ($siswaBelumDiterima->currentPage() - 1) * $siswaBelumDiterima->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $siswa->nis }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->nama }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($siswa->pilihanPeminatan1)
                                            <span class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $siswa->pilihanPeminatan1->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($siswa->pilihanPeminatan2)
                                            <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $siswa->pilihanPeminatan2->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($siswa->pilihanPeminatan3)
                                            <span class="px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $siswa->pilihanPeminatan3->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900">
                                        @php
                                            $skorSaw = 0;
                                            if ($siswa->pilihan_peminatan_1) {
                                                // Hitung skor untuk pilihan 1
                                                $peminatan = $siswa->pilihanPeminatan1;
                                                $kriterias = \App\Models\Kriteria::where('peminatan_id', $peminatan->id)->get();
                                                $totalSkor = 0;
                                                foreach ($kriterias as $k) {
                                                    $mapField = 'nilai_' . $k->mapel;
                                                    $nilaiSiswa = $siswa->$mapField ?? 0;
                                                    $nilai_max = \App\Models\Kriteria::where('mapel', $k->mapel)->max('nilai_max');
                                                    $normalisasi = $nilai_max > 0 ? $nilaiSiswa / $nilai_max : 0;
                                                    $totalSkor += $k->bobot * $normalisasi;
                                                }
                                                $skorSaw = round($totalSkor, 4);
                                            }
                                        @endphp
                                        {{ number_format($skorSaw, 4, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        <p class="text-lg">✅ Tidak ada siswa yang belum dialokasikan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($siswaBelumDiterima->total() > 0)
                    <div class="mt-6 flex justify-between items-center">
                        <div>
                            {{ $siswaBelumDiterima->links() }}
                        </div>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-semibold transition">
                            💾 Simpan Alokasi
                        </button>
                    </div>
                @endif
            </form>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const masterCheckbox = document.getElementById('masterCheckbox');
            const checkboxes = document.querySelectorAll('.siswa-checkbox');
            const countSelected = document.getElementById('countSelected');
            const selectAllBtn = document.getElementById('selectAll');
            const clearAllBtn = document.getElementById('clearAll');

            function updateCount() {
                const selected = document.querySelectorAll('.siswa-checkbox:checked').length;
                countSelected.textContent = selected + ' siswa dipilih';
                masterCheckbox.checked = selected === checkboxes.length && checkboxes.length > 0;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCount);
            });

            masterCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateCount();
            });

            selectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                masterCheckbox.checked = true;
                updateCount();
            });

            clearAllBtn.addEventListener('click', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                masterCheckbox.checked = false;
                updateCount();
            });
        });
    </script>
@endsection