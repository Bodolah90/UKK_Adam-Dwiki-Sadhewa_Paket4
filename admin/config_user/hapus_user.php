<?php
session_start();
include '../../config/config.php';

// Cek admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../kelola_user.php");
    exit();
}

// Admin tidak boleh hapus dirinya sendiri
if ($_SESSION['id'] == $id) {
    header("Location: ../kelola_user.php?msg=self");
    exit();
}

// 🔍 CEK APAKAH USER PUNYA TRANSAKSI
$cek = mysqli_query($koneksi,
    "SELECT COUNT(*) AS total 
     FROM transaksi_user 
     WHERE user_id = '$id'"
);

$data = mysqli_fetch_assoc($cek);

if ($data['total'] > 0) {
    // ❌ GAGAL HAPUS
    header("Location: ../kelola_user.php?msg=punya_transaksi");
    exit();
}

// ✅ AMAN DIHAPUS
mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

header("Location: ../kelola_user.php?msg=hapus_sukses");
exit();