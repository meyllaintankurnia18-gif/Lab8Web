# Lab8Web — PHP dan Database MySQL

**Mata Kuliah:** Pemrograman Web  
**Praktikum:** 8 — PHP dan Database MySQL  
**Topik:** CRUD (Create, Read, Update, Delete)

## Deskripsi
Project ini merupakan aplikasi sederhana untuk mengelola data barang menggunakan PHP dan database MySQL. Aplikasi menerapkan empat proses CRUD, yaitu menampilkan, menambahkan, mengubah, dan menghapus data barang.

## Teknologi
- PHP
- MySQL
- HTML
- CSS
- XAMPP
- phpMyAdmin

## Struktur Folder
```text
Lab8Web/
├── gambar/              # Tempat menyimpan gambar barang
├── screenshots/         # Tempat menyimpan screenshot praktikum
├── database.sql         # Query database dan tabel
├── koneksi.php          # Koneksi PHP ke MySQL
├── index.php            # Menampilkan data barang (Read)
├── tambah.php           # Menambahkan data barang (Create)
├── ubah.php             # Mengubah data barang (Update)
├── hapus.php            # Menghapus data barang (Delete)
├── style.css            # Tampilan aplikasi
└── README.md            # Dokumentasi project
```

## Langkah Instalasi dan Praktikum

### 1. Menyiapkan XAMPP
Jalankan Apache dan MySQL melalui XAMPP Control Panel.

**Screenshot:** `screenshots/01-xampp.png`

### 2. Membuat Database
Buka `http://localhost/phpmyadmin/`, pilih menu SQL, lalu jalankan seluruh perintah yang ada di file `database.sql`. Perintah tersebut membuat database `latihan1`, tabel `data_barang`, dan tiga contoh data barang.

**Screenshot:** `screenshots/02-database.png`

### 3. Menyiapkan Folder Project
Salin folder `Lab8Web` ke dalam direktori `C:/xampp/htdocs/`. Pastikan nama folder sesuai dengan alamat project.

**Screenshot:** `screenshots/03-folder-project.png`

### 4. Mengatur Koneksi Database
File `koneksi.php` digunakan untuk menghubungkan aplikasi PHP dengan database MySQL. Pengaturan bawaan XAMPP biasanya menggunakan host `localhost`, user `root`, password kosong, dan database `latihan1`.

**Screenshot:** `screenshots/04-koneksi.png`

### 5. Menampilkan Data (Read)
File `index.php` menjalankan perintah SELECT untuk mengambil data dari tabel `data_barang`, kemudian menampilkannya dalam bentuk tabel.

**Screenshot:** `screenshots/05-read.png`

### 6. Menambahkan Data (Create)
Tombol **Tambah Barang** membuka file `tambah.php`. Pengguna dapat mengisi nama, kategori, harga beli, harga jual, stok, dan gambar barang. Setelah disimpan, data masuk ke database.

**Screenshot:** `screenshots/06-create.png`

### 7. Mengubah Data (Update)
Tombol **Ubah** membuka file `ubah.php` berdasarkan ID barang. Form akan menampilkan data sebelumnya sehingga pengguna dapat memperbarui informasi barang.

**Screenshot:** `screenshots/07-update.png`

### 8. Menghapus Data (Delete)
Tombol **Hapus** menjalankan file `hapus.php` berdasarkan ID barang. Aplikasi menampilkan konfirmasi sebelum data dihapus.

**Screenshot:** `screenshots/08-delete.png`

## Cara Menjalankan
1. Pastikan Apache dan MySQL sudah aktif.
2. Pastikan database `latihan1` sudah dibuat melalui `database.sql`.
3. Simpan folder project di `C:/xampp/htdocs/Lab8Web/`.
4. Buka browser dan akses `http://localhost/Lab8Web/`.

## Hasil Praktikum
Aplikasi dapat menampilkan daftar barang dan melakukan tambah, ubah, serta hapus data. Data tersimpan pada database MySQL sehingga perubahan dapat dilihat kembali melalui aplikasi.

## Catatan Screenshot
Folder `screenshots/` sudah disiapkan. Isi dengan screenshot hasil pengerjaan sendiri pada setiap langkah. Nama file screenshot mengikuti daftar di atas.
