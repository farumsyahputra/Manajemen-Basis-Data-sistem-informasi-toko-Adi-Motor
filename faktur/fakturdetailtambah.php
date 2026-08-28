<?php
include '../config/koneksi.php';

// Cek parameter
if (!isset($_GET['NoFaktur'])) {
    header("location:fakturlihat.php");
    exit;
}
$NoFaktur = mysqli_real_escape_string($conn, $_GET['NoFaktur']);

if (isset($_POST['proses'])){
    $kodeBarang = $_POST['KodeBarang'];
    $jumlahBarang = (int)$_POST['JumlahBarang'];
    
    // Ambil Harga Satuan dari tabel barang
    $qBarang = mysqli_query($conn, "SELECT HargaSatuan FROM barang WHERE KodeBarang = '$kodeBarang'");
    $bData = mysqli_fetch_array($qBarang);
    $hargaSatuan = $bData['HargaSatuan'];
    
    // Hitung subtotal (HargaJumlah)
    $hargaJumlah = $hargaSatuan * $jumlahBarang;
    
    // Insert ke detail_faktur
    // Kita gunakan REPLACE INTO atau INSERT INTO .. ON DUPLICATE KEY UPDATE jika ingin menumpuk
    // Namun desain awal database mungkin akan error jika KodeBarang sama dimasukkan 2x karna primary key nya (NoFaktur, KodeBarang).
    // Kita gunakan cek apakah sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM detail_faktur WHERE NoFaktur='$NoFaktur' AND KodeBarang='$kodeBarang'");
    if(mysqli_num_rows($cek) > 0){
        // Jika sudah ada, tambahkan jumlah dan hargajumlah
        $ex = mysqli_fetch_array($cek);
        $newJml = $ex['JumlahBarang'] + $jumlahBarang;
        $newHrg = $ex['HargaJumlah'] + $hargaJumlah;
        mysqli_query($conn, "UPDATE detail_faktur SET JumlahBarang='$newJml', HargaJumlah='$newHrg' WHERE NoFaktur='$NoFaktur' AND KodeBarang='$kodeBarang'");
    } else {
        mysqli_query($conn, "INSERT INTO detail_faktur (NoFaktur, KodeBarang, JumlahBarang, HargaJumlah) VALUES ('$NoFaktur', '$kodeBarang', '$jumlahBarang', '$hargaJumlah')");
    }
    
    // Update Total di tabel faktur
    mysqli_query($conn, "UPDATE faktur SET Total = Total + $hargaJumlah WHERE NoFaktur = '$NoFaktur'");
    
    header("location:fakturdetaillihat.php?NoFaktur=$NoFaktur");
    exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Faktur</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Detail Faktur</span>
        </div>
        <div class="topbar-title">Tambah Barang</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-cart-plus" style="color:#22c55e;margin-right:8px;"></i>Tambah Item ke Nota: <?php echo $NoFaktur; ?></span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">Pilih Barang</label>
                    <select name="KodeBarang" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php
                        $qBrg = mysqli_query($conn, "SELECT KodeBarang, NamaBarang, HargaSatuan FROM barang ORDER BY NamaBarang ASC");
                        while($b = mysqli_fetch_array($qBrg)){
                            echo "<option value='".$b['KodeBarang']."'>".$b['KodeBarang']." - ".$b['NamaBarang']." (Rp ".number_format($b['HargaSatuan'],0,',','.').")</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Banyaknya (Jumlah)</label>
                    <input type="number" name="JumlahBarang" class="form-control" placeholder="Tentukan Jumlah" min="1" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary" style="background: #22c55e; border-color: #22c55e;"><i class="fas fa-plus"></i> Tambah ke Nota</button>
                    <a href="fakturdetaillihat.php?NoFaktur=<?php echo $NoFaktur; ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>
