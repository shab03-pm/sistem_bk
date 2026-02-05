<x-guest-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <div
        class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex flex-col items-center py-12 px-4 relative">
        <!-- Background decoration -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10 -z-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10 -z-10">
        </div>

        <!-- Main Container -->
        <div class="w-full flex flex-col items-center">
            <div class="w-full max-w-2xl mx-auto">
                <!-- Branding -->
                <div class="text-center mb-10">
                    <!-- Logo -->
                    <div class="mb-4 flex justify-center">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full p-3 shadow-xl">
                            <svg class="w-14 h-14" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Outer circle background -->
                                <circle cx="50" cy="50" r="48" fill="white" opacity="0.15" stroke="white"
                                    stroke-width="2" />

                                <!-- Main shape - stylized book/growth -->
                                <g transform="translate(50, 50)">
                                    <!-- Left curve -->
                                    <path d="M -15 -10 Q -20 0 -15 10 L 0 15 L 0 -15 Z" fill="white" opacity="0.95" />
                                    <!-- Right curve -->
                                    <path d="M 15 -10 Q 20 0 15 10 L 0 15 L 0 -15 Z" fill="white" opacity="0.75" />
                                    <!-- Center arrow up -->
                                    <path d="M 0 -8 L -4 4 L -1 4 L -1 8 L 1 8 L 1 4 L 4 4 Z" fill="white" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-4xl font-black text-indigo-900 mb-2 tracking-tight">Sistem BK</h1>
                    <p class="text-base text-indigo-700 font-semibold">Platform Bimbingan Karir Digital</p>
                </div>

                <!-- Register Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 sm:p-12 border border-gray-100">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akun Baru 📝</h2>
                        <p class="text-sm text-gray-600">Buat akun siswa untuk mulai bimbingan karir</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                type="text" name="name" :value="old('name')" required autofocus
                                placeholder="Masukkan nama lengkap" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- NIS -->
                        <div class="mt-4">
                            <x-input-label for="nis" :value="__('NIS (Nomor Induk Siswa)')" />
                            <x-text-input id="nis"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                type="text" name="nis" :value="old('nis')" required placeholder="Masukkan NIS Anda" />
                            <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                        </div>

                        <!-- Kelas Asal -->
                        <div class="mt-4">
                            <x-input-label for="kelas_asal" :value="__('Kelas Asal')" />
                            <select id="kelas_asal" name="kelas_asal"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="X MERDEKA 1" {{ old('kelas_asal') == 'X MERDEKA 1' ? 'selected' : '' }}>X
                                    MERDEKA 1</option>
                                <option value="X MERDEKA 2" {{ old('kelas_asal') == 'X MERDEKA 2' ? 'selected' : '' }}>X
                                    MERDEKA 2</option>
                                <option value="X MERDEKA 3" {{ old('kelas_asal') == 'X MERDEKA 3' ? 'selected' : '' }}>X
                                    MERDEKA 3</option>
                                <option value="X MERDEKA 4" {{ old('kelas_asal') == 'X MERDEKA 4' ? 'selected' : '' }}>X
                                    MERDEKA 4</option>
                                <option value="X MERDEKA 5" {{ old('kelas_asal') == 'X MERDEKA 5' ? 'selected' : '' }}>X
                                    MERDEKA 5</option>
                                <option value="X MERDEKA 6" {{ old('kelas_asal') == 'X MERDEKA 6' ? 'selected' : '' }}>X
                                    MERDEKA 6</option>
                                <option value="X MERDEKA 7" {{ old('kelas_asal') == 'X MERDEKA 7' ? 'selected' : '' }}>X
                                    MERDEKA 7</option>
                                <option value="X MERDEKA 8" {{ old('kelas_asal') == 'X MERDEKA 8' ? 'selected' : '' }}>X
                                    MERDEKA 8</option>
                                <option value="X MERDEKA 9" {{ old('kelas_asal') == 'X MERDEKA 9' ? 'selected' : '' }}>X
                                    MERDEKA 9</option>
                                <option value="X MERDEKA 10" {{ old('kelas_asal') == 'X MERDEKA 10' ? 'selected' : '' }}>X
                                    MERDEKA 10</option>
                            </select>
                            <x-input-error :messages="$errors->get('kelas_asal')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                type="email" name="email" :value="old('email')" required placeholder="Masukkan email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Masukkan password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                type="password" name="password_confirmation" required
                                placeholder="Konfirmasi password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- File Raport -->
                        <div class="mt-6 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">File Raport</h3>
                            <x-input-label for="file_raport" :value="__('Upload File Raport (PDF, JPG, PNG)*')" />
                            <input type="file" id="file_raport" name="file_raport" accept=".pdf,.jpg,.jpeg,.png"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md"
                                required />
                            <p class="text-xs text-gray-500 mt-2">Maksimal 5MB</p>
                            <x-input-error :messages="$errors->get('file_raport')" class="mt-2" />
                        </div>

                        <!-- Input Nilai Mata Pelajaran -->
                        <div class="mt-6 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Input Nilai Mata Pelajaran</h3>
                            <p class="text-sm text-gray-600 mb-4">Masukkan nilai rapor (0-100)</p>

                            <div class="grid grid-cols-1 gap-4">
                                <!-- Matematika -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Matematika*</label>
                                    <input type="number" name="nilai_matematika" min="0" max="100"
                                        value="{{ old('nilai_matematika') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_matematika')" class="mt-1" />
                                </div>

                                <!-- Fisika -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fisika*</label>
                                    <input type="number" name="nilai_fisika" min="0" max="100"
                                        value="{{ old('nilai_fisika') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_fisika')" class="mt-1" />
                                </div>

                                <!-- Kimia -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kimia*</label>
                                    <input type="number" name="nilai_kimia" min="0" max="100"
                                        value="{{ old('nilai_kimia') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_kimia')" class="mt-1" />
                                </div>

                                <!-- Biologi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Biologi*</label>
                                    <input type="number" name="nilai_biologi" min="0" max="100"
                                        value="{{ old('nilai_biologi') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_biologi')" class="mt-1" />
                                </div>

                                <!-- TIK -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">TIK*</label>
                                    <input type="number" name="nilai_tik" min="0" max="100"
                                        value="{{ old('nilai_tik') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_tik')" class="mt-1" />
                                </div>

                                <!-- Bahasa Inggris -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa Inggris*</label>
                                    <input type="number" name="nilai_binggris" min="0" max="100"
                                        value="{{ old('nilai_binggris') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_binggris')" class="mt-1" />
                                </div>

                                <!-- Sosiologi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sosiologi*</label>
                                    <input type="number" name="nilai_sosiologi" min="0" max="100"
                                        value="{{ old('nilai_sosiologi') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_sosiologi')" class="mt-1" />
                                </div>

                                <!-- Ekonomi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ekonomi*</label>
                                    <input type="number" name="nilai_ekonomi" min="0" max="100"
                                        value="{{ old('nilai_ekonomi') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_ekonomi')" class="mt-1" />
                                </div>

                                <!-- Geografi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Geografi*</label>
                                    <input type="number" name="nilai_geografi" min="0" max="100"
                                        value="{{ old('nilai_geografi') }}"
                                        class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 border"
                                        required placeholder="0-100" />
                                    <x-input-error :messages="$errors->get('nilai_geografi')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex items-center justify-between gap-4">
                            <a href="{{ route('login') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                {{ __('Sudah punya akun? Masuk') }}
                            </a>

                            <x-primary-button
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium px-6">
                                {{ __('Daftar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Footer Links -->
                <div class="mt-8 text-center mb-8">
                    <p class="text-sm text-gray-600">
                        © 2026 Sistem Bimbingan Karir. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>