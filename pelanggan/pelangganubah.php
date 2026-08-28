<?php
include '../config/koneksi.php';

// Proses ubah - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    $id   = $_POST['idpelanggan'];
    $nama = $_POST['namapelanggan'];
    mysqli_query($conn, "UPDATE pelanggan SET namapelanggan='$nama' WHERE idpelanggan='$id'");
    header("location:pelangganlihat.php");
    exit;
}

if (isset($_GET['idpelanggan'])) {
    $id    = $_GET['idpelanggan'];
    $query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE idpelanggan = '$id'");
    $data  = mysqli_fetch_array($query);
} else {
    header("location:pelangganlihat.php"); exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Pelanggan</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Edit Pelanggan</span>
        </div>
        <div class="topbar-title">Form Edit Pelanggan</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-user-pen" style="color:#22c55e;margin-right:8px;"></i>Edit Data Pelanggan</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <input type="hidden" name="idpelanggan" value="<?php echo $data['idpelanggan']; ?>">
                <div class="form-group">
                    <label class="form-label">ID Pelanggan</label>
                    <input type="text" class="form-control" value="<?php echo $data['idpelanggan']; ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="namapelanggan" class="form-control" value="<?php echo $data['namapelanggan']; ?>">
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="pelangganlihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>