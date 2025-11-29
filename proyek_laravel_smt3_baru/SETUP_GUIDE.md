# 🚀 Panduan Setup Project untuk Teman

## ⚠️ Masalah: ERR_TOO_MANY_REDIRECTS

Error ini terjadi karena **database belum di-setup**. Ikuti langkah berikut:

## 📋 Langkah Setup (WAJIB URUT!)

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Setup Environment

```bash
# Copy file .env.example ke .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Konfigurasi Database

Buka file `.env` dan ubah:

```env
DB_DATABASE=laravel       # Nama database kamu
DB_USERNAME=root          # Username MySQL kamu
DB_PASSWORD=              # Password MySQL kamu (kosong jika default)
```

### 4. Buat Database

Buka phpMyAdmin atau MySQL dan jalankan:

```sql
CREATE DATABASE laravel;
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Jalankan Server

```bash
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

## 🔧 Jika Masih Error

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Cek Database Connection

```bash
php artisan migrate:status
```

### Cek Log Error

Buka file: `storage/logs/laravel.log`

## ✅ Checklist

-   [ ] MySQL/XAMPP sudah jalan
-   [ ] Database sudah dibuat
-   [ ] File .env sudah dikonfigurasi
-   [ ] Migration sudah dijalankan
-   [ ] composer install berhasil
