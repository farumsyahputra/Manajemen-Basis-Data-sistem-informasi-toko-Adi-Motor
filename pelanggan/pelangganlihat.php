<?php include '../config/koneksi.php'; ?>
<?php include '../config/sidebar.php'; ?>
<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Data Pelanggan</span>
        </div>
        <div class="topbar-title">Manajemen Pelanggan</div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-users" style="color:#22c55e;margin-right:8px;"></i>Tabel Pelanggan</span>
            <a href="pelanggantambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pelanggan</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM pelanggan");
                $no = 1;
                while ($data = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td style="color:#94a3b8;font-weight:500;"><?php echo $no++; ?></td>
                    <td><span style="background:#f1f5f9;color:#475569;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600;"><?php echo $data['idpelanggan']; ?></span></td>
                    <td style="font-weight:500;"><?php echo $data['namapelanggan']; ?></td>
                    <td>
                        <a class="btn btn-warning" href="pelangganubah.php?idpelanggan=<?php echo $data['idpelanggan']; ?>"><i class="fas fa-pen"></i> Edit</a>
                        <a class="btn btn-danger" href="pelangganhapus.php?idpelanggan=<?php echo $data['idpelanggan']; ?>" onclick="return confirm('Yakin hapus data pelanggan ini?')"><i class="fas fa-trash"></i> Hapus</a>
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