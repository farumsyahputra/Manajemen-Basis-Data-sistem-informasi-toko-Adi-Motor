<?php
include '../config/koneksi.php';

if (isset($_GET['NoFaktur']) && isset($_GET['KodeBarang'])) {
    $NoFaktur = mysqli_real_escape_string($conn, $_GET['NoFaktur']);
    $KodeBarang = mysqli_real_escape_string($conn, $_GET['KodeBarang']);

    // Ambil subtotal (HargaJumlah) dari record yang akan dihapus
    $query = mysqli_query($conn, "SELECT HargaJumlah FROM detail_faktur WHERE NoFaktur='$NoFaktur' AND KodeBarang='$KodeBarang'");
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_array($query);
        $hargaJumlah = $data['HargaJumlah'];

        // Hapus detail barang
        mysqli_query($conn, "DELETE FROM detail_faktur WHERE NoFaktur='$NoFaktur' AND KodeBarang='$KodeBarang'");

        // Kurangi Total di faktur
        mysqli_query($conn, "UPDATE faktur SET Total = Total - $hargaJumlah WHERE NoFaktur='$NoFaktur'");
    }

    header("location:fakturdetaillihat.php?NoFaktur=$NoFaktur");
} else {
    header("location:fakturlihat.php");
}
?>
