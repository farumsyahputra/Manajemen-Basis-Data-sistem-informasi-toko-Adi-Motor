<?php include '../config/koneksi.php'; ?>
<?php include '../config/sidebar.php'; ?>
<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Data Pegawai</span>
        </div>
        <div class="topbar-title">Manajemen Pegawai</div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-user-tie" style="color:#f97316;margin-right:8px;"></i>Tabel Pegawai</span>
            <a href="pegawaitambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pegawai</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Pegawai</th>
                        <th>Nama Pegawai</th>
                        <th>TTD Digital</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM pegawai");
                $no = 1;
                while ($data = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td style="color:#94a3b8;font-weight:500;"><?php echo $no++; ?></td>
                    <td><span style="background:#f1f5f9;color:#475569;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600;"><?php echo $data['idpegawai']; ?></span></td>
                    <td style="font-weight:500;"><?php echo $data['NamaPegawai']; ?></td>
                    <td style="text-align:center;">
                        <?php if (!empty($data['TTD_Digital_Pegawai'])): ?>
                            <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:5px;font-size:12px;font-weight:600;font-family:monospace;">
                                <?php echo htmlspecialchars($data['TTD_Digital_Pegawai']); ?>
                            </span>
                        <?php else: ?>
                            <span style="color:#cbd5e1;font-size:12px;">— belum ada —</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="pegawaiubah.php?idpegawai=<?php echo $data['idpegawai']; ?>"><i class="fas fa-pen"></i> Edit</a>
                        <a class="btn btn-danger" href="pegawaihapus.php?idpegawai=<?php echo $data['idpegawai']; ?>" onclick="return confirm('Yakin hapus data pegawai ini?')"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div><!-- end main-content -->
</body>
</html>