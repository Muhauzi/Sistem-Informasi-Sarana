<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Distribusi Sarana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header Form --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Form Tambah Distribusi Sarana
                        </h2>
                        <a href="{{ route('distributions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Form Tambah Data --}}
                    <form method="POST" action="{{ route('distributions.store') }}" class="space-y-6" id="distributionForm">
                        @csrf

                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Divisi Tujuan</label>
                            <select name="division_id" id="division_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Pilih Divisi</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('division_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan Distribusi</label>
                            <textarea name="description" id="description" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Keterangan Distribusi">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="distributed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Distribusi</label>
                            <input type="date" name="distributed_at" id="distributed_at" value="{{ old('distributed_at', date('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            @error('distributed_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Scan atau Input Kode Barang</label>
                            <div class="flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <input type="text" id="qrInput" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Scan/masukkan kode QR barang">
                                    <button type="button" id="scanItemBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex-shrink-0">Scan</button>
                                    <button type="button" id="addItemBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex-shrink-0">Tambah</button>
                                </div>
                            </div>
                            <small class="text-gray-500">Scan QR atau masukkan kode barang, lalu tekan Tambah.</small>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Daftar Barang Untuk Distribusi</label>
                            <div id="itemsListContainer" class="p-4 border border-gray-200 dark:border-gray-700 rounded-md min-h-[80px]">
                                <ul id="itemsList" class="space-y-2">
                                    {{-- Daftar item hasil scan akan muncul di sini --}}
                                </ul>
                                <p id="emptyState" class="text-gray-400 text-sm">Belum ada barang yang ditambahkan.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('distributions.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-md shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                                Simpan Distribusi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="qrModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end sm:items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-lg w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Scan QR Barang</h3>
                        <button type="button" id="closeQrModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold">&times;</button>
                    </div>
                    <div class="mt-4">
                        <div id="qr-video-container" class="w-full bg-gray-200 rounded">
                            <div id="qr-video" style="width: 100%;"></div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-center">Arahkan kamera ke QR Code.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- DEKLARASI VARIABEL ---
            const qrInput = document.getElementById('qrInput');
            const scanItemBtn = document.getElementById('scanItemBtn');
            const addItemBtn = document.getElementById('addItemBtn');
            const itemsList = document.getElementById('itemsList');
            const itemsListContainer = document.getElementById('itemsListContainer');
            const emptyState = document.getElementById('emptyState');
            const qrModal = document.getElementById('qrModal');
            const closeQrModalBtn = document.getElementById('closeQrModal');

            let items = [];
            let html5QrScanner = null;

            // --- FUNGSI-FUNGSI ---

            // Fungsi untuk menampilkan/menyembunyikan placeholder "Belum ada barang"
            function updateEmptyState() {
                if (items.length === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            // Fungsi untuk merender daftar barang ke <ul>
            function renderItems() {
                itemsList.innerHTML = '';
                items.forEach((item, idx) => {
                    const li = document.createElement('li');
                    li.className = "flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded";
                    li.innerHTML = `
                        <div>
                           <span class="font-medium">${item.name}</span>
                           <span class="text-xs text-gray-500 dark:text-gray-400">(${item.id})</span>
                        </div>
                        <div class="flex items-center">
                            <button type="button" class="text-red-500 hover:text-red-700 font-bold ml-4 remove-item" data-idx="${idx}">&times;</button>
                            <input type="hidden" name="item_ids[]" value="${item.id}">
                        </div>
                    `;
                    itemsList.appendChild(li);
                });
                updateEmptyState();
            }

            // Fungsi untuk mengambil data barang dari server
            // File: resources/views/distributions/create.blade.php (di dalam tag <script>)

            function fetchItem(id) {
                // PERUBAHAN DI SINI: 'get-item' menjadi 'get-items'
                const url = `{{ route('distributions.get-items', ':id') }}`.replace(':id', encodeURIComponent(id));

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                return fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            // Jika masih error, coba tampilkan pesan error dari server
                            return response.json().then(err => {
                                throw new Error(err.error || 'Gagal mengambil data barang.');
                            }).catch(() => {
                                throw new Error(`Gagal mengambil data barang. Status: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cek jika ada data dan ada properti 'name'
                        if (data && data.name) {
                            return {
                                id: data.id,
                                name: data.name
                            }; // Gunakan data.id dari respon
                        } else {
                            throw new Error('Format data barang dari server tidak sesuai.');
                        }
                    });
            }

            // Fungsi untuk menambah barang ke daftar
            function addItemById(id) {
                if (!id) return;
                if (items.some(item => item.id === id)) {
                    alert('Barang ini sudah ada dalam daftar.');
                    return;
                }

                addItemBtn.disabled = true;
                addItemBtn.innerText = 'Mencari...';

                fetchItem(id)
                    .then(item => {
                        items.push(item);
                        renderItems();
                        qrInput.value = '';
                        qrInput.focus();
                    })
                    .catch(error => {
                        alert(error.message);
                    })
                    .finally(() => {
                        addItemBtn.disabled = false;
                        addItemBtn.innerText = 'Tambah';
                    });
            }

            // --- LOGIKA SCANNER DARI HTML5-QRCODE ---
            function onScanSuccess(decodedText, decodedResult) {
                html5QrScanner.stop().then(() => {
                    closeQrModal();
                    addItemById(decodedText);
                }).catch(err => console.error("Gagal menghentikan scanner", err));
            }

            function onScanFailure(error) {
                // Biarkan kosong agar tidak memunculkan log error terus-menerus
            }

            // Fungsi untuk membuka modal dan memulai scanner
            function openQrModal() {
                qrModal.classList.remove('hidden');
                // Inisialisasi scanner jika belum ada
                if (!html5QrScanner) {
                    html5QrScanner = new Html5Qrcode("qr-video");
                }
                html5QrScanner.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    console.error("Gagal memulai scanner", err);
                    alert("Tidak dapat memulai kamera. Pastikan Anda memberikan izin akses kamera.");
                    closeQrModal();
                });
            }

            // Fungsi untuk menutup modal dan menghentikan scanner
            function closeQrModal() {
                qrModal.classList.add('hidden');
                if (html5QrScanner && html5QrScanner.isScanning) {
                    html5QrScanner.stop().catch(err => console.error("Gagal menghentikan scanner saat menutup.", err));
                }
            }


            // --- EVENT LISTENERS ---

            // Klik tombol "Scan"
            scanItemBtn.addEventListener('click', openQrModal);

            // Klik tombol "Tambah"
            addItemBtn.addEventListener('click', () => addItemById(qrInput.value.trim()));

            // Tekan "Enter" di input field
            qrInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addItemBtn.click();
                }
            });

            // Klik tombol hapus item (delegasi event)
            itemsList.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-item')) {
                    const idx = parseInt(e.target.getAttribute('data-idx'));
                    items.splice(idx, 1);
                    renderItems();
                }
            });

            // Klik tombol close (X) di modal
            closeQrModalBtn.addEventListener('click', closeQrModal);

            // Klik area luar modal untuk menutup
            qrModal.addEventListener('click', function(e) {
                if (e.target === qrModal) {
                    closeQrModal();
                }
            });

            // Inisialisasi tampilan awal
            updateEmptyState();
        });
    </script>
</x-app-layout>