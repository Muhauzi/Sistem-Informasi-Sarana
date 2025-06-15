<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRANA BKPSDM SUBANG</title>
    <link rel="icon" type="image/png" href="/assets/logo.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        #html5-qrcode-button-camera-stop {
            display: inline-block; padding: 0.5rem 1rem; margin-top: 1rem;
            background-color: #ef4444; color: white; border-radius: 0.5rem; cursor: pointer;
        }
        #html5-qrcode-button-camera-stop:hover { background-color: #dc2626; }
        .loader {
            border: 4px solid #f3f3f3; border-top: 4px solid #3498db;
            border-radius: 50%; width: 40px; height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-gray-100">

    <div x-data="scannerApp()" x-init="init()">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img src="/assets/logo.png" alt="Logo" class="h-8 w-8 object-contain">
                    <h1 class="text-xl font-bold text-gray-800">SIRANA BKPSDM</h1>
                </div>
                <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Login</a>
            </div>
        </header>

        <main class="min-h-[calc(100vh-64px)] flex flex-col items-center p-6">
            <div class="text-center mt-8">
                <h2 class="text-3xl font-light text-gray-700 mb-2">Selamat Datang</h2>
                <p class="text-gray-500 mb-8">Untuk melacak sarana, silakan pindai QR code yang terpasang.</p>
                <button @click="openScannerModal()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-2xl shadow-lg">
                    Scan Sarana
                </button>
            </div>

            <div x-show="isLoading" class="mt-8 flex flex-col items-center" x-cloak>
                <div class="loader"></div>
                <p class="text-gray-600 mt-2">Mencari data sarana...</p>
            </div>

            <div x-show="currentItem && !isLoading" class="container mx-auto max-w-5xl mt-10 p-6 bg-white rounded-lg shadow-lg" x-cloak x-transition>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6" x-text="'Detail Sarana: ' + currentItem.name"></h2>
                
                <div class="flex flex-col md:flex-row items-start gap-8">
                    <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center">
                        <template x-if="currentItem.photo_path">
                            <img :src="'/storage/uploads/items/' + currentItem.photo_path" alt="Foto Sarana" class="h-48 w-48 object-cover rounded shadow border">
                        </template>
                        <template x-if="!currentItem.photo_path">
                            <div class="h-48 w-48 flex items-center justify-center bg-gray-100 rounded shadow border text-gray-500">Tidak ada foto</div>
                        </template>
                    </div>

                    <div class="w-full md:w-2/3 space-y-8">
                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Detail Informasi</h3>
                            <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Nama Sarana</span><span class="mr-2">:</span><span x-text="currentItem.name"></span></div>
                            <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Kategori</span><span class="mr-2">:</span><span x-text="currentItem.category.name"></span></div>
                            <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Kondisi</span><span class="mr-2">:</span><span x-text="currentItem.condition"></span></div>
                            <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Tahun Pembelian</span><span class="mr-2">:</span><span x-text="currentItem.purchase_year"></span></div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Posisi Terakhir</h3>
                            <template x-if="lastDistribution">
                                <div class="space-y-1">
                                    <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Tanggal Distribusi</span><span class="mr-2">:</span><span x-text="new Date(lastDistribution.distributed_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })"></span></div>
                                    <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Divisi Penerima</span><span class="mr-2">:</span><span x-text="histories.length > 0 ? histories[0].to_division_name : 'N/A'"></span></div>
                                    <div class="flex"><span class="w-40 flex-shrink-0 font-medium text-gray-700">Keterangan</span><span class="mr-2">:</span><span x-text="lastDistribution.description || '-'"></span></div>
                                </div>
                            </template>
                            <template x-if="!lastDistribution">
                                <p class="text-gray-500">Belum pernah didistribusikan.</p>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">Riwayat Distribusi</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full bg-white text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Tanggal</th>
                                    <th class="px-4 py-2 text-left font-medium">Asal Divisi</th>
                                    <th class="px-4 py-2 text-left font-medium">Divisi Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="history in histories" :key="history.id">
                                    <tr class="border-t">
                                        <td class="px-4 py-2" x-text="new Date(history.created_at).toLocaleString('id-ID')"></td>
                                        <td class="px-4 py-2" x-text="history.from_division_name || '-'"></td>
                                        <td class="px-4 py-2" x-text="history.to_division_name || '-'"></td>
                                    </tr>
                                </template>
                                <template x-if="!histories || histories.length === 0">
                                    <tr><td colspan="3" class="text-center py-4 text-gray-500">Tidak ada riwayat distribusi.</td></tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>

        <div x-show="isScannerModalOpen" x-transition class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50" x-cloak>
            <div @click.outside="closeScannerModal()" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                <button @click="closeScannerModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 font-bold text-2xl">&times;</button>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Pindai QR Code Sarana</h3>
                <div id="qr-reader" class="w-full border-2 border-dashed rounded-lg overflow-hidden"></div>
            </div>
        </div>
    </div>

    <script>
        function scannerApp() {
            return {
                isScannerModalOpen: false,
                html5Qrcode: null,
                isLoading: false,
                currentItem: null,
                histories: [],
                lastDistribution: null,

                init() {
                    if (typeof Html5Qrcode !== 'undefined') {
                        this.html5Qrcode = new Html5Qrcode("qr-reader");
                    }
                },
                
                onScanSuccess(decodedText, decodedResult) {
                    this.closeScannerModal(); 
                    this.fetchItemDetails(decodedText);
                },

                async fetchItemDetails(itemId) {
                    this.isLoading = true;
                    this.currentItem = null; // Reset data sebelumnya agar kontainer hilang

                    // PASTIKAN ROUTE INI SESUAI DENGAN YANG ANDA BUAT
                    const url = `/sarana-scan/${itemId}`; 

                    try {
                        const response = await fetch(url);
                        if (!response.ok) {
                            const errorData = await response.json();
                            alert(`Error: ${errorData.message || 'Gagal mengambil data.'}`);
                            return;
                        }

                        const data = await response.json();
                        
                        // Isi state Alpine dengan data dari JSON
                        this.currentItem = data.item;
                        this.histories = data.histories;
                        this.lastDistribution = data.last_distribution;

                    } catch (error) {
                        console.error('Fetch error:', error);
                        alert('Gagal terhubung ke server. Periksa koneksi Anda.');
                    } finally {
                        this.isLoading = false;
                    }
                },

                // --- Fungsi untuk mengelola Modal Scanner ---
                openScannerModal() {
                    this.isScannerModalOpen = true;
                    this.$nextTick(() => { this.startScanner(); });
                },
                closeScannerModal() {
                    this.isScannerModalOpen = false;
                    this.stopScanner();
                },
                startScanner() {
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                    this.html5Qrcode.start({ facingMode: "environment" }, config, this.onScanSuccess.bind(this), () => {});
                },
                stopScanner() {
                    if (this.html5Qrcode && this.html5Qrcode.isScanning) {
                        try {
                           this.html5Qrcode.stop();
                        } catch(e) {
                           console.warn("Error stopping scanner", e);
                        }
                    }
                },
            }
        }
    </script>
</body>
</html>