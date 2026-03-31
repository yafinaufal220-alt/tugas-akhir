<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StokPro — Sign In</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --ink: #07070d;
    --ink-2: #0e0e1a;
    --ink-3: #16162a;
    --line: rgba(255,255,255,0.07);
    --line-2: rgba(255,255,255,0.12);
    --muted: #6b7280;
    --muted-2: #9ca3af;
    --white: #ffffff;
    --accent: #6366f1;
    --accent-2: #818cf8;
    --accent-glow: rgba(99,102,241,0.4);
    --red: #f43f5e;
    --font-head: 'Syne', sans-serif;
    --font-body: 'DM Sans', sans-serif;
}

body {
    font-family: var(--font-body);
    background: var(--ink);
    color: var(--white);
    min-height: 100vh;
    display: grid;
    place-items: center;
    background-image:
        radial-gradient(ellipse 70% 60% at 50% -20%, rgba(99,102,241,0.18) 0%, transparent 70%),
        radial-gradient(ellipse 40% 40% at 90% 80%, rgba(129,140,248,0.08) 0%, transparent 60%);
}

/* Grid dots background */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
    z-index: 0;
}

.login-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 440px;
    padding: 20px;
}

.login-card {
    background: rgba(14, 14, 26, 0.8);
    border: 1px solid var(--line-2);
    border-radius: 28px;
    padding: 52px 48px;
    backdrop-filter: blur(30px);
    box-shadow: 0 32px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.03);
}

.login-logo {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, var(--accent), #a78bfa);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 28px;
    box-shadow: 0 12px 30px var(--accent-glow);
}

.login-title {
    font-family: var(--font-head);
    font-size: 28px;
    font-weight: 800;
    text-align: center;
    letter-spacing: -0.5px;
    margin-bottom: 6px;
    color: var(--white);
}

.login-sub {
    text-align: center;
    font-size: 14px;
    color: var(--muted-2);
    margin-bottom: 36px;
}

.alert-err {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(244,63,94,0.1);
    border: 1px solid rgba(244,63,94,0.25);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 500;
    color: #fb7185;
    margin-bottom: 24px;
}

.field { margin-bottom: 20px; }

.field label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
}

.field input {
    width: 100%;
    height: 50px;
    padding: 0 18px;
    background: var(--ink-3);
    border: 1px solid var(--line-2);
    border-radius: 14px;
    color: var(--white);
    font-family: var(--font-body);
    font-size: 15px;
    transition: all 0.2s;
}

.field input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    background: var(--ink-2);
}

.field input::placeholder { color: var(--muted); }

.btn-signin {
    width: 100%;
    height: 52px;
    margin-top: 8px;
    background: linear-gradient(135deg, var(--accent) 0%, #7c7ff5 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-family: var(--font-head);
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.3px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px var(--accent-glow);
}

.btn-signin:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px var(--accent-glow);
    filter: brightness(1.1);
}

.btn-signin:active { transform: translateY(0); }

.login-footer {
    margin-top: 28px;
    text-align: center;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
}
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>

        <h1 class="login-title">Welcome back</h1>
        <p class="login-sub">Sign in to your StokPro workspace</p>

        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
        <div class="alert-err">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Username atau password salah. Coba lagi.
        </div>
        <?php endif; ?>

        <form action="index.php?page=login&action=proses" method="POST">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-signin">Sign In →</button>
        </form>

        <div class="login-footer">&copy; <?= date('Y') ?> StokPro Management System</div>
    </div>
</div>
</body>
</html>