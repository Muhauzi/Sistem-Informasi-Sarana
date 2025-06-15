<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Distribusi Sarana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header Form --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Form Edit Distribusi Sarana
                        </h2>
                        <a href="{{ route('distributions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Form Edit Data --}}
                    <form method="POST" action="{{ route('distributions.update', $distribution->id) }}" class="space-y-6" id="distributionForm">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Divisi Tujuan</label>
                            <select name="division_id" id="division_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Pilih Divisi</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ (old('division_id', $distribution->division_id) == $division->id) ? 'selected' : '' }}>
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
                                placeholder="Keterangan Distribusi">{{ old('description', $distribution->description) }}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="distributed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Distribusi</label>
                            <input type="date" name="distributed_at" id="distributed_at" value="{{ old('distributed_at', $distribution->distributed_at ? \Illuminate\Support\Carbon::parse($distribution->distributed_at)->format('Y-m-d') : '') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            @error('distributed_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modal Trigger & Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Scan QR Code Barang</label>
                            <div class="flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <input type="text" id="qrInput" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Scan/masukkan kode QR barang">
                                    <button type="button" id="scanItemBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Scan</button>
                                    <button type="button" id="addItemBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Tambah</button>
                                </div>
                            </div>
                            <small class="text-gray-500">Scan QR atau masukkan kode barang, lalu tekan Tambah.</small>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Daftar Barang Terdaftar</label>

                            <ul id="itemsList" class="space-y-2">
                                {{-- Daftar item hasil scan akan muncul di sini --}}
                                @if(old('item_id', $items->pluck('id')->toArray()))
                                @foreach($items as $item)
                                <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded">
                                    <span>{{ $item['name'] }} <span class="text-xs text-gray-500">({{ $item['id'] }})</span></span>
                                    <button type="button" class="text-red-500 hover:text-red-700 font-bold ml-4 remove-item" data-idx="{{ $loop->index }}">&times;</button>
                                    <input type="hidden" name="item_id[]" value="{{ $item['id'] }}">
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('distributions.index') }}" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gray-800 ms-2 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-gray-900 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                                Simpan Distribusi
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="qrModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-md w-full z-50">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100" id="modal-title">Scan QR Barang</h3>
                    <button type="button" id="closeQrModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">&times;</button>
                </div>
                <div class="p-4">
                    <video id="qr-video" class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-black" style="max-height:220px;"></video>
                    <div class="mt-2 text-center text-sm text-gray-500 dark:text-gray-300">Arahkan kamera ke QR Code barang</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/simple-qrcode@latest/dist/simple-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let scanner = null;
            const qrModal = document.getElementById('qrModal');
            const scanItemBtn = document.getElementById('scanItemBtn');
            const closeQrModal = document.getElementById('closeQrModal');
            const qrInput = document.getElementById('qrInput');
            let scannerStarted = false;

            function openQrModal() {
                qrModal.classList.remove('hidden');
                setTimeout(() => {
                    if (window.SimpleQRCode && !scannerStarted) {
                        const video = document.getElementById('qr-video');
                        scanner = new SimpleQRCode.Scanner(video, {
                            onDecode: function(result) {
                                if (result && qrInput.value !== result) {
                                    qrInput.value = result;
                                    document.getElementById('addItemBtn').click();
                                    closeQrModalFunc();
                                }
                            },
                            onError: function() {}
                        });
                        scanner.start();
                        scannerStarted = true;
                    }
                }, 200);
            }

            function closeQrModalFunc() {
                qrModal.classList.add('hidden');
                if (scanner && scannerStarted) {
                    scanner.stop();
                    scannerStarted = false;
                }
            }

            scanItemBtn.addEventListener('click', openQrModal);
            closeQrModal.addEventListener('click', closeQrModalFunc);

            // Optional: close modal on outside click
            qrModal.addEventListener('mousedown', function(e) {
                if (e.target === qrModal) {
                    closeQrModalFunc();
                }
            });
        });
    </script>

    <script>
        const qrInput = document.getElementById('qrInput');
        const scanItemBtn = document.getElementById('scanItemBtn');
        const addItemBtn = document.getElementById('addItemBtn');
        const itemsList = document.getElementById('itemsList');
        const qrModal = document.getElementById('qrModal');
        const closeQrModal = document.getElementById('closeQrModal');
        const video = document.getElementById('qr-video');


        let items = @json($items);
        let scanner = null;
        let scannerStarted = false;

        function renderItems() {
            itemsList.innerHTML = '';
            items.forEach((item, idx) => {
                const li = document.createElement('li');
                li.className = "flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded";
                li.innerHTML = `
                <span>${item.name} <span class="text-xs text-gray-500">(${item.id})</span></span>
                <button type="button" class="text-red-500 hover:text-red-700 font-bold ml-4 remove-item" data-idx="${idx}">&times;</button>
                <input type="hidden" name="item_id[]" value="${item.id}">
            `;
                itemsList.appendChild(li);
            });
        }

        function renderItems() {
            itemsList.innerHTML = '';
            items.forEach((item, idx) => {
                const li = document.createElement('li');
                li.className = "flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded";
                li.innerHTML = `
                <span>${item.name} <span class="text-xs text-gray-500">(${item.id})</span></span>
                <button type="button" class="text-red-500 hover:text-red-700 font-bold ml-4 remove-item" data-idx="${idx}">&times;</button>
                <input type="hidden" name="item_id[]" value="${item.id}">
            `;
                itemsList.appendChild(li);
            });
        }

        function fetchItemName(id) {
            const url = `{{ route('distributions.get-items', ['id' => 'ITEM_ID_PLACEHOLDER']) }}`.replace('ITEM_ID_PLACEHOLDER', encodeURIComponent(id));
            return fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data && data.name) {
                        return {
                            id: id,
                            name: data.name
                        };
                    } else {
                        throw new Error('Barang tidak ditemukan');
                    }
                });
        }

        function addItemById(id) {
            if (items.some(item => item.id === id)) return;

            fetchItemName(id)
                .then(item => {
                    items.push(item);
                    renderItems();
                    qrInput.value = '';
                    qrInput.focus();
                })
                .catch(() => {
                    alert('Barang tidak ditemukan!');
                });
        }

        function openQrModal() {
            qrModal.classList.remove('hidden');
            setTimeout(() => {
                if (window.SimpleQRCode && !scannerStarted) {
                    scanner = new SimpleQRCode.Scanner(video, {
                        onDecode: function(result) {
                            if (result) {
                                addItemById(result);
                                closeQrModalFunc();
                            }
                        },
                        onError: function() {}
                    });
                    scanner.start();
                    scannerStarted = true;
                }
            }, 200);
        }

        function closeQrModalFunc() {
            qrModal.classList.add('hidden');
            if (scanner && scannerStarted) {
                scanner.stop();
                scannerStarted = false;
            }
        }

        // Klik tombol SCAN untuk buka modal
        scanItemBtn.addEventListener('click', openQrModal);

        // Klik tombol TAMBAH untuk input manual
        addItemBtn.addEventListener('click', function() {
            const id = qrInput.value.trim();
            if (id) {
                addItemById(id);
            }
        });

        // Enter = Tambah
        qrInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addItemBtn.click();
            }
        });

        // Tombol close modal
        closeQrModal.addEventListener('click', closeQrModalFunc);

        // Klik luar modal = tutup
        qrModal.addEventListener('mousedown', function(e) {
            if (e.target === qrModal) {
                closeQrModalFunc();
            }
        });

        // Hapus item dari daftar
        itemsList.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                const idx = parseInt(e.target.getAttribute('data-idx'));
                items.splice(idx, 1);
                renderItems();
            }
        });
    </script>
    <script>
        document.getElementById('distributionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>


</x-app-layout>