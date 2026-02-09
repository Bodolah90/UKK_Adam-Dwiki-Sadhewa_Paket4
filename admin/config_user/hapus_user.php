<?php
session_start();
include '../../config/config.php';

// Cek admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'] ?? null;

// Validasi id
if (!$id) {
    header("Location: ../kelola_user.php");
    exit();
}

// ❌ Admin tidak boleh hapus dirinya sendiri
if ($_SESSION['id'] == $id) {
    header("Location: ../kelola_user.php");
    exit();
}

// Hapus user
mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

header("Location: ../kelola_user.php");
exit();
