<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Sarana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 w-auto max-w-full">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Detail Sarana
                        </h2>
                        <a href="{{ route('sarana.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Detail Section --}}
                    <div class="flex flex-col md:flex-row items-start gap-8">
                        {{-- Kolom 1: Image --}}
                        <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center">
                            @if($item->photo_path)
                            <img src="{{ asset('storage/uploads/items/' . $item->photo_path) }}" alt="Foto Sarana" class="h-48 w-48 object-cover rounded shadow border">
                            @else
                            <div class="h-48 w-48 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded shadow border text-gray-500">
                                Tidak ada foto
                            </div>
                            @endif
                        </div>

                        {{-- Kolom 2: Wrapper untuk konten teks --}}
                        <div class="w-full md:w-2/3 space-y-8">

                            {{-- Details --}}
                            <div class="space-y-4">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Detail Sarana</h3>
                                <div class="flex">
                                    <span class="w-40 flex-shrink-0 font-medium text-gray-700 dark:text-gray-300">Nama Sarana</span>
                                    <span class="mr-2">:</span>
                                    <span>{{ $item->name }}</span>
                                </div>
                                <div class="flex">
                                    <span class="w-40 flex-shrink-0 font-medium text-gray-700 dark:text-gray-300">Kategori Sarana</span>
                                    <span class="mr-2">:</span>
                                    <span>{{ $item->category->name ?? '-' }}</span>
                                </div>
                                <div class="flex">
                                    <span class="w-40 flex-shrink-0 font-medium text-gray-700 dark:text-gray-300">Kondisi</span>
                                    <span class="mr-2">:</span>
                                    <span>{{ $item->condition }}</span>
                                </div>
                                <div class="flex">
                                    <span class="w-40 flex-shrink-0 font-medium text-gray-700 dark:text-gray-300">Tahun Pembelian</span>
                                    <span class="mr-2">:</span>
                                    <span>{{ $item->purchase_year }}</span>
                                </div>
                                <div class="flex">
                                    <span class="w-40 flex-shrink-0 font-medium text-gray-700 dark:text-gray-300">QR Code</span>
                                    <span class="mr-2">:</span>
                                    <span>
                                        @if($item->qr_code)
                                        <img src="{{ asset($item->qr_code) }}" alt="QR Code" class="h-52 w-52 object-cover rounded shadow border" style="width:200px; height:200px;">
                                        <a href="{{ asset($item->qr_code) }}" download class="ml-4 inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded hover:bg-blue-600 transition">
                                            Download QR Code
                                        </a>
                                        @else
                                        <form action="{{ route('sarana.generateQrCode', $item->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-blue-500 hover:underline">Generate QR Code</button>
                                        </form>
                                        @endif
                                    </span>
                                </div>

                                {{-- Item Last Distribution --}}
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Distribusi Terakhir</h3>
                                    @if($distributions && count($distributions))
                                    @php
                                    $lastDistribution = collect($distributions)->sortByDesc('distributed_at')->first();
                                    @endphp
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <tbody>
                                                <tr>
                                                    <td class="pr-4 py-2 font-medium text-gray-700 dark:text-gray-300 w-48 align-baseline">Tanggal</td>
                                                    <td class="py-2">{{ $lastDistribution->distributed_at ? \Carbon\Carbon::parse($lastDistribution->distributed_at)->format('d-m-Y') : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4 py-2 font-medium text-gray-700 dark:text-gray-300 align-baseline">Divisi Penerima</td>
                                                    <td class="py-2">{{ $lastDistribution->division->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4 py-2 font-medium text-gray-700 dark:text-gray-300 align-baseline">Keterangan</td>
                                                    <td class="py-2">{{ $lastDistribution->description ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4 py-2 font-medium text-gray-700 dark:text-gray-300 align-baseline">Didistribusikan Oleh</td>
                                                    <td class="py-2">{{ $lastDistribution->user->name ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-gray-500">Belum ada distribusi.</div>
                                    @endif
                                </div>

                                {{-- Item History --}}
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Riwayat Distribusi</h3>
                                    @if($distributions && count($distributions))
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                                    <th class="px-4 py-2 text-left">Divisi Penerima</th>
                                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(collect($distributions)->sortByDesc('distributed_at') as $distribution)
                                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                                    <td class="px-4 py-2">{{ $distribution->distributed_at ? \Carbon\Carbon::parse($distribution->distributed_at)->format('d-m-Y') : '-' }}</td>
                                                    <td class="px-4 py-2">{{ $distribution->division->name ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $distribution->description ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-gray-500">Belum ada riwayat distribusi.</div>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>