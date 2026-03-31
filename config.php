<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'stok_db';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    define('DB_ERROR', "Koneksi database gagal. Pastikan MySQL sudah berjalan dan database '<strong>$db</strong>' sudah dibuat.<br><small>Error: " . mysqli_connect_error() . "</small>");
} else {
    mysqli_set_charset($conn, 'utf8');

    // Auto-migration: tambah kolom tanggal_masuk jika belum ada
    $check = mysqli_query($conn, "SHOW COLUMNS FROM barang LIKE 'tanggal_masuk'");
    if ($check && mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "ALTER TABLE barang ADD COLUMN tanggal_masuk DATE DEFAULT NULL AFTER harga");
        // Isi data lama dengan tanggal hari ini
        mysqli_query($conn, "UPDATE barang SET tanggal_masuk = CURDATE() WHERE tanggal_masuk IS NULL");
    }
}

function input($data) {
    global $conn;
    if (!$conn) return htmlspecialchars(strip_tags(trim($data)));
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}