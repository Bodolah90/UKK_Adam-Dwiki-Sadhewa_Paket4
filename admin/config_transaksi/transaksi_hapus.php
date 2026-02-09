<?php
include '../../config/config.php';

$id = $_GET['id'];
$id_buku = $_GET['id_buku'];
$tgl_kembali = date('Y-m-d');

// 1. UPDATE status transaksi (Data tetap ada di DB)
mysqli_query($koneksi, "UPDATE transaksi_user SET 
    status = 'kembali', 
    tgl_kembali = '$tgl_kembali' 
    WHERE id = '$id'");

// 2. UPDATE status buku (Agar bisa dipinjam lagi)
mysqli_query($koneksi, "UPDATE buku SET status = 'Tersedia' WHERE id_buku = '$id_buku'");

header("Location: ../kelola_transaksi.php");
