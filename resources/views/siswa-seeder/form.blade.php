<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">🌱 Generator Siswa Seeder</h2>
                <p class="text-gray-600 mt-1">Buat data siswa untuk testing/demo</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <!-- Konfigurasi -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                        <h3 class="text-lg font-bold text-blue-900 mb-4">⚙️ Konfigurasi</h3>

                        <form id="seederForm" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jumlah Kelas
                                </label>
                                <input type="number" name="jumlah_kelas" value="11" min="1" max="20"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-600 mt-1">Kelas: X MERDEKA 1 s.d. X MERDEKA N</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Siswa Per Kelas
                                </label>
                                <input type="number" name="siswa_per_kelas" value="36" min="1" max="50"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-600 mt-1">Total Siswa = Jumlah Kelas × Siswa Per Kelas</p>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 p-3 rounded">
                                <p class="text-sm font-semibold text-yellow-900">
                                    📊 Total Siswa yang akan dibuat:
                                    <span id="totalSiswa" class="text-yellow-600 font-bold">396</span>
                                </p>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="delete_existing" id="deleteExisting"
                                    class="h-4 w-4 border-gray-300 rounded text-red-600 focus:ring-red-500 cursor-pointer">
                                <label for="deleteExisting" class="ml-3 text-sm text-gray-700 cursor-pointer">
                                    <span class="font-semibold">Hapus siswa yang sudah ada</span>
                                    <p class="text-xs text-gray-600">⚠️ Akan menghapus semua data siswa sebelumnya</p>
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition">
                                🚀 Generate Siswa
                            </button>
                        </form>
                    </div>

                    <!-- Informasi -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded">
                        <h3 class="text-lg font-bold text-green-900 mb-4">ℹ️ Informasi Generasi</h3>

                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="font-semibold text-gray-700">📚 Kelas yang dibuat:</p>
                                <p class="text-gray-600">X MERDEKA 1 s.d. X MERDEKA 11</p>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-700">🧑 Data Siswa:</p>
                                <ul class="text-gray-600 space-y-1 ml-4 mt-1">
                                    <li>✓ NIS: 10001 - 10396</li>
                                    <li>✓ Nama: Siswa [NIS]</li>
                                    <li>✓ Email: siswa[NIS]@sekolah.local</li>
                                    <li>✓ Password: password123</li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-700">📊 Nilai Mata Pelajaran:</p>
                                <p class="text-gray-600">Random 70-100 untuk:</p>
                                <ul class="text-gray-600 space-y-1 ml-4 mt-1">
                                    <li>• Matematika, Fisika, Kimia</li>
                                    <li>• Biologi, TIK, B. Inggris</li>
                                    <li>• Sosiologi, Ekonomi, Geografi</li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-700">🎯 Pilihan Peminatan:</p>
                                <p class="text-gray-600">Acak dari 7 paket peminatan</p>
                                <p class="text-xs text-gray-500 mt-1">Bisa pilihan yang sama untuk P1, P2, P3</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading & Result -->
                <div id="resultContainer" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-6 mt-6">
                    <div id="loadingSpinner" class="hidden text-center">
                        <div
                            class="animate-spin h-8 w-8 border-4 border-blue-500 border-t-transparent rounded-full mx-auto mb-3">
                        </div>
                        <p class="text-gray-700">Sedang membuat siswa...</p>
                    </div>

                    <div id="successResult" class="hidden">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-4">
                            <p class="text-sm font-semibold text-green-900">✅ Berhasil!</p>
                            <p id="successMessage" class="text-sm text-green-800 mt-1"></p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded p-4">
                            <p class="text-sm font-semibold text-blue-900">📈 Statistik:</p>
                            <ul class="text-sm text-blue-800 space-y-1 mt-2 ml-4">
                                <li>✓ Siswa Dibuat: <span id="createdCount" class="font-bold">0</span></li>
                                <li>✓ Total Target: <span id="totalCount" class="font-bold">0</span></li>
                            </ul>
                        </div>

                        <div id="errorsContainer" class="hidden mt-4 bg-red-50 border border-red-200 rounded p-4">
                            <p class="text-sm font-semibold text-red-900">⚠️ Errors:</p>
                            <ul id="errorsList" class="text-sm text-red-800 space-y-1 mt-2 ml-4"></ul>
                        </div>
                    </div>

                    <div id="errorResult" class="hidden">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <p class="text-sm font-semibold text-red-900">❌ Error!</p>
                            <p id="errorMessage" class="text-sm text-red-800 mt-1"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('admin.siswa.profil') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition inline-block">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <script>
        // Update total siswa saat input berubah
        document.querySelectorAll('input[name="jumlah_kelas"], input[name="siswa_per_kelas"]').forEach(input => {
            input.addEventListener('change', updateTotal);
            input.addEventListener('input', updateTotal);
        });

        function updateTotal() {
            const jumlahKelas = parseInt(document.querySelector('input[name="jumlah_kelas"]').value) || 0;
            const siswaPerKelas = parseInt(document.querySelector('input[name="siswa_per_kelas"]').value) || 0;
            const total = jumlahKelas * siswaPerKelas;
            document.getElementById('totalSiswa').textContent = total.toLocaleString();
        }

        // Submit form
        document.getElementById('seederForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(document.getElementById('seederForm'));
            const resultContainer = document.getElementById('resultContainer');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const successResult = document.getElementById('successResult');
            const errorResult = document.getElementById('errorResult');

            // Show loading
            resultContainer.classList.remove('hidden');
            loadingSpinner.classList.remove('hidden');
            successResult.classList.add('hidden');
            errorResult.classList.add('hidden');

            try {
                const response = await fetch("{{ route('siswa-seeder.generate') }}", {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();
                loadingSpinner.classList.add('hidden');

                if (data.success) {
                    document.getElementById('successMessage').textContent = data.message;
                    document.getElementById('createdCount').textContent = data.created;
                    document.getElementById('totalCount').textContent = data.total;

                    if (data.errors && data.errors.length > 0) {
                        const errorsList = document.getElementById('errorsList');
                        errorsList.innerHTML = data.errors.map(e => `<li>${e}</li>`).join('');
                        document.getElementById('errorsContainer').classList.remove('hidden');
                    }

                    successResult.classList.remove('hidden');
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                    errorResult.classList.remove('hidden');
                }
            } catch (error) {
                loadingSpinner.classList.add('hidden');
                document.getElementById('errorMessage').textContent = error.message;
                errorResult.classList.remove('hidden');
            }
        });

        // Initial update
        updateTotal();
    </script>
</x-app-layout>