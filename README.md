# 🎓 Sistem Pendukung Keputusan SKPI

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel\&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php\&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?logo=mysql\&logoColor=white)](https://www.mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?logo=tailwindcss\&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite\&logoColor=white)](https://vite.dev)
[![PHPUnit](https://img.shields.io/badge/Testing-PHPUnit-4C51BF?logo=php\&logoColor=white)](https://phpunit.de)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

> **Aplikasi web untuk membantu perguruan tinggi mengelola data mahasiswa, aktivitas akademik dan non-akademik, organisasi, kegiatan, pencapaian, serta proses penyusunan Surat Keterangan Pendamping Ijazah (SKPI).**

---

## 📌 Tentang Project

**Sistem Pendukung Keputusan SKPI** merupakan aplikasi berbasis web yang dibangun menggunakan **Laravel 12** untuk membantu proses pengelolaan dan dokumentasi aktivitas mahasiswa secara terintegrasi.

Sistem mengelola berbagai data yang berkaitan dengan mahasiswa, organisasi, kegiatan, kehadiran, prestasi, serta sistem perhitungan poin yang dapat digunakan sebagai bagian dari proses penyusunan **Surat Keterangan Pendamping Ijazah (SKPI)**.

Dengan adanya sistem ini, proses yang sebelumnya dilakukan secara manual dapat dikelola melalui satu platform terpusat sehingga data menjadi lebih terstruktur, mudah ditelusuri, dan dapat digunakan untuk kebutuhan administrasi maupun pelaporan.

### 🎯 Tujuan

Project ini dikembangkan untuk:

* Memusatkan pengelolaan data mahasiswa.
* Mendokumentasikan aktivitas akademik dan non-akademik mahasiswa.
* Mengelola data organisasi dan keanggotaan mahasiswa.
* Mengelola kegiatan dan kehadiran mahasiswa.
* Mengotomatisasi perhitungan poin aktivitas dan prestasi.
* Mendukung proses validasi data mahasiswa.
* Membantu proses penyusunan dan penerbitan SKPI.
* Menyediakan laporan dalam format PDF dan Excel.

---

## ✨ Fitur Utama

### 🎓 Manajemen Mahasiswa

Mengelola informasi mahasiswa secara terpusat, seperti:

* NIM
* Nama mahasiswa
* Fakultas
* Program studi
* Informasi kontak
* Data aktivitas mahasiswa
* Riwayat organisasi
* Riwayat kegiatan
* Riwayat perolehan poin

---

### 🏛️ Manajemen Organisasi

Mengelola organisasi mahasiswa beserta informasi keanggotaannya.

Fitur meliputi:

* Data organisasi.
* Fakultas penyelia.
* Keanggotaan mahasiswa.
* Jabatan dalam organisasi.
* Periode kepengurusan.
* Riwayat organisasi mahasiswa.

---

### 📅 Manajemen Kegiatan

Digunakan untuk mengelola kegiatan mahasiswa.

Fitur meliputi:

* Membuat kegiatan.
* Menentukan jenis kegiatan.
* Menentukan tanggal kegiatan.
* Mengelola informasi kegiatan.
* Mengelola peserta kegiatan.
* Mencatat aktivitas mahasiswa.

---

### 🏆 Sistem Penilaian Poin

Sistem menyediakan mekanisme untuk mencatat dan menghitung poin aktivitas mahasiswa.

Poin dapat berasal dari:

* Kegiatan mahasiswa.
* Organisasi.
* Jabatan organisasi.
* Prestasi atau perlombaan.
* Tingkat kegiatan.
* Poin tambahan.
* Poin pengurangan.

Konfigurasi poin disimpan dalam sistem sehingga aturan penilaian dapat dikelola secara terstruktur.

#### Alur Perhitungan

```text
┌──────────────────────┐
│ Aktivitas Mahasiswa  │
└──────────┬───────────┘
           │
           ├───────────────┐
           ▼               ▼
     ┌───────────┐   ┌───────────┐
     │ Organisasi│   │  Kegiatan │
     └─────┬─────┘   └─────┬─────┘
           │               │
           └───────┬───────┘
                   ▼
          ┌─────────────────┐
          │ Aturan Penilaian│
          │      Poin       │
          └────────┬────────┘
                   ▼
          ┌─────────────────┐
          │  Total Poin     │
          │   Mahasiswa     │
          └─────────────────┘
```

---

### 📋 Sistem Absensi

Sistem menyediakan pencatatan kehadiran mahasiswa pada kegiatan.

Data absensi dapat digunakan untuk:

* Mencatat partisipasi mahasiswa.
* Memvalidasi keikutsertaan kegiatan.
* Mendukung dokumentasi aktivitas mahasiswa.

---

### 📄 Pembuatan SKPI

Sistem membantu menghasilkan data dan dokumen **Surat Keterangan Pendamping Ijazah (SKPI)** berdasarkan aktivitas mahasiswa yang telah tercatat.

Informasi yang dapat digunakan antara lain:

* Identitas mahasiswa.
* Fakultas dan program studi.
* Aktivitas organisasi.
* Kegiatan mahasiswa.
* Prestasi.
* Poin aktivitas.
* Informasi pendukung lainnya.

Dokumen dapat dihasilkan dalam format **PDF** untuk kebutuhan administrasi.

---

### 👥 Role-Based Access Control

Sistem menerapkan pembagian akses berdasarkan role pengguna.

| Role           | Fungsi                                       |
| -------------- | -------------------------------------------- |
| **Admin**      | Mengelola data dan konfigurasi sistem        |
| **Mahasiswa**  | Mengelola dan melihat data aktivitas pribadi |
| **Organisasi** | Mengelola organisasi dan kegiatan            |
| **Warek**      | Monitoring dan validasi data                 |

Hak akses dapat disesuaikan dengan kebutuhan dan kebijakan institusi.

---

### 📊 Export Data

Sistem menyediakan fitur export untuk mendukung kebutuhan administrasi dan pelaporan.

* 📄 **PDF** menggunakan `barryvdh/laravel-dompdf`
* 📊 **Excel** menggunakan `maatwebsite/excel`

---

## 🧰 Tech Stack

| Technology          | Purpose                      |
| ------------------- | ---------------------------- |
| **Laravel 12**      | Backend & Web Framework      |
| **PHP 8.2**         | Backend Programming Language |
| **MySQL / MariaDB** | Database                     |
| **Blade**           | Server-side Templating       |
| **Tailwind CSS**    | UI & Styling                 |
| **Vite**            | Frontend Asset Bundling      |
| **Dompdf**          | PDF Generation               |
| **Laravel Excel**   | Excel Export                 |
| **PHPUnit**         | Automated Testing            |

---

## 🏗️ Application Architecture

Aplikasi menggunakan arsitektur MVC yang disediakan oleh Laravel.

```text
┌────────────────────────────────────┐
│              Browser               │
└──────────────────┬─────────────────┘
                   │
                   ▼
┌────────────────────────────────────┐
│          Laravel Routes            │
│       Web / Authentication        │
└──────────────────┬─────────────────┘
                   │
                   ▼
┌────────────────────────────────────┐
│            Controllers             │
│          Request Handling          │
└──────────────────┬─────────────────┘
                   │
             ┌─────┴─────┐
             ▼           ▼
     ┌─────────────┐ ┌─────────────┐
     │   Models    │ │  Services   │
     │ Eloquent ORM│ │ Business    │
     │             │ │ Logic       │
     └──────┬──────┘ └─────────────┘
            │
            ▼
┌────────────────────────────────────┐
│          MySQL / MariaDB           │
└────────────────────────────────────┘
```

---

## 🗄️ Database Structure

Beberapa tabel utama yang digunakan dalam sistem:

| Table                         | Description                        |
| ----------------------------- | ---------------------------------- |
| `mahasiswas`                  | Menyimpan data mahasiswa           |
| `organisasis`                 | Menyimpan data organisasi          |
| `kegiatans`                   | Menyimpan data kegiatan            |
| `detail_organisasi_mahasiswa` | Relasi mahasiswa dengan organisasi |
| `poin_mahasiswas`             | Menyimpan riwayat poin mahasiswa   |
| `penentuan_poin`              | Menyimpan konfigurasi aturan poin  |
| `skpis`                       | Menyimpan data SKPI mahasiswa      |

Struktur database dirancang untuk menghubungkan data mahasiswa dengan aktivitas, organisasi, kegiatan, poin, dan SKPI.

---

## 📂 Project Structure

Struktur utama aplikasi Laravel:

```text
skpi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   └── ...
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── public/
├── storage/
├── .env.example
├── composer.json
├── package.json
└── vite.config.js
```

---

## 📋 Requirements

Sebelum menjalankan aplikasi, pastikan environment berikut telah tersedia:

* PHP **8.2 atau lebih baru**
* Composer
* Node.js
* npm
* MySQL atau MariaDB
* Git

Cek versi:

```bash
php -v
composer -V
node -v
npm -v
```

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/rhesap/skpi.git
cd skpi
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Database

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skpi
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan database `skpi` telah dibuat terlebih dahulu.

### 6. Run Database Migration

```bash
php artisan migrate
```

Jika project memiliki seed data:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate --seed
```

### 7. Build Frontend

Untuk development:

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 8. Run Application

Jalankan Laravel development server:

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## 🔐 Authentication & Authorization

Pengguna dapat melakukan login melalui:

```text
/login
```

Setelah berhasil melakukan autentikasi, sistem akan menentukan akses berdasarkan role pengguna.

```text
                    Login
                      │
                      ▼
               Authentication
                      │
                      ▼
                Role Checking
                      │
        ┌─────────────┼─────────────┐
        ▼             ▼             ▼
      Admin       Mahasiswa      Organisasi
        │             │             │
        └─────────────┼─────────────┘
                      │
                      ▼
                Role Dashboard
```

---

## 🔄 Main Workflow

Alur utama pengelolaan data mahasiswa:

```text
┌──────────────────┐
│ Data Mahasiswa   │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Aktivitas        │
│ Organisasi       │
│ Kegiatan         │
│ Prestasi         │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│     Absensi      │
│ & Validasi Data  │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Perhitungan Poin │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Total Poin       │
│ Mahasiswa        │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Penyusunan SKPI  │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Generate PDF     │
└──────────────────┘
```

---

## 🧪 Testing

Project menggunakan **PHPUnit** untuk automated testing.

Menjalankan seluruh test:

```bash
php artisan test
```

atau:

```bash
vendor/bin/phpunit
```

Menjalankan test dengan output lebih detail:

```bash
php artisan test -v
```

### Test Categories

Test dapat dikelompokkan menjadi:

```text
tests/
├── Feature/
│   ├── Authentication/
│   ├── Mahasiswa/
│   ├── Organisasi/
│   ├── Kegiatan/
│   └── SKPI/
│
└── Unit/
    ├── Models/
    └── Services/
```

Pastikan seluruh test berhasil sebelum melakukan merge ke branch utama.

---

## 📄 PDF Generation

Pembuatan dokumen PDF menggunakan:

```text
barryvdh/laravel-dompdf
```

Library ini digunakan untuk menghasilkan dokumen administratif seperti SKPI dan laporan dari template HTML/Blade.

---

## 📊 Excel Export

Export data ke Excel menggunakan:

```text
maatwebsite/excel
```

Fitur ini dapat digunakan untuk kebutuhan:

* Rekap mahasiswa.
* Rekap poin.
* Rekap kegiatan.
* Rekap organisasi.
* Laporan administrasi.

---

## 🔒 Security

Project menerapkan beberapa mekanisme keamanan dari Laravel, antara lain:

* Authentication.
* Authorization berdasarkan role.
* CSRF Protection.
* Input validation.
* Password hashing.
* Environment configuration.
* Protection terhadap sensitive credentials.

### Environment Security

Jangan pernah melakukan commit terhadap:

```text
.env
```

Gunakan:

```text
.env.example
```

sebagai template konfigurasi.

Sensitive information seperti password database, API key, token, dan credentials production harus disimpan melalui environment variables.

---

## 🌱 Development Workflow

Gunakan feature branch untuk mengembangkan fitur baru:

```bash
git checkout -b feature/nama-fitur
```

Setelah selesai:

```bash
git add .
git commit -m "feat: add student activity management"
git push origin feature/nama-fitur
```

Kemudian buat Pull Request menuju:

```text
main
```

### Commit Convention

Project menggunakan pola conventional commit:

```text
feat: add student activity management
fix: resolve point calculation issue
refactor: simplify student service
test: add SKPI feature tests
docs: update installation guide
chore: update dependencies
```

---

## 🗺️ Roadmap

Beberapa pengembangan yang dapat dilakukan selanjutnya:

* [ ] Dashboard analytics
* [ ] Advanced point calculation
* [ ] Notification system
* [ ] REST API
* [ ] API documentation
* [ ] QR Code pada dokumen SKPI
* [ ] Digital verification SKPI
* [ ] Audit log aktivitas pengguna
* [ ] Improved automated testing
* [ ] Production deployment

---

## 🤝 Contributing

Contributions, suggestions, dan improvements sangat terbuka.

1. Fork repository.
2. Buat feature branch.
3. Implementasikan perubahan.
4. Jalankan automated tests.
5. Pastikan tidak ada error.
6. Commit perubahan.
7. Push branch.
8. Buat Pull Request.

---

## 📄 License

Project ini menggunakan **MIT License**.

Lihat file [`LICENSE`](LICENSE) untuk informasi lebih lanjut.

---

## 👨‍💻 Author

**Rhesa Ivander Sihol Azaria Panjaitan**

Web Developer dengan fokus pada pengembangan aplikasi web menggunakan **Laravel, PHP, Vue.js, dan teknologi web modern**.

* GitHub: [@rhesap](https://github.com/rhesap)

---

<p align="center">
  Built with ❤️ using Laravel
</p>
