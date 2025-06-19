<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Skynest REST API

API backend untuk aplikasi Skynest, dibangun dengan Laravel.
Mendukung fitur transaksi penjualan, customer, sales, target, dan pelaporan bulanan.

---

## 🚀 Instalasi & Setup Awal

### 1. Clone Repository & Masuk ke Folder Project
```bash
git clone <repo-url>
cd rest-api
```

### 2. Install Dependency Composer
```bash
composer install
```

### 3. Copy File Environment & Generate Key
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rest-api
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Docker (Laravel Sail)
```bash
./vendor/bin/sail up -d
```
> Pastikan Docker sudah terinstall dan berjalan.

### 6. Migrasi & Import Data Awal
**Import database dari file SQL (otomatis refresh & import):**
```bash
php artisan db:sql import --file=Database.sql --chunk-size=50
```
> Perintah di atas akan menghapus semua data, migrasi ulang, dan mengimport data dari `database/Database.sql`.

---

## 🧪 Menjalankan Test Otomatis

Jalankan seluruh test (menggunakan Pest/Laravel test):
```bash
composer test
```
atau
```bash
./vendor/bin/pest
```

---

## 📦 Struktur Fitur Utama

- **Customer**: CRUD customer, validasi nomor telepon (Abstract API)
- **Sales Order**: Create sales order & items, validasi relasi
- **Monthly Transaction**: Laporan transaksi bulanan, target, revenue, income, performa sales
- **Repository Pattern**: Semua logic database melalui repository & interface
- **Request Validation**: Semua endpoint POST/PUT menggunakan FormRequest

---

## 📝 Catatan Pengembangan

- Semua endpoint utama terdokumentasi dengan Scribe (lihat anotasi di controller).
- Untuk pengembangan/test, gunakan database SQLite atau MySQL sesuai `.env`.
- Untuk validasi nomor telepon, set `ABSTRACT_API_KEY` di `.env` jika ingin validasi real.

---

## 💡 Perintah Penting

- Jalankan server (Sail):
  `./vendor/bin/sail up -d`
- Import database dari SQL:
  `php artisan db:sql import --file=Database.sql --chunk-size=50`
- Jalankan test:
  `composer test`

---

## 📚 Dokumentasi API

- Dokumentasi endpoint otomatis tersedia via Scribe (lihat anotasi di controller).
- Untuk endpoint dan contoh response, cek file controller terkait.
- **Akses dokumentasi API di browser:**
  Buka [http://localhost/docs](http://localhost/docs) (atau sesuai domain/project Anda) setelah menjalankan aplikasi.

---

## Lisensi

MIT License.
