<?php
include '../config/koneksi.php';

// Proses ubah - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    $id    = $_POST['KodeBarang'];
    $nama  = $_POST['NamaBarang'];
    $harga = $_POST['HargaSatuan'];
    mysqli_query($conn, "UPDATE barang SET NamaBarang='$nama', HargaSatuan='$harga' WHERE KodeBarang='$id'");
    header("location:baranglihat.php");
    exit;
}

if (isset($_GET['KodeBarang'])) {
    $id    = $_GET['KodeBarang'];
    $query = mysqli_query($conn, "SELECT * FROM barang WHERE KodeBarang = '$id'");
    $data  = mysqli_fetch_array($query);
} else {
    header("location:baranglihat.php"); exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Barang</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Edit Barang</span>
        </div>
        <div class="topbar-title">Form Edit Barang</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-box-open" style="color:#3b82f6;margin-right:8px;"></i>Edit Data Barang</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <input type="hidden" name="KodeBarang" value="<?php echo $data['KodeBarang']; ?>">
                <div class="form-group">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" class="form-control" value="<?php echo $data['KodeBarang']; ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="NamaBarang" class="form-control" value="<?php echo $data['NamaBarang']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Satuan (Rp)</label>
                    <input type="number" name="HargaSatuan" class="form-control" value="<?php echo $data['HargaSatuan']; ?>">
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="baranglihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>