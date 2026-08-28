<?php
include '../config/koneksi.php';

// Ambil NoFaktur dari URL
$NoFaktur = isset($_GET['NoFaktur']) ? mysqli_real_escape_string($conn, $_GET['NoFaktur']) : '';

if (empty($NoFaktur)) {
    die("NoFaktur tidak ditemukan.");
}

// Query header faktur + pelanggan + pegawai (termasuk TTD Digital)
$query_faktur = mysqli_query($conn,
    "SELECT faktur.*, pelanggan.NamaPelanggan, pegawai.NamaPegawai, pegawai.TTD_Digital_Pegawai
     FROM faktur
     LEFT JOIN pelanggan ON faktur.IDPELANGGAN = pelanggan.IDPELANGGAN
     LEFT JOIN pegawai   ON faktur.IDPEGAWAI   = pegawai.IDPEGAWAI
     WHERE faktur.NoFaktur = '$NoFaktur'"
);
$header = mysqli_fetch_array($query_faktur);

if (!$header) {
    die("Data faktur tidak ditemukan.");
}

// Query detail_faktur
$query_detail = mysqli_query($conn,
    "SELECT detail_faktur.*, barang.NamaBarang, barang.HargaSatuan
     FROM detail_faktur
     JOIN barang ON detail_faktur.KodeBarang = barang.KodeBarang
     WHERE detail_faktur.NoFaktur = '$NoFaktur'"
);

// Format tanggal  →  "Palembang, _____ 20__"
$tgl = strtotime($header['Tanggal']);
$hari_nama  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'];
$bulan_nama = ['Januari','Februari','Maret','April','Mei','Juni',
               'Juli','Agustus','September','Oktober','November','Desember'];
$tanggal_str = date('j', $tgl) . ' ' . $bulan_nama[date('n', $tgl) - 1] . ' ' . date('Y', $tgl);

$detail_rows = [];
while ($d = mysqli_fetch_array($query_detail)) {
    $detail_rows[] = $d;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Faktur <?php echo htmlspecialchars($NoFaktur); ?> – Toko Adi Motor</title>
    <style>
        /* ── Reset & base ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            background: #f0f0f0;
            color: #111;
        }

        /* ── Tombol cetak (tidak ikut tercetak) ── */
        .no-print {
            text-align: center;
            padding: 18px;
            background: #fff;
            border-bottom: 1px solid #ccc;
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .btn-print {
            background: #f59e0b;
            color: #fff;
            border: none;
            padding: 10px 32px;
            border-radius: 6px;
            font-size: 14pt;
            font-family: Arial, sans-serif;
            cursor: pointer;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(0,0,0,.2);
            transition: background .2s;
        }
        .btn-print:hover { background: #d97706; }
        .btn-back {
            background: #6b7280;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 6px;
            font-size: 14pt;
            font-family: Arial, sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,.15);
            transition: background .2s;
        }
        .btn-back:hover { background: #4b5563; }

        /* ── Kertas ── */
        .page {
            width: 148mm;          /* lebar kertas A5 / setara gambar */
            min-height: 210mm;
            margin: 20px auto;
            background: #fff;
            padding: 10mm 12mm 12mm 12mm;
            border: 1px solid #aaa;
            box-shadow: 0 4px 18px rgba(0,0,0,.15);
        }

        /* ── Header kiri (logo toko) ── */
        .header-wrap {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6mm;
        }
        .toko-name { line-height: 1.2; }
        .toko-name .toko-label {
            font-size: 10pt;
            font-weight: normal;
        }
        .toko-name .toko-big {
            font-size: 20pt;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ── Header kanan (tanggal / kepada / dll) ── */
        .header-right {
            font-size: 10pt;
            line-height: 1.9;
            width: 58mm;
        }
        .header-right table { width: 100%; border-collapse: collapse; }
        .header-right td { vertical-align: top; }
        .header-right .label-col { white-space: nowrap; width: 48px; }
        .header-right .sep-col   { width: 8px; text-align: center; }
        .dotline {
            border-bottom: 1px dotted #555;
            display: inline-block;
            min-width: 70px;
        }

        /* ── Deskripsi toko ── */
        .toko-desc {
            font-size: 8pt;
            color: #444;
            font-style: italic;
            margin: 3mm 0;
            line-height: 1.5;
        }

        /* ── No Faktur ── */
        .faktur-no {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin: 2mm 0 3mm;
            letter-spacing: 0.5px;
        }

        /* ── Tabel Barang ── */
        .tbl-barang {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
        }
        .tbl-barang th, .tbl-barang td {
            border: 1px solid #333;
            text-align: center;
            padding: 1.8mm 2mm;
            font-size: 9.5pt;
            line-height: 1.3;
        }
        .tbl-barang th {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 9.5pt;
        }
        .tbl-barang .col-banyak  { width: 14%; }
        .tbl-barang .col-jenis   { width: 42%; text-align: left; padding-left: 3mm; }
        .tbl-barang .col-harga   { width: 22%; text-align: right; padding-right: 3mm; }
        .tbl-barang .col-jumlah  { width: 22%; text-align: right; padding-right: 3mm; }
        .tbl-barang td.col-jenis { text-align: left; padding-left: 3mm; }
        .tbl-barang td.col-harga { text-align: right; padding-right: 3mm; }
        .tbl-barang td.col-jumlah { text-align: right; padding-right: 3mm; }
        .tbl-barang .row-empty td { height: 7mm; }

        /* ── Total ── */
        .tbl-total {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
        }
        .tbl-total td {
            border: 1px solid #333;
            padding: 2mm 3mm;
            font-size: 10pt;
        }
        .tbl-total .note-cell {
            font-size: 7.5pt;
            font-style: italic;
            line-height: 1.5;
            width: 55%;
            vertical-align: top;
            border-right: none;
        }
        .tbl-total .total-label {
            width: 20%;
            font-weight: bold;
            text-align: right;
            border-left: none;
            border-right: 1px solid #333;
            vertical-align: middle;
        }
        .tbl-total .total-value {
            width: 25%;
            text-align: right;
            font-weight: bold;
            vertical-align: middle;
            padding-right: 4mm;
        }

        /* ── Tanda tangan ── */
        .ttd-wrap {
            display: flex;
            justify-content: space-between;
            margin-top: 4mm;
            font-size: 10pt;
        }
        .ttd-box { text-align: center; width: 42%; }
        .ttd-box .ttd-img-wrap {
            height: 18mm;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            margin-bottom: 1mm;
        }
        .ttd-box .ttd-img-wrap img {
            max-height: 16mm;
            max-width: 90%;
            object-fit: contain;
        }
        .ttd-box .ttd-placeholder {
            height: 18mm;
        }
        .ttd-box .ttd-line {
            border-top: 1px solid #333;
            padding-top: 2mm;
            font-size: 10pt;
        }

        /* ── Print media ── */
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .page {
                margin: 0;
                border: none;
                box-shadow: none;
                width: 148mm;
                padding: 8mm 10mm 10mm 10mm;
            }
        }
    </style>
</head>
<body>
<!-- Halaman Faktur -->
<div class="page">
    <!-- HEADER -->
    <div class="header-wrap">
        <!-- Kiri: identitas toko -->
        <div class="toko-name">
            <div class="toko-label">Toko</div>
            <div class="toko-big">ADI MOTOR</div>
        </div>

        <!-- Kanan: tanggal & kepada -->
        <div class="header-right">
            <table>
                <tr>
                    <td class="label-col">Palembang,</td>
                    <td colspan="2">
                        <span class="dotline">&nbsp;<?php echo $tanggal_str; ?>&nbsp;</span>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kepada Yth.</td>
                    <td class="sep-col">:</td>
                    <td><span class="dotline">&nbsp;<?php echo htmlspecialchars($header['NamaPelanggan'] ?? 'Pelanggan Umum'); ?>&nbsp;</span></td>
                </tr>
                <tr>
                    <td class="label-col">Toko</td>
                    <td class="sep-col">:</td>
                    <td><span class="dotline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
                <tr>
                    <td class="label-col">Toko</td>
                    <td class="sep-col">:</td>
                    <td><span class="dotline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- No Faktur -->
    <div class="faktur-no">Faktur No.&nbsp;&nbsp;<?php echo htmlspecialchars($NoFaktur); ?></div>

    <!-- Deskripsi Toko -->
    <div class="toko-desc">
        Menyediakan:<br>
        Berbagai jenis sparepart mesin diesel/bensin, baut, mur,<br>
        kabel-kabel, ring, alat-alat mekanik
    </div>

    <!-- TABEL BARANG -->
    <table class="tbl-barang">
        <thead>
            <tr>
                <th class="col-banyak">BANYAK</th>
                <th class="col-jenis">JENIS BARANG</th>
                <th class="col-harga">HARGA @</th>
                <th class="col-jumlah">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $count = count($detail_rows);
        // Baris berisi data
        foreach ($detail_rows as $row):
        ?>
            <tr>
                <td class="col-banyak"><?php echo $row['JumlahBarang']; ?></td>
                <td class="col-jenis"><?php echo htmlspecialchars($row['NamaBarang']); ?></td>
                <td class="col-harga">Rp <?php echo number_format($row['HargaSatuan'], 0, ',', '.'); ?></td>
                <td class="col-jumlah">Rp <?php echo number_format($row['HargaJumlah'], 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    <!-- TOTAL -->
    <table class="tbl-total">
        <tr>
            <td class="note-cell">
                NB.: Barang yg sudah diterima / dibeli tidak<br>dapat dikembalikan
            </td>
            <td class="total-label">TOTAL &nbsp;Rp.</td>
            <td class="total-value">
                <?php echo number_format($header['Total'], 0, ',', '.'); ?>
            </td>
        </tr>
    </table>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrap">
        <div class="ttd-box">
            Yang Menerima,
            <div class="ttd-placeholder"></div>
            <div class="ttd-line">
                <?php echo htmlspecialchars($header['NamaPelanggan'] ?? ''); ?>
            </div>
        </div>
        <div class="ttd-box">
            Hormat Kami,
            <?php if (!empty($header['TTD_Digital_Pegawai'])): ?>
            <div class="ttd-img-wrap">
                <img src="../ASSET/TTD/<?php echo htmlspecialchars($header['TTD_Digital_Pegawai']); ?>"
                     alt="TTD <?php echo htmlspecialchars($header['NamaPegawai'] ?? ''); ?>">
            </div>
            <?php else: ?>
            <div class="ttd-placeholder"></div>
            <?php endif; ?>
            <div class="ttd-line">
                <?php echo htmlspecialchars($header['NamaPegawai'] ?? ''); ?>
            </div>
        </div>
    </div>

</div><!-- /.page -->

</body>

<script>
// Deteksi apakah halaman dibuka di dalam iframe (dari fakturdetaillihat.php)
// atau langsung dari browser / link Cetak di fakturlihat.php
var inIframe = (window.self !== window.top);

if (!inIframe) {
    // Dibuka langsung → auto-print, lalu kembali ke daftar faktur setelah selesai
    window.onload = function () {
        window.print();
    };
    window.onafterprint = function () {
        window.location.href = 'fakturlihat.php';
    };
}
// Jika di dalam iframe → fakturdetaillihat.php yg memanggil print()
// via iframe.contentWindow.print(), tidak perlu auto-print di sini,
// dan TIDAK boleh redirect parent window.
</script>

</html>
