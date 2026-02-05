<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Ubah Password</h2>
                <p class="text-gray-600 mt-1">Perbarui password akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form method="POST" action="#" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan password saat ini" required />
                                <p class="text-xs text-gray-500 mt-1">Masukkan password Anda saat ini untuk verifikasi
                                </p>
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan password baru" required />
                                <p class="text-xs text-gray-500 mt-1">Password minimal 8 karakter, kombinasi huruf
                                    besar, huruf kecil, dan angka</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
                                    Baru</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Konfirmasi password baru" required />
                            </div>

                            <!-- Password Requirements -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm font-semibold text-blue-900 mb-2">Persyaratan Password:</p>
                                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                                    <li>Minimal 8 karakter</li>
                                    <li>Mengandung huruf besar (A-Z)</li>
                                    <li>Mengandung huruf kecil (a-z)</li>
                                    <li>Mengandung angka (0-9)</li>
                                    <li>Mengandung simbol khusus (!@#$%^&*)</li>
                                </ul>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-4 pt-4 border-t">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition">
                                    Simpan Password Baru
                                </button>
                                <button type="button"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Note -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h4 class="text-sm font-semibold text-yellow-900 mb-2">⚠️ Tips Keamanan:</h4>
                    <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                        <li>Gunakan password yang kuat dan sulit ditebak</li>
                        <li>Jangan bagikan password Anda kepada siapa pun</li>
                        <li>Ubah password secara berkala untuk keamanan lebih baik</li>
                        <li>Gunakan password yang berbeda dari akun lain</li>
                        <li>Pastikan Anda tidak membagikan password melalui email atau SMS</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>