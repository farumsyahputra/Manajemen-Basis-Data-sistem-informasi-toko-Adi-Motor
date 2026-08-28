<?php
include '../config/koneksi.php';
if (isset($_GET['KodeBarang'])) {
    $id = $_GET['KodeBarang'];
    // Hapus detail_faktur yang terkait terlebih dahulu
    mysqli_query($conn, "DELETE FROM detail_faktur WHERE KodeBarang='$id'");
    
    // Baru kemudian hapus barang
    if (!mysqli_query($conn, "DELETE FROM barang WHERE KodeBarang='$id'")) {
        die("Gagal menghapus data barang: " . mysqli_error($conn));
    }
}
header("Location:baranglihat.php");
?>