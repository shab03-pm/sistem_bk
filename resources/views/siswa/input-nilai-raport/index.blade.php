<x-app-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Input Nilai Raport</h2>
                <p class="text-gray-600 mt-1">Masukkan nilai raport Anda untuk proses seleksi</p>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ambil data dari tabel siswas -->
            @php
                $siswa = \App\Models\Siswa::where('nis', auth()->user()->nis)->first();
                $nilaiFields = ['nilai_matematika', 'nilai_fisika', 'nilai_kimia', 'nilai_biologi', 'nilai_tik', 'nilai_binggris', 'nilai_sosiologi', 'nilai_ekonomi', 'nilai_geografi'];
                $filledCount = 0;
                $totalNilai = 0;

                foreach ($nilaiFields as $field) {
                    if ($siswa && $siswa->{$field} !== null) {
                        $filledCount++;
                        $totalNilai += $siswa->{$field};
                    }
                }

                $status = $filledCount == 9 ? 'Sudah Diisi' : 'Belum Lengkap';
                $rataRata = $filledCount > 0 ? round($totalNilai / $filledCount, 1) : 0;
                $predikat = $rataRata >= 85 ? 'Sangat Baik' : ($rataRata >= 75 ? 'Baik' : ($rataRata >= 60 ? 'Cukup' : 'Kurang'));

                $predikatColor = $predikat == 'Sangat Baik' ? 'from-green-400 to-green-600' : ($predikat == 'Baik' ? 'from-blue-400 to-blue-600' : ($predikat == 'Cukup' ? 'from-yellow-400 to-yellow-600' : 'from-red-400 to-red-600'));
            @endphp

            <!-- Top Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Status Card -->
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 border-t-4 {{ $filledCount == 9 ? 'border-green-500' : 'border-yellow-500' }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Status Input</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $status }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $filledCount }}/9 mata pelajaran</p>
                            </div>
                            <div class="text-4xl">
                                @if($filledCount == 9)
                                    ✓
                                @else
                                    ⚠
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full"
                                style="width: {{ ($filledCount / 9) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Average Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                    <div class="p-6">
                        <p class="text-blue-100 text-sm font-medium">Rata-rata Nilai</p>
                        <p class="text-5xl font-bold mt-3">{{ $rataRata }}</p>
                        <p class="text-blue-100 text-xs mt-2">Dari {{ $filledCount }} mata pelajaran</p>
                    </div>
                </div>

                <!-- Predicate Card -->
                <div
                    class="bg-gradient-to-br {{ $predikatColor }} rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 text-white">
                    <div class="p-6">
                        <p class="text-white text-opacity-90 text-sm font-medium">Predikat</p>
                        <p class="text-3xl font-bold mt-3">{{ $predikat }}</p>
                        <div
                            class="mt-4 inline-block px-3 py-1 bg-white bg-opacity-25 rounded-full text-xs font-semibold">
                            @if($rataRata >= 85)
                                Excellent ⭐⭐⭐⭐⭐
                            @elseif($rataRata >= 75)
                                Good ⭐⭐⭐⭐
                            @elseif($rataRata >= 60)
                                Fair ⭐⭐⭐
                            @else
                                Needs Improvement ⭐⭐
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <form action="{{ route('siswa.input-nilai-raport.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Upload File Raport Section - DISABLED / READ ONLY -->
                    <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1 1 0 11-2 0 1 1 0 012 0zM15 7a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                <path fill-rule="evenodd"
                                    d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-600">File Raport (View Only)</h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">File raport sudah disimpan dan tidak bisa diubah</p>

                        <div class="flex flex-col gap-3">
                            @if($siswa?->file_raport)
                                <div class="flex items-center gap-4">
                                    <a href="{{ asset('storage/raport/' . $siswa->file_raport) }}" target="_blank"
                                        class="px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition flex items-center gap-2 whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.657 14.243a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM11 17a1 1 0 102 0v-1a1 1 0 10-2 0v1zM5.757 15.657a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707zM5 10a1 1 0 01-1-1V8a1 1 0 012 0v1a1 1 0 01-1 1zM5.757 5.757a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM10 5a1 1 0 01-1-1V3a1 1 0 012 0v1a1 1 0 01-1 1z">
                                            </path>
                                        </svg>
                                        Lihat File
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">Belum ada file raport yang diunggah</p>
                            @endif
                        </div>
                    </div>

                    <!-- Nilai Mata Pelajaran Section -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-13-5h10m-10 4h10m-10 4h10m-10 4h6">
                                </path>
                            </svg>
                            Input Nilai Mata Pelajaran
                        </h3>

                        <!-- Nilai Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $subjects = [
                                    ['name' => 'Matematika', 'field' => 'nilai_matematika', 'icon' => '📐', 'color' => 'blue'],
                                    ['name' => 'Fisika', 'field' => 'nilai_fisika', 'icon' => '⚛️', 'color' => 'green'],
                                    ['name' => 'Kimia', 'field' => 'nilai_kimia', 'icon' => '🧪', 'color' => 'yellow'],
                                    ['name' => 'Biologi', 'field' => 'nilai_biologi', 'icon' => '🔬', 'color' => 'red'],
                                    ['name' => 'TIK', 'field' => 'nilai_tik', 'icon' => '💻', 'color' => 'indigo'],
                                    ['name' => 'Bahasa Inggris', 'field' => 'nilai_binggris', 'icon' => '🌍', 'color' => 'cyan'],
                                    ['name' => 'Sosiologi', 'field' => 'nilai_sosiologi', 'icon' => '👥', 'color' => 'pink'],
                                    ['name' => 'Ekonomi', 'field' => 'nilai_ekonomi', 'icon' => '💰', 'color' => 'green'],
                                    ['name' => 'Geografi', 'field' => 'nilai_geografi', 'icon' => '🗺️', 'color' => 'orange'],
                                ];
                            @endphp

                            @foreach($subjects as $subject)
                                @php
                                    $value = $siswa ? $siswa->{$subject['field']} : null;
                                    $colorMap = [
                                        'blue' => 'from-blue-50 border-blue-200 focus-within:ring-blue-500',
                                        'green' => 'from-green-50 border-green-200 focus-within:ring-green-500',
                                        'yellow' => 'from-yellow-50 border-yellow-200 focus-within:ring-yellow-500',
                                        'red' => 'from-red-50 border-red-200 focus-within:ring-red-500',
                                        'indigo' => 'from-indigo-50 border-indigo-200 focus-within:ring-indigo-500',
                                        'cyan' => 'from-cyan-50 border-cyan-200 focus-within:ring-cyan-500',
                                        'pink' => 'from-pink-50 border-pink-200 focus-within:ring-pink-500',
                                        'orange' => 'from-orange-50 border-orange-200 focus-within:ring-orange-500',
                                    ];
                                @endphp
                                <div
                                    class="bg-gradient-to-br {{ $colorMap[$subject['color']] }} border-2 rounded-lg p-4 transition focus-within:ring-2 focus-within:ring-offset-2">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                            <span class="text-2xl">{{ $subject['icon'] }}</span>
                                            {{ $subject['name'] }}
                                        </label>
                                        @if($value !== null)
                                            <span
                                                class="inline-flex items-center gap-1 bg-gradient-to-r from-green-400 to-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                                ✓ Tersimpan
                                            </span>
                                        @endif
                                    </div>

                                    <input type="number" step="0.1" min="0" max="100" name="{{ $subject['field'] }}"
                                        value="{{ old($subject['field'], $value) }}"
                                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-300 rounded-lg font-semibold text-lg text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:outline-none transition @error($subject['field']) border-red-500 @enderror"
                                        placeholder="0-100" required disabled>

                                    @if($value !== null)
                                        <p class="mt-2 text-xs text-gray-600">Nilai saat ini: <span
                                                class="font-bold text-lg">{{ number_format($value, 1, ',', '') }}</span></p>
                                    @endif

                                    @error($subject['field'])
                                        <p class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded">⚠ {{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <!-- Save Button Disabled for Read-Only View -->
                    <div class="border-t border-gray-200 bg-gray-50 p-6 flex gap-4">
                        <div class="flex-1 bg-gray-200 text-gray-500 font-bold py-3 px-6 rounded-lg text-center flex items-center justify-center gap-2 cursor-not-allowed opacity-60"
                            title="Data nilai adalah read-only dan tidak bisa diubah">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                </path>
                            </svg>
                            Simpan Nilai (Read-Only)
                        </div>
                        <a href="{{ route('siswa.dashboard') }}"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.707 7.293a1 1 0 010 1.414L5.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm5.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L14.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('fileLabel');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name + ' (' + (input.files[0].size / 1024).toFixed(2) + ' KB)';
                label.classList.add('border-green-500', 'bg-green-50');
                label.classList.remove('border-dashed', 'border-blue-300');
            }
        }

        // Drag and drop support
        const fileLabel = document.getElementById('fileLabel');
        const fileInput = document.getElementById('file_raport');

        fileLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileLabel.classList.add('border-green-500', 'bg-green-50');
        });

        fileLabel.addEventListener('dragleave', () => {
            fileLabel.classList.remove('border-green-500', 'bg-green-50');
        });

        fileLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            updateFileName(fileInput);
            fileLabel.classList.remove('border-green-500', 'bg-green-50');
        });
    </script>
</x-app-layout>