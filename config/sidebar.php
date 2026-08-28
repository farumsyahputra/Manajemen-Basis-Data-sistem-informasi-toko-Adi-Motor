<?php
// Determine current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));

function isActive($dir, $currentDir, $currentPage) {
    if ($dir === 'dashboard' && $currentPage === 'dashboard.php') return 'active';
    if ($dir === $currentDir) return 'active';
    return '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TOKO ADI MOTOR - Sistem Manajemen</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Inter', sans-serif;
    background: #f0f2f5;
    display: flex;
    min-height: 100vh;
    color: #333;
}

/* ─── SIDEBAR ─── */
.sidebar {
    width: 220px;
    min-width: 220px;
    background: #0f172a;
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 100;
}
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 20px 18px 16px;
    border-bottom: 1px solid #1e293b;
}
.sidebar-brand .brand-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px;
}
.sidebar-brand .brand-text { display: flex; flex-direction: column; }
.sidebar-brand .brand-name { color: #fff; font-weight: 700; font-size: 14px; letter-spacing: 0.5px; }
.sidebar-brand .brand-sub  { color: #64748b; font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; }

.sidebar-nav { padding: 16px 12px; flex: 1; }
.nav-label {
    font-size: 9px; font-weight: 600; letter-spacing: 1.5px;
    color: #475569; text-transform: uppercase;
    padding: 0 8px 8px;
}
.nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 8px;
    color: #94a3b8; text-decoration: none;
    font-size: 13px; font-weight: 500;
    margin-bottom: 2px;
    transition: all 0.2s;
}
.nav-item i { width: 16px; text-align: center; font-size: 14px; }
.nav-item:hover { background: #1e293b; color: #fff; }
.nav-item.active { background: #f97316; color: #fff; }
.nav-separator { margin: 12px 0 8px; }

.sidebar-footer {
    padding: 14px 18px;
    border-top: 1px solid #1e293b;
    display: flex; align-items: center; gap: 10px;
}
.sidebar-footer .avatar {
    width: 32px; height: 32px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 8px;
    color: #fff; font-weight: 700; font-size: 12px;
    display: flex; align-items: center; justify-content: center;
}
.sidebar-footer .user-info { flex: 1; }
.sidebar-footer .user-name { color: #e2e8f0; font-size: 12px; font-weight: 600; }
.sidebar-footer .user-role { color: #64748b; font-size: 10px; }
.sidebar-footer .logout-btn {
    color: #64748b; font-size: 14px; cursor: pointer;
    text-decoration: none; transition: color 0.2s;
}
.sidebar-footer .logout-btn:hover { color: #f97316; }

/* ─── MAIN CONTENT ─── */
.main-content { margin-left: 220px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

/* ─── TOPBAR ─── */
.topbar {
    background: #fff;
    padding: 14px 28px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid #e2e8f0;
    position: sticky; top: 0; z-index: 50;
}
.topbar-breadcrumb { display: flex; align-items: center; gap: 6px; }
.topbar-breadcrumb .bc-app { color: #94a3b8; font-size: 12px; }
.topbar-breadcrumb .bc-sep { color: #cbd5e1; font-size: 12px; }
.topbar-breadcrumb .bc-current { color: #f97316; font-size: 12px; font-weight: 500; }
.topbar-title { font-size: 22px; font-weight: 700; color: #0f172a; margin-top: 2px; }
.topbar-clock {
    background: #0f172a; color: #fff;
    padding: 8px 16px; border-radius: 20px;
    font-size: 13px; font-weight: 600; font-family: monospace;
    display: flex; align-items: center; gap: 8px;
}
.topbar-clock i { color: #f97316; font-size: 12px; }

.page-body { padding: 28px; flex: 1; }

/* ─── CARDS & TABLES ─── */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.06);
    overflow: hidden;
}
.card-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.card-title { font-size: 15px; font-weight: 600; color: #0f172a; }
.card-body { padding: 0; }

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 16px; border-radius: 8px;
    font-size: 13px; font-weight: 500;
    text-decoration: none; border: none; cursor: pointer;
    transition: all 0.2s;
}
.btn-primary { background: #f97316; color: #fff; }
.btn-primary:hover { background: #ea580c; }
.btn-secondary { background: #e2e8f0; color: #475569; }
.btn-secondary:hover { background: #cbd5e1; }
.btn-danger { background: #fee2e2; color: #dc2626; }
.btn-danger:hover { background: #fecaca; }
.btn-warning { background: #fef3c7; color: #d97706; }
.btn-warning:hover { background: #fde68a; }

table { width: 100%; border-collapse: collapse; }
table thead th {
    background: #f8fafc; color: #64748b;
    font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 12px 16px; text-align: left;
    border-bottom: 1px solid #e2e8f0;
}
table tbody td {
    padding: 13px 16px; font-size: 13px;
    border-bottom: 1px solid #f1f5f9; color: #374151;
}
table tbody tr:last-child td { border-bottom: none; }
table tbody tr:hover { background: #f8fafc; }

/* ─── FORM STYLES ─── */
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-control {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: 13px; color: #0f172a; font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
}
.form-control:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,.12);
}
.form-actions { display: flex; gap: 10px; margin-top: 24px; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-cog"></i></div>
        <div class="brand-text">
            <span class="brand-name">TOKO <span style="color:#f97316;">ADI MOTOR</span></span>
            <span class="brand-sub">Sistem Manajemen</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>dashboard.php"
           class="nav-item <?php echo isActive('dashboard', $currentDir, $currentPage); ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="nav-separator">
            <div class="nav-label">Management</div>
        </div>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>pegawai/pegawailihat.php"
           class="nav-item <?php echo isActive('pegawai', $currentDir, $currentPage); ?>">
            <i class="fas fa-user-tie"></i> Pegawai
        </a>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>pelanggan/pelangganlihat.php"
           class="nav-item <?php echo isActive('pelanggan', $currentDir, $currentPage); ?>">
            <i class="fas fa-users"></i> Pelanggan
        </a>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>barang/baranglihat.php"
           class="nav-item <?php echo isActive('barang', $currentDir, $currentPage); ?>">
            <i class="fas fa-box"></i> Barang / Stok
        </a>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>faktur/fakturlihat.php"
           class="nav-item <?php echo isActive('faktur', $currentDir, $currentPage); ?>">
            <i class="fas fa-file-invoice"></i> Faktur
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="avatar">AA</div>
        <div class="user-info">
            <div class="user-name">Administrator</div>
            <div class="user-role">admin@otomotif.com</div>
        </div>
        <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2); ?>logout.php" class="logout-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>

<div class="main-content">
<script>
function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    const el = document.getElementById('live-clock');
    if(el) el.textContent = h + ':' + m + ':' + s;
}
setInterval(updateClock, 1000);
document.addEventListener('DOMContentLoaded', updateClock);
</script>
