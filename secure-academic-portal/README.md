# Secure Academic Portal — Tugas PBKK Pertemuan 5 & 6

Pengembangan dari `tugas1_5025241151_AdrianAfzalZaidana` (Laravel 13) menjadi portal akademik dengan
autentikasi **Laravel Breeze**, otorisasi multi-peran (**dosen**, **asdos**, **mahasiswa**), dan basis data
proposal proyek Agentic AI.

## Cara Menjalankan

Panduan berikut dapat digunakan untuk menyiapkan dan menjalankan aplikasi di komputer masing-masing. Semua perintah terminal dijalankan dari folder `secure-academic-portal`, yaitu folder yang berisi file `artisan` dan `composer.json`.

### Persiapan

Siapkan **PHP 8.3+** (disarankan PHP 8.4), **Composer**, **Node.js 20.19+ pada versi 20 atau 22.12+**, dan **MySQL**. Pastikan perintah `php`, `composer`, `node`, dan `npm` tersedia di terminal, serta ekstensi PHP `pdo_mysql` aktif.

Database aplikasi memakai MySQL sesuai tugas pertemuan 6. SQLite hanya digunakan untuk pengujian otomatis secara default.

### Setup awal (cukup sekali)

1. Unduh atau clone repositori, lalu buka folder **`secure-academic-portal`** di VS Code melalui **File → Open Folder**. Buka terminal melalui **Terminal → New Terminal** atau tekan **Ctrl + `**. Pada Windows, gunakan **PowerShell**.

2. Instal dependensi dan bangun aset tampilan:

   ```powershell
   composer install
   npm install
   npm run build
   ```

3. Buat konfigurasi aplikasi dari contoh yang tersedia, lalu buat application key:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   Pada Linux atau macOS, gunakan `cp .env.example .env` sebagai pengganti `Copy-Item`.

4. Nyalakan layanan **MySQL** pada komputer tersebut. Jika menggunakan XAMPP, buka **XAMPP Control Panel**, lalu klik **Start** pada **MySQL**.

5. Buat database melalui phpMyAdmin atau klien MySQL. Jalankan SQL berikut di menu atau klien SQL:

   ```sql
   CREATE DATABASE secure_academic_portal
   CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. Buka file `.env` dan sesuaikan koneksi dengan MySQL yang digunakan. Contoh untuk MySQL lokal dengan pengguna `root` tanpa password:

   ```dotenv
   APP_ENV=local
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=secure_academic_portal
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Sesuaikan `DB_PORT`, `DB_USERNAME`, dan `DB_PASSWORD` jika pengaturan MySQL berbeda. Simpan file `.env` dan jangan sertakan file tersebut dalam Git.

7. Buat tabel dan isi data demo:

   ```powershell
   php artisan config:clear
   php artisan migrate --seed
   ```

8. Jalankan aplikasi dengan langkah pada bagian berikut.

### Menyalakan aplikasi setelah setup

1. Nyalakan **MySQL**.

2. Buka terminal di folder **`secure-academic-portal`**, lalu jalankan:

   ```powershell
   php artisan serve --host=127.0.0.1 --port=8000
   ```

3. Tunggu hingga terminal menampilkan `Server running on [http://127.0.0.1:8000]`. Biarkan terminal tetap terbuka selama aplikasi digunakan.

4. Buka **[http://localhost:8000](http://localhost:8000)** di browser pada komputer yang menjalankan aplikasi. Untuk masuk, buka **[halaman login](http://localhost:8000/login)** dan gunakan akun pada bagian **Akun Demo** di bawah.

Setelah komputer dinyalakan ulang, cukup ulangi langkah pada bagian **Menyalakan aplikasi setelah setup**. Untuk menghentikan server aplikasi, tekan **Ctrl + C** pada terminal tersebut.

### Data demo dan pengujian

Untuk menghapus seluruh data aplikasi dan membuat ulang data demo, jalankan `php artisan migrate:fresh --seed`. Jalankan pengujian dengan `php artisan test`.

Profil (`nrp`, `nip`, `department`, `bio`), proposal, dan riwayat tugas sekarang disimpan di database. Dosen memakai NIP, sedangkan mahasiswa dan asdos memakai NRP; kedua nomor disimpan pada kolom terpisah dan unik. Profil dapat disunting melalui `/profile`; riwayat tugas dapat ditambah dan dihapus melalui `/dashboard`. Halaman publik menampilkan akun `PORTFOLIO_PUBLIC_EMAIL` (bawaan `mahasiswa@student.its.ac.id`); pengguna yang login melihat portofolionya sendiri. API key tidak ditampilkan pada halaman publik.

Untuk database lama, jalankan `php artisan migrate`, lalu `php artisan db:seed --class=PortfolioSeeder` untuk melengkapi data portofolio demo tanpa menghapus proposal yang ada. Seeder ini dapat dijalankan ulang tanpa menggandakan riwayat tugas bawaan.

Format PHP menggunakan PSR-12 melalui `pint.json`. Jalankan `vendor/bin/pint` untuk merapikan kode atau `vendor/bin/pint --test` untuk memeriksa format. Pengujian pada MySQL harus memakai database khusus pengujian, bukan `secure_academic_portal`, karena suite menggunakan `RefreshDatabase`.

## Akun Demo (password semua: `password`)

| Peran | Email |
|---|---|
| Dosen (akun penguji, punya 2 proposal siap pakai) | `dosenpbkk@its.ac.id` |
| Asisten Dosen | `asdospbkk@its.ac.id` |
| Mahasiswa | `mahasiswa@student.its.ac.id` |

Seeder juga membuat 15 mahasiswa acak, masing-masing dengan 2 proposal dummy. Saat `APP_ENV=local`,
halaman login menampilkan tombol **Login sebagai Dosen / Asdos / Mahasiswa** (tanpa ketik sandi).

## Area Halaman

| Area | URL | Akses |
|---|---|---|
| Publik | `/`, `/about`, `/project-idea`, `/hitung/{a}/{b}/{operasi}` | Bebas |
| Mahasiswa | `/dashboard`, `/projects/create`, `/projects/{id}/edit` | User login |
| Dosen/Asisten | `/admin`, `/admin/projects/{id}/nilai` | Role `dosen` atau `asdos` |

## Pemetaan Spesifikasi Tugas

### Pertemuan 5 — Middleware, Autentikasi, & Otorisasi

| Spesifikasi | Implementasi |
|---|---|
| Laravel Breeze (register & login) | `laravel/breeze` stack Blade: `routes/auth.php`, `app/Http/Controllers/Auth/*` |
| Kolom `role` lewat migration tambahan | `database/migrations/2026_10_12_000001_add_role_to_users_table.php` (enum, default `mahasiswa`). `role` tidak ada di fillable, jadi pendaftar baru tidak bisa memilih peran sendiri |
| Custom middleware alias `cek.peran` | `app/Http/Middleware/CekPeran.php`, didaftarkan di `bootstrap/app.php` |
| Group `/admin` khusus dosen/asdos | `routes/web.php` → `middleware(['auth', 'cek.peran:dosen,asdos'])`, user lain mendapat 403 dengan pesan (`resources/views/errors/403.blade.php`) |
| Gate global | `kelola-nilai` di `app/Providers/AppServiceProvider.php`, dicek dengan `Gate::authorize()` di `Admin/AdminController` |
| Policy model | `app/Policies/ProjectPolicy.php` — hanya pembuat proposal yang boleh menyunting/menghapus; dipanggil via `Gate::authorize('update', $project)` |
| Blade `@can` | Link **Input Nilai** di navigasi, dashboard, dan panel admin dibungkus `@can('kelola-nilai')`; tombol Edit/Hapus dibungkus `@can('update'/'delete', $project)` |
| A+ Rate limiting | Limiter `submit-proposal` (3 kali/menit per user) dipasang pada `POST /projects` |
| A+ Auto-login | Route `/login/as/{role}` (hanya `local`) + tombol di `resources/views/auth/login.blade.php` |

### Pertemuan 6 — Migration, Eloquent, Factory & Seeder

| Spesifikasi | Implementasi |
|---|---|
| Tabel `users` bawaan Breeze, email `unique()` | migration bawaan `0001_01_01_000000_create_users_table.php` |
| Tabel `projects` (judul, deskripsi, tema_agent, api_key_secure, user_id) | `database/migrations/2026_10_12_000002_create_projects_table.php`, ditambah `nilai` & `catatan_review` untuk area dosen |
| FK `user_id` → `users.id` cascade | `foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete()` |
| `nullable()` deskripsi, `default('Ollama')` tema_agent | ada di migration projects |
| `$fillable` pada model `Project` | `app/Models/Project.php` — hanya `judul`, `deskripsi`, `tema_agent`, `api_key_secure`; `api_key_secure` juga di-cast `encrypted` dan `hidden` |
| `ProjectFactory` realistis | `database/factories/ProjectFactory.php` |
| 15 mahasiswa × 2 project + akun `dosenpbkk@its.ac.id` | `database/seeders/DatabaseSeeder.php` |
| Query dashboard hanya project milik user login, terbaru dulu | `app/Http/Controllers/DashboardController.php` → `$user->projects()->latest()->get()` |

Profil dinamis ditambahkan lewat migration `add_portfolio_fields_to_users_table`. Riwayat tugas memakai model `CourseTask` dan tabel `course_tasks` dengan FK cascade ke pengguna. Keduanya diuji pada `PortfolioTest` dan `CourseTaskTest`.

Semua aturan di atas diuji di `tests/Feature/SecurePortalTest.php`.
