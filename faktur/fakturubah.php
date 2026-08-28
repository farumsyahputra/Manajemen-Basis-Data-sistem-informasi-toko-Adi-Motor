<?php
include '../config/koneksi.php';

// Proses ubah - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    $no    = $_POST['NoFaktur'];
    $tgl   = $_POST['Tanggal'];
    $pel   = $_POST['IDPELANGGAN'];
    $peg   = $_POST['IDPEGAWAI'];
    mysqli_query($conn, "UPDATE faktur SET Tanggal='$tgl', IDPELANGGAN='$pel', IDPEGAWAI='$peg' WHERE NoFaktur='$no'");
    header("location:fakturlihat.php");
    exit;
}

if (isset($_GET['NoFaktur'])) {
    $no    = $_GET['NoFaktur'];
    $query = mysqli_query($conn, "SELECT * FROM faktur WHERE NoFaktur = '$no'");
    $data  = mysqli_fetch_array($query);
} else {
    header("location:fakturlihat.php"); exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Faktur</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Edit Faktur</span>
        </div>
        <div class="topbar-title">Form Edit Faktur</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-file-pen" style="color:#a855f7;margin-right:8px;"></i>Edit Data Faktur</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <input type="hidden" name="NoFaktur" value="<?php echo $data['NoFaktur']; ?>">
                <div class="form-group">
                    <label class="form-label">No Faktur</label>
                    <input type="text" class="form-control" value="<?php echo $data['NoFaktur']; ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="Tanggal" class="form-control" value="<?php echo $data['Tanggal']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Total (Rp)</label>
                    <input type="number" name="Total" class="form-control" value="<?php echo $data['Total']; ?>" readonly style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="IDPELANGGAN" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $qPelanggan = mysqli_query($conn, "SELECT idpelanggan, namapelanggan FROM pelanggan ORDER BY namapelanggan ASC");
                        while($p = mysqli_fetch_array($qPelanggan)){
                            $sel = ($p['idpelanggan'] == $data['IDPELANGGAN']) ? "selected" : "";
                            echo "<option value='".$p['idpelanggan']."' $sel>".$p['idpelanggan']." - ".$p['namapelanggan']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pilih Pegawai</label>
                    <select name="IDPEGAWAI" class="form-control" required>
                        <option value="">-- Pilih Pegawai --</option>
                        <?php
                        $qPegawai = mysqli_query($conn, "SELECT idpegawai, NamaPegawai FROM pegawai ORDER BY NamaPegawai ASC");
                        while($pg = mysqli_fetch_array($qPegawai)){
                            $sel = ($pg['idpegawai'] == $data['IDPEGAWAI']) ? "selected" : "";
                            echo "<option value='".$pg['idpegawai']."' $sel>".$pg['idpegawai']." - ".$pg['NamaPegawai']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="fakturlihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>
