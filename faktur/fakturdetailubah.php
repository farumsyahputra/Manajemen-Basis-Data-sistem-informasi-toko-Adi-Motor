<?php
include '../config/koneksi.php';

// Cek parameter
if (!isset($_GET['NoFaktur']) || !isset($_GET['KodeBarang'])) {
    header("location:fakturlihat.php");
    exit;
}
$NoFaktur = mysqli_real_escape_string($conn, $_GET['NoFaktur']);
$KodeBarang = mysqli_real_escape_string($conn, $_GET['KodeBarang']);

// Ambil data detail barang yang mau diubah
$qDetail = mysqli_query($conn, "SELECT detail_faktur.*, barang.NamaBarang, barang.HargaSatuan 
                                FROM detail_faktur 
                                JOIN barang ON detail_faktur.KodeBarang = barang.KodeBarang 
                                WHERE detail_faktur.NoFaktur='$NoFaktur' AND detail_faktur.KodeBarang='$KodeBarang'");
if (mysqli_num_rows($qDetail) == 0) {
    header("location:fakturdetaillihat.php?NoFaktur=$NoFaktur");
    exit;
}
$data = mysqli_fetch_array($qDetail);

if (isset($_POST['proses'])){
    $jumlahBarangBaru = (int)$_POST['JumlahBarang'];
    $hargaSatuan = $data['HargaSatuan'];
    
    // Hitung subtotal baru (HargaJumlah)
    $hargaJumlahBaru = $hargaSatuan * $jumlahBarangBaru;
    
    // Selisih untuk update ke tabel faktur induk
    $selisih = $hargaJumlahBaru - $data['HargaJumlah'];
    
    // Update ke detail_faktur
    mysqli_query($conn, "UPDATE detail_faktur SET JumlahBarang='$jumlahBarangBaru', HargaJumlah='$hargaJumlahBaru' WHERE NoFaktur='$NoFaktur' AND KodeBarang='$KodeBarang'");
    
    // Update Total di tabel faktur
    mysqli_query($conn, "UPDATE faktur SET Total = Total + $selisih WHERE NoFaktur = '$NoFaktur'");
    
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
            <span class="bc-app">Detail Faktur</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Edit Barang</span>
        </div>
        <div class="topbar-title">Edit Item Faktur</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-edit" style="color:#eab308;margin-right:8px;"></i>Ubah Jumlah Barang: <?php echo $NoFaktur; ?></span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" value="<?php echo $data['KodeBarang'] . ' - ' . $data['NamaBarang']; ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" class="form-control" value="Rp <?php echo number_format($data['HargaSatuan'],0,',','.'); ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Banyaknya (Jumlah)</label>
                    <input type="number" name="JumlahBarang" class="form-control" value="<?php echo $data['JumlahBarang']; ?>" min="1" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-warning" style="background: #eab308; border-color: #eab308; color: white;"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="fakturdetaillihat.php?NoFaktur=<?php echo $NoFaktur; ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>
