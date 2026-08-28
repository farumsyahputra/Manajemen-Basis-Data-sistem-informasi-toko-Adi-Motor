<?php include '../config/koneksi.php'; ?>
<?php include '../config/sidebar.php'; ?>

<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Data Faktur</span>
        </div>
        <div class="topbar-title">Manajemen Faktur</div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>

<div class="page-body">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-file-invoice" style="color:#3b82f6;margin-right:8px;"></i>Tabel Faktur</span>
            <a href="fakturtambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Faktur</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Jumlah Rp</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn,
                    "SELECT faktur.*, pelanggan.NamaPelanggan, pegawai.NamaPegawai
                     FROM faktur
                     LEFT JOIN pelanggan ON faktur.IDPELANGGAN = pelanggan.IDPELANGGAN
                     LEFT JOIN pegawai   ON faktur.IDPEGAWAI   = pegawai.IDPEGAWAI
                     ORDER BY faktur.Tanggal ASC"
                );
                $no = 1;
                while ($data = mysqli_fetch_array($query)){ 
                    $nf  = htmlspecialchars($data['NoFaktur']);
                    $tgl = date('d/m/Y', strtotime($data['Tanggal']));
                    $pel = htmlspecialchars($data['NamaPelanggan'] ?? $data['IDPELANGGAN'] ?? '-');
                    $peg = htmlspecialchars($data['NamaPegawai']   ?? $data['IDPEGAWAI']   ?? '-');
                    $tot = number_format($data['Total'], 0, ',', '.');
                ?>
                <tr>
                    <td style="color:#94a3b8;font-weight:500;"><?php echo $no++; ?></td>
                    <td><span style="background:#f1f5f9;color:#475569;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600;"><?php echo $nf; ?></span></td>
                    <td style="font-weight:500;"><?php echo $tgl; ?></td>
                    <td style="font-weight:500;"><?php echo $pel; ?></td>
                    <td style="font-weight:500;"><?php echo $peg; ?></td>
                    <td style="font-weight:600;color:#0f172a;">Rp <?php echo $tot; ?></td>
                    <td>
                        <a class="btn btn-warning" href="fakturubah.php?NoFaktur=<?php echo urlencode($data['NoFaktur']); ?>"><i class="fas fa-pen"></i> Edit</a>
                        <a class="btn btn-danger" href="fakturhapus.php?NoFaktur=<?php echo urlencode($data['NoFaktur']); ?>" onclick="return confirm('Yakin hapus faktur ini?')"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                    <td>
                        <a class="btn btn-secondary" href="fakturdetaillihat.php?NoFaktur=<?php echo urlencode($data['NoFaktur']); ?>"><i class="fas fa-eye"></i> Detail</a>
                        <a class="btn btn-primary" style="background:#0ea5e9;" href="fakturcetak.php?NoFaktur=<?php echo urlencode($data['NoFaktur']); ?>"><i class="fas fa-print"></i> Cetak</a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div><!-- end main-content -->

<script>
// ── Live clock ──────────────────────────────────
function updateClock() {
    const now = new Date();
    document.getElementById('live-clock').textContent =
        [now.getHours(), now.getMinutes(), now.getSeconds()]
        .map(v => String(v).padStart(2, '0')).join(':');
}
setInterval(updateClock, 1000);
updateClock();

// ── Cetak via fetch + overlay (100% tanpa buka tab/jendela baru) ──
function cetakFaktur(noFaktur) {
    const overlay = document.getElementById('print-overlay');
    overlay.innerHTML = '<p style="text-align:center;padding:40px;font-size:16px;">Memuat faktur...</p>';

    fetch('fakturcetak.php?NoFaktur=' + noFaktur)
        .then(function(response) {
            if (!response.ok) throw new Error('Gagal memuat halaman cetak.');
            return response.text();
        })
        .then(function(html) {
            // Ambil hanya konten di dalam <div class="page">
            const parser = new DOMParser();
            const doc    = parser.parseFromString(html, 'text/html');
            const page   = doc.querySelector('.page');

            if (!page) {
                overlay.innerHTML = '<p style="color:red;padding:20px;">Konten faktur tidak ditemukan.</p>';
                return;
            }

            // Salin juga CSS <style> dari halaman cetak agar layout benar
            let styles = '';
            doc.querySelectorAll('style').forEach(function(s) { styles += s.outerHTML; });

            overlay.innerHTML = styles + page.outerHTML;

            // Sedikit jeda agar browser render dulu, lalu print
            setTimeout(function() {
                window.print();
                // Bersihkan overlay setelah dialog print ditutup
                setTimeout(function() {
                    overlay.innerHTML = '';
                }, 500);
            }, 300);
        })
        .catch(function(err) {
            overlay.innerHTML = '';
            alert('Gagal mencetak: ' + err.message);
        });
}
</script>

</body>
</html>
