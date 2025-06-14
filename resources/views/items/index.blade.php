<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Sarana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4 sm:mb-0 text-left">
                        {{ __('List Sarana') }}
                    </h2>
                    <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
                        <!-- Tombol Tambah (KANAN) -->
                        <a href="{{ route('sarana.create') }}"
                            class="px-3 py-3 bg-gray-800 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-700 transition">
                            Tambah Sarana
                        </a>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                            <!-- Optional: Pagination -->
                            <div class="flex items-center gap-2">
                                <select id="paginate-select" class="py-2 pe-5 border border-gray-300 dark:border-gray-700 rounded-md text-sm dark:bg-gray-900 dark:text-white">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <input id="datatable-search" type="search" placeholder="Cari..."
                                    class="py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-md text-sm w-full sm:w-64 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:bg-gray-900 dark:text-white" />
                            </div>

                            <!-- Optional: Filter by Kategori -->
                            <div class="flex items-center gap-2">
                                <label for="filter-kategori" class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategori:</label>
                                <select id="filter-kategori" class="py-2 px-auto border border-gray-300 dark:border-gray-700 rounded-md text-sm dark:bg-gray-900 dark:text-white">
                                    <option value="">Semua</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table id="items-table" class="table-auto w-full text-left text-sm text-gray-500 dark:text-gray-400 mt-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                <tr>
                                    <th scope="col" class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Nama Sarana</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Kondisi</th>
                                    <th class="px-4 py-3">Tahun Pengadaan</th>
                                    <th class="px-4 py-3">Bidang</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $item->id }}</td>
                                    <td class="px-4 py-2">{{ $item->name }}</td>
                                    <td class="px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($item->condition) }}</td>
                                    <td class="px-4 py-2">{{ $item->purchase_year }}</td>
                                    <td class="px-4 py-2">{{ $item->division->name ?? '-' }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="{{ route('sarana.show', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-100 hover:bg-blue-200 text-blue-600" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sarana.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-yellow-100 hover:bg-yellow-200 text-yellow-600" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form id="delete-form-{{$item->id}}" action="{{ route('sarana.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="confirmDelete('{{$item->id}}')" type="button" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 hover:bg-red-200 text-red-600" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-center">Tidak ada data sarana yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $items->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('datatable-search');
            const kategoriFilter = document.getElementById('filter-kategori');
            const table = document.getElementById('items-table');
            const rows = table.querySelectorAll('tbody tr');
            const paginateSelect = document.getElementById('paginate-select');

            function filterTable() {
                const keyword = searchInput.value.toLowerCase();
                const kategori = kategoriFilter.value.toLowerCase();

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const nama = cells[1]?.textContent.toLowerCase() || '';
                    const kategoriText = cells[2]?.textContent.toLowerCase() || '';
                    const matchSearch = nama.includes(keyword);
                    const matchKategori = !kategori || kategoriText.includes(kategori);

                    row.style.display = (matchSearch && matchKategori) ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            kategoriFilter.addEventListener('change', filterTable);

            // Paginate select change
            paginateSelect.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                params.set('per_page', this.value);
                window.location.search = params.toString();
            });
        });
    </script>


    <!-- Alert -->
    <x-alert></x-alert>
    <x-confirm-delete></x-confirm-delete>
</x-app-layout>