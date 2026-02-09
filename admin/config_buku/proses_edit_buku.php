<?php
session_start();
include '../../config/config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_buku'];

    mysqli_query($koneksi, "UPDATE buku SET
        nama_buku='$_POST[nama_buku]',
        pengarang='$_POST[pengarang]',
        penerbit='$_POST[penerbit]',
        tahun_terbit='$_POST[tahun_terbit]',
        status='$_POST[status]'
        WHERE id_buku='$id'
    ");

    header("Location: ../kelola_buku.php");
    exit;
}
