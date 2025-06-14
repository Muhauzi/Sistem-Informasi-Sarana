<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Distribusi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Detail Distribusi
                        </h2>
                        <a href="{{ route('distributions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Detail Section --}}
                    <div class="space-y-4 mb-6">
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Divisi Tujuan</span>
                            <span class="ml-2">: {{ $distribution->division->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Deskripsi</span>
                            <span class="ml-2">: {{ $distribution->description ?? '-' }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Tanggal Distribusi</span>
                            <span class="ml-2">: {{ \Carbon\Carbon::parse($distribution->distributed_at)->format('d-m-Y') }}</span>
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <div>
                        <h3 class="font-semibold mb-2">Daftar Item Didistribusikan</h3>
                        <table class="min-w-full bg-white dark:bg-gray-700 rounded">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Kode Item</th>
                                    <th class="px-4 py-2 border">Nama Item</th>
                                    <th class="px-4 py-2 border">Dari Divisi</th>
                                    <th class="px-4 py-2 border">Ke Divisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($distribution->itemHistories as $ih)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border">{{ $ih->item->id ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $ih->item->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $ih->fromDivision->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $ih->toDivision->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                                @if($distribution->itemHistories->isEmpty())
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 border text-center">Tidak ada item.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>