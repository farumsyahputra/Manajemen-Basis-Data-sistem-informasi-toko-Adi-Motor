<?php
include '../config/koneksi.php';
if (isset($_GET['idpelanggan'])) {
    $id = $_GET['idpelanggan'];
    
    // 1. Hapus detail_faktur yang terkait dengan faktur milik pelanggan ini
    mysqli_query($conn, "DELETE FROM detail_faktur WHERE NoFaktur IN (SELECT NoFaktur FROM faktur WHERE IDPELANGGAN='$id')");
    
    // 2. Hapus faktur milik pelanggan ini
    mysqli_query($conn, "DELETE FROM faktur WHERE IDPELANGGAN='$id'");
    
    // 3. Baru kemudian hapus pelanggan
    if (!mysqli_query($conn, "DELETE FROM pelanggan WHERE idpelanggan='$id'")) {
        die("Gagal menghapus data pelanggan: " . mysqli_error($conn));
    }
}
header("Location:pelangganlihat.php");
?>