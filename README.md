
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
- **Frontend:** Blade Template dengan Tailwind CSS
- **Design Figma:** [Link Design](https://www.figma.com/design/QFWpYrRuiCzaIs6MjvxnNN/SIRANA-BKPSDM?node-id=1-752&t=v9MGKMlxql9SC3OJ-1) 

## 📸 Screenshot

1. **Homepage**
   ![Screenshot 2025-07-03 114121](https://github.com/user-attachments/assets/4b16d566-07c6-4451-afdc-fcef4564bdb0)
3. **Login Page**
   ![Screenshot 2025-07-03 114129](https://github.com/user-attachments/assets/b0447c32-7d05-40be-981b-3633666c0880)
5. **Kelola Kategori**
   ![Screenshot 2025-07-03 114145](https://github.com/user-attachments/assets/44993a66-f516-4953-a849-a534b9ac59c9)
7. **Kelola Sarana**
   ![Screenshot 2025-07-03 114152](https://github.com/user-attachments/assets/57335580-3b08-4e15-8c68-a96ad505c3c6)

9. **Kelola Divisi**
    ![Screenshot 2025-07-03 114158](https://github.com/user-attachments/assets/6ed3ae3c-8c95-4fa1-a531-037366917137)

11. **Kelola Distribusi**
    ![Screenshot 2025-07-03 114205](https://github.com/user-attachments/assets/c98fe424-c956-482a-b35d-25a97a00c4e6)

13. **Kelola Users**
    ![Screenshot 2025-07-03 114215](https://github.com/user-attachments/assets/b8cca4ad-c3f0-4bd9-aaae-d8937813eb29)


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
