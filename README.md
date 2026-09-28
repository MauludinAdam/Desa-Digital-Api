# Desa Digita Api

Restful API untuk aplikasi Desa Digital, sebuah sistem informasi desa yang digunakan untuk mengelola administrasi, data kependudukan, surat-menyurat, bantuan sosial dan operasional BUMDes.

Backend API dibangun menggunakan Laravel 12 dengan autentikasi berbasis Laravel Sanctum serta manajemen role dan permission menggunakan Spatie Laravel Permission. 

## Features.
## Authentication
- Login 
- Logout
- Get Authenticated user
- Token-base Authentication menggunakan laravel Sanctum
- Role & permission authorization 

## User Manajemen

- CRUD User
- User Profile
- Role manajemen
- Permission manajemen
- Assign role kepada user

## Manajemen Penduduk
- CRUD data penduduk
- CRUD kartu keluarga
- Relasi penduduk dengan kartu keluarga
- Data pekerjaan
- Data pendidikan
- Data status perkawinan
- Search dan pagination

## Manajemen Surat
- Pengajuan surat
- Pengelolaan jenis surat
- Upload lampiran
- Approval surat oleh kepala desa
- Reject surat
- Generate nomor surat
- validasi data penduduk

## Bantuan Sosial
- CRUD kategori bantuan sosial
- CRUD program bantuan
- CRUD penerima bantuan sosial
- Approval penerima bantuan sosial
- Reject penerima bantuan sosial
- Pencatatan status pencairan bantuan

## BUMDes
- BUMDes Profile
- Product manajemen
- Product barcode
- Stock manajemen
- Sales manajemen
- Sales item manajemen / POS / KASIR
- Transaksi
- Stock berkurang otomatis setelah transaksi
- Generate invoice
- Riwayat transaksi
- Export excel
- Print PDF
- BUMDes dashboard

## Dashboard
- Dashboard administrasi desa
- Statistik penduduk
- Statistik gender
- Statistik pendidikan
- Statistik umur
- Dashboard BUMDes
- Statistik bantuan sosial
- Statistik transaksi dan penjualan


## Tech Stack
| Technology | Version |
|----------|--------|
| `PHP` | 8.2+ |
| `Laravel` | 12 |
| `Mysql` | 8+ |
| `Postmant` | API Testing |
| `VS Code` | Tools Menulis Code |
| `Xampp` | 3.3.0 |

## Requirements
Sebelum menjalankan project, pastikan environment sudah meiliki:
- PHP 8.2+
- Composer
- Mysql
- Apache
- Git
- Postmant

## Instalation
1.Clone Repository
 https://github.com/MauludinAdam/Desa-Digital-Api.git
 Masuk ke directory project
 cd Desa-Digital-Api
2. Install Dependencies
   composer Install
3. Copy Environment File
   cp .env.example .env
   untuk windows:
   copy .env.example .env
4. Generate Application Key
   php artisan serve
   
## Konfigurasi Database
Buat database Mysql terlebih dahulu.
Contoh: CREATE DATABASE desa_digital.

APP_NAME=Laravel, 
APP_ENV=local,
APP_KEY=,
APP_DEBUG=true,
APP_URL=http://localhost,

DB_CONNECTION=mysql,
DB_HOST=127.0.0.1,
DB_PORT=3306,
DB_DATABASE=desa-digital,
DB_USERNAME=root,
DB_PASSWORD=,

Sesuaikan Konfigurasi database dengan environment masing-masing.

## Migration
Jalankan migration:
php artisan migrate
jika project menggunakan seeder:
php artisan db:seed
atau
php artisan migrate --seede

## Authentication
API menggunakan Laravel Sanctum untuk autentikasi.
Setelah login berhasil, API akan memberikan autentikasi token.
Contoh: POST /api/login
Request:
{
    "emali": "admin@gmail.com",
    "password": "admin123"
}

Response:
{
    "success": true,
    "message": "Login Berhasil",
    "data": {
        "user": {
          "id": "213232",
          "name": "Admin",
          "email": "admin@gmail.com"
        },
        "token": "1|34343rrersrer345"
    }
}

Token digunakan pada endpoint yang membutuhkan autentikasi:
Authorization: Bearer {token}

## Roles & Permission
Role Utama:
1 Admin
admin memiliki akses untuk mengelola administrasi desa seperti:
- User
- Penduduk
- Kartu keluarga
- Surat
- Bantuan Sosial
- Master Data
- Profile Desa

2 Kepala Desa
 Kepala desa memiliki akses untuk:
 - Melihat data administrasi
 - melihat dashboard
 - Approval Surat
 - Approval Bantuan Sosial
 - Melihat data BUMDes
 - Melihat dashboard BUMDes

3 Operator BUMDes
Operator BUMDes memiliki akses untuk:
- Mengelola produk
- Mengelola Stok
- Mengelola Transaksi
- Mengelola Sales
- Mengelola Sales Item
- Mengakses POS / KASIR
- Export Laproan Transaksi

## API Endpoint
Base URL:
http://localhost:8000/api

Authentication
| Method | Endpoint | Description |
|:--------|:------:|------:|
| Post | /login | Login |
| Post | /logout | Logout |
| Get | /me | Get authenticated |

## users
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /user | Get user |
| POST | /user | Create user |
| GET | /user/{id} | Get user detail |
| PUT | /user/{id} | Update user |
| DELETE | /user/{id} | Delete user |

## Roles
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /roles | Get role |
| POST | /roles | Create role |
| GET | /roles/{id} | Get role detail |
| PUT | /roles/{id} | Update role |
| DELETE | /roles/{id} | Delete role |

## Citizens
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /citizens | Get citizens |
| POST | /citizens | Create citizen |
| GET | /citizens/{id} | Get citizens detail |
| PUT | /citizens/{id} | Update citizen |
| DELETE | /citizens/{id} | Delete citizen |

## Family Cards
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /family-card | Get family card |
| POST | /family-card | Create family card |
| GET | /family-card/{id} | Get family card detail |
| PUT | /family-card/{id} | Update family card |
| DELETE | /family-card/{id} | Delete family card |

## BUMDes Product
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /bumdes-product | Get product |
| POST | /bumdes-product | Create product |
| GET | /bumdes-product/{id} | Get product detail |
| PUT | /bumdes-product/{id} | Update product |
| DELETE | /bumdes-product/{id} | Delete product |

## BUMDes Sales
| Method | Endpoint | Description |
|:--------|:------:|------:|
| GET | /bumdes-sales | Get sales |
| POST | /bumdes-sales | Create sales |
| GET | /bumdes-sales/{id} | Get sales detail |
| PUT | /bumdes-sales/{id} | Update sales |
| DELETE | /bumdes-sales/{id} | Delete sales |

## API Response Format
API menggunakan format response yang konsisten.

Success
{
    "success": true,
    "message": "Data berhasil diambil",
    "data": {}
}

Error
{
    "success": false,
    "message": "Data tidak ditemukan",
    "data": null,
}


## Pagination
Endpoint yang menggunakan pagination memiliki response seperti:
{
    "success": true'
    "message": "Data berhasil diambil",
    "data": {
      "data": [],
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 100
    }
}


## API Testing
API dikembangkan dan diuji mengguanakan Postman.

Testing mencakup:
- Authentication
- CRUD
- Validation
- Authorization
- Role & Permission
- Pagination
- Search
- File Upload
- Approval
- Transaksi
- Stock Manajemen
- API Error Handling

Postman Collection dapat disimpan pada Repository:
/docs/postman

## Struktur project
desa-digital-api/
├── app/ 
│   ├── Export/
│   ├── Helpers/
│   ├── Http/ 
│   │    ├── Controllers/ 
│   │    ├── Middleware/ 
│   │    ├── Requests/ 
│   │    └── Resources/ 
│   │ 
│   ├── Models/ 
│   ├── Notifikations/ 
│   ├── Providers/ 
│   ├── Traits/ 
│   │ 
│   │ 
│   ├── Helpers/ 
│   │ 
│   └── Traits/
│
├── config/
├── database/
│     ├── migrations/
│     └── seeders/
│
├── routes/
│    └── api.php/
│
├── storage/
├── test/
├── env.example/
├── gitignore/
├── artisan/
├── composer.json/
└── README.md/

## Running Application
jalankan development serve:
php artisan serve
API dapat diakses melalui
http://127.0.0.1:8000


## Clear Cache
Jika terjadi masalah Konfigurasi atau route:
php artisan optimize:clear

atau secara terpisah:
php artisan config:clear
php artisan route:clear
php artisan cache:clear

## Security
Beberapa mekanisme keamanan yang digunakan:
- Laravel Sanctum authentication
- Role-based authorization
- Permission-based authentication
- Form Request Validation
- API rate limiting
- CSRF protection sesuai kebutuhan
- Mass assignment protection
- Input validation
- Soft delete untuk data tertentu

## Development
- Eloquent ORM
- Api Resource
- Form Request
- Middleware
- UUID
- Soft Delete
- Pagination
- Search & Filtering
- Centralized API response

## Author
Mauludin Adam
Backend Development -- Laravel & REST API
Project: Desa Digital


## License
Project ini kembangkan untuk portofolio dan bertujuan untuk edukasi

