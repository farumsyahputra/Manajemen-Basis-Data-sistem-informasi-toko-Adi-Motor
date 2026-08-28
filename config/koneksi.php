\<?php
// Menggunakan variabel $conn agar sesuai dengan kode yang Anda kirim
$conn = mysqli_connect("localhost", "root", "", "toko_adi_motor");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>