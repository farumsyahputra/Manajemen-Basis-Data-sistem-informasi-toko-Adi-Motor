<?php
include '../config/koneksi.php';
if (isset($_GET['NoFaktur'])) {
    $no = $_GET['NoFaktur'];
    // Hapus detail_faktur yang terkait terlebih dahulu
    mysqli_query($conn, "DELETE FROM detail_faktur WHERE NoFaktur='$no'");
    
    // Baru kemudian hapus faktur
    if (!mysqli_query($conn, "DELETE FROM faktur WHERE NoFaktur='$no'")) {
        die("Gagal menghapus data faktur: " . mysqli_error($conn));
    }
}
header("Location:fakturlihat.php");
?>
