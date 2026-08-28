<?php
include '../config/koneksi.php';
// Proses simpan data - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    $no    = $_POST['NoFaktur'];
    $tgl   = $_POST['Tanggal'];
    $total = 0;
    $pel   = $_POST['IDPELANGGAN'];
    $peg   = $_POST['IDPEGAWAI'];
    mysqli_query($conn, "INSERT INTO faktur (NoFaktur, Tanggal, Total, IDPELANGGAN, IDPEGAWAI) VALUES('$no','$tgl','$total','$pel','$peg')");
    header("location:fakturdetaillihat.php?NoFaktur=$no");
    exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Faktur</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Tambah Faktur</span>
        </div>
        <div class="topbar-title">Form Tambah Faktur</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-file-invoice" style="color:#a855f7;margin-right:8px;"></i>Data Faktur Baru</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">No Faktur</label>
                    <input type="text" name="NoFaktur" class="form-control" placeholder="Contoh: FK001" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="Tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="IDPELANGGAN" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $qPelanggan = mysqli_query($conn, "SELECT idpelanggan, namapelanggan FROM pelanggan ORDER BY namapelanggan ASC");
                        while($p = mysqli_fetch_array($qPelanggan)){
                            echo "<option value='".$p['idpelanggan']."'>"." - ".$p['namapelanggan']."</option>";
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
                            echo "<option value='".$pg['idpegawai']."'>"." - ".$pg['NamaPegawai']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="fakturlihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>
