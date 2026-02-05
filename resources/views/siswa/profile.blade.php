<x-app-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Profil Saya</h2>
                <p class="text-gray-600 mt-1">Kelola informasi profil siswa Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">✓ {{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Alert -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-red-800">⚠ Terjadi kesalahan:</p>
                    </div>
                </div>
            @endif

            <!-- Form Edit Profil -->
            <form method="POST" action="{{ route('siswa.profile.update') }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @csrf
                @method('PUT')
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name"
                                value="{{ old('name', $siswa?->nama ?? auth()->user()->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                            <input type="text" name="nis"
                                value="{{ old('nis', $siswa?->nis ?? auth()->user()->nis ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nis') border-red-500 @enderror" />
                            @error('nis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email"
                                value="{{ old('email', $siswa?->email ?? auth()->user()->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas Asal *</label>
                            <input type="text" name="kelas_asal"
                                value="{{ old('kelas_asal', $siswa?->kelas_asal ?? auth()->user()->kelas_asal ?? '') }}"
                                placeholder="Contoh: X MERDEKA 2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas_asal') border-red-500 @enderror"
                                required />
                            @error('kelas_asal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password (Biarkan kosong jika
                                tidak ingin mengubah)</label>
                            <input type="password" name="password"
                                placeholder="Masukkan password baru (min. 8 karakter)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror" />
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mendaftar</label>
                            <input type="text" value="{{ auth()->user()->created_at->format('d F Y') }}" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                            <input type="text" value="Aktif" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900" />
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t mt-6">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('siswa.dashboard') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition text-center">
                            Batal
                        </a>
                    </div>
                </div>
            </form>

            <!-- Informasi Kontak -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">ℹ️ Informasi Penting:</h4>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Pastikan semua data pribadi Anda sudah benar dan lengkap</li>
                    <li>Kelas asal wajib diisi untuk keperluan administrasi</li>
                    <li>Anda dapat memperbarui profil kapan saja sesuai kebutuhan</li>
                    <li>Jangan lupa menyimpan perubahan dengan mengklik tombol "Simpan Perubahan"</li>
                    <li>Nilai raport Anda ditampilkan untuk referensi dan tidak dapat diubah</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>