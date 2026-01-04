
# User Service Management

Sistem manajemen user service yang dibangun dengan CodeIgniter 4 dan Docker untuk kompatibilitas di semua perangkat.

## Deskripsi Proyek

User Service Management adalah aplikasi backend untuk mengelola data pengguna, autentikasi, dan manajemen akses pengguna dengan fitur-fitur lengkap.

## Prasyarat

- PHP 7.4+
- Composer
- Database (MySQL/MariaDB)
- Git
- Docker

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd User-Service
```

### 2. Build Docker Image
```bash
docker-compose build
```

### 3. Jalankan Docker Container
```bash
docker-compose up -d
```

### 4. Setup Environment
```bash
cp env .env
```

Edit file `.env` dan sesuaikan konfigurasi (bebas aja sebenarnya, tapi ini yang saya gunakan di project saya):
```
CI_ENVIRONMENT = development
database.default.hostname = db
database.default.database = userservice
database.default.username = user
database.default.password = password
database.default.DBDriver = MySQLi
```

### 7. Migration Database
```bash
docker-compose exec app php spark migrate
```

### 8. Seed Data (Opsional)
```bash
docker-compose exec app php spark db:seed UserSeeder
```

### 9. Akses Aplikasi
Akses di `http://localhost:8080`

## Fitur Utama

- Manajemen user
- Autentikasi & autorisasi
- Role-based access control
- API REST endpoints
