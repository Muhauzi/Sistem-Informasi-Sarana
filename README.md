
# Sistem Informasi Sarana

Sistem Informasi Sarana adalah sebuah aplikasi berbasis web yang dirancang untuk membantu pengelolaan data sarana dan prasarana pada suatu instansi atau organisasi. Aplikasi ini mempermudah proses pendataan, monitoring kondisi, dan pengelolaan inventaris sarana.

## 🚀 Fitur Utama

- **Manajemen Data Sarana**
  - Tambah, ubah, dan hapus data sarana.
  - Kategori dan detail inventaris.
- **Monitoring & Pelaporan**
  - Lihat status ketersediaan dan kondisi sarana.
  - Cetak laporan pendataan sarana.
- **Autentikasi Pengguna**
  - Login, register, manajemen user dengan role berbeda (admin/user).
- **Dashboard Interaktif**
  - Statistik penggunaan dan kondisi sarana.

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel
- **Frontend**: Blade Template + Bootstrap/Tailwind *(sesuaikan dengan stack yang dipakai)*
- **Database**: MySQL
- **Autentikasi**: Laravel Breeze/Fortify *(atau sebutkan sesuai package)*
- **Fitur Tambahan**: Validasi input, flash message, dll.

## ⚙️ Cara Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/Muhauzi/Sistem-Informasi-Sarana.git
   cd Sistem-Informasi-Sarana
   ```

2. **Install Dependency**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Buat File Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   - Update file `.env` dengan detail database MySQL kamu.
   - Jalankan migrasi:
     ```bash
     php artisan migrate
     ```

5. **Jalankan Server**
   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di `http://localhost:8000`

## 📝 Catatan

- Pastikan sudah mengatur permission folder `storage` dan `bootstrap/cache`.
- Repository ini masih tahap pengembangan *(update jika project sudah production-ready)*.

## 📬 Kontribusi

Pull request sangat disambut!  
Jika menemukan bug, silakan buat issue atau PR dengan perbaikan.

## 👤 Penulis

- **Nama**: [Muhauzi](https://github.com/Muhauzi)
- **Role**: Backend Developer | Fullstack Developer *(jika sesuai)*

---

**Lisensi**: MIT License
