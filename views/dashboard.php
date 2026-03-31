<?php $isAdmin = ($_SESSION['role'] ?? '') === 'admin'; ?>
<style>
.dash-wrap, .dash-wrap * {
    font-family: var(--font-body);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.dash-wrap .page-title,
.dash-wrap .tbl-title,
.dash-wrap .stat-value { font-family: var(--font-head); }

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 12px;
    flex-wrap: wrap;
}
.page-title {
    font-size: 28px;
    font-weight: 800;
    color: var(--white);
    letter-spacing: -0.8px;
    line-height: 1;
}
.page-subtitle {
    font-size: 13px;
    color: var(--muted);
    margin-top: 6px;
    line-height: 1.4;
}
.page-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

/* ── STATS ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 28px;
}
.stat-card {
    background: var(--ink-2);
    border: 1px solid var(--line);
    border-radius: var(--radius-lg);
    padding: 22px 24px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.2s;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 100px; height: 100px;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.4;
    pointer-events: none;
}
.stat-card.c-purple::before { background: var(--accent); }
.stat-card.c-green::before  { background: var(--green); }
.stat-card.c-gold::before   { background: var(--gold); }
.stat-card:hover { border-color: var(--line-2); }
.stat-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
    line-height: 1;
}
.stat-value {
    font-size: 26px;
    font-weight: 800;
    color: var(--white);
    letter-spacing: -0.8px;
    line-height: 1;
    word-break: break-all;
}
.stat-value.c-purple { color: var(--accent-2); }
.stat-value.c-green  { color: #34d399; }
.stat-value.c-gold   { color: #fbbf24; font-size: 18px; }

/* ── TABLE ── */
.tbl-wrap {
    background: var(--ink-2);
    border: 1px solid var(--line);
    border-radius: var(--radius-lg);
    overflow: hidden;
}
.tbl-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 22px;
    border-bottom: 1px solid var(--line);
    flex-wrap: wrap;
    gap: 6px;
}
.tbl-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--white);
    line-height: 1;
}
.tbl-count { font-size: 12px; color: var(--muted); line-height: 1; }

/* Desktop table */
.tbl-desktop { width: 100%; border-collapse: collapse; }
thead th {
    padding: 11px 18px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    text-align: left;
    background: rgba(255,255,255,0.02);
    border-bottom: 1px solid var(--line);
    white-space: nowrap;
    line-height: 1;
}
.tbl-row td {
    padding: 14px 18px;
    font-size: 13px;
    color: var(--off-white);
    border-bottom: 1px solid var(--line);
    transition: background 0.15s;
    vertical-align: middle;
    line-height: 1.4;
}
.tbl-row:last-child td { border-bottom: none; }
.row-num { font-size: 11px; font-weight: 600; color: var(--muted); line-height: 1; }
.item-img {
    width: 40px; height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid var(--line-2);
    cursor: zoom-in;
    transition: transform 0.2s, border-color 0.2s;
    display: block;
}
.item-img:hover { transform: scale(1.1); border-color: var(--accent); }
.img-placeholder {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: var(--ink-3);
    border: 1px dashed var(--line-2);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
}
.item-name { font-size: 13px; font-weight: 600; color: var(--white); line-height: 1.3; }
.qty-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(99,102,241,0.12);
    color: var(--accent-2);
    border: 1px solid rgba(99,102,241,0.2);
    border-radius: 8px;
    padding: 4px 9px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    white-space: nowrap;
}
.qty-badge .qty-unit { font-size: 10px; font-weight: 400; color: var(--muted); }
.price-text { font-size: 13px; font-weight: 700; color: #34d399; line-height: 1; }
.price-prefix { font-size: 11px; color: var(--muted); font-weight: 400; }
.nilai-text { font-size: 12px; color: var(--muted-2); line-height: 1; }
.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--muted-2);
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 4px 8px;
    white-space: nowrap;
    line-height: 1;
}
.actions-cell { display: flex; gap: 6px; align-items: center; flex-wrap: nowrap; white-space: nowrap; }

/* ── MOBILE CARDS ── */
.tbl-mobile { display: none; }
.item-card {
    padding: 16px;
    border-bottom: 1px solid var(--line);
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.item-card:last-child { border-bottom: none; }
.item-card-img {
    width: 52px; height: 52px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid var(--line-2);
    flex-shrink: 0;
}
.item-card-img-placeholder {
    width: 52px; height: 52px;
    border-radius: 12px;
    background: var(--ink-3);
    border: 1px dashed var(--line-2);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
    flex-shrink: 0;
}
.item-card-body { flex: 1; min-width: 0; }
.item-card-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--white);
    line-height: 1.3;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.item-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
}
.item-card-row {
    font-size: 12px;
    color: var(--muted-2);
    display: flex;
    gap: 4px;
    align-items: center;
    width: 100%;
}
.item-card-row strong { color: var(--off-white); font-weight: 600; }
.item-card-actions { display: flex; gap: 8px; }

/* ── EMPTY STATE ── */
.empty-state { padding: 60px 20px; text-align: center; }
.empty-icon { font-size: 44px; margin-bottom: 14px; opacity: 0.25; display: block; }
.empty-title { font-family: var(--font-head); font-size: 17px; font-weight: 700; color: var(--muted-2); margin-bottom: 6px; }
.empty-desc { font-size: 13px; color: var(--muted); }

/* ── LIGHTBOX ── */
.lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999;
    background: rgba(0,0,0,0.88);
    backdrop-filter: blur(12px);
    place-items: center;
}
.lightbox.open { display: grid; }
.lightbox-img {
    max-width: 92vw;
    max-height: 85vh;
    border-radius: 16px;
    box-shadow: 0 40px 80px rgba(0,0,0,0.8);
    border: 1px solid var(--line-2);
}
.lightbox-close {
    position: fixed;
    top: 20px; right: 20px;
    font-size: 28px;
    color: var(--muted-2);
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s;
    width: 36px; height: 36px;
    background: var(--ink-2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--line-2);
}
.lightbox-close:hover { color: var(--white); }

/* ── PRINT MODAL ── */
.print-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 500;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.print-modal-overlay.open { display: flex; animation: pmOverlayIn 0.2s ease; }
@keyframes pmOverlayIn { from { opacity:0; } to { opacity:1; } }
.print-modal {
    background: var(--ink-2);
    border: 1px solid var(--line-2);
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.7);
    animation: pmIn 0.25s cubic-bezier(0.34, 1.3, 0.64, 1);
    max-height: 92vh;
    overflow-y: auto;
}
@keyframes pmIn {
    from { opacity:0; transform: scale(0.9) translateY(20px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}
.pm-head {
    padding: 20px 22px 16px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    background: var(--ink-2);
    z-index: 1;
}
.pm-head-left { display: flex; align-items: center; gap: 12px; }
.pm-icon {
    width: 38px; height: 38px;
    background: rgba(99,102,241,0.15);
    border: 1px solid rgba(99,102,241,0.25);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--accent-2);
    flex-shrink: 0;
}
.pm-title { font-family: var(--font-head); font-size: 14px; font-weight: 800; color: var(--white); line-height: 1.2; }
.pm-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }
.pm-close {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: transparent;
    border: 1px solid var(--line-2);
    color: var(--muted-2);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.pm-close:hover { background: var(--ink-3); color: var(--white); }
.pm-body { padding: 20px 22px 24px; }
.pm-field { margin-bottom: 14px; }
.pm-field label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 6px;
    line-height: 1;
}
.pm-field input[type="date"] {
    width: 100%;
    height: 44px;
    padding: 0 12px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: 12px;
    color: var(--white);
    font-family: var(--font-body);
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
    -webkit-appearance: none;
}
.pm-field input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(0.6); cursor: pointer; }
.pm-field input[type="date"]:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
.pm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pm-shortcuts { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
.pm-shortcut {
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 8px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    color: var(--muted-2);
    cursor: pointer;
    transition: all 0.15s;
    line-height: 1;
    user-select: none;
}
.pm-shortcut:hover { background: rgba(99,102,241,0.12); border-color: rgba(99,102,241,0.3); color: var(--accent-2); }
.pm-preview {
    background: var(--ink-3);
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 10px 12px;
    margin-bottom: 16px;
    font-size: 12px;
    color: var(--muted-2);
    display: flex;
    align-items: center;
    gap: 8px;
    line-height: 1.4;
}
.pm-preview-val { color: var(--accent-2); font-weight: 600; }
.pm-btn {
    width: 100%;
    height: 44px;
    border: none;
    border-radius: 12px;
    font-family: var(--font-head);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    background: linear-gradient(135deg, var(--accent), #7c7ff5);
    color: white;
    box-shadow: 0 4px 16px var(--accent-glow);
    display: flex; align-items: center; justify-content: center;
    gap: 8px;
    text-decoration: none;
    line-height: 1;
}
.pm-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 24px var(--accent-glow); filter: brightness(1.1); }

/* ════════════════════════════════
   RESPONSIVE — TABLET
════════════════════════════════ */
/* ── RESPONSIVE TABLET (≤768px) ── */
@media (max-width: 768px) {
    /* Hide desktop table, show mobile cards */
    .tbl-desktop { display: none; }
    .tbl-mobile  { display: block; }

    /* Page header actions wrap below title */
    .page-header  { align-items: flex-start; }
    .page-actions { width: 100%; }

    /* Print modal date row */
    .pm-row { grid-template-columns: 1fr 1fr; }
}

/* ── RESPONSIVE MOBILE (≤480px) ── */
@media (max-width: 480px) {
    /* Stats stack vertically */
    .stats-row { grid-template-columns: 1fr; }

    /* Print modal date inputs stack */
    .pm-row { grid-template-columns: 1fr; }
}
</style>

<?php
$data      = tampilBarang();
$total     = 0;
$total_val = 0;
$rows      = [];
if ($data && mysqli_num_rows($data) > 0) {
    while ($r = mysqli_fetch_assoc($data)) {
        $rows[]    = $r;
        $total++;
        $total_val += ($r['jumlah'] * $r['harga']);
    }
}
$total_qty = array_sum(array_column($rows, 'jumlah'));
?>

<div class="dash-wrap">

<!-- Page Header -->
<div class="page-header" data-animate>
    <div>
        <h1 class="page-title">Inventory</h1>
        <p class="page-subtitle">Kelola semua stok barang Anda dalam satu tempat</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-ghost" onclick="openPrintModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak
        </button>
        <?php if ($isAdmin): ?>
        <a href="index.php?page=form" class="btn btn-success">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Barang
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card c-purple" data-animate>
        <div class="stat-label">Total Jenis Barang</div>
        <div class="stat-value c-purple"><?= $total ?></div>
    </div>
    <div class="stat-card c-green" data-animate>
        <div class="stat-label">Total Unit Stok</div>
        <div class="stat-value c-green"><?= number_format($total_qty, 0, ',', '.') ?></div>
    </div>
    <div class="stat-card c-gold" data-animate>
        <div class="stat-label">Nilai Inventori</div>
        <div class="stat-value c-gold">Rp <?= number_format($total_val, 0, ',', '.') ?></div>
    </div>
</div>

<!-- Table -->
<div class="tbl-wrap" data-animate>
    <div class="tbl-header">
        <span class="tbl-title">Daftar Stok Barang</span>
        <span class="tbl-count"><?= $total ?> item terdaftar</span>
    </div>

    <?php if ($total > 0): ?>

    <!-- DESKTOP TABLE -->
    <table class="tbl-desktop">
        <thead>
            <tr>
                <th style="width:40px; padding-left:22px">#</th>
                <th style="width:56px">Foto</th>
                <th>Nama Barang</th>
                <th style="width:110px; text-align:center">Stok</th>
                <th style="width:150px">Harga Satuan</th>
                <th style="width:140px">Nilai Stok</th>
                <th style="width:130px">Tgl Masuk</th>
                <?php if ($isAdmin): ?><th style="width:140px; text-align:center">Aksi</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $row):
            $nama  = !empty($row['nama_barang']) ? $row['nama_barang'] : '—';
            $foto  = !empty($row['foto']) ? "assets/img/" . $row['foto'] : null;
            $nilai = $row['jumlah'] * $row['harga'];
            $tgl_raw = $row['tanggal_masuk'] ?? '';
            $tgl_fmt = ($tgl_raw && $tgl_raw !== '0000-00-00') ? date('d M Y', strtotime($tgl_raw)) : '—';
        ?>
        <tr class="tbl-row">
            <td style="padding-left:22px"><span class="row-num"><?= sprintf('%02d', $i+1) ?></span></td>
            <td>
                <?php if ($foto && file_exists($foto)): ?>
                    <img src="<?= $foto ?>" class="item-img" alt="foto" onclick="openLB('<?= $foto ?>')">
                <?php else: ?>
                    <div class="img-placeholder">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                <?php endif; ?>
            </td>
            <td><span class="item-name"><?= htmlspecialchars($nama) ?></span></td>
            <td style="text-align:center">
                <span class="qty-badge"><?= number_format($row['jumlah'], 0, ',', '.') ?> <span class="qty-unit">unit</span></span>
            </td>
            <td><span class="price-prefix">Rp&nbsp;</span><span class="price-text"><?= number_format($row['harga'], 0, ',', '.') ?></span></td>
            <td><span class="nilai-text">Rp <?= number_format($nilai, 0, ',', '.') ?></span></td>
            <td>
                <span class="date-badge">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <?= $tgl_fmt ?>
                </span>
            </td>
            <?php if ($isAdmin): ?>
            <td>
                <div class="actions-cell">
                    <a href="index.php?page=form&id=<?= $row['id'] ?>" class="btn btn-edit-sm">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <a href="index.php?action=hapus&id=<?= $row['id'] ?>" class="btn btn-delete-sm" onclick="return confirm('Hapus <?= htmlspecialchars($nama, ENT_QUOTES) ?>?')">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                        Hapus
                    </a>
                </div>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- MOBILE CARDS -->
    <div class="tbl-mobile">
        <?php foreach ($rows as $i => $row):
            $nama  = !empty($row['nama_barang']) ? $row['nama_barang'] : '—';
            $foto  = !empty($row['foto']) ? "assets/img/" . $row['foto'] : null;
            $nilai = $row['jumlah'] * $row['harga'];
            $tgl_raw = $row['tanggal_masuk'] ?? '';
            $tgl_fmt = ($tgl_raw && $tgl_raw !== '0000-00-00') ? date('d M Y', strtotime($tgl_raw)) : '—';
        ?>
        <div class="item-card">
            <?php if ($foto && file_exists($foto)): ?>
                <img src="<?= $foto ?>" class="item-card-img" alt="foto" onclick="openLB('<?= $foto ?>')">
            <?php else: ?>
                <div class="item-card-img-placeholder">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
            <?php endif; ?>
            <div class="item-card-body">
                <div class="item-card-name"><?= htmlspecialchars($nama) ?></div>
                <div class="item-card-meta">
                    <div class="item-card-row">
                        <span>Stok:</span>
                        <strong><?= number_format($row['jumlah'], 0, ',', '.') ?> unit</strong>
                    </div>
                    <div class="item-card-row">
                        <span>Harga:</span>
                        <strong style="color:#34d399">Rp <?= number_format($row['harga'], 0, ',', '.') ?></strong>
                    </div>
                    <div class="item-card-row">
                        <span>Nilai:</span>
                        <strong>Rp <?= number_format($nilai, 0, ',', '.') ?></strong>
                    </div>
                    <div class="item-card-row">
                        <span>Tgl Masuk:</span>
                        <strong><?= $tgl_fmt ?></strong>
                    </div>
                </div>
                <?php if ($isAdmin): ?>
                <div class="item-card-actions">
                    <a href="index.php?page=form&id=<?= $row['id'] ?>" class="btn btn-edit-sm">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <a href="index.php?action=hapus&id=<?= $row['id'] ?>" class="btn btn-delete-sm" onclick="return confirm('Hapus <?= htmlspecialchars($nama, ENT_QUOTES) ?>?')">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Hapus
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <span class="empty-icon">📦</span>
        <div class="empty-title">Belum Ada Data Barang</div>
        <div class="empty-desc">Klik "Tambah Barang" untuk mulai mengisi inventori</div>
    </div>
    <?php endif; ?>
</div>

</div><!-- /.dash-wrap -->

<!-- Print Modal -->
<div class="print-modal-overlay" id="printModal" onclick="handlePrintOverlay(event)">
    <div class="print-modal">
        <div class="pm-head">
            <div class="pm-head-left">
                <div class="pm-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                </div>
                <div>
                    <div class="pm-title">Cetak Laporan</div>
                    <div class="pm-sub">Pilih rentang tanggal</div>
                </div>
            </div>
            <button class="pm-close" onclick="closePrintModal()">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="pm-body">
            <div style="font-size:10px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Pilihan Cepat</div>
            <div class="pm-shortcuts">
                <span class="pm-shortcut" onclick="setRange('bulan_ini')">Bulan Ini</span>
                <span class="pm-shortcut" onclick="setRange('bulan_lalu')">Bulan Lalu</span>
                <span class="pm-shortcut" onclick="setRange('3bulan')">3 Bulan Terakhir</span>
                <span class="pm-shortcut" onclick="setRange('tahun_ini')">Tahun Ini</span>
                <span class="pm-shortcut" onclick="setRange('semua')">Semua Data</span>
            </div>
            <div class="pm-row">
                <div class="pm-field">
                    <label>Dari Tanggal</label>
                    <input type="date" id="pm_dari" onchange="updatePreview()">
                </div>
                <div class="pm-field">
                    <label>Sampai Tanggal</label>
                    <input type="date" id="pm_sampai" onchange="updatePreview()">
                </div>
            </div>
            <div class="pm-preview" id="pmPreview">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span id="pmPreviewText">Pilih rentang tanggal di atas</span>
            </div>
            <a class="pm-btn" id="pmPrintBtn" href="#" target="_blank" onclick="return handlePrint()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Buka Halaman Cetak
            </a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lb" onclick="closeLB()">
    <span class="lightbox-close" onclick="closeLB()">&times;</span>
    <img class="lightbox-img" id="lb-img" src="" alt="">
</div>

<script>
function openLB(src) { document.getElementById('lb').classList.add('open'); document.getElementById('lb-img').src = src; }
function closeLB() { document.getElementById('lb').classList.remove('open'); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeLB(); closePrintModal(); } });

function openPrintModal() {
    const today = new Date();
    const y = today.getFullYear(), m = String(today.getMonth()+1).padStart(2,'0'), d = String(today.getDate()).padStart(2,'0');
    document.getElementById('pm_dari').value   = y + '-' + m + '-01';
    document.getElementById('pm_sampai').value = y + '-' + m + '-' + d;
    updatePreview();
    document.getElementById('printModal').classList.add('open');
}
function closePrintModal() { document.getElementById('printModal').classList.remove('open'); }
function handlePrintOverlay(e) { if (e.target === document.getElementById('printModal')) closePrintModal(); }

function fmt(dateStr) {
    if (!dateStr) return '—';
    const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const [y,m,d] = dateStr.split('-');
    return parseInt(d) + ' ' + bulan[parseInt(m)-1] + ' ' + y;
}
function updatePreview() {
    const dari = document.getElementById('pm_dari').value;
    const sampai = document.getElementById('pm_sampai').value;
    const prev = document.getElementById('pmPreviewText');
    if (dari && sampai) {
        prev.innerHTML = 'Laporan: <span class="pm-preview-val">' + fmt(dari) + '</span> — <span class="pm-preview-val">' + fmt(sampai) + '</span>';
    } else {
        prev.innerHTML = 'Pilih rentang tanggal di atas';
    }
}
function setRange(type) {
    const today = new Date();
    const y = today.getFullYear(), m = today.getMonth();
    const pad = n => String(n).padStart(2,'0');
    const toStr = d => d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate());
    let dari, sampai;
    if (type === 'bulan_ini')  { dari = new Date(y,m,1);   sampai = new Date(y,m+1,0); }
    else if (type === 'bulan_lalu') { dari = new Date(y,m-1,1); sampai = new Date(y,m,0); }
    else if (type === '3bulan')     { dari = new Date(y,m-2,1); sampai = new Date(y,m+1,0); }
    else if (type === 'tahun_ini')  { dari = new Date(y,0,1);   sampai = new Date(y,11,31); }
    else if (type === 'semua')      { dari = new Date(2000,0,1); sampai = new Date(y,11,31); }
    document.getElementById('pm_dari').value   = toStr(dari);
    document.getElementById('pm_sampai').value = toStr(sampai);
    updatePreview();
}
function handlePrint() {
    const dari   = document.getElementById('pm_dari').value;
    const sampai = document.getElementById('pm_sampai').value;
    if (!dari || !sampai) { alert('Pilih tanggal dari dan sampai.'); return false; }
    if (dari > sampai)    { alert('Tanggal "Dari" tidak boleh lebih besar dari "Sampai".'); return false; }
    window.open('views/cetak.php?dari=' + dari + '&sampai=' + sampai, '_blank');
    closePrintModal();
    return false;
}
</script>