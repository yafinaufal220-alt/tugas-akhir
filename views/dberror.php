<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Database Error — StokPro</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#07070d;color:#f0f0f5;min-height:100vh;display:grid;place-items:center;padding:20px}
.err-card{max-width:520px;text-align:center;padding:56px 48px;background:rgba(14,14,26,0.8);border:1px solid rgba(244,63,94,0.2);border-radius:28px;backdrop-filter:blur(20px)}
.err-icon{font-size:52px;margin-bottom:24px}
h1{font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:#fb7185;margin-bottom:12px}
p{font-size:14px;color:#9ca3af;line-height:1.7}
.err-detail{margin-top:20px;padding:16px;background:rgba(244,63,94,0.07);border:1px solid rgba(244,63,94,0.15);border-radius:12px;font-size:13px;color:#f87171;text-align:left}
.hint{margin-top:28px;padding:16px;background:rgba(16,185,129,0.07);border:1px solid rgba(16,185,129,0.15);border-radius:12px;font-size:13px;color:#34d399;text-align:left;line-height:1.8}
</style>
</head>
<body>
<div class="err-card">
    <div class="err-icon">🔌</div>
    <h1>Koneksi Database Gagal</h1>
    <p>Sistem tidak dapat terhubung ke database MySQL. Pastikan layanan database sudah aktif.</p>
    <?php if (defined('DB_ERROR')): ?>
    <div class="err-detail"><?= DB_ERROR ?></div>
    <?php endif; ?>
    <div class="hint">
        <strong>Cara memperbaiki:</strong><br>
        1. Buka <strong>XAMPP Control Panel</strong><br>
        2. Klik <strong>Start</strong> pada baris MySQL<br>
        3. Pastikan database <code>stok_db</code> sudah dibuat<br>
        4. Refresh halaman ini
    </div>
</div>
</body>
</html>