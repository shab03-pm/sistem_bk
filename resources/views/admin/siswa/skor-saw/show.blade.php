<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">� Detail Perhitungan SAW</h2>
                <p class="text-gray-600 mt-1">Analisis transparansi scoring Simple Additive Weighting</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Student Info Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-8 text-white">
                <div class="grid grid-cols-4 gap-6">
                    <div>
                        <p class="text-indigo-100 text-sm uppercase tracking-wide">Nama Siswa</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nama }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm uppercase tracking-wide">NIS</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->nis }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm uppercase tracking-wide">Kelas Asal</p>
                        <p class="text-2xl font-bold mt-1">{{ $siswa->kelas_asal }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm uppercase tracking-wide">Peminatan Diterima</p>
                        <p class="text-xl font-bold mt-1">{{ $alokasi->peminatan->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Skor SAW Akhir -->
            <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-indigo-600">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold uppercase">Skor SAW Akhir</p>
                        <p class="text-5xl font-bold text-indigo-600 mt-2">{{ number_format($alokasi->skor_saw, 4) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-semibold uppercase">Status Alokasi</p>
                        <p class="text-lg font-bold mt-2">
                            @if($alokasi->status === 'diterima')
                                <span class="text-green-600">✓ Diterima</span>
                            @else
                                <span class="text-yellow-600">⏳ Waitlist (Dialokasikan oleh Admin)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Perbandingan Tiga Pilihan -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-3">⚖️</span> Perbandingan Ketiga Pilihan Peminatan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($pilihanScores as $pilihan => $data)
                        <div class="border-2 rounded-lg p-6 @if($alokasi->peminatan_id === $data['peminatan']->id) bg-green-50 border-green-400 @else border-gray-300 @endif">
                            <div class="flex items-center justify-between mb-4">
                                <p class="font-bold text-lg text-gray-900">Pilihan {{ $pilihan }}</p>
                                @if($alokasi->peminatan_id === $data['peminatan']->id)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">✓ TERPILIH</span>
                                @endif
                            </div>

                            <p class="text-gray-700 font-semibold mb-2">{{ $data['peminatan']->nama }}</p>

                            <div class="bg-gray-100 rounded-lg p-3 mb-3">
                                <p class="text-sm text-gray-600">Skor SAW</p>
                                <p class="text-2xl font-bold text-indigo-600">{{ number_format($data['skor'], 4) }}</p>
                            </div>

                            <!-- Quota Info -->
                            <div class="bg-blue-50 rounded-lg p-3 text-xs">
                                <p class="text-gray-700 mb-1"><strong>Kuota:</strong></p>
                                <p class="text-gray-600">Maksimal: {{ $data['kuota_maksimal'] }} siswa</p>
                                <p class="text-gray-600">Sisa Kursi: <strong class="@if($data['sisa_kursi'] > 0) text-green-600 @else text-red-600 @endif">{{ $data['sisa_kursi'] }}</strong></p>
                                <p class="text-gray-600 mt-1">Status Kursi: 
                                    @if($data['sisa_kursi'] > 0)
                                        <span class="text-green-600 font-bold">✓ Tersedia</span>
                                    @else
                                        <span class="text-red-600 font-bold">✗ Penuh</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Logika Preferensi -->
            <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-6">
                <h4 class="text-lg font-bold text-indigo-900 mb-3">🎯 Logika Preferensi Peminatan</h4>
                <div class="text-indigo-800 space-y-2 text-sm">
                    <p class="flex items-start">
                        <span class="text-lg mr-2">1️⃣</span>
                        <span><strong>Pilihan Pertama:</strong> Sistem akan mencoba alokasikan ke pilihan 1 jika ada kursi tersedia</span>
                    </p>
                    <p class="flex items-start">
                        <span class="text-lg mr-2">2️⃣</span>
                        <span><strong>Pilihan Kedua:</strong> Jika pilihan 1 penuh, sistem akan mencoba alokasikan ke pilihan 2</span>
                    </p>
                    <p class="flex items-start">
                        <span class="text-lg mr-2">3️⃣</span>
                        <span><strong>Pilihan Ketiga:</strong> Jika pilihan 2 juga penuh, sistem akan mencoba alokasikan ke pilihan 3</span>
                    </p>
                    <p class="flex items-start">
                        <span class="text-lg mr-2">⏳</span>
                        <span><strong>Waitlist:</strong> Jika semua pilihan penuh, siswa akan masuk ke daftar tunggu (waitlist)</span>
                    </p>
                </div>
            </div>

            <!-- Rincian Perhitungan SAW per Pilihan dengan Accordion -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Rincian Perhitungan SAW (Semua Pilihan)</h3>

                <div class="space-y-4">
                    @foreach($pilihanScores as $noPilihan => $data)
                        <div class="border-2 rounded-lg overflow-hidden @if($alokasi->peminatan_id === $data['peminatan']->id) border-green-400 @else border-gray-300 @endif">
                            <!-- Accordion Header -->
                            <button type="button" class="accordion-button w-full px-6 py-4 flex items-center justify-between @if($alokasi->peminatan_id === $data['peminatan']->id) bg-green-50 @else hover:bg-gray-50 @endif transition" data-accordion="accordion-{{ $noPilihan }}">
                                <div class="flex items-center gap-4 text-left flex-1">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">
                                            Pilihan {{ $noPilihan }}: {{ $data['peminatan']->nama }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-2 flex-wrap">
                                            <span class="text-sm text-gray-600">Skor: <span class="font-bold text-gray-900">{{ number_format($data['skor'], 4) }}</span></span>
                                            <span class="text-sm text-gray-600">Peringkat: <span class="font-bold @if($alokasi->peminatan_id === $data['peminatan']->id) text-green-600 @else text-gray-900 @endif">{{ $data['ranking'] }}/{{ $data['total_siswa'] }}</span></span>
                                            @if($alokasi->peminatan_id === $data['peminatan']->id)
                                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">✓ TERPILIH</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <svg class="accordion-icon w-5 h-5 text-gray-500 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transform: {{ $noPilihan === 1 ? 'rotate(180deg)' : 'rotate(0deg)' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>

                            <!-- Accordion Content -->
                            <div class="accordion-content @if($alokasi->peminatan_id === $data['peminatan']->id) border-t-2 border-green-400 @endif {{ $noPilihan !== 1 ? 'hidden' : '' }}" id="accordion-{{ $noPilihan }}">
                                <div class="px-6 py-6 @if($alokasi->peminatan_id === $data['peminatan']->id) bg-green-50 @endif">
                                    <!-- Tabel Rincian -->
                                    <div class="overflow-x-auto mb-6">
                                        <table class="w-full text-sm border border-gray-200">
                                            <thead class="bg-indigo-100 border-b-2 border-indigo-300">
                                                <tr>
                                                    <th class="text-left px-4 py-3 font-bold">Mata Pelajaran</th>
                                                    <th class="text-center px-4 py-3 font-bold">Nilai Siswa</th>
                                                    <th class="text-center px-4 py-3 font-bold">Nilai Maksimum</th>
                                                    <th class="text-center px-4 py-3 font-bold">Bobot</th>
                                                    <th class="text-center px-4 py-3 font-bold">Normalisasi</th>
                                                    <th class="text-center px-4 py-3 font-bold">Kontribusi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($data['detail'] as $d)
                                                    <tr>
                                                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $d['mapel'] }}</td>
                                                        <td class="text-center px-4 py-3">{{ number_format($d['nilai'], 2) }}</td>
                                                        <td class="text-center px-4 py-3">{{ number_format($d['max_nilai'], 2) }}</td>
                                                        <td class="text-center px-4 py-3 font-bold">{{ number_format($d['bobot'], 4) }}</td>
                                                        <td class="text-center px-4 py-3">
                                                            <span class="text-xs text-gray-600">{{ number_format($d['nilai'], 2) }} / {{ number_format($d['max_nilai'], 2) }} =</span>
                                                            <br>
                                                            <strong>{{ number_format($d['normalisasi'], 4) }}</strong>
                                                        </td>
                                                        <td class="text-center px-4 py-3 font-bold text-indigo-600">{{ number_format($d['skor'], 4) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-indigo-50 border-t-2 border-indigo-300">
                                                <tr>
                                                    <td colspan="5" class="text-right px-4 py-3 font-bold text-gray-900">Total Skor SAW:</td>
                                                    <td class="text-center px-4 py-3 font-bold text-lg text-indigo-600">{{ number_format($data['skor'], 4) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Rumus -->
                                    <div class="p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                                        <p class="text-sm font-semibold text-gray-900 mb-2">📐 Rumus Perhitungan SAW:</p>
                                        <p class="text-sm text-gray-700 mb-1"><strong>Skor_SAW = Σ (Bobot_j × Normalisasi_ij)</strong></p>
                                        <p class="text-sm text-gray-700"><strong>Dimana: Normalisasi = Nilai_Siswa / Nilai_Maksimum_Mapel</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Script untuk Accordion -->
            <script>
                document.querySelectorAll('.accordion-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const accordionId = this.getAttribute('data-accordion');
                        const content = document.getElementById(accordionId);
                        const icon = this.querySelector('.accordion-icon');
                        
                        // Toggle
                        content.classList.toggle('hidden');
                        icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                    });
                });
            </script>

            <!-- Penjelasan Mengapa Terpilih -->
            <div class="@if($alokasiInfo['status'] === 'diterima') bg-green-50 border-green-500 @elseif($alokasiInfo['status'] === 'waitlist') bg-yellow-50 border-yellow-500 @else bg-red-50 border-red-500 @endif border-l-4 rounded-lg p-6">
                <h4 class="@if($alokasiInfo['status'] === 'diterima') text-green-900 @elseif($alokasiInfo['status'] === 'waitlist') text-yellow-900 @else text-red-900 @endif text-lg font-bold mb-3">
                    @if($alokasiInfo['status'] === 'diterima')
                        ✅ Hasil Alokasi - DITERIMA
                    @elseif($alokasiInfo['status'] === 'waitlist')
                        ⏳ Hasil Alokasi - WAITLIST
                    @else
                        ❌ Hasil Alokasi - DITOLAK
                    @endif
                </h4>
                
                <p class="@if($alokasiInfo['status'] === 'diterima') text-green-800 @elseif($alokasiInfo['status'] === 'waitlist') text-yellow-800 @else text-red-800 @endif mb-2">
                    {{ $alokasiInfo['alasan'] }}
                </p>

                @if($alokasiInfo['status'] === 'diterima')
                    <p class="text-green-800 mt-2">
                        <strong>Siswa dialokasikan ke:</strong> {{ $alokasiInfo['peminatan_id'] ? \App\Models\Peminatan::find($alokasiInfo['peminatan_id'])->nama : '-' }}
                    </p>
                    <p class="text-green-800 mt-1">
                        <strong>Skor SAW:</strong> {{ number_format($alokasiInfo['skor_saw'], 4) }}
                    </p>
                @elseif($alokasiInfo['status'] === 'waitlist')
                    <p class="text-yellow-800 mt-2">
                        <strong>Statusnya ditunggu kursi di:</strong> {{ $alokasiInfo['peminatan_id'] ? \App\Models\Peminatan::find($alokasiInfo['peminatan_id'])->nama : '-' }}
                    </p>
                    <p class="text-yellow-800 mt-1">
                        <strong>Skor tertinggi dari pilihan:</strong> {{ number_format($alokasiInfo['skor_saw'], 4) }}
                    </p>
                @endif
            </div>

            <!-- Action Button -->
            <div class="flex gap-3 justify-end">
                <a href="{{ route('admin.siswa.skor-saw') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>