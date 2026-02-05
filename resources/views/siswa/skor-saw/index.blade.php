<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Skor SAW</h2>
                <p class="text-gray-600 mt-1">Rincian perhitungan skor SAW Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($alokasi)
                <!-- Informasi Siswa -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Nama Siswa</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $alokasi->siswa->nama }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">NIS</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $alokasi->siswa->nis }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Kelas Asal</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $alokasi->siswa->kelas_asal }}</p>
                        </div>
                    </div>
                </div>

                <!-- Header Skor -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                        <p class="text-gray-600 text-sm">Peminatan Diterima</p>
                        <p class="text-xl font-bold text-gray-900 mt-2">{{ $alokasi->peminatan->nama }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                        <p class="text-gray-600 text-sm">Skor SAW Akhir</p>
                        <p class="text-2xl font-bold text-purple-800 mt-2">{{ number_format($alokasi->skor_saw, 4) }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                        <p class="text-gray-600 text-sm">Peringkat</p>
                        <p class="text-2xl font-bold text-green-700 mt-2">
                            @php
                                $noPilihanDiterima = array_key_first(array_filter($detailSkorPerPilihan, fn($p) => $p['isDiterima']));
                                $dataDiterima = $detailSkorPerPilihan[$noPilihanDiterima] ?? null;
                            @endphp
                            {{ $dataDiterima['ranking'] ?? '-' }}<span class="text-lg text-gray-500"> /
                                {{ $dataDiterima['totalSiswa'] ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Accordion Rincian Perhitungan SAW per Pilihan -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">📊 Rincian Perhitungan SAW per Pilihan</h3>

                    @foreach($detailSkorPerPilihan as $noPilihan => $data)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <!-- Accordion Header -->
                            <button type="button"
                                class="accordion-button w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition"
                                data-accordion="accordion-{{ $noPilihan }}">
                                <div class="flex items-center gap-4 text-left flex-1">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            Pilihan {{ $noPilihan }}: {{ $data['peminatan']->nama }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-2">
                                            <span class="text-sm text-gray-600">Skor: <span
                                                    class="font-bold text-gray-900">{{ number_format($data['skor'], 4) }}</span></span>
                                            <span class="text-sm text-gray-600">Peringkat: <span
                                                    class="font-bold text-gray-900">{{ $data['ranking'] }}/{{ $data['totalSiswa'] }}</span></span>
                                            @if($data['isDiterima'])
                                                <span
                                                    class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">✓
                                                    DITERIMA</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="accordion-icon w-5 h-5 text-gray-500 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24"
                                    style="transform: {{ $noPilihan === 1 ? 'rotate(180deg)' : 'rotate(0deg)' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>

                            <!-- Accordion Content -->
                            <div class="accordion-content border-t border-gray-200 {{ $noPilihan !== 1 ? 'hidden' : '' }}"
                                id="accordion-{{ $noPilihan }}">
                                <div class="px-6 py-6">
                                    <!-- Tabel Rincian -->
                                    <div class="overflow-x-auto mb-6">
                                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Mata Pelajaran</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Nilai Siswa</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Nilai Maksimum</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Bobot</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Normalisasi</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Kontribusi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($data['detail'] as $item)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ ucfirst(str_replace('_', ' ', $item['mapel'])) }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                                            {{ number_format($item['nilai'], 2) }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                                            {{ number_format($item['nilai_maksimum'], 2) }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                                            {{ number_format($item['bobot'], 4) }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                                            {{ number_format($item['normalisasi'], 4) }}</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-green-700">
                                                            {{ number_format($item['kontribusi'], 4) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-gray-50">
                                                <tr>
                                                    <td colspan="5"
                                                        class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total
                                                        Skor SAW:</td>
                                                    <td class="px-6 py-4 text-center text-sm font-bold text-purple-800">
                                                        {{ number_format($data['skor'], 4) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Rumus -->
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                        <p class="text-sm text-gray-700 mb-2">
                                            <span class="font-semibold">📐 Rumus Perhitungan SAW:</span>
                                        </p>
                                        <p
                                            class="text-sm text-gray-700 font-mono bg-white p-2 rounded border border-gray-300 mb-2">
                                            Skor_SAW = Σ (Bobot<sub>j</sub> × Normalisasi<sub>ij</sub>)
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">Dimana:</span> Normalisasi = Nilai_Siswa /
                                            Nilai_Maksimum_Mapel
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Script untuk Accordion -->
                <script>
                    document.querySelectorAll('.accordion-button').forEach(button => {
                        button.addEventListener('click', function () {
                            const accordionId = this.getAttribute('data-accordion');
                            const content = document.getElementById(accordionId);
                            const icon = this.querySelector('.accordion-icon');

                            // Toggle
                            content.classList.toggle('hidden');
                            icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                        });
                    });
                </script>

            @else
                <!-- Belum Ada Hasil -->
                <div class="bg-white p-12 rounded-lg shadow-sm text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 6a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Skor SAW</h3>
                    <p class="mt-2 text-gray-500">Skor SAW akan muncul setelah Guru BK menjalankan proses seleksi.</p>

                    <div class="mt-6 bg-yellow-50 p-4 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            Pastikan Anda sudah melengkapi data nilai raport dan pilihan peminatan.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>