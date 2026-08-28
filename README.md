# 🏍️ Sistem Informasi Toko Adi Motor

Aplikasi web manajemen toko sparepart motor berbasis **PHP Native** dan **MySQL**. Proyek ini dibuat sebagai bagian dari latihan Manajemen Basis Data (MBSD).

---

## 📋 Fitur Utama

- 🔐 **Autentikasi** — Login & logout untuk pegawai
- 📦 **Manajemen Barang** — CRUD data sparepart (tambah, lihat, ubah, hapus)
- 👥 **Manajemen Pelanggan** — CRUD data pelanggan toko
- 👷 **Manajemen Pegawai** — CRUD data pegawai toko
- 🧾 **Transaksi & Faktur** — Pembuatan faktur penjualan beserta detail item
- 🖨️ **Cetak Faktur** — Fitur cetak faktur transaksi langsung dari browser

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| PHP Native | Backend tanpa framework |
| MySQL | Database relasional |
| XAMPP | Web server lokal (Apache + MySQL) |
| HTML/CSS | Tampilan antarmuka |
| Bootstrap | Komponen UI responsif |

---

## 🗂️ Struktur Folder

```
LatihanMBSD/
├── ASSET/              # Aset statis (gambar, TTD, dll)
├── barang/             # Halaman CRUD data barang
│   ├── baranglihat.php
│   ├── barangtambah.php
│   ├── barangubah.php
│   └── baranghapus.php
├── config/             # Konfigurasi aplikasi
│   ├── koneksi.php     # Koneksi database
│   └── sidebar.php     # Komponen sidebar navigasi
├── faktur/             # Halaman transaksi & faktur
│   ├── fakturlihat.php
│   ├── fakturtambah.php
│   ├── fakturubah.php
│   ├── fakturhapus.php
│   ├── fakturdetaillihat.php
│   ├── fakturdetailtambah.php
│   ├── fakturdetailubah.php
│   ├── fakturdetailhapus.php
│   └── fakturcetak.php
├── pegawai/            # Halaman CRUD data pegawai
├── pelanggan/          # Halaman CRUD data pelanggan
├── dashboard.php       # Halaman utama dashboard
├── index.php           # Halaman awal / redirect
├── login.php           # Halaman login
├── logout.php          # Proses logout
└── toko_adi_motor.sql  # File database SQL
```

---

## ⚙️ Cara Instalasi

### Prasyarat
- [XAMPP](https://www.apachefriends.org/) (PHP 7.4+ & MySQL)
- Browser modern (Chrome, Firefox, Edge)

### Langkah-langkah

**1. Clone atau download repositori ini**
```bash
git clone https://github.com/farumsyahputra/Manajemen-Basis-Data-sistem-informasi-toko-Adi-Motor.git
```
Letakkan folder di dalam direktori `htdocs` XAMPP:
```
C:\xampp\htdocs\LatihanMBSD\
```

**2. Import database**

- Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
- Buat database baru bernama `toko_adi_motor`
- Pilih database tersebut, klik tab **Import**
- Pilih file `toko_adi_motor.sql` dari folder proyek ini, lalu klik **Go**

**3. Konfigurasi koneksi database**

Buka file `config/koneksi.php` dan sesuaikan pengaturan berikut jika diperlukan:

```php
<?php
$conn = mysqli_connect("localhost", "root", "", "toko_adi_motor");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

| Parameter | Default | Keterangan |
|-----------|---------|------------|
| Host | `localhost` | Host MySQL |
| Username | `root` | Username MySQL (default XAMPP) |
| Password | `""` | Password MySQL (kosong untuk XAMPP default) |
| Database | `toko_adi_motor` | Nama database |

**4. Jalankan aplikasi**

- Pastikan **Apache** dan **MySQL** sudah berjalan di XAMPP Control Panel
- Buka browser dan akses:
```
http://localhost/LatihanMBSD/
```

---

## 🖥️ Screenshot

> Dashboard dan halaman utama aplikasi Toko Adi Motor

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan edukasi dan latihan mata kuliah **Manajemen Basis Data**.

---

## 👨‍💻 Developer

**Farum Syah Putra**  
Sistem Informasi Toko Adi Motor 
