<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Kategori Sarana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4 sm:mb-0 text-left">
                        {{ __('List Kategori Sarana') }}
                    </h2>
                    <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
                        <!-- Search Form (KIRI) -->
                        <form method="GET" action="{{ route('kategori-sarana.index') }}" class="flex items-center w-50 sm:w-auto">
                            <span class="inline-flex items-center px-2 text-gray-400 dark:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari berdasarkan nama..."
                                class="ml-2 block w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <button type="submit"
                                class="ml-2 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 transition">
                                Cari
                            </button>
                        </form>

                        <!-- Tombol Tambah (KANAN) -->
                        <a href="{{ route('kategori-sarana.create') }}"
                            class="px-4 py-4 bg-gray-800 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-700 transition">
                            Tambah Kategori
                        </a>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <div class="rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full w-full bg-white dark:bg-gray-900">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 whitespace-nowrap">
                                            <div class="flex items-center">Kode Kategori</div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 whitespace-nowrap">
                                            <div class="flex items-center">Nama Kategori</div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 whitespace-nowrap">
                                            <div class="flex items-center">Tanggal Dibuat</div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 whitespace-nowrap">
                                            <div class="flex items-center">Aksi</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                    <tr class="hover:bg-indigo-50 dark:hover:bg-gray-800 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex items-center">
                                                <span>{{ $category->code }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex items-center">
                                                <span>{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $category->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <!-- Edit Button with FontAwesome Pencil Icon -->
                                                <a href="{{ route('kategori-sarana.edit', $category->id) }}"
                                                    class="inline-flex items-center px-4 py-3 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-xs font-semibold transition">
                                                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                                                </a>
                                                <!-- Delete Button with FontAwesome Trash Icon -->
                                                <form id="delete-form-{{$category->id}}" action="{{ route('kategori-sarana.destroy', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="confirmDelete('{{$category->id}}')" type="button"
                                                        class="inline-flex items-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition">
                                                        <i class="fa-solid fa-trash mr-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-10 h-10 mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Tidak ada data kategori yang ditemukan.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Alert -->
    <x-alert></x-alert>
    <x-confirm-delete></x-confirm-delete>
</x-app-layout>