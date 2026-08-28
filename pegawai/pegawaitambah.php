<?php
// Proses simpan data - HARUS di atas sebelum output HTML
if (isset($_POST['proses'])){
    include '../config/koneksi.php';
    $id   = $_POST['idpegawai'];
    $nama = $_POST['NamaPegawai'];
    $ttd  = '';

    // Proses upload file JPG tanda tangan
    if (isset($_FILES['TTD_file']) && $_FILES['TTD_file']['error'] === UPLOAD_ERR_OK) {
        $ext     = strtolower(pathinfo($_FILES['TTD_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            // Hitung jumlah file yang sudah ada di folder TTD → buat nomor urut
            $folder    = '../ASSET/TTD/';
            $fileList  = glob($folder . '*');
            $urutan    = count($fileList) + 1;
            $namaFile  = str_pad($urutan, 4, '0', STR_PAD_LEFT) . '_' . strtoupper($ext);
            // Jika nama sudah ada (tabrakan), tambah sampai unik
            while (file_exists($folder . $namaFile)) {
                $urutan++;
                $namaFile = str_pad($urutan, 4, '0', STR_PAD_LEFT) . '_' . strtoupper($ext);
            }
            move_uploaded_file($_FILES['TTD_file']['tmp_name'], $folder . $namaFile);
            $ttd = $namaFile;
        }
    }

    mysqli_query($conn, "INSERT INTO pegawai (idpegawai, NamaPegawai, TTD_Digital_Pegawai) VALUES('$id','$nama','$ttd')");
    header("location:pegawailihat.php");
    exit;
}
?>
<?php include '../config/sidebar.php'; ?>
<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Pegawai</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Tambah Pegawai</span>
        </div>
        <div class="topbar-title">Form Tambah Pegawai</div>
    </div>
    <div class="topbar-clock"><i class="fas fa-clock"></i><span id="live-clock">00:00:00</span></div>
</div>
<div class="page-body">
    <div class="card" style="max-width:520px;">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-user-plus" style="color:#f97316;margin-right:8px;"></i>Data Pegawai Baru</span>
        </div>
        <div style="padding:24px;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">ID Pegawai</label>
                    <input type="text" name="idpegawai" class="form-control" placeholder="Contoh: PG001" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" name="NamaPegawai" class="form-control" placeholder="Nama lengkap pegawai" required>
                </div>
                <div class="form-group">
                    <label class="form-label">TTD Digital
                        <span style="font-size:11px;color:#94a3b8;">(Upload file JPG/PNG — nama file otomatis dibuat)</span>
                    </label>
                    <input type="file" name="TTD_file" id="TTD_file" class="form-control"
                           accept=".jpg,.jpeg,.png"
                           onchange="tampilkanNamaFile(this)"
                           style="padding:6px 10px;">
                    <div id="info-namafile" style="margin-top:8px;display:none;">
                        <span style="font-size:11px;color:#64748b;">Nama file yang akan disimpan: </span>
                        <span id="label-namafile"
                              style="font-size:12px;font-weight:700;color:#f97316;font-family:monospace;background:#fff7ed;padding:2px 8px;border-radius:4px;border:1px solid #fed7aa;"></span>
                        <span style="font-size:10px;color:#94a3b8;display:block;margin-top:3px;">* Nomor urut akhir ditentukan saat disimpan</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="proses" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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