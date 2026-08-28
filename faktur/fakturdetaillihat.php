<?php 
include '../config/koneksi.php'; 
include '../config/sidebar.php'; 

// Mengambil NoFaktur dari URL
$NoFaktur = mysqli_real_escape_string($conn, $_GET['NoFaktur']);

// Query Gabungan: Mengambil data faktur, nama pelanggan, dan nama pegawai
$query_faktur = mysqli_query($conn, "SELECT faktur.*, pelanggan.NamaPelanggan, pegawai.NamaPegawai 
                                    FROM faktur 
                                    LEFT JOIN pelanggan ON faktur.IDPELANGGAN = pelanggan.IDPELANGGAN 
                                    LEFT JOIN pegawai ON faktur.IDPEGAWAI = pegawai.IDPEGAWAI
                                    WHERE faktur.NoFaktur = '$NoFaktur'");
$header = mysqli_fetch_array($query_faktur);
?>

<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-app">Data Faktur</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Detail Faktur</span>
        </div>
        <div class="topbar-title">Detail Faktur: <?php echo $NoFaktur; ?></div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>

<div class="page-body">
    <div style="margin-bottom: 15px; display: flex; gap: 10px;">
        <a href="fakturlihat.php" class="btn btn-secondary" style="padding: 8px 20px;">Simpan</a>
    </div>

    <div class="card" style="margin-bottom: 30px; border: 1px solid #e2e8f0; border-radius: 8px;">
        <div class="card-body" style="padding: 30px;">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                
                <div style="display: flex; align-items: center;">
                    <label style="width: 180px; color:#94a3b8; font-size: 13px; text-transform: uppercase; font-weight: 600;">No Faktur</label>
                    <div style="flex: 1; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 6px; color: #475569; font-family: monospace; font-size: 15px;">
                        <?php echo $header['NoFaktur']; ?>
                    </div>
                </div>

                <div style="display: flex; align-items: center;">
                    <label style="width: 180px; color:#94a3b8; font-size: 13px; text-transform: uppercase; font-weight: 600;">Tanggal</label>
                    <div style="flex: 1; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 6px; color: #475569;">
                        <?php echo date('d/m/Y', strtotime($header['Tanggal'])); ?>
                    </div>
                </div>

                <div style="display: flex; align-items: center;">
                    <label style="width: 180px; color:#94a3b8; font-size: 13px; text-transform: uppercase; font-weight: 600;">Pelanggan</label>
                    <div style="flex: 1; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 6px; color: #475569;">
                        <?php echo $header['NamaPelanggan'] ?? 'Pelanggan Umum'; ?>
                    </div>
                </div>

                <div style="display: flex; align-items: center;">
                    <label style="width: 180px; color:#94a3b8; font-size: 13px; text-transform: uppercase; font-weight: 600;">Kasir / Pegawai</label>
                    <div style="flex: 1; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 6px; color: #475569;">
                        <?php echo ($header['NamaPegawai'] ?? $header['IDPEGAWAI']) ?: '-'; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <h4 style="text-align: center; color: #94a3b8; margin-bottom: 20px; font-weight: 600; text-transform: uppercase;">Tabel Detail Faktur</h4>
    
    <div style="background: white; border-top: 1px solid #e2e8f0; padding-top: 20px;">
        <div style="margin-bottom: 15px; display: flex; gap: 8px;">
            <a href="fakturdetailtambah.php?NoFaktur=<?php echo $NoFaktur; ?>" style="background: #22c55e; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 500; font-size: 14px;">Tambah</a>
            <button onclick="cetakFaktur('<?php echo urlencode($NoFaktur); ?>')" style="background: #fbbf24; color: white; padding: 8px 16px; border-radius: 4px; border: none; font-weight: 500; font-size: 14px; cursor:pointer;">&#128438; Cetak</button>
        </div>
        
        <table width="100%" style="border-collapse: collapse; text-align: center; font-size: 14px; border: 1px solid #cbd5e1;">
            <thead>
                <tr style="background-color: #bfdbfe; color: #000; font-weight: 600;">
                    <th style="padding: 10px; border: 1px solid #93c5fd; width: 50px;">No</th>
                    <th style="padding: 10px; border: 1px solid #93c5fd;">Banyaknya</th>
                    <th style="padding: 10px; border: 1px solid #93c5fd;">Nama Barang</th>
                    <th style="padding: 10px; border: 1px solid #93c5fd;">Harga Satuan</th>
                    <th style="padding: 10px; border: 1px solid #93c5fd;">Jumlah</th>
                    <th style="padding: 10px; border: 1px solid #93c5fd;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql_detail = "SELECT detail_faktur.*, barang.NamaBarang, barang.HargaSatuan 
                           FROM detail_faktur 
                           JOIN barang ON detail_faktur.KodeBarang = barang.KodeBarang 
                           WHERE detail_faktur.NoFaktur = '$NoFaktur'";
            
            $query_detail = mysqli_query($conn, $sql_detail);
            $no = 1;
            
            if(mysqli_num_rows($query_detail) > 0) {
                while ($row = mysqli_fetch_array($query_detail)){ 
                ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;"><?php echo $no++; ?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; font-weight: 600;"><?php echo $row['JumlahBarang']; ?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; font-weight: 600;"><?php echo $row['NamaBarang']; ?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">Rp <?php echo number_format($row['HargaSatuan'], 0, ',', '.'); ?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">Rp <?php echo number_format($row['HargaJumlah'], 0, ',', '.'); ?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <a href="fakturdetailubah.php?NoFaktur=<?php echo $NoFaktur; ?>&KodeBarang=<?php echo $row['KodeBarang']; ?>" style="color: #eab308; margin-right: 12px;" title="Edit Jumlah"><i class="fas fa-edit"></i></a>
                        <a href="fakturdetailhapus.php?NoFaktur=<?php echo $NoFaktur; ?>&KodeBarang=<?php echo $row['KodeBarang']; ?>" onclick="return confirm('Hapus barang ini?')" style="color: #ef4444;" title="Hapus Barang"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php 
                } 
            } else {
                echo "<tr><td colspan='6' style='text-align:center; padding: 20px; border: 1px solid #cbd5e1; color:#94a3b8;'>Data detail barang tidak ditemukan.</td></tr>";
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align: center; padding: 10px; border: 1px solid #cbd5e1; color: #64748b; font-size: 14px;">TOTAL HARGA</th>
                    <th style="text-align: center; padding: 10px; border: 1px solid #cbd5e1; font-weight: 600; color: #64748b;">Rp <?php echo number_format($header['Total'], 0, ',', '.'); ?></th>
                    <th style="padding: 10px; border: 1px solid #cbd5e1;"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    // Fungsi jam live jika diperlukan
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

// ── Cetak via hidden iframe (tanpa buka tab baru) ──
function cetakFaktur(noFaktur) {
    const old = document.getElementById('cetak-iframe');
    if (old) old.remove();

    const iframe = document.createElement('iframe');
    iframe.id  = 'cetak-iframe';
    iframe.src = 'fakturcetak.php?NoFaktur=' + noFaktur;
    iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:0;height:0;border:none;';
    document.body.appendChild(iframe);

    iframe.onload = function () {
        try {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        } catch(e) {
            window.open('fakturcetak.php?NoFaktur=' + noFaktur, '_blank');
        }
    };
}
</script>

</body>
</html>