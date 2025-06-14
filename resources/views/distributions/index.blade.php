<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Distribusi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4 sm:mb-0 text-left">
                        {{ __('List Distribusi') }}
                    </h2>
                    <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
                        <!-- Tombol Tambah (KANAN) -->
                        <a href="{{ route('distributions.create') }}"
                            class="px-3 py-3 bg-gray-800 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-700 transition">
                            Tambah Distribusi
                        </a>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
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
                        </div>

                        <table id="items-table" class="table-auto w-full text-left text-sm text-gray-500 dark:text-gray-400 mt-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                <tr>
                                    <th scope="col" class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Divisi</th>
                                    <th class="px-4 py-3">Didistribusikan Oleh</th>
                                    <th class="px-4 py-3">Tanggal Distribusi</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($distributions as $distribution)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $distribution->id }}</td>
                                    <td class="px-4 py-2">
                                        {{ $distribution->division->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $distribution->user->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $distribution->distributed_at ? \Carbon\Carbon::parse($distribution->distributed_at)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="{{ route('distributions.show', $distribution->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-100 hover:bg-blue-200 text-blue-600" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('distributions.edit', $distribution->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-yellow-100 hover:bg-yellow-200 text-yellow-600" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form id="delete-form-{{$distribution->id}}" action="{{ route('distributions.destroy', $distribution->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="confirmDelete('{{$distribution->id}}')" type="button" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 hover:bg-red-200 text-red-600" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center">Tidak ada data distribusi yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $distributions->withQueryString()->links('pagination::tailwind') }}
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
            const table = document.getElementById('items-table');
            const rows = table.querySelectorAll('tbody tr');
            const paginateSelect = document.getElementById('paginate-select');

            function filterTable() {
                const keyword = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const divisi = cells[1]?.textContent.toLowerCase() || '';
                    const by = cells[2]?.textContent.toLowerCase() || '';
                    const at = cells[3]?.textContent.toLowerCase() || '';
                    const matchSearch = divisi.includes(keyword) || by.includes(keyword) || at.includes(keyword);

                    row.style.display = matchSearch ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);

            // Paginate select change
            paginateSelect.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                params.set('per_page', this.value);
                window.location.search = params.toString();
            });
        });
    </script>

    <x-alert></x-alert>
    <x-confirm-delete></x-confirm-delete>
</x-app-layout>
