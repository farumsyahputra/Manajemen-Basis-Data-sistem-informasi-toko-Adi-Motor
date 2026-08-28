<?php
// Proses simpan data - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    include '../config/koneksi.php';
    $id   = $_POST['idpelanggan'];
    $nama = $_POST['namapelanggan'];
    mysqli_query($conn, "INSERT INTO pelanggan (idpelanggan, namapelanggan) VALUES('$id','$nama')");
    header("location:pelangganlihat.php");
    exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Pelanggan</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Tambah Pelanggan</span>
        </div>
        <div class="topbar-title">Form Tambah Pelanggan</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-user-plus" style="color:#22c55e;margin-right:8px;"></i>Data Pelanggan Baru</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">ID Pelanggan</label>
                    <input type="text" name="idpelanggan" class="form-control" placeholder="Contoh: P001" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="namapelanggan" class="form-control" placeholder="Nama lengkap pelanggan" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="pelangganlihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>