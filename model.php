<?php
require_once 'config.php';

function cekLogin($username, $password) {
    global $conn;
    if (!$conn) return false;
    $u = mysqli_real_escape_string($conn, $username);
    $p = mysqli_real_escape_string($conn, $password);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    return mysqli_fetch_assoc($result);
}

function tampilBarang() {
    global $conn;
    if (!$conn) return false;
    return mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
}

function tambahBarang($nama, $foto, $jumlah, $harga, $tanggal) {
    global $conn;
    if (!$conn) return false;
    $n = mysqli_real_escape_string($conn, $nama);
    $f = mysqli_real_escape_string($conn, $foto);
    $j = (int)$jumlah;
    $h = (float)$harga;
    $t = mysqli_real_escape_string($conn, $tanggal);
    return mysqli_query($conn, "INSERT INTO barang (nama_barang, foto, jumlah, harga, tanggal_masuk) VALUES ('$n','$f','$j','$h','$t')");
}

function hapusBarang($id) {
    global $conn;
    if (!$conn) return false;
    $id = (int)$id;
    return mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
}

function getBarangById($id) {
    global $conn;
    if (!$conn) return false;
    $id = (int)$id;
    $res = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");
    return mysqli_fetch_assoc($res);
}

function updateBarang($id, $nama, $foto, $jumlah, $harga, $tanggal) {
    global $conn;
    if (!$conn) return false;
    $id = (int)$id;
    $n = mysqli_real_escape_string($conn, $nama);
    $f = mysqli_real_escape_string($conn, $foto);
    $j = (int)$jumlah;
    $h = (float)$harga;
    $t = mysqli_real_escape_string($conn, $tanggal);
    if ($f != "") {
        return mysqli_query($conn, "UPDATE barang SET nama_barang='$n', foto='$f', jumlah='$j', harga='$h', tanggal_masuk='$t' WHERE id=$id");
    } else {
        return mysqli_query($conn, "UPDATE barang SET nama_barang='$n', jumlah='$j', harga='$h', tanggal_masuk='$t' WHERE id=$id");
    }
}