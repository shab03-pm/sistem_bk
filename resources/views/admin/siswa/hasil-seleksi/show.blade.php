<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">📊 Detail Hasil Seleksi</h2>
                <p class="text-gray-600 mt-1">Transparansi perhitungan dan alasan alokasi peminatan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Student Info Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-8 text-white">
                <div class="grid grid-cols-4 gap-6">
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">NIS</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nis }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">Nama Siswa</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nama }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">Kelas Asal</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->kelas_asal }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm uppercase tracking-wide">Status Alokasi</p>
                        <p class="text-2xl font-bold mt-1">✓ Diterima</p>
                    </div>
                </div>
            </div>

            <!-- Perbandingan Ketiga Pilihan -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-3">⚖️</span> Perbandingan Skor Ketiga Pilihan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($pilihanScores as $pilihan => $data)
                        <div
                            class="border rounded-lg p-6 @if($terpilih === $pilihan) bg-green-50 border-green-300 @else border-gray-300 @endif">
                            <div class="flex items-center justify-between mb-4">
                                <p class="font-bold text-lg text-gray-900">Pilihan {{ $pilihan }}</p>
                                @if($terpilih === $pilihan)
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">TERPILIH</span>
                                @endif
                            </div>

                            <p class="text-gray-700 mb-3">{{ $data['peminatan']->nama }}</p>

                            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                                <p class="text-sm text-gray-600">Skor SAW</p>
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($data['skor'], 4) }}</p>
                            </div>

                            <!-- Detail Perhitungan Quick View -->
                            <div class="text-xs space-y-1 border-t pt-3 bg-gray-50 p-2 rounded">
                                @foreach($data['detail'] as $d)
                                    <div class="flex justify-between items-start">
                                        <span class="font-semibold text-gray-700 flex-1">{{ substr($d['mapel'], 0, 3) }}</span>
                                        <span
                                            class="text-gray-600 text-right flex-1">{{ $d['nilai'] }}/{{ $d['max_nilai'] }}</span>
                                        <span
                                            class="font-bold text-blue-600 text-right flex-1">{{ number_format($d['skor'], 3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Alasan Alokasi -->
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                <h4 class="text-lg font-bold text-green-900 mb-3">✅ Alasan Alokasi</h4>
                <p class="text-green-800">
                    Siswa <strong>{{ $siswa->nama }}</strong> dialokasikan ke
                    <strong>{{ $alokasi->peminatan->nama }}</strong>
                    karena memiliki skor SAW tertinggi yaitu
                    <strong>{{ number_format($alokasi->skor_saw, 4) }}</strong>
                    dibandingkan pilihan lainnya.
                </p>
            </div>

            <!-- Detail Perhitungan SAW Terpilih -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Detail Perhitungan SAW Terpilih</h3>

                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-gray-700"><strong>Peminatan:</strong> {{ $alokasi->peminatan->nama }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b-2 border-gray-300">
                            <tr>
                                <th class="text-left px-4 py-3">Mata Pelajaran</th>
                                <th class="text-center px-4 py-3">Nilai Siswa</th>
                                <th class="text-center px-4 py-3">Nilai Maks</th>
                                <th class="text-center px-4 py-3">Normalisasi</th>
                                <th class="text-center px-4 py-3">Bobot</th>
                                <th class="text-center px-4 py-3">Skor Kriteria</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $totalSkor = 0;
                                /** @var int $terpilih */
                                $terpilihInt = (int)$terpilih;
                            @endphp
                            @if($terpilihInt > 0 && isset($pilihanScores[$terpilihInt]) && isset($pilihanScores[$terpilihInt]['detail']))
                                @foreach($pilihanScores[$terpilihInt]['detail'] as $d)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $d['mapel'] }}</td>
                                    <td class="text-center px-4 py-3 font-semibold">{{ $d['nilai'] }}</td>
                                    <td class="text-center px-4 py-3">{{ $d['max_nilai'] }}</td>
                                    <td class="text-center px-4 py-3">
                                        <span class="text-xs text-gray-600">{{ number_format($d['nilai'], 0) }} /
                                            {{ number_format($d['max_nilai'], 0) }} =</span>
                                        <br>
                                        <strong>{{ number_format($d['normalisasi'], 4) }}</strong>
                                    </td>
                                    <td class="text-center px-4 py-3 font-bold">{{ $d['bobot'] }}</td>
                                    <td class="text-center px-4 py-3 font-bold text-blue-600">
                                        {{ number_format($d['skor'], 4) }}
                                    </td>
                                </tr>
                                @php
                                    $totalSkor += $d['skor'];
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data detail tersedia</td>
                            </tr>
                        @endif
                        </tbody>
                        <tfoot class="bg-blue-50 border-t-2 border-blue-300">
                            <tr>
                                <td colspan="5" class="text-right px-4 py-3 font-bold text-gray-900">Total Skor SAW:
                                </td>
                                <td class="text-center px-4 py-3 font-bold text-2xl text-blue-600">
                                    {{ number_format($alokasi->skor_saw, 4) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Formula Explanation -->
                <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                    <p class="text-sm font-semibold text-gray-900 mb-2">📐 Penjelasan Formula:</p>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>• <strong>Normalisasi</strong> = Nilai Siswa ÷ Nilai Maksimum (dari semua siswa)</li>
                        <li>• <strong>Skor Kriteria</strong> = Normalisasi × Bobot Peminatan</li>
                        <li>• <strong>Total Skor SAW</strong> = Σ (Skor Kriteria untuk semua mata pelajaran)</li>
                    </ul>
                </div>
            </div>

            <!-- Informasi Peringkat -->
            <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-6">
                <h4 class="text-lg font-bold text-indigo-900 mb-3">🏆 Peringkat Siswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-indigo-700 mb-1"><strong>Peminatan Terpilih:</strong></p>
                        <p class="text-base text-indigo-800">{{ $alokasi->peminatan->nama }}</p>
                        <p class="text-2xl font-bold text-indigo-600 mt-2">
                            🥇 Peringkat {{ $ranking }}/{{ $totalSiswa }}
                        </p>
                        <p class="text-sm text-indigo-700 mt-1">
                            Skor SAW: <strong>{{ number_format($alokasi->skor_saw, 4) }}</strong>
                        </p>
                    </div>
                    <div class="bg-indigo-100 rounded p-4">
                        <p class="text-xs text-indigo-700 mb-2">📊 Penjelasan:</p>
                        <p class="text-sm text-indigo-800">
                            Siswa ini menempati peringkat <strong>{{ $ranking }}</strong> dari
                            <strong>{{ $totalSiswa }}</strong> siswa
                            yang dialokasikan ke peminatan ini. Artinya ada <strong>{{ $ranking - 1 }}</strong> siswa
                            dengan skor SAW lebih tinggi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Analisis Pilihan yang Tidak Dialokasikan -->
            @if(count($pilihanScores) > 1)
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Analisis Pilihan Lain (Tidak Dialokasikan)</h3>

                    <div class="space-y-6">
                        @foreach($pilihanScores as $pilihan => $data)
                            @if($pilihan !== $terpilih)
                                <div class="border border-gray-300 rounded-lg p-6 bg-gray-50">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <p class="font-bold text-lg text-gray-900">Pilihan {{ $pilihan }}</p>
                                            <p class="text-gray-700 mt-1">{{ $data['peminatan']->nama }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Skor SAW</p>
                                            <p class="text-3xl font-bold text-gray-500">{{ number_format($data['skor'], 4) }}</p>
                                            <p class="text-xs text-orange-600 font-semibold mt-1">🥇 Peringkat
                                                {{ $data['ranking'] }}/{{ $data['total_siswa'] }}</p>
                                            <p class="text-xs text-red-600 mt-1">❌ Tidak Dialokasikan</p>
                                        </div>
                                    </div>

                                    <!-- Tabel Perhitungan Detail -->
                                    <div class="overflow-x-auto mb-4">
                                        <table class="w-full text-xs">
                                            <thead class="bg-gray-200 border-b-2 border-gray-400">
                                                <tr>
                                                    <th class="text-left px-3 py-2">Mata Pelajaran</th>
                                                    <th class="text-center px-3 py-2">Nilai</th>
                                                    <th class="text-center px-3 py-2">Max</th>
                                                    <th class="text-center px-3 py-2">Normalisasi</th>
                                                    <th class="text-center px-3 py-2">Bobot</th>
                                                    <th class="text-center px-3 py-2">Skor</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($data['detail'] as $d)
                                                    <tr>
                                                        <td class="px-3 py-2 font-semibold text-gray-800">{{ $d['mapel'] }}</td>
                                                        <td class="text-center px-3 py-2">{{ $d['nilai'] }}</td>
                                                        <td class="text-center px-3 py-2">{{ $d['max_nilai'] }}</td>
                                                        <td class="text-center px-3 py-2">
                                                            <span
                                                                class="font-semibold text-gray-700">{{ number_format($d['nilai'], 0) }}/{{ number_format($d['max_nilai'], 0) }}
                                                                = {{ number_format($d['normalisasi'], 4) }}</span>
                                                        </td>
                                                        <td class="text-center px-3 py-2 font-bold">{{ $d['bobot'] }}</td>
                                                        <td class="text-center px-3 py-2 font-bold text-gray-600">
                                                            {{ number_format($d['skor'], 4) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Penjelasan Mengapa Tidak Terpilih -->
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                                        <p class="text-sm font-semibold text-red-900 mb-2">ℹ️ Alasan Tidak Dipilih:</p>
                                        <p class="text-sm text-red-800">
                                            Pilihan {{ $pilihan }} dengan skor SAW
                                            <strong>{{ number_format($data['skor'], 4) }}</strong>
                                            lebih rendah dari pilihan terpilih
                                            (<strong>{{ number_format($alokasi->skor_saw, 4) }}</strong>).
                                            Selisih: <strong>{{ number_format($alokasi->skor_saw - $data['skor'], 4) }}</strong>
                                        </p>
                                        <p class="text-xs text-red-700 mt-2">
                                            📐 Total Skor = Σ (Normalisasi × Bobot) untuk semua mata pelajaran
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Button -->
            <div class="flex gap-3 justify-end">
                <a href="{{ route('admin.siswa.hasil-seleksi') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>