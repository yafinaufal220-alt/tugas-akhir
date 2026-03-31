<?php
$id   = isset($_GET['id']) ? (int)$_GET['id'] : null;
$item = $id ? getBarangById($id) : null;
$mode = $id ? 'edit' : 'add';
$default_tanggal = date('Y-m-d');
$current_tanggal = ($item && !empty($item['tanggal_masuk'])) ? $item['tanggal_masuk'] : $default_tanggal;
?>
<style>
.form-page, .form-page * {
    font-family: var(--font-body);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.form-page .form-card-title { font-family: var(--font-head); }

.form-page {
    max-width: 620px;
    margin: 0 auto;
}

.form-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted-2);
    text-decoration: none;
    margin-bottom: 24px;
    transition: color 0.2s;
    line-height: 1;
}
.form-back:hover { color: var(--white); }

.form-card {
    background: var(--ink-2);
    border: 1px solid var(--line-2);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.form-card-header {
    padding: 24px 28px 20px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    gap: 14px;
}
.form-card-icon {
    width: 44px; height: 44px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.icon-add  { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
.icon-edit { background: rgba(99,102,241,0.15); color: var(--accent-2); border: 1px solid rgba(99,102,241,0.25); }

.form-card-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--white);
    line-height: 1.2;
    letter-spacing: -0.3px;
}
.form-card-sub {
    font-size: 12px;
    color: var(--muted-2);
    margin-top: 3px;
    line-height: 1.4;
}

.form-body { padding: 28px; }

.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.field-group { margin-bottom: 20px; }
.field-group label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 7px;
    line-height: 1;
}
.field-group input[type="text"],
.field-group input[type="number"],
.field-group input[type="date"] {
    width: 100%;
    height: 46px;
    padding: 0 14px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: var(--radius);
    color: var(--white);
    font-family: var(--font-body);
    font-size: 14px;
    line-height: 46px;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    box-sizing: border-box;
    -webkit-appearance: none;
    appearance: none;
}
.field-group input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.6); cursor: pointer; opacity: 0.7;
}
.field-group input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
    background: var(--ink-2);
}
.field-group input::placeholder { color: var(--muted); }

/* File upload */
.file-upload-label {
    display: flex;
    align-items: center;
    gap: 12px;
    height: 46px;
    padding: 0 14px;
    background: var(--ink-3);
    border: 1px dashed var(--line-2);
    border-radius: var(--radius);
    cursor: pointer;
    transition: all 0.2s;
    color: var(--muted-2);
    font-size: 13px;
    font-weight: 500;
    line-height: 1;
}
.file-upload-label:hover { border-color: var(--accent); color: var(--accent-2); background: rgba(99,102,241,0.05); }
.file-upload-label input[type="file"] { display: none; }
.current-file {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    margin-top: 7px;
    font-size: 11px;
    color: #34d399;
    line-height: 1.5;
}

/* Prefix wrapper */
.input-prefix-wrap { position: relative; }
.input-prefix {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    pointer-events: none;
    line-height: 1;
}
.input-prefix-wrap input { padding-left: 36px; }

/* Section label */
.section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-label::after { content: ''; flex: 1; height: 1px; background: var(--line); }

/* Actions */
.form-actions {
    display: flex;
    gap: 10px;
    padding-top: 6px;
}
.btn-form-submit {
    flex: 1;
    height: 48px;
    border: none;
    border-radius: var(--radius);
    font-family: var(--font-head);
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.2px;
    cursor: pointer;
    transition: all 0.2s;
    line-height: 1;
}
.btn-form-submit.add {
    background: linear-gradient(135deg, var(--green), #059669);
    color: white;
    box-shadow: 0 4px 16px var(--green-glow);
}
.btn-form-submit.add:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--green-glow); }
.btn-form-submit.edit {
    background: linear-gradient(135deg, var(--accent), #7c7ff5);
    color: white;
    box-shadow: 0 4px 16px var(--accent-glow);
}
.btn-form-submit.edit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--accent-glow); }
.btn-cancel {
    height: 48px;
    padding: 0 22px;
    background: transparent;
    border: 1px solid var(--line-2);
    border-radius: var(--radius);
    color: var(--muted-2);
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    line-height: 1;
    white-space: nowrap;
}
.btn-cancel:hover { background: var(--ink-3); color: var(--white); }

/* ── RESPONSIVE TABLET (≤600px) ── */
@media (max-width: 600px) {
    .form-body        { padding: 20px 16px; }
    .form-card-header { padding: 20px 16px 16px; }
    /* Stok & Harga: 2 col → 1 col */
    .field-row        { grid-template-columns: 1fr; }
    /* Actions stack */
    .form-actions     { flex-direction: column; }
    .btn-cancel       { width: 100%; justify-content: center; }
}
</style>

<div class="form-page" data-animate>
    <a href="index.php?page=dashboard" class="form-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Dashboard
    </a>

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon <?= $mode === 'add' ? 'icon-add' : 'icon-edit' ?>">
                <?php if ($mode === 'add'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <?php endif; ?>
            </div>
            <div>
                <div class="form-card-title"><?= $mode === 'add' ? 'Tambah Barang Baru' : 'Edit Data Barang' ?></div>
                <div class="form-card-sub">
                    <?= $mode === 'add' ? 'Isi detail barang yang ingin ditambahkan' : 'Memperbarui: ' . htmlspecialchars($item['nama_barang'] ?? '') ?>
                </div>
            </div>
        </div>

        <div class="form-body">
            <form action="index.php?action=<?= $mode === 'add' ? 'tambah' : 'edit' ?>" method="POST" enctype="multipart/form-data">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="section-label">Info Barang</div>

                <div class="field-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama"
                           value="<?= $item ? htmlspecialchars($item['nama_barang']) : '' ?>"
                           placeholder="Contoh: Laptop ASUS VivoBook 14" required>
                </div>

                <div class="field-group">
                    <label>Foto Barang</label>
                    <label class="file-upload-label">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <span id="file-label-text">Klik untuk pilih foto...</span>
                        <input type="file" name="foto" accept="image/*" onchange="updateFileName(this)">
                    </label>
                    <?php if ($item && !empty($item['foto'])): ?>
                    <div class="current-file">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        File aktif: <?= htmlspecialchars($item['foto']) ?> — kosongkan jika tidak ingin mengubah
                    </div>
                    <?php endif; ?>
                </div>

                <div class="section-label">Stok &amp; Harga</div>

                <div class="field-row">
                    <div class="field-group">
                        <label>Jumlah Stok (Unit)</label>
                        <input type="number" name="jumlah" min="0"
                               value="<?= $item ? $item['jumlah'] : '' ?>"
                               placeholder="0" required>
                    </div>
                    <div class="field-group">
                        <label>Harga Satuan (Rp)</label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" name="harga" min="0" step="100"
                                   value="<?= $item ? $item['harga'] : '' ?>"
                                   placeholder="0" required>
                        </div>
                    </div>
                </div>

                <div class="section-label">Tanggal</div>

                <div class="field-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk"
                           value="<?= htmlspecialchars($current_tanggal) ?>"
                           max="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-form-submit <?= $mode ?>">
                        <?= $mode === 'add' ? '+ Tambah Barang' : '✓ Simpan Perubahan' ?>
                    </button>
                    <a href="index.php?page=dashboard" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const label = document.getElementById('file-label-text');
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        label.style.color = 'var(--accent-2)';
    } else {
        label.textContent = 'Klik untuk pilih foto...';
        label.style.color = '';
    }
}
</script>