<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">👤 Detail Siswa</h2>
                <p class="text-gray-600 mt-1">Informasi lengkap profil siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-lg mb-6">
                    <p class="text-sm opacity-90">NIS: {{ $siswa->nis }}</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $siswa->nama }}</h3>
                    <p class="text-sm opacity-90 mt-1">{{ $siswa->kelas_asal }}</p>
                </div>

                <!-- Data Section -->
                <div class="space-y-6">
                    <!-- NIS -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📌 NIS</label>
                        <p class="text-lg text-gray-900">{{ $siswa->nis }}</p>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">👤 Nama Lengkap</label>
                        <p class="text-lg text-gray-900">{{ $siswa->nama }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">✉️ Email</label>
                        <p class="text-lg text-gray-900">{{ $siswa->email }}</p>
                    </div>

                    <!-- Kelas Asal -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🏫 Kelas Asal</label>
                        <p class="text-lg text-gray-900">{{ $siswa->kelas_asal ?? '-' }}</p>
                    </div>

                    <!-- Tanggal Daftar -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Tanggal Daftar</label>
                        <p class="text-lg text-gray-900">{{ $siswa->created_at->format('d F Y H:i') }}</p>
                    </div>

                    <!-- Phone (if available) -->
                    @if($siswa->phone)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📱 No. Telepon</label>
                            <p class="text-lg text-gray-900">{{ $siswa->phone }}</p>
                        </div>
                    @endif

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ℹ️ Status</label>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ✏️ Edit Data
                    </a>
                    <form method="POST" action="{{ route('admin.siswa.delete', $siswa->id) }}" class="flex-1"
                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            🗑️ Hapus Siswa
                        </button>
                    </form>
                    <a href="{{ route('admin.siswa.profil') }}"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>