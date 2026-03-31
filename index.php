<?php
require_once 'model.php';

$page   = isset($_GET['page'])   ? $_GET['page']   : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action']  : '';

// Cek DB Error
if (defined('DB_ERROR') && $page != 'dberror') {
    header("Location: index.php?page=dberror");
    exit;
}

// Proses Login
if ($page == 'login' && $action == 'proses') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = cekLogin($username, $password);
    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php?page=dashboard");
    } else {
        header("Location: index.php?page=login&pesan=gagal");
    }
    exit;
}

// Logout
if ($action == 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// Proteksi halaman
if (!isset($_SESSION['user']) && $page != 'login') {
    header("Location: index.php?page=login");
    exit;
}

// ── Update Username (AJAX) ──
if ($action == 'update_username' && isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    $new_username = trim($_POST['new_username'] ?? '');
    if (strlen($new_username) < 3) {
        echo json_encode(['success' => false, 'message' => 'Username minimal 3 karakter.']);
        exit;
    }
    // Cek apakah username sudah dipakai user lain
    $nu  = mysqli_real_escape_string($conn, $new_username);
    $cur = mysqli_real_escape_string($conn, $_SESSION['user']);
    $chk = mysqli_query($conn, "SELECT id FROM users WHERE username='$nu' AND username != '$cur'");
    if ($chk && mysqli_num_rows($chk) > 0) {
        echo json_encode(['success' => false, 'message' => 'Username sudah digunakan.']);
        exit;
    }
    $ok = mysqli_query($conn, "UPDATE users SET username='$nu' WHERE username='$cur'");
    if ($ok) {
        $_SESSION['user'] = $new_username;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui database.']);
    }
    exit;
}

// ── Update Password (AJAX) ──
if ($action == 'update_password' && isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    $old_pw  = $_POST['old_password'] ?? '';
    $new_pw  = $_POST['new_password'] ?? '';
    if (strlen($new_pw) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password baru minimal 6 karakter.']);
        exit;
    }
    $u   = mysqli_real_escape_string($conn, $_SESSION['user']);
    $op  = mysqli_real_escape_string($conn, $old_pw);
    // Verifikasi password lama
    $res = mysqli_query($conn, "SELECT id FROM users WHERE username='$u' AND password='$op'");
    if (!$res || mysqli_num_rows($res) === 0) {
        echo json_encode(['success' => false, 'message' => 'Password lama tidak sesuai.']);
        exit;
    }
    $np = mysqli_real_escape_string($conn, $new_pw);
    $ok = mysqli_query($conn, "UPDATE users SET password='$np' WHERE username='$u'");
    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui database.']);
    }
    exit;
}

// CRUD (admin only)
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($action == 'tambah') {
        $nama     = $_POST['nama']          ?? '';
        $jumlah   = $_POST['jumlah']        ?? 0;
        $harga    = $_POST['harga']         ?? 0;
        $tanggal  = $_POST['tanggal_masuk'] ?? date('Y-m-d');
        $foto     = $_FILES['foto']['name'] ?? '';
        $tmp      = $_FILES['foto']['tmp_name'] ?? '';
        if (!empty($foto)) {
            $ext     = pathinfo($foto, PATHINFO_EXTENSION);
            $newname = uniqid('img_') . '.' . $ext;
            move_uploaded_file($tmp, "assets/img/" . $newname);
            $foto = $newname;
        }
        tambahBarang($nama, $foto, $jumlah, $harga, $tanggal);
        header("Location: index.php?page=dashboard&status=added");
        exit;
    } elseif ($action == 'edit' || $action == 'update') {
        $id       = $_POST['id']            ?? 0;
        $nama     = $_POST['nama']          ?? '';
        $jumlah   = $_POST['jumlah']        ?? 0;
        $harga    = $_POST['harga']         ?? 0;
        $tanggal  = $_POST['tanggal_masuk'] ?? date('Y-m-d');
        $foto     = $_FILES['foto']['name'] ?? '';
        $tmp      = $_FILES['foto']['tmp_name'] ?? '';
        if (!empty($foto)) {
            $ext     = pathinfo($foto, PATHINFO_EXTENSION);
            $newname = uniqid('img_') . '.' . $ext;
            move_uploaded_file($tmp, "assets/img/" . $newname);
            $foto = $newname;
        }
        updateBarang($id, $nama, $foto, $jumlah, $harga, $tanggal);
        header("Location: index.php?page=dashboard&status=updated");
        exit;
    } elseif ($action == 'hapus') {
        hapusBarang($_GET['id'] ?? 0);
        header("Location: index.php?page=dashboard&status=deleted");
        exit;
    }
}

// Load View
if ($page != 'login') {
    include 'views/layout/header.php';
}

switch ($page) {
    case 'login':    include 'views/login.php';     break;
    case 'form':     include 'views/form.php';      break;
    case 'dberror':  include 'views/dberror.php';   break;
    case 'dashboard':
    default:         include 'views/dashboard.php'; break;
}

if ($page != 'login') {
    include 'views/layout/footer.php';
}