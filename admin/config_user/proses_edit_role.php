<?php
session_start();
include '../../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id_user = $_POST['id_user'];
$role    = $_POST['role'];

// 🔒 Admin tidak boleh ubah role sendiri
if ($_SESSION['id'] == $id_user) {
    header("Location: ../kelola_user.php");
    exit();
}

// Update role
mysqli_query($koneksi, "UPDATE users SET role='$role' WHERE id='$id_user'");

header("Location: ../kelola_user.php");
exit();
