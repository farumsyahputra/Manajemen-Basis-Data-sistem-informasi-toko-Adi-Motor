<?php include '../config/koneksi.php'; ?>
<?php include '../config/sidebar.php'; ?>
<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Data Barang</span>
        </div>
        <div class="topbar-title">Manajemen Barang / Stok</div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-box" style="color:#3b82f6;margin-right:8px;"></i>Tabel Barang</span>
            <a href="barangtambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM barang");
                $no = 1;
                while ($data = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td style="color:#94a3b8;font-weight:500;"><?php echo $no++; ?></td>
                    <td><span style="background:#f1f5f9;color:#475569;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600;"><?php echo $data['KodeBarang']; ?></span></td>
                    <td style="font-weight:500;"><?php echo $data['NamaBarang']; ?></td>
                    <td style="font-weight:600;color:#0f172a;">Rp <?php echo number_format($data['HargaSatuan'], 0, ',', '.'); ?></td>
                    <td>
                        <a class="btn btn-warning" href="barangubah.php?KodeBarang=<?php echo $data['KodeBarang']; ?>"><i class="fas fa-pen"></i> Edit</a>
                        <a class="btn btn-danger" href="baranghapus.php?KodeBarang=<?php echo $data['KodeBarang']; ?>" onclick="return confirm('Yakin hapus data barang ini?')"><i class="fas fa-trash"></i> Hapus</a>
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