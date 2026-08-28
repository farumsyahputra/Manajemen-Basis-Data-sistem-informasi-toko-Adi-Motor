<?php
include '../config/koneksi.php';
if (isset($_GET['idpegawai'])) {
    $id = $_GET['idpegawai'];
    
    // 1. Hapus detail_faktur yang terkait dengan faktur milik pegawai ini
    mysqli_query($conn, "DELETE FROM detail_faktur WHERE NoFaktur IN (SELECT NoFaktur FROM faktur WHERE IDPEGAWAI='$id')");
    
    // 2. Hapus faktur milik pegawai ini
    mysqli_query($conn, "DELETE FROM faktur WHERE IDPEGAWAI='$id'");
    
    // 3. Baru kemudian hapus pegawai
    if (!mysqli_query($conn, "DELETE FROM pegawai WHERE idpegawai='$id'")) {
        die("Gagal menghapus data pegawai: " . mysqli_error($conn));
    }
}
header("Location:pegawailihat.php");
?>