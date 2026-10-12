# Secure Academic Portal — Tugas PBKK Pertemuan 5 & 6

Pengembangan dari `tugas1_5025241151_AdrianAfzalZaidana` (Laravel 13) menjadi portal akademik dengan
autentikasi **Laravel Breeze**, otorisasi multi-peran (**dosen**, **asdos**, **mahasiswa**), dan basis data
proposal proyek Agentic AI.

## Cara Menjalankan

Kebutuhan: PHP 8.3+, Composer, Node.js 20+, dan MySQL. Database aplikasi memakai MySQL sesuai tugas pertemuan 6; SQLite hanya digunakan untuk pengujian otomatis secara default.

```bash
composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate

# Buat database MySQL kosong bernama secure_academic_portal (lihat DB_* di .env), lalu:
php artisan migrate --seed

php artisan serve
```

Atur `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env` sesuai server MySQL lokal. Nama database bawaan adalah `secure_academic_portal`; buat dengan `CREATE DATABASE secure_academic_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`. Jangan sertakan `.env` dalam Git.

Pada workspace Windows ini, instance MySQL khusus proyek menggunakan port **3307** dan data di `../../.runtime/mysql-pbkk6/data`; konfigurasi aktif tersimpan di `.env`. PHP portable berada di `../../.runtime/php84`. Untuk menyalakan kembali MySQL dan aplikasi, jalankan dari folder proyek:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\start-local.ps1
```

Halaman aplikasi tersedia di `http://localhost:8000`. Pada komputer lain, gunakan server MySQL sendiri dan sesuaikan `.env`, lalu jalankan `php artisan serve`.

Reset data demo kapan saja: `php artisan migrate:fresh --seed`. Jalankan pengujian: `php artisan test`.

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
