<?php
session_start();

/* INI YANG BENAR */
include $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../kelola_buku.php");
    exit();
}

mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'");

header("Location: ../kelola_buku.php");
exit();