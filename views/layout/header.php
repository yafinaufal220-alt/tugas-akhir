<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StokPro — Inventory Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --ink:         #0a0a0f;
    --ink-2:       #16161f;
    --ink-3:       #1f1f2e;
    --surface:     #252535;
    --line:        rgba(255,255,255,0.07);
    --line-2:      rgba(255,255,255,0.12);
    --muted:       #6b7280;
    --muted-2:     #9ca3af;
    --white:       #ffffff;
    --off-white:   #f0f0f5;
    --accent:      #6366f1;
    --accent-2:    #818cf8;
    --accent-glow: rgba(99,102,241,0.35);
    --green:       #10b981;
    --green-glow:  rgba(16,185,129,0.25);
    --red:         #f43f5e;
    --red-glow:    rgba(244,63,94,0.2);
    --gold:        #f59e0b;
    --font-head:   'Syne', sans-serif;
    --font-body:   'DM Sans', sans-serif;
    --radius:      16px;
    --radius-lg:   24px;
    --shadow:      0 4px 24px rgba(0,0,0,0.4);
    --shadow-lg:   0 20px 60px rgba(0,0,0,0.6);
}

html { scroll-behavior: smooth; }

body {
    font-family: var(--font-body);
    background-color: var(--ink);
    color: var(--off-white);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background-image:
        radial-gradient(ellipse 80% 50% at 20% -10%, rgba(99,102,241,0.12) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 80% 100%, rgba(16,185,129,0.07) 0%, transparent 60%);
}

/* ── TOPBAR ── */
.topbar {
    position: sticky;
    top: 0;
    z-index: 200;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    height: 68px;
    background: rgba(10,10,15,0.9);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--line);
}

.topbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    flex-shrink: 0;
}

.brand-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 20px var(--accent-glow);
    flex-shrink: 0;
}

.brand-name {
    font-family: var(--font-head);
    font-size: 20px;
    font-weight: 800;
    color: var(--white);
    letter-spacing: -0.5px;
    white-space: nowrap;
}
.brand-name span { color: var(--accent-2); }

.topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ── USER PILL ── */
.user-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 12px 5px 5px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: 100px;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    user-select: none;
}
.user-pill:hover { border-color: var(--accent); background: rgba(99,102,241,0.08); }
.user-pill:hover .user-avatar { box-shadow: 0 0 0 2px var(--accent); }

.user-avatar {
    width: 30px; height: 30px;
    background: linear-gradient(135deg, var(--accent), #a78bfa);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-head);
    font-weight: 700;
    font-size: 12px;
    color: white;
    transition: box-shadow 0.2s;
    flex-shrink: 0;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--off-white);
    line-height: 1;
    white-space: nowrap;
}

.badge-role {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 3px 7px;
    border-radius: 100px;
    background: rgba(99,102,241,0.2);
    color: var(--accent-2);
    border: 1px solid rgba(99,102,241,0.3);
    line-height: 1;
    white-space: nowrap;
}
.badge-role.viewer {
    background: rgba(16,185,129,0.15);
    color: #34d399;
    border-color: rgba(16,185,129,0.25);
}

.pill-caret {
    color: var(--muted);
    transition: transform 0.2s;
    flex-shrink: 0;
}
.user-pill.open .pill-caret { transform: rotate(180deg); }

.btn-logout {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 600;
    color: var(--muted-2);
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 10px;
    border: 1px solid var(--line);
    transition: all 0.2s;
    line-height: 1;
    white-space: nowrap;
}
.btn-logout:hover { color: var(--red); border-color: rgba(244,63,94,0.3); background: rgba(244,63,94,0.07); }
.btn-logout .logout-text { display: inline; }

/* ── MAIN ── */
.main-wrap {
    flex: 1;
    padding: 32px 40px;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
}

/* ── BUTTONS ── */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: var(--radius);
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
    line-height: 1;
}
.btn-primary {
    background: linear-gradient(135deg, var(--accent), #7c7ff5);
    color: white;
    box-shadow: 0 4px 16px var(--accent-glow);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--accent-glow); filter: brightness(1.1); }
.btn-success {
    background: linear-gradient(135deg, var(--green), #059669);
    color: white;
    box-shadow: 0 4px 16px var(--green-glow);
}
.btn-success:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--green-glow); filter: brightness(1.1); }
.btn-ghost {
    background: transparent;
    color: var(--muted-2);
    border: 1px solid var(--line-2);
}
.btn-ghost:hover { background: var(--ink-3); color: var(--white); }
.btn-edit-sm {
    padding: 6px 12px;
    font-size: 12px;
    background: rgba(99,102,241,0.12);
    color: var(--accent-2);
    border-radius: 10px;
    border: 1px solid rgba(99,102,241,0.2);
}
.btn-edit-sm:hover { background: rgba(99,102,241,0.25); transform: translateY(-1px); }
.btn-delete-sm {
    padding: 6px 12px;
    font-size: 12px;
    background: rgba(244,63,94,0.1);
    color: #fb7185;
    border-radius: 10px;
    border: 1px solid rgba(244,63,94,0.2);
}
.btn-delete-sm:hover { background: rgba(244,63,94,0.22); transform: translateY(-1px); }

/* ── TOAST ── */
.toast {
    position: fixed;
    top: 76px;
    right: 16px;
    left: 16px;
    z-index: 9999;
    padding: 14px 18px;
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideIn 0.3s ease, fadeOut 0.5s ease 2.5s forwards;
    backdrop-filter: blur(10px);
}
.toast.success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
.toast.info    { background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); color: var(--accent-2); }
.toast.danger  { background: rgba(244,63,94,0.15);  border: 1px solid rgba(244,63,94,0.3);  color: #fb7185; }

@keyframes slideIn { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform: translateX(0); } }
@keyframes fadeOut { from { opacity:1; } to { opacity:0; pointer-events:none; } }

/* ── FORM INPUTS ── */
.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
}
.form-input {
    width: 100%;
    height: 48px;
    padding: 0 16px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: var(--radius);
    color: var(--white);
    font-family: var(--font-body);
    font-size: 15px;
    transition: all 0.2s;
}
.form-input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
    background: var(--ink-2);
}
.form-input::placeholder { color: var(--muted); }

/* ════════════════════════════════
   PROFILE MODAL
════════════════════════════════ */
.modal-overlay {
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
.modal-overlay.open { display: flex; animation: overlayIn 0.2s ease; }
@keyframes overlayIn { from { opacity:0; } to { opacity:1; } }

.modal-box {
    background: var(--ink-2);
    border: 1px solid var(--line-2);
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 440px;
    overflow: hidden;
    animation: modalIn 0.25s cubic-bezier(0.34, 1.3, 0.64, 1);
    box-shadow: 0 32px 80px rgba(0,0,0,0.7);
    max-height: 90vh;
    overflow-y: auto;
}
@keyframes modalIn {
    from { opacity:0; transform: scale(0.92) translateY(16px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}

.modal-head {
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
.modal-head-left { display: flex; align-items: center; gap: 12px; }
.modal-avatar-lg {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, var(--accent), #a78bfa);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-head);
    font-weight: 800;
    font-size: 16px;
    color: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
    flex-shrink: 0;
}
.modal-head-title {
    font-family: var(--font-head);
    font-size: 15px;
    font-weight: 800;
    color: var(--white);
    line-height: 1.2;
}
.modal-head-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
.modal-close {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: transparent;
    border: 1px solid var(--line-2);
    color: var(--muted-2);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}
.modal-close:hover { background: var(--ink-3); color: var(--white); }

.modal-tabs {
    display: flex;
    border-bottom: 1px solid var(--line);
    padding: 0 22px;
    position: sticky;
    top: 65px;
    background: var(--ink-2);
    z-index: 1;
}
.modal-tab {
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
    padding: 11px 0;
    margin-right: 20px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: color 0.2s, border-color 0.2s;
    line-height: 1;
    user-select: none;
}
.modal-tab:hover { color: var(--muted-2); }
.modal-tab.active { color: var(--accent-2); border-bottom-color: var(--accent); }

.modal-body { padding: 20px 22px 24px; }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

.mfield { margin-bottom: 16px; }
.mfield label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 7px;
    line-height: 1;
}
.mfield input {
    width: 100%;
    height: 46px;
    padding: 0 14px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: 12px;
    color: var(--white);
    font-family: var(--font-body);
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    box-sizing: border-box;
}
.mfield input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
    background: var(--ink-2);
}
.mfield input::placeholder { color: var(--muted); font-size: 13px; }
.pw-hint {
    font-size: 11px;
    color: var(--muted);
    margin-top: 6px;
    line-height: 1.5;
    display: flex;
    align-items: flex-start;
    gap: 5px;
}
.pw-hint svg { flex-shrink: 0; margin-top: 1px; }
.mfield-sep { border: none; border-top: 1px solid var(--line); margin: 16px 0; }
.modal-alert {
    display: none;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 14px;
    line-height: 1.4;
}
.modal-alert.show { display: flex; }
.modal-alert.err { background: rgba(244,63,94,0.1); border: 1px solid rgba(244,63,94,0.25); color: #fb7185; }
.modal-alert.ok  { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #34d399; }
.modal-btn {
    width: 100%;
    height: 46px;
    border: none;
    border-radius: 12px;
    font-family: var(--font-head);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    line-height: 1;
    margin-top: 4px;
}
.modal-btn.accent {
    background: linear-gradient(135deg, var(--accent), #7c7ff5);
    color: white;
    box-shadow: 0 4px 16px var(--accent-glow);
}
.modal-btn.accent:hover { transform: translateY(-1px); box-shadow: 0 8px 24px var(--accent-glow); filter: brightness(1.1); }
.modal-btn.accent:disabled { opacity: 0.5; cursor: not-allowed; transform: none; filter: none; }

/* ════════════════════════════════
   RESPONSIVE — TABLET (≤768px)
════════════════════════════════ */
/* ── RESPONSIVE TABLET (≤768px) ── */
@media (max-width: 768px) {
    .topbar { padding: 0 16px; }
    .badge-role { display: none; }
    .pill-caret { display: none; }
    .btn-logout .logout-text { display: none; }
    .btn-logout { padding: 7px 10px; gap: 0; }
    .main-wrap { padding: 24px 16px; }
    .toast { top: 76px; right: 16px; left: 16px; }
}

/* ── RESPONSIVE MOBILE (≤480px) ── */
@media (max-width: 480px) {
    .topbar { padding: 0 12px; }
    .topbar-right { gap: 8px; }
    .user-name { display: none; }
    .main-wrap { padding: 16px 12px; }
}
</style>
</head>
<body>

<?php
if (isset($_SESSION['user'])):
    $initial = strtoupper(substr($_SESSION['user'], 0, 1));
    $role    = $_SESSION['role'] ?? 'viewer';
    $isAdmin = $role === 'admin';
?>
<header class="topbar">
    <a href="index.php?page=dashboard" class="topbar-brand">
        <div class="brand-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <span class="brand-name">Stok<span>Pro</span></span>
    </a>

    <div class="topbar-right">
        <div class="user-pill" id="userPill" onclick="toggleProfileModal()">
            <div class="user-avatar"><?= $initial ?></div>
            <span class="user-name"><?= htmlspecialchars($_SESSION['user']) ?></span>
            <span class="badge-role <?= $isAdmin ? '' : 'viewer' ?>"><?= $role ?></span>
            <svg class="pill-caret" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <a href="index.php?action=logout" class="btn-logout">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span class="logout-text">Logout</span>
        </a>
    </div>
</header>

<!-- PROFILE MODAL -->
<div class="modal-overlay" id="profileModal" onclick="handleOverlayClick(event)">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-avatar-lg"><?= $initial ?></div>
                <div>
                    <div class="modal-head-title"><?= htmlspecialchars($_SESSION['user']) ?></div>
                    <div class="modal-head-sub">Role: <?= htmlspecialchars($role) ?></div>
                </div>
            </div>
            <button class="modal-close" onclick="closeProfileModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-tabs">
            <div class="modal-tab active" onclick="switchTab('username', event)">Ubah Username</div>
            <div class="modal-tab" onclick="switchTab('password', event)">Ubah Password</div>
        </div>
        <div class="modal-body">
            <div class="modal-alert" id="modalAlert"></div>
            <div class="tab-panel active" id="tab-username">
                <form onsubmit="submitUsername(event)">
                    <div class="mfield">
                        <label>Username Baru</label>
                        <input type="text" id="new_username" value="<?= htmlspecialchars($_SESSION['user']) ?>" placeholder="Masukkan username baru" minlength="3" required>
                    </div>
                    <button type="submit" class="modal-btn accent">Simpan Username</button>
                </form>
            </div>
            <div class="tab-panel" id="tab-password">
                <form onsubmit="submitPassword(event)">
                    <div class="mfield">
                        <label>Password Sekarang</label>
                        <input type="password" id="old_password" placeholder="••••••••" required>
                    </div>
                    <hr class="mfield-sep">
                    <div class="mfield">
                        <label>Password Baru</label>
                        <input type="password" id="new_password" placeholder="Minimal 6 karakter" minlength="6" required>
                        <div class="pw-hint">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Minimal 6 karakter
                        </div>
                    </div>
                    <div class="mfield">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" id="confirm_password" placeholder="Ulangi password baru" required>
                    </div>
                    <button type="submit" class="modal-btn accent">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
$status = $_GET['status'] ?? '';
if ($status === 'added')      echo '<div class="toast success">✓ Barang berhasil ditambahkan</div>';
if ($status === 'updated')    echo '<div class="toast info">✓ Data barang berhasil diperbarui</div>';
if ($status === 'deleted')    echo '<div class="toast danger">✓ Barang berhasil dihapus</div>';
if ($status === 'profile_ok') echo '<div class="toast success">✓ Profil berhasil diperbarui</div>';
if ($status === 'pw_ok')      echo '<div class="toast success">✓ Password berhasil diganti</div>';
if ($status === 'pw_wrong')   echo '<div class="toast danger">✗ Password lama tidak sesuai</div>';
if ($status === 'user_taken') echo '<div class="toast danger">✗ Username sudah digunakan</div>';
?>

<div class="main-wrap">

<script>
function toggleProfileModal() {
    const modal = document.getElementById('profileModal');
    const pill  = document.getElementById('userPill');
    if (modal.classList.contains('open')) { closeProfileModal(); }
    else { modal.classList.add('open'); pill.classList.add('open'); clearAlert(); }
}
function closeProfileModal() {
    document.getElementById('profileModal').classList.remove('open');
    document.getElementById('userPill').classList.remove('open');
}
function handleOverlayClick(e) {
    if (e.target === document.getElementById('profileModal')) closeProfileModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeProfileModal(); });

function switchTab(name, event) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    if (event && event.currentTarget) event.currentTarget.classList.add('active');
    clearAlert();
}

function showAlert(msg, type) {
    const el = document.getElementById('modalAlert');
    el.className = 'modal-alert show ' + type;
    el.innerHTML = (type === 'err'
        ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
        : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
    ) + msg;
}
function clearAlert() {
    const el = document.getElementById('modalAlert');
    el.className = 'modal-alert'; el.innerHTML = '';
}

function submitUsername(e) {
    e.preventDefault(); clearAlert();
    const newName = document.getElementById('new_username').value.trim();
    if (!newName || newName.length < 3) { showAlert('Username minimal 3 karakter.', 'err'); return; }
    const btn = e.target.querySelector('button');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    fetch('index.php?action=update_username', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'new_username=' + encodeURIComponent(newName)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showAlert('Username berhasil diperbarui. Memuat ulang...', 'ok');
            setTimeout(() => location.href = 'index.php?page=dashboard&status=profile_ok', 1200);
        } else {
            showAlert(data.message || 'Gagal memperbarui username.', 'err');
            btn.disabled = false; btn.textContent = 'Simpan Username';
        }
    })
    .catch(() => { showAlert('Terjadi kesalahan.', 'err'); btn.disabled = false; btn.textContent = 'Simpan Username'; });
}

function submitPassword(e) {
    e.preventDefault(); clearAlert();
    const oldPw  = document.getElementById('old_password').value;
    const newPw  = document.getElementById('new_password').value;
    const confPw = document.getElementById('confirm_password').value;
    if (newPw.length < 6) { showAlert('Password baru minimal 6 karakter.', 'err'); return; }
    if (newPw !== confPw) { showAlert('Konfirmasi password tidak cocok.', 'err'); return; }
    const btn = e.target.querySelector('button');
    btn.disabled = true; btn.textContent = 'Memproses...';
    fetch('index.php?action=update_password', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'old_password=' + encodeURIComponent(oldPw) + '&new_password=' + encodeURIComponent(newPw)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showAlert('Password berhasil diganti!', 'ok');
            e.target.reset();
            setTimeout(() => { closeProfileModal(); location.href = 'index.php?page=dashboard&status=pw_ok'; }, 1200);
        } else {
            showAlert(data.message || 'Gagal mengganti password.', 'err');
            btn.disabled = false; btn.textContent = 'Ganti Password';
        }
    })
    .catch(() => { showAlert('Terjadi kesalahan.', 'err'); btn.disabled = false; btn.textContent = 'Ganti Password'; });
}
</script>