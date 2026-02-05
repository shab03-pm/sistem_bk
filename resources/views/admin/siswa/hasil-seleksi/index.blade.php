<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">✅ Hasil Seleksi</h2>
                <p class="text-gray-600 mt-1">Monitoring hasil alokasi peminatan siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert untuk Waitlist -->
            @if($stats['waitinglist'] > 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 flex justify-between items-center">
                    <div>
                        <p class="text-yellow-700 font-semibold">⏳ Ada {{ $stats['waitinglist'] }} siswa di Waitlist</p>
                        <p class="text-yellow-600 text-sm mt-1">Klik tombol di bawah untuk allocate semuanya ke PAKET 6</p>
                    </div>
                    <form action="{{ route('admin.siswa.allocate-all-waitlist') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold transition"
                            onclick="return confirm('Allocate semua {{ $stats['waitinglist'] }} siswa waitlist ke PAKET 6?')">
                            ✅ Allocate Semua ke PAKET 6
                        </button>
                    </form>
                </div>
            @endif

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                    <p class="text-green-600 text-sm font-semibold uppercase">Total Alokasi</p>
                    <p class="text-4xl font-bold text-green-900 mt-2">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 border border-yellow-200">
                    <p class="text-yellow-600 text-sm font-semibold uppercase">Waitinglist</p>
                    <p class="text-4xl font-bold text-yellow-900 mt-2">{{ $stats['waitinglist'] }}</p>
                </div>

                @foreach($stats['distribusi'] as $peminatan)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                        <p class="text-blue-600 text-sm font-semibold uppercase">{{ $peminatan->nama }}</p>
                        <p class="text-4xl font-bold text-blue-900 mt-2">{{ $peminatan->alokasis_count }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.siswa.hasil-seleksi') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Hasil Alokasi -->
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                @if($isWaitlist && $result->total() > 0)
                    <form action="{{ route('admin.siswa.simpan-alokasi-manual') }}" method="POST" id="formWaitlist">
                        @csrf
                @endif

                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-green-600 to-green-700 text-white sticky top-0">
                            <tr>
                                @if($isWaitlist && $result->total() > 0)
                                    <th class="px-4 py-3 text-center">
                                        <input type="checkbox" id="masterCheckbox" class="w-5 h-5 cursor-pointer">
                                    </th>
                                @endif
                                <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">NIS</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Kelas Asal</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 1</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 2</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Pilihan 3</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Peminatan Dialokasikan</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Skor SAW</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($result as $index => $alokasi)
                                <tr class="hover:bg-gray-50 transition">
                                    @if($isWaitlist && $result->total() > 0)
                                        <td class="px-4 py-3 text-center">
                                            <input type="checkbox" name="siswa_ids[]" value="{{ $alokasi->siswa_id }}"
                                                class="siswa-checkbox w-5 h-5 cursor-pointer">
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ ($result->currentPage() - 1) * 15 + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $alokasi->siswa->nis }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $alokasi->siswa->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $alokasi->siswa->kelas_asal }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($alokasi->siswa->pilihanPeminatan1)
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">{{ $alokasi->siswa->pilihanPeminatan1->nama }}</span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($alokasi->siswa->pilihanPeminatan2)
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">{{ $alokasi->siswa->pilihanPeminatan2->nama }}</span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($alokasi->siswa->pilihanPeminatan3)
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">{{ $alokasi->siswa->pilihanPeminatan3->nama }}</span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold">
                                        @if($alokasi->status === 'diterima' && $alokasi->peminatan)
                                            <span class="text-indigo-600">{{ $alokasi->peminatan->nama }}</span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-bold">
                                        @if($alokasi->skor_saw)
                                            <span class="text-blue-600">{{ round($alokasi->skor_saw, 4) }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($alokasi->status === 'diterima')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">✓
                                                Diterima</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">⏳
                                                Waitlist</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        @if($alokasi->status === 'diterima' && $alokasi->id)
                                            <a href="{{ route('admin.siswa.hasil-seleksi.show', $alokasi->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition inline-block">
                                                👁️ Detail
                                            </a>
                                        @else
                                            <a href="{{ route('admin.siswa.hasil-seleksi.edit-alokasi', $alokasi->siswa_id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-semibold transition inline-block">
                                                ✏️ Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isWaitlist ? 12 : 11 }}" class="px-6 py-8 text-center text-gray-500">
                                        <p class="text-lg">📭 Belum ada hasil alokasi</p>
                                        <p class="text-sm mt-2">Jalankan proses SAW terlebih dahulu</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($isWaitlist && $result->total() > 0)
                        </form>
                    @endif
            </div>

            <!-- Tombol Aksi untuk Waitlist -->
            @if($isWaitlist && $result->total() > 0)
                <div class="mt-4 flex gap-3">
                    <button type="button" id="selectAll"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold">
                        ✓ Pilih Semua
                    </button>
                    <button type="button" id="clearAll"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-semibold">
                        ✕ Hapus Pilihan
                    </button>
                    <span id="countSelected" class="ml-4 text-gray-700 font-semibold">0 siswa dipilih</span>
                    <button type="submit" form="formWaitlist"
                        class="ml-auto bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold transition">
                        💾 Simpan Alokasi ke PAKET 6
                    </button>
                </div>
            @endif

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-md p-4">
                {{ $result->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($isWaitlist && $result->total() > 0)
            const masterCheckbox = document.getElementById('masterCheckbox');
            const checkboxes = document.querySelectorAll('.siswa-checkbox');
            const countSelected = document.getElementById('countSelected');
            const selectAllBtn = document.getElementById('selectAll');
            const clearAllBtn = document.getElementById('clearAll');

            function updateCount() {
                const selected = document.querySelectorAll('.siswa-checkbox:checked').length;
                countSelected.textContent = selected + ' siswa dipilih';
                if (masterCheckbox) {
                    masterCheckbox.checked = selected === checkboxes.length && checkboxes.length > 0;
                }
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCount);
            });

            if (masterCheckbox) {
                masterCheckbox.addEventListener('change', function () {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateCount();
                });
            }

            selectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                if (masterCheckbox) masterCheckbox.checked = true;
                updateCount();
            });

            clearAllBtn.addEventListener('click', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                if (masterCheckbox) masterCheckbox.checked = false;
                updateCount();
            });
        @endif
});
</script>