# 📦 Aplikasi Inventaris Sederhana

Aplikasi berbasis **Laravel** untuk mengelola data produk, kategori, dan stok dengan antarmuka yang sederhana namun fungsional.  
✅ Status: **Stable Release**

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![Release](https://img.shields.io/badge/Version-1.0.0-blue)
![License](https://img.shields.io/badge/License-MIT-green)

---

## ✨ Fitur Utama
- CRUD Produk (tambah, edit, hapus)
- Manajemen kategori
- Export data ke CSV
- Autentikasi user & halaman profil
- Dashboard dengan statistik inventaris

---

## 📸 Demo
![Dashboard Screenshot](docs/images/dashboard.png)

---

## 🚀 Instalasi
```bash
git clone https://github.com/Oksipituaja/Aplikasi-Invetaris-Sederhana.git
cd Aplikasi-Invetaris-Sederhana
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
