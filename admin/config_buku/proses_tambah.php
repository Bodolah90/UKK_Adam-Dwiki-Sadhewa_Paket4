<?php
session_start();
include '../../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi, "INSERT INTO buku 
        (nama_buku, pengarang, penerbit, tahun_terbit, status)
        VALUES (
            '$_POST[nama_buku]',
            '$_POST[pengarang]',
            '$_POST[penerbit]',
            '$_POST[tahun_terbit]',
            '$_POST[status]'
        )
    ");

    header("Location: ../kelola_buku.php");
}
