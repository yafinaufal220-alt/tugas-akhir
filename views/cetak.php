<?php
require_once '../model.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php?page=login");
    exit;
}

$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dari))   $dari   = date('Y-m-01');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $sampai)) $sampai = date('Y-m-d');

$dari_esc   = mysqli_real_escape_string($conn, $dari);
$sampai_esc = mysqli_real_escape_string($conn, $sampai);
$result = mysqli_query($conn,
    "SELECT * FROM barang
     WHERE tanggal_masuk BETWEEN '$dari_esc' AND '$sampai_esc'
     ORDER BY tanggal_masuk ASC, id ASC"
);

$rows = []; $total_val = 0; $total_qty = 0;
if ($result && mysqli_num_rows($result) > 0) {
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[]     = $r;
        $total_qty += $r['jumlah'];
        $total_val += ($r['jumlah'] * $r['harga']);
    }
}
$total_item = count($rows);

function fmt_tgl($date) {
    if (!$date || $date === '0000-00-00') return '—';
    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    [$y,$m,$d] = explode('-', $date);
    return (int)$d . ' ' . $bulan[(int)$m] . ' ' . $y;
}

$dari_fmt   = fmt_tgl($dari);
$sampai_fmt = fmt_tgl($sampai);
$cetak_oleh = htmlspecialchars($_SESSION['user']);
$cetak_pada = fmt_tgl(date('Y-m-d')) . ', ' . date('H:i') . ' WIB';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Inventori — StokPro</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

body {
    font-family: 'DM Sans', sans-serif;
    background: #f4f5f7;
    color: #1a1a2e;
    font-size: 13px;
    line-height: 1.5;
    -webkit-font-smoothing: antialiased;
}

/* ── TOOLBAR ── */
.toolbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    background: #1a1a2e;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    height: 54px;
    gap: 10px;
    flex-wrap: wrap;
}
.toolbar-left { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.toolbar-brand { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.3px; white-space: nowrap; }
.toolbar-brand span { color: #818cf8; }
.toolbar-info { font-size: 11px; color: rgba(255,255,255,0.4); white-space: nowrap; }
.toolbar-right { display: flex; align-items: center; gap: 8px; }
.btn-back, .btn-print {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600;
    padding: 7px 14px; border-radius: 9px; border: none; cursor: pointer;
    text-decoration: none; transition: all 0.2s; line-height: 1; white-space: nowrap;
}
.btn-back { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.12); }
.btn-back:hover { background: rgba(255,255,255,0.13); color: #fff; }
.btn-print { background: linear-gradient(135deg, #6366f1, #818cf8); color: white; box-shadow: 0 4px 14px rgba(99,102,241,0.4); }
.btn-print:hover { filter: brightness(1.1); }
.btn-back-text { display: inline; }

/* ── PAGE ── */
.page-wrap {
    margin-top: 70px;
    padding: 24px 20px 40px;
    max-width: 860px;
    margin-left: auto;
    margin-right: auto;
}

/* ── PAPER ── */
.report-paper {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    padding: 40px 44px;
}

/* ── REPORT HEADER ── */
.rpt-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 2px solid #f0f0f5;
    gap: 16px;
    flex-wrap: wrap;
}
.rpt-logo-area { display: flex; align-items: center; gap: 12px; }
.rpt-logo-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.rpt-logo-name { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; color: #1a1a2e; letter-spacing: -0.5px; line-height: 1; }
.rpt-logo-name span { color: #6366f1; }
.rpt-logo-sub { font-size: 10px; color: #9ca3af; margin-top: 3px; line-height: 1; }
.rpt-meta { text-align: right; }
.rpt-meta-title { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 800; color: #1a1a2e; letter-spacing: -0.3px; line-height: 1; }
.rpt-meta-period { font-size: 12px; color: #6366f1; font-weight: 600; margin-top: 5px; line-height: 1; }
.rpt-meta-info { font-size: 11px; color: #9ca3af; margin-top: 6px; line-height: 1.7; }

/* ── SUMMARY ── */
.summary-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 28px;
}
.sum-card { background: #f8f9ff; border: 1px solid #e8eaf6; border-radius: 10px; padding: 14px 16px; }
.sum-card.accent { background: linear-gradient(135deg, #6366f1, #818cf8); border-color: transparent; }
.sum-label { font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; line-height: 1; }
.sum-card.accent .sum-label { color: rgba(255,255,255,0.7); }
.sum-value { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; color: #1a1a2e; letter-spacing: -0.5px; line-height: 1; }
.sum-card.accent .sum-value { color: #fff; font-size: 14px; }

/* ── TABLE ── */
.rpt-table-wrap { margin-bottom: 24px; border-radius: 10px; overflow: hidden; border: 1px solid #e8eaf0; }
table { width: 100%; border-collapse: collapse; }
thead tr { background: #1a1a2e; }
thead th {
    padding: 11px 14px;
    font-size: 9px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
    color: rgba(255,255,255,0.7); text-align: left; white-space: nowrap; line-height: 1;
}
tbody tr { border-bottom: 1px solid #f0f0f5; }
tbody tr:last-child { border-bottom: none; }
tbody tr:nth-child(even) { background: #fafafa; }
tbody td { padding: 11px 14px; font-size: 12px; color: #374151; vertical-align: middle; line-height: 1.4; }
.td-no { font-size: 10px; font-weight: 700; color: #9ca3af; }
.td-name { font-weight: 600; color: #1a1a2e; font-size: 12px; }
.td-qty { font-weight: 700; color: #6366f1; text-align: center; }
.td-price { font-weight: 600; color: #059669; text-align: right; }
.td-total { font-weight: 700; color: #1a1a2e; text-align: right; }
.td-date { font-size: 11px; color: #6b7280; white-space: nowrap; }
.tfoot-row td { padding: 13px 14px; background: #f8f9ff; border-top: 2px solid #e8eaf0; font-weight: 700; font-size: 11px; }
.tfoot-label { font-family: 'Syne', sans-serif; font-size: 11px; font-weight: 800; color: #1a1a2e; }
.tfoot-val { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 800; color: #6366f1; text-align: right; }

/* ── MOBILE TABLE (cards) ── */
.rpt-mobile { display: none; }
.rpt-item {
    padding: 14px;
    border-bottom: 1px solid #f0f0f5;
}
.rpt-item:last-child { border-bottom: none; }
.rpt-item-name { font-weight: 700; font-size: 13px; color: #1a1a2e; margin-bottom: 8px; }
.rpt-item-row { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 4px; color: #6b7280; }
.rpt-item-row strong { color: #374151; font-weight: 600; }
.rpt-total-bar {
    padding: 14px;
    background: #f8f9ff;
    border-top: 2px solid #e8eaf0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.rpt-total-bar .label { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 800; color: #1a1a2e; }
.rpt-total-bar .val { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 800; color: #6366f1; }

/* ── EMPTY ── */
.rpt-empty { text-align: center; padding: 48px 20px; color: #9ca3af; }
.rpt-empty-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: #6b7280; margin-bottom: 6px; margin-top: 14px; }
.rpt-empty-sub { font-size: 12px; }

/* ── FOOTER ── */
.rpt-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-top: 20px;
    border-top: 1px solid #f0f0f5;
    gap: 16px;
    flex-wrap: wrap;
}
.rpt-footer-note { font-size: 11px; color: #9ca3af; line-height: 1.7; }
.rpt-footer-note strong { color: #6b7280; }
.ttd-area { text-align: center; min-width: 140px; }
.ttd-label { font-size: 11px; color: #6b7280; margin-bottom: 44px; line-height: 1; }
.ttd-name { font-weight: 700; font-size: 12px; color: #1a1a2e; border-top: 1.5px solid #1a1a2e; padding-top: 5px; }
.ttd-role { font-size: 10px; color: #9ca3af; margin-top: 2px; }

/* ── RESPONSIVE TABLET (≤640px) ── */
@media (max-width: 640px) {
    /* Toolbar: hide info text, shrink back button */
    .toolbar-info  { display: none; }
    .btn-back-text { display: none; }
    .btn-back      { padding: 7px 10px; gap: 0; }

    /* Page layout */
    .page-wrap    { padding: 16px 12px 32px; margin-top: 62px; }
    .report-paper { padding: 28px 20px; }

    /* Report header stacks */
    .rpt-head { flex-direction: column; }
    .rpt-meta { text-align: left; }

    /* Summary: 2 col, nilai full-width */
    .summary-row          { grid-template-columns: 1fr 1fr; }
    .sum-card.accent      { grid-column: 1 / -1; }

    /* Hide desktop table, show mobile cards */
    .rpt-table-wrap table { display: none; }
    .rpt-mobile           { display: block; }

    /* Footer stacks */
    .rpt-footer { flex-direction: column; }
    .ttd-area   { align-self: flex-end; }
}

/* ── RESPONSIVE MOBILE (≤400px) ── */
@media (max-width: 400px) {
    .toolbar      { padding: 0 12px; }
    .summary-row  { grid-template-columns: 1fr; }
    .sum-card.accent { grid-column: auto; }
}

/* ── PRINT ── */
@media print {
    .toolbar { display: none !important; }
    body { background: white; }
    .page-wrap { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
    .report-paper { border-radius: 0 !important; box-shadow: none !important; padding: 24px 32px !important; }
    .rpt-mobile { display: none !important; }
    .rpt-table-wrap table { display: table !important; }
    tbody tr:nth-child(even) { background: #f9f9f9 !important; }
    thead tr { background: #1a1a2e !important; }
}
</style>
</head>
<body>

<div class="toolbar">
    <div class="toolbar-left">
        <div class="toolbar-brand">Stok<span>Pro</span></div>
        <div class="toolbar-info">Pratinjau Laporan Inventori</div>
    </div>
    <div class="toolbar-right">
        <a href="../index.php?page=dashboard" class="btn-back">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            <span class="btn-back-text">Kembali</span>
        </a>
        <button class="btn-print" onclick="window.print()">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak / PDF
        </button>
    </div>
</div>

<div class="page-wrap">
<div class="report-paper">

    <div class="rpt-head">
        <div class="rpt-logo-area">
            <div class="rpt-logo-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
            <div>
                <div class="rpt-logo-name">Stok<span>Pro</span></div>
                <div class="rpt-logo-sub">Inventory Management System</div>
            </div>
        </div>
        <div class="rpt-meta">
            <div class="rpt-meta-title">Laporan Inventori</div>
            <div class="rpt-meta-period"><?= $dari_fmt ?> — <?= $sampai_fmt ?></div>
            <div class="rpt-meta-info">
                Dicetak oleh: <strong><?= $cetak_oleh ?></strong><br>
                Pada: <?= $cetak_pada ?>
            </div>
        </div>
    </div>

    <div class="summary-row">
        <div class="sum-card">
            <div class="sum-label">Total Jenis</div>
            <div class="sum-value"><?= $total_item ?></div>
        </div>
        <div class="sum-card">
            <div class="sum-label">Total Unit</div>
            <div class="sum-value"><?= number_format($total_qty, 0, ',', '.') ?></div>
        </div>
        <div class="sum-card accent">
            <div class="sum-label">Total Nilai Inventori</div>
            <div class="sum-value">Rp <?= number_format($total_val, 0, ',', '.') ?></div>
        </div>
    </div>

    <?php if ($total_item > 0): ?>
    <div class="rpt-table-wrap">
        <!-- Desktop table -->
        <table>
            <thead>
                <tr>
                    <th style="width:32px">#</th>
                    <th>Nama Barang</th>
                    <th style="width:90px; text-align:center">Stok</th>
                    <th style="width:130px; text-align:right">Harga Satuan</th>
                    <th style="width:140px; text-align:right">Nilai Stok</th>
                    <th style="width:110px">Tgl Masuk</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $i => $row):
                $nilai = $row['jumlah'] * $row['harga'];
            ?>
            <tr>
                <td class="td-no"><?= sprintf('%02d', $i+1) ?></td>
                <td class="td-name"><?= htmlspecialchars($row['nama_barang'] ?: '—') ?></td>
                <td class="td-qty"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                <td class="td-price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td class="td-total">Rp <?= number_format($nilai, 0, ',', '.') ?></td>
                <td class="td-date"><?= fmt_tgl($row['tanggal_masuk']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="tfoot-row">
                    <td colspan="2" class="tfoot-label">TOTAL KESELURUHAN</td>
                    <td class="td-qty tfoot-val" style="text-align:center"><?= number_format($total_qty, 0, ',', '.') ?></td>
                    <td></td>
                    <td class="tfoot-val">Rp <?= number_format($total_val, 0, ',', '.') ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <!-- Mobile cards -->
        <div class="rpt-mobile">
            <?php foreach ($rows as $i => $row):
                $nilai = $row['jumlah'] * $row['harga'];
            ?>
            <div class="rpt-item">
                <div class="rpt-item-name"><?= sprintf('%02d', $i+1) ?>. <?= htmlspecialchars($row['nama_barang'] ?: '—') ?></div>
                <div class="rpt-item-row"><span>Stok</span><strong><?= number_format($row['jumlah'], 0, ',', '.') ?> unit</strong></div>
                <div class="rpt-item-row"><span>Harga Satuan</span><strong style="color:#059669">Rp <?= number_format($row['harga'], 0, ',', '.') ?></strong></div>
                <div class="rpt-item-row"><span>Nilai Stok</span><strong>Rp <?= number_format($nilai, 0, ',', '.') ?></strong></div>
                <div class="rpt-item-row"><span>Tgl Masuk</span><strong><?= fmt_tgl($row['tanggal_masuk']) ?></strong></div>
            </div>
            <?php endforeach; ?>
            <div class="rpt-total-bar">
                <span class="label">TOTAL NILAI</span>
                <span class="val">Rp <?= number_format($total_val, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="rpt-empty">
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" style="display:block; margin:0 auto"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <div class="rpt-empty-title">Tidak Ada Data</div>
        <div class="rpt-empty-sub">Tidak ada barang pada periode <?= $dari_fmt ?> — <?= $sampai_fmt ?></div>
    </div>
    <?php endif; ?>

    <div class="rpt-footer">
        <div class="rpt-footer-note">
            <strong>Catatan:</strong><br>
            Laporan dibuat otomatis oleh sistem StokPro.<br>
            Data menampilkan barang yang masuk pada periode yang dipilih.
        </div>
        <div class="ttd-area">
            <div class="ttd-label">Dibuat oleh,</div>
            <div class="ttd-name"><?= $cetak_oleh ?></div>
            <div class="ttd-role"><?= htmlspecialchars($_SESSION['role'] ?? 'Staff') ?></div>
        </div>
    </div>

</div>
</div>
</body>
</html>