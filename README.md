# E-Mading Sekolah

Aplikasi E-Mading (Electronic Magazine Dinding) untuk sekolah yang memungkinkan siswa dan guru berkolaborasi dalam membuat dan mengelola konten artikel sekolah.

## Fitur Utama

### Untuk Siswa
- Membuat artikel baru dengan judul, isi, kategori, dan foto
- Mengedit artikel milik sendiri
- Membaca dan berkomentar pada artikel
- Memberikan like pada artikel
- Artikel disimpan sebagai draft hingga disetujui guru

### Untuk Guru/Admin
- Menulis artikel sendiri
- Mengedit semua artikel
- Melihat dan mengelola komentar
- Menyetujui artikel siswa untuk dipublikasikan
- Generate laporan artikel yang dipublikasikan
- Dashboard dengan statistik lengkap

### Untuk Pengunjung/Publik
- Membaca artikel yang sudah dipublikasikan
- Melihat artikel tanpa perlu login
- Tidak dapat menulis atau berkomentar

## Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd ujikom1
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Jalankan migration dan seeder
```bash
php artisan migrate --seed
```

6. Buat storage link
```bash
php artisan storage:link
```

7. Jalankan server
```bash
php artisan serve
```

## Akun Default

Setelah menjalankan seeder, tersedia akun berikut:

- **Admin**: username: `admin`, password: `admin123`
- **Guru**: username: `guru`, password: `guru123`  
- **Siswa**: username: `ramdhani`, password: `siswa123`

## Struktur Database

### Tabel Users
- id, nama, username, password, role (admin/guru/siswa)

### Tabel Kategoris
- id, nama_kategori

### Tabel Artikels
- id, judul, isi, tanggal, user_id, kategori_id, foto, status (draft/published)

### Tabel Komentars
- id, artikel_id, user_id, isi

### Tabel Likes
- id, artikel_id, user_id

## Alur Sistem

1. Siswa login → membuat artikel baru (judul, isi, kategori, foto)
2. Artikel disimpan sebagai draft
3. Guru/Admin memverifikasi dan mem-publish artikel
4. Artikel tampil di halaman utama e-mading
5. Siswa lain dapat memberi komentar atau like
6. Admin dapat men-generate laporan artikel yang dipublikasikan

## Desain

Aplikasi menggunakan desain modern dengan skema warna biru dan putih:
- Primary Color: #3B82F6 (Blue-500)
- Secondary Color: #1E40AF (Blue-800)
- Background: White dan Gray-50
- Menggunakan Tailwind CSS untuk styling

## Teknologi

- **Framework**: Laravel 11
- **Database**: SQLite (default) / MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage (local)

## Fitur Keamanan

- Role-based access control (Admin, Guru, Siswa)
- Siswa hanya dapat mengedit artikel milik sendiri
- Artikel siswa harus disetujui sebelum dipublikasikan
- Validasi input dan file upload
- CSRF protection

## Kontribusi

Aplikasi ini dibuat untuk keperluan ujian kompetensi keahlian (UKK) dengan fokus pada fungsionalitas minimal yang efektif.