<?php
session_start();
if($_SESSION['status'] != 'login'){ header("location:login.php"); exit; }
include 'config/koneksi.php';

// Count stats
$totalPegawai   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pegawai"))[0];
$totalPelanggan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan"))[0];
$totalBarang    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM barang"))[0];
$totalFaktur    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM faktur"))[0];
?>
<?php include 'config/sidebar.php'; ?>
<!-- TOPBAR -->
<div class="topbar">
    <div>
        <div class="topbar-breadcrumb">
            <span class="bc-app">Application</span>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:9px"></i></span>
            <span class="bc-current">Dashboard Overview</span>
        </div>
        <div class="topbar-title">Selamat Datang!</div>
    </div>
    <div class="topbar-clock">
        <i class="fas fa-clock"></i>
        <span id="live-clock">00:00:00</span>
    </div>
</div>

<!-- PAGE BODY -->
<div class="page-body">

    <!-- STATS CARDS -->
    <div style="display:grid; grid-template-columns: repeat(4,1fr); gap:16px; margin-bottom:24px;">
        <div class="stat-card" style="background:#fff; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                <span style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Pegawai</span>
                <div style="width:36px;height:36px;background:#fff7ed;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-tie" style="color:#f97316;font-size:15px;"></i>
                </div>
            </div>
            <div style="font-size:32px; font-weight:700; color:#0f172a;"><?php echo $totalPegawai; ?></div>
            <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Total data pegawai</div>
        </div>

        <div class="stat-card" style="background:#fff; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                <span style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Pelanggan</span>
                <div style="width:36px;height:36px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-users" style="color:#22c55e;font-size:15px;"></i>
                </div>
            </div>
            <div style="font-size:32px; font-weight:700; color:#0f172a;"><?php echo $totalPelanggan; ?></div>
            <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Total data pelanggan</div>
        </div>

        <div class="stat-card" style="background:#fff; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                <span style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Barang</span>
                <div style="width:36px;height:36px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-box" style="color:#3b82f6;font-size:15px;"></i>
                </div>
            </div>
            <div style="font-size:32px; font-weight:700; color:#0f172a;"><?php echo $totalBarang; ?></div>
            <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Total data barang</div>
        </div>

        <div class="stat-card" style="background:#fff; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                <span style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Faktur</span>
                <div style="width:36px;height:36px;background:#fdf4ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-file-invoice" style="color:#a855f7;font-size:15px;"></i>
                </div>
            </div>
            <div style="font-size:32px; font-weight:700; color:#0f172a;"><?php echo $totalFaktur; ?></div>
            <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Total transaksi faktur</div>
        </div>
    </div>

    <!-- WELCOME BANNER -->
    <div style="background:#fff; border-radius:12px; padding:48px 32px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,.06); margin-bottom:24px;">
        <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin-bottom:10px;">
            Sistem Manajemen <span style="color:#f97316;">Bengkel</span>
        </h2>
        <p style="color:#64748b; font-size:14px; max-width:400px; margin:0 auto 28px;">
            Selamat datang kembali, Admin. Mulai kelola data bengkel Kamu hari ini dengan lebih mudah dan efisien.
        </p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="faktur/fakturlihat.php" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:20px 28px;border-radius:12px;background:#eff6ff;text-decoration:none;min-width:130px;transition:transform .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-file-invoice-dollar" style="font-size:22px;color:#3b82f6;"></i>
                <span style="font-size:13px;font-weight:600;color:#1d4ed8;">Buat Transaksi</span>
                <span style="font-size:10px;color:#93c5fd;">Catat penjualan baru</span>
            </a>
            <a href="barang/baranglihat.php" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:20px 28px;border-radius:12px;background:#fff7ed;text-decoration:none;min-width:130px;transition:transform .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-boxes-stacked" style="font-size:22px;color:#f97316;"></i>
                <span style="font-size:13px;font-weight:600;color:#c2410c;">Data Barang</span>
                <span style="font-size:10px;color:#fdba74;">Kelola stok sparepart</span>
            </a>
            <a href="pelanggan/pelangganlihat.php" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:20px 28px;border-radius:12px;background:#f0fdf4;text-decoration:none;min-width:130px;transition:transform .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-user-group" style="font-size:22px;color:#22c55e;"></i>
                <span style="font-size:13px;font-weight:600;color:#15803d;">Pelanggan</span>
                <span style="font-size:10px;color:#86efac;">Kelola data pelanggan</span>
            </a>
        </div>
    </div>

</div>
</div><!-- end main-content -->
</body>
</html>