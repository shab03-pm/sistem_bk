<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Kriteria & Bobot Penilaian</h2>
                <p class="text-gray-600 mt-1">Lihat kriteria dan bobot yang digunakan untuk perhitungan SAW</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Kode</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Nama Kriteria</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Bobot</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Rentang Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">C1</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Nilai Raport</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Benefit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">35%</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">1 - 100</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">C2</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Nilai UN</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Benefit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">30%</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">1 - 100</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">C3</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Nilai Prestasi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Benefit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">20%</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">1 - 100</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">C4</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Nilai Minat Bakat</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Benefit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">15%</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">1 - 100</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                        <p class="text-sm text-blue-800"><strong>Total Bobot:</strong> 100%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>