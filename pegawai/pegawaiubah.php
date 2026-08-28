<?php
include '../config/koneksi.php';

// Proses ubah - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    $id       = $_POST['idpegawai'];
    $nama     = $_POST['NamaPegawai'];
    $ttd_lama = $_POST['TTD_Digital_Pegawai_lama'];
    $ttd      = $ttd_lama; // default: pertahankan file lama

    // Proses upload file TTD baru (jika dipilih)
    if (isset($_FILES['TTD_file']) && $_FILES['TTD_file']['error'] === UPLOAD_ERR_OK) {
        $ext     = strtolower(pathinfo($_FILES['TTD_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $folder   = '../ASSET/TTD/';

            // Hapus file TTD lama bila ada
            if (!empty($ttd_lama) && file_exists($folder . $ttd_lama)) {
                unlink($folder . $ttd_lama);
            }

            // Hitung jumlah file di folder → nomor urut baru
            $fileList = glob($folder . '*');
            $urutan   = count($fileList) + 1;
            $namaFile = str_pad($urutan, 4, '0', STR_PAD_LEFT) . '_' . strtoupper($ext);
            // Pastikan nama unik
            while (file_exists($folder . $namaFile)) {
                $urutan++;
                $namaFile = str_pad($urutan, 4, '0', STR_PAD_LEFT) . '_' . strtoupper($ext);
            }
            move_uploaded_file($_FILES['TTD_file']['tmp_name'], $folder . $namaFile);
            $ttd = $namaFile;
        }
    }

    mysqli_query($conn, "UPDATE pegawai SET NamaPegawai='$nama', TTD_Digital_Pegawai='$ttd' WHERE idpegawai='$id'");
    header("location:pegawailihat.php");
    exit;
}

if (isset($_GET['idpegawai'])) {
    $id    = $_GET['idpegawai'];
    $query = mysqli_query($conn, "SELECT * FROM pegawai WHERE idpegawai = '$id'");
    $data  = mysqli_fetch_array($query);
} else {
    header("location:pegawailihat.php"); exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Pegawai</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Edit Pegawai</span>
        </div>
        <div class="topbar-title">Form Edit Pegawai</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-user-pen" style="color:#f97316;margin-right:8px;"></i>Edit Data Pegawai</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idpegawai" value="<?php echo $data['idpegawai']; ?>">
                <input type="hidden" name="TTD_Digital_Pegawai_lama" value="<?php echo $data['TTD_Digital_Pegawai']; ?>">
                <div class="form-group">
                    <label class="form-label">ID Pegawai</label>
                    <input type="text" class="form-control" value="<?php echo $data['idpegawai']; ?>" readonly
                           style="background:#f8fafc;color:#94a3b8;">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" name="NamaPegawai" class="form-control" value="<?php echo $data['NamaPegawai']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">TTD Digital
                        <span style="font-size:11px;color:#94a3b8;">(Kosongkan jika tidak ingin mengganti)</span>
                    </label>

                    <?php if (!empty($data['TTD_Digital_Pegawai'])): ?>
                    <div style="margin-bottom:10px;padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;">
                        <span style="font-size:11px;color:#64748b;">File TTD saat ini: </span>
                        <span style="font-size:13px;font-weight:700;color:#475569;font-family:monospace;">
                            <?php echo htmlspecialchars($data['TTD_Digital_Pegawai']); ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <input type="file" name="TTD_file" id="TTD_file" class="form-control"
                           accept=".jpg,.jpeg,.png"
                           onchange="tampilkanNamaFile(this)"
                           style="padding:6px 10px;">
                    <div id="info-namafile" style="margin-top:8px;display:none;">
                        <span style="font-size:11px;color:#64748b;">Nama file baru yang akan disimpan: </span>
                        <span id="label-namafile"
                              style="font-size:12px;font-weight:700;color:#f97316;font-family:monospace;background:#fff7ed;padding:2px 8px;border-radius:4px;border:1px solid #fed7aa;"></span>
                        <span style="font-size:10px;color:#94a3b8;display:block;margin-top:3px;">* Nomor urut akhir ditentukan saat disimpan · File TTD lama akan dihapus otomatis</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="pegawailihat.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- end main-content -->
<script>
function tampilkanNamaFile(input) {
    var infoDiv = document.getElementById('info-namafile');
    var label   = document.getElementById('label-namafile');
    if (input.files && input.files[0]) {
        var ext = input.files[0].name.split('.').pop().toUpperCase();
        label.textContent = 'XXXX_' + ext;
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
    }
}
</script>
</body>
</html>