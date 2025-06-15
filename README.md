# 🧭 Carikeun - Sistem Lost and Found Kampus Berbasis Web

**Carikeun** adalah sistem berbasis website yang dikembangkan untuk membantu sivitas kampus Telkom University dalam menangani kasus kehilangan dan penemuan barang. Sistem ini hadir sebagai solusi digital yang terpusat untuk menggantikan metode manual yang selama ini digunakan, seperti bertanya ke petugas keamanan atau menyebarkan informasi melalui media sosial seperti akun Instagram [@lostandfound.telu](https://www.instagram.com/lostandfound.telu).

## 📌 Latar Belakang

Di lingkungan kampus, kasus kehilangan barang pribadi cukup sering terjadi. Sayangnya, proses pelacakan masih mengandalkan cara-cara konvensional yang tidak efisien dan berisiko hilangnya informasi penting. **Carikeun** hadir untuk mengatasi masalah ini dengan sistem pelaporan dan pencarian barang yang lebih terstruktur, terdokumentasi, dan dapat diakses secara daring.

## 🚀 Fitur Utama

- **Pelaporan Barang Hilang**  
  Pengguna dapat melaporkan detail barang hilang secara digital dan terpusat.

- **Pelaporan Barang Ditemukan**  
  Individu yang menemukan barang dapat memposting informasi barang tersebut melalui sistem resmi.

- **Pencocokan Data Otomatis**  
  Sistem akan mencocokkan laporan barang hilang dan ditemukan secara otomatis untuk mempercepat identifikasi.

- **Dokumentasi & Histori**  
  Semua laporan dan interaksi disimpan sebagai rekam jejak yang dapat ditelusuri.

- **Pengelolaan Terpusat**  
  Data barang hilang dan ditemukan dikelola dalam satu sistem basis data yang terintegrasi.

## 🎯 Manfaat Penggunaan

- **Meningkatkan Peluang Pengembalian Barang**  
  Sistem yang terpusat meningkatkan efektivitas pencarian barang.

- **Efisiensi Waktu & Tenaga**  
  Mengurangi proses manual baik bagi pengguna maupun petugas kampus.

- **Transparansi & Akuntabilitas**  
  Proses klaim lebih objektif dan terdokumentasi dengan baik.

- **Aksesibilitas Tinggi**  
  Sistem dapat diakses kapan saja dan di mana saja melalui perangkat yang terhubung ke internet.

- **Membangun Budaya Peduli**  
  Mendorong warga kampus untuk lebih bertanggung jawab dalam membantu sesama.

## 👥 Target Pengguna

- **Admin**  
  Bertanggung jawab untuk mengelola dan memverifikasi data barang hilang dan ditemukan di seluruh area Telkom University.

- **Pengguna Umum (Mahasiswa/Dosen/Staf)**  
  Dapat mengajukan laporan barang hilang atau memposting barang yang ditemukan di lingkungan kampus.

---

## 📦 Instalasi & Cara Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project **Carikeun** secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/fadiarizqa/TUBES-WAD.git
cd TUBES-WAD
```

### 2. Install Dependencies
- **Backend Laravel**
  ```bash
  composer install
  ```
- **Frontend (Tailwind CSS + Vite)**
  ```bash
  npm install
  ```
### 3. Konfigurasi Environment
- **Salin file `.env.example` menjadi `.env`
  ```bash
  cp .env.example .env
  ```
- **Generate application key
  ```bash
  php artisan key:generate
  ```
### 4. Setup Database
- Buat database baru di MySQL (contoh: carikeun_db)
- Atur konfigurasi DB di file `.env`
- Jalankan migrasi
  ```bash
  php artisan migrate
  ```
### 5. Jalankan Project
- Jalankan server Laravel
  ```bash
  php artisan serve
  ```
- Jalankan Vite (Frontend & Tailwind CSS)
  ```bash
  npm run dev
  ```

## 👨‍👩‍👧‍👦 Identitas Kelompok

| No | Nama                            | NIM           | Peran                                                                                                          | Username GitHub       |
|----|---------------------------------|---------------|---------------------------------------------------------------------------------------------------------------|------------------------|
| 1  | Muhammad Fadli Deandri Putra    | 102022300018  | **Pengguna:** Mengklaim Barang Hilang  <br> **Admin:** Login, Melihat Report Postingan, Ubah Status, Hapus Postingan | `deandri3000`          |
| 2  | Mellafesa Rofida                | 102022330095  | **Pengguna:** Registrasi, Login, Edit Postingan, Hapus Postingan, Buat Postingan Barang Ditemukan             | `Mellafesa`            |
| 3  | Casta Garneta                   | 102022330303  | **Pengguna:** Klaim Barang Hilang, Lihat Status Riwayat Klaim  <br> **Admin:** Lihat Pengajuan, Hapus, Ubah Status | `castagh`, `casagh`    |
| 4  | Naufal Rahmat Muzakky           | 102022300167  | **Pengguna:** Buat Postingan Barang Hilang, Edit & Hapus Foto Profil                                          | `Marcy545`             |
| 5  | Fadia Rizqa Yunanto             | 102022300333  | **Pengguna:** Lihat Riwayat Postingan, Komentar (Buat/Edit/Hapus), Registrasi, Login                          | `fadiarizqa`           |
