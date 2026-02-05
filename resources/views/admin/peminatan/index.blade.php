<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-4xl font-bold text-gray-900">Kelola Paket Peminatan</h2>
                <p class="text-gray-600 mt-2 text-lg">Atur paket peminatan dan kapasitas siswa</p>
            </div>
            <a href="{{ route('admin.peminatan.create') }}"
                style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(to right, #2563eb, #1d4ed8); color: white; font-weight: 600; padding: 0.75rem 2rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: transform 0.2s; text-decoration: none;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Paket Peminatan</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tombol Tambah Peminatan -->
        <div class="mb-8 flex justify-end">
            <a href="{{ route('admin.peminatan.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Paket Peminatan
            </a>
        </div>

        <!-- Statistik Cards -->
        @if($peminatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Peminatan</p>
                            <p class="text-4xl font-bold mt-2">{{ $peminatans->count() }}</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200 opacity-50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total Kuota</p>
                            <p class="text-4xl font-bold mt-2">{{ $peminatans->sum('kuota_maksimal') }}</p>
                        </div>
                        <svg class="w-12 h-12 text-purple-200 opacity-50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Total Diterima</p>
                            <p class="text-4xl font-bold mt-2">
                                {{ $peminatans->sum(function ($p) {
            return $p->alokasis()->where('status', 'diterima')->count(); }) }}
                            </p>
                        </div>
                        <svg class="w-12 h-12 text-orange-200 opacity-50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM16 5H4m10 7H4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @endif

        <!-- Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-800">{{ $errors->first() }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table atau Empty State -->
        @if($peminatans->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Peminatan</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Kuota</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Diterima</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Sisa Kursi</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Persentase</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($peminatans as $index => $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $p->nama }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold text-sm">
                                            {{ $p->kuota_maksimal }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-semibold text-sm">
                                            {{ $p->alokasis()->where('status', 'diterima')->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 {{ $p->sisaKursi() > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full font-semibold text-sm">
                                            {{ $p->sisaKursi() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full"
                                                    style="width: {{ ($p->alokasis()->where('status', 'diterima')->count() / $p->kuota_maksimal) * 100 }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs font-semibold text-gray-700">{{ round(($p->alokasis()->where('status', 'diterima')->count() / $p->kuota_maksimal) * 100) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.peminatan.edit', $p) }}"
                                                class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-2 rounded-lg font-medium transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.peminatan.destroy', $p) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus peminatan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-2 rounded-lg font-medium transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl shadow-xl p-12 text-center border border-gray-200">
                <div class="mb-6 flex justify-center">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur-lg opacity-20">
                        </div>
                        <svg class="relative w-24 h-24 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                            </path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-3">Belum Ada Paket Peminatan</h3>
                <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">Mulai dengan membuat paket peminatan pertama Anda.
                </p>
                <a href="{{ route('admin.peminatan.create') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-10 rounded-lg shadow-lg transition transform hover:scale-105 text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Paket Peminatan Pertama
                </a>
            </div>
        @endif
    </div>
</x-app-layout>