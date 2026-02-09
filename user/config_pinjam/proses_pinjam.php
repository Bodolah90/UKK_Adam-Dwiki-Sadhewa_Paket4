<?php
session_start();
// Perbaikan path include
include '../../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Tambahkan pengecekan isset agar tidak error jika id kosong
$buku_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$buku_id) {
    die("ID Buku tidak ditemukan.");
}
// ... sisa kode kamu selanjutnya
// Insert transaksi
$tgl_pinjam = date('Y-m-d');
mysqli_query($koneksi, "INSERT INTO transaksi_user (user_id, buku_id, tgl_pinjam) VALUES ('$user_id', '$buku_id', '$tgl_pinjam')");

// Update status buku
// Update status buku menjadi 'tidak' agar sesuai dengan ENUM di database
mysqli_query($koneksi, "UPDATE buku SET status='dipinjam' WHERE id_buku='$buku_id'");

header("Location: ../pinjam_buku.php");
