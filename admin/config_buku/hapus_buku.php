<?php
session_start();
include '../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'");
header("Location: kelola_buku.php");
