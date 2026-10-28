# Data Siswa

Aplikasi web sederhana untuk mengelola data siswa. Aplikasi dibuat dengan CodeIgniter 4 dan menyediakan antarmuka responsif untuk melihat, mencari, menambah, mengedit, dan menghapus data siswa.

## Fitur

- Daftar siswa berisi NIS, nama, dan kelas.
- Pencarian berdasarkan NIS, nama, atau kelas.
- Pagination pada tabel.
- Tambah, edit, dan hapus data tanpa memuat ulang halaman.
- Pilihan kelas yang tersedia: `X RPL`, `XI RPL`, `XII RPL`, `X BC`, `XI BC`, `XII BC`, `X MM`, `XI MM`, dan `XII MM`.
- Antarmuka responsif menggunakan Tailwind CSS dan Alpine.js melalui CDN.

## Teknologi

- PHP 8.2 atau lebih baru
- CodeIgniter 4
- MySQL atau MariaDB
- Tailwind CSS dan Alpine.js (dimuat dari CDN)

## Persyaratan

- PHP 8.2+
- Ekstensi PHP `intl` dan `mbstring`
- Ekstensi `mysqli` untuk koneksi database MySQL/MariaDB
- Composer
- MySQL atau MariaDB

## Menjalankan secara lokal

1. Clone atau salin project ke komputer, lalu buka direktori project di terminal.
2. Pasang dependency PHP:

   ```sh
   composer install
   ```

3. Buat database MySQL, misalnya `ci_siswa`.
4. Buat tabel `siswa` dengan struktur berikut:

   ```sql
   CREATE TABLE siswa (
       id INT UNSIGNED NOT NULL AUTO_INCREMENT,
       nis VARCHAR(30) NOT NULL,
       nama VARCHAR(150) NOT NULL,
       kelas VARCHAR(20) NOT NULL,
       PRIMARY KEY (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
   ```

5. Atur koneksi database pada file `.env` di root project. Jika belum memiliki file tersebut, salin `env` menjadi `.env`, lalu isi atau sesuaikan konfigurasi berikut:

   ```ini
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = ci_siswa
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   Sesuaikan nama database, username, password, dan port dengan konfigurasi MySQL lokal Anda. Jangan menyimpan kredensial database produksi ke dalam repository.

6. Jalankan server pengembangan CodeIgniter:

   ```sh
   php spark serve
   ```

7. Buka [http://localhost:8080](http://localhost:8080).

### Menggunakan Laragon

Letakkan project di direktori `www` Laragon dan pastikan Apache/Nginx serta MySQL berjalan. Atur document root virtual host ke direktori `public` project. Sesuaikan `app.baseURL` di `.env` dengan URL lokal Laragon yang digunakan. Jangan arahkan document root web server ke root project karena folder `public` adalah entry point aplikasi.

## Endpoint

| Method | Path | Keterangan |
| --- | --- | --- |
| `GET` | `/` | Menampilkan daftar siswa |
| `POST` | `/home/tambah` | Menambahkan siswa |
| `POST` | `/home/edit` | Memperbarui siswa |
| `POST` | `/home/hapus/{id}` | Menghapus siswa |

Operasi formulir mengembalikan JSON untuk permintaan AJAX dan juga mendukung pengiriman formulir biasa.

## Struktur kode utama

```text
app/
├── Config/Routes.php          # Pemetaan route aplikasi
├── Controllers/Home.php       # Daftar dan operasi CRUD siswa
├── Models/siswamodel.php      # Model tabel siswa
└── Views/siswa.php            # Halaman daftar, formulir, dan interaksi UI
public/
└── index.php                  # Entry point web
```

## Menjalankan pengujian

Jika dependency pengembangan sudah terpasang, jalankan:

```sh
composer test
```

Atau pada Windows:

```powershell
vendor\bin\phpunit
```
