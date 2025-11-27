# Panduan Instalasi E-Mading

## Langkah-langkah Instalasi

### 1. Persiapan Environment
```bash
# Pastikan PHP 8.1+ dan Composer terinstall
php --version
composer --version
```

### 2. Setup Project
```bash
# Masuk ke direktori project
cd ujikom1

# Install dependencies
composer install

# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Setup Database
```bash
# Jalankan migration dan seeder
php artisan migrate --seed

# Buat storage link untuk upload file
php artisan storage:link
```

### 4. Jalankan Aplikasi
```bash
# Start development server
php artisan serve

# Akses aplikasi di browser: http://localhost:8000
```

## Akun Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Guru | guru | guru123 |
| Siswa | ramdhani | siswa123 |

## Struktur Aplikasi

```
ujikom1/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── ArtikelController.php
│   │   └── DashboardController.php
│   └── Models/
│       ├── User.php
│       ├── Artikel.php
│       ├── Kategori.php
│       ├── Komentar.php
│       └── Like.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   ├── auth/
│   ├── artikel/
│   └── dashboard/
└── routes/web.php
```

## Fitur yang Tersedia

✅ **Sistem Login Multi-Role**
- Admin, Guru, Siswa dengan hak akses berbeda

✅ **Manajemen Artikel**
- CRUD artikel dengan upload foto
- Status draft/published
- Approval system untuk artikel siswa

✅ **Interaksi Sosial**
- Sistem komentar
- Like/unlike artikel

✅ **Dashboard**
- Dashboard berbeda untuk setiap role
- Statistik dan laporan

✅ **Halaman Publik**
- Pengunjung dapat membaca tanpa login
- Desain responsive dengan Tailwind CSS

## Troubleshooting

### Error: Address already in use
```bash
# Gunakan port lain
php artisan serve --port=8001
```

### Error: Storage link
```bash
# Hapus link lama dan buat ulang
rm public/storage
php artisan storage:link
```

### Error: Permission denied
```bash
# Set permission untuk storage dan bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Aplikasi E-Mading siap digunakan! 🎉