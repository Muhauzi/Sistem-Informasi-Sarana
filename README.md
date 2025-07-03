
# Sistem Informasi Sarana

Sistem Informasi Sarana adalah aplikasi web berbasis Laravel yang digunakan untuk membantu pencatatan dan manajemen distribusi sarana/barang di sebuah organisasi. Aplikasi ini bertujuan mempermudah pencatatan distribusi barang ke setiap divisi, mengenali kepemilikan sarana dengan QR Code, dan mengelola data terkait sarana secara terpusat.

## ✨ Fitur Utama

- **Manajemen Data**
  - Pengelolaan data **kategori** sarana.
  - Pengelolaan data **sarana/barang**.
  - Pengelolaan data **divisi**.
  - Pengelolaan data **pengguna/user**.
  - Pencatatan **distribusi sarana** ke masing-masing divisi.

- **QR Code Scanner**
  - Setiap sarana memiliki QR Code unik.
  - Halaman utama dilengkapi fitur **QR Scanner** untuk memindai QR sarana.
  - Hasil pemindaian menampilkan informasi sarana dan divisi pemiliknya.

- **Autentikasi**
  - Sistem login untuk admin/pengelola.
  - User hanya bisa memindai QR tanpa perlu login.

- **Pencatatan Distribusi**
  - Mencatat barang apa saja yang didistribusikan ke divisi tertentu.
  - Belum dilengkapi fitur cetak laporan (masih fokus pada pencatatan distribusi).

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel
- **Database:** MySQL
- **QR Code:** Library untuk generate dan membaca QR Code
- **Frontend:** Blade Template dengan Tailwind CSS (jika digunakan)

## 📸 Screenshot

_Tambahkan tangkapan layar di sini jika ada_

## 🚀 Cara Menjalankan

1. **Clone repository**
   ```bash
   git clone https://github.com/Muhauzi/Sistem-Informasi-Sarana.git
   ```

2. **Install dependensi**
   ```bash
   composer install
   ```

3. **Copy file .env**
   ```bash
   cp .env.example .env
   ```

4. **Generate APP_KEY**
   ```bash
   php artisan key:generate
   ```

5. **Buat database dan atur .env**

6. **Migrate database**
   ```bash
   php artisan migrate
   ```

7. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```

## 💡 Catatan

- Pastikan database sudah terhubung dengan benar.
- Untuk QR Code Scanner, gunakan kamera pada perangkat Anda melalui homepage.

## 📄 Lisensi

Project ini hanya digunakan untuk kebutuhan internal dan pembelajaran.

---

**Author**  
[@Muhauzi](https://github.com/Muhauzi)
