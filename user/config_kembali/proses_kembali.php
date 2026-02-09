<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../../index.php");
    exit();
}

$id_transaksi = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_transaksi) {
    die("ID Transaksi tidak ditemukan.");
}

// Ambil data buku_id
$query_transaksi = mysqli_query($koneksi, "SELECT buku_id FROM transaksi_user WHERE id = '$id_transaksi'");
$data = mysqli_fetch_assoc($query_transaksi);

if ($data) {
    $id_buku = $data['buku_id'];
    $tgl_kembali = date('Y-m-d');

    // 1. Update status buku (Gunakan 'Tersedia' sesuai image_4d6355.png)
    mysqli_query($koneksi, "UPDATE buku SET status = 'Tersedia' WHERE id_buku = '$id_buku'");

    // 2. Update status transaksi_user 
    // Pastikan kata 'kembali' sudah ada di ENUM transaksi_user melalui SQL di atas
    $update = mysqli_query($koneksi, "UPDATE transaksi_user SET status = 'Kembali ', tgl_kembali = '$tgl_kembali' WHERE id = '$id_transaksi'");
    // Perhatikan saya coba tambah spasi setelah kata Kembali di atas

    if ($update) {
        header("Location: ../kembalikan_buku.php?pesan=berhasil");
    } else {
        // Tampilkan error jika SQL gagal
        die("Gagal Update! Pesan Error: " . mysqli_error($koneksi));
    }
} else {
    echo "Data transaksi tidak ditemukan.";
}
