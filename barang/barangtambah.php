<?php
// Proses simpan data - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    include '../config/koneksi.php';
    $id    = $_POST['KodeBarang'];
    $nama  = $_POST['NamaBarang'];
    $harga = $_POST['HargaSatuan'];
    mysqli_query($conn, "INSERT INTO barang (KodeBarang, NamaBarang, HargaSatuan) VALUES('$id','$nama','$harga')");
    header("location:baranglihat.php");
    exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Barang</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Tambah Barang</span>
        </div>
        <div class="topbar-title">Form Tambah Barang</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-box" style="color:#3b82f6;margin-right:8px;"></i>Data Barang Baru</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="KodeBarang" class="form-control" placeholder="Contoh: BRG001" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="NamaBarang" class="form-control" placeholder="Nama barang / sparepart" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Satuan (Rp)</label>
                    <input type="number" name="HargaSatuan" class="form-control" placeholder="0" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="baranglihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>