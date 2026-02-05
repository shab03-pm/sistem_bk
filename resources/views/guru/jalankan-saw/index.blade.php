<x-app-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Jalankan Proses SAW</h2>
                <p class="text-gray-600 mt-1">Proses seleksi peminatan menggunakan metode SAW</p>
            </div>
        </div>
    </x-slot>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <h4 class="text-sm font-semibold text-red-800 mb-2">Terjadi Kesalahan:</h4>
            <ul class="text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-600 font-semibold">✓ {{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <p class="text-sm text-red-600 font-semibold">⚠ {{ session('error') }}</p>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Siswa Siap Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Siswa Siap</p>
                                <p class="text-4xl font-bold mt-2">{{ $siswaLengkap }}</p>
                                <p class="text-blue-100 text-xs mt-2">Siswa siap diproses</p>
                            </div>
                            <div class="text-5xl opacity-20">👥</div>
                        </div>
                    </div>
                </div>

                <!-- Total Peminatan Card -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total Peminatan</p>
                                <p class="text-4xl font-bold mt-2">{{ $totalPeminatan }}</p>
                                <p class="text-purple-100 text-xs mt-2">Paket peminatan tersedia</p>
                            </div>
                            <div class="text-5xl opacity-20">📦</div>
                        </div>
                    </div>
                </div>

                <!-- Peminatan Lengkap Card -->
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Peminatan Lengkap</p>
                                <p class="text-4xl font-bold mt-2">{{ $peminatanLengkap }}</p>
                                <p class="text-green-100 text-xs mt-2">Memiliki kriteria penilaian</p>
                            </div>
                            <div class="text-5xl opacity-20">✅</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status dan Form -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-3 h-3 rounded-full bg-{{ $status == 'Siap' ? 'green' : 'yellow' }}-500"></div>
                        <span class="text-lg font-semibold text-gray-900">Status: <span
                                class="text-{{ $status == 'Siap' ? 'green' : 'yellow' }}-600">{{ $status }}</span></span>
                    </div>

                    @if($status == 'Siap')
                        <div class="bg-yellow-50 border-l-4 border-yellow-600 p-6 rounded-lg mb-8">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-yellow-800 mb-2">⚠️ Peringatan Penting</h4>
                                    <ul class="text-sm text-yellow-700 space-y-1">
                                        <li>• Proses ini akan menghapus hasil alokasi sebelumnya</li>
                                        <li>• Sistem akan memproses {{ $siswaLengkap }} siswa secara otomatis</li>
                                        <li>• Hasil tidak dapat diubah setelah proses selesai</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('guru.jalankan-saw.proses') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Jalankan SAW Sekarang
                            </button>
                        </form>
                    @else
                        <div class="bg-red-50 border-l-4 border-red-600 p-6 rounded-lg">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-red-800 mb-2">Sistem Belum Siap</h4>
                                    <ul class="text-sm text-red-700 space-y-1">
                                        @if($siswaLengkap == 0)
                                            <li>• Belum ada siswa yang memenuhi syarat</li>
                                        @endif
                                        @if($peminatanLengkap < $totalPeminatan)
                                            <li>• Belum semua peminatan memiliki kriteria</li>
                                        @endif
                                        @if($totalPeminatan == 0)
                                            <li>• Belum ada paket peminatan yang dibuat</li>
                                        @endif
                                    </ul>
                                    <p class="mt-3 text-red-600 text-sm">Silakan lengkapi data terlebih dahulu sebelum
                                        menjalankan SAW.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>