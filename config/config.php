<?php
$host = 'localhost';
$dbname = 'perpustakaan';
$username_db = 'root';
$password_db = '';

$koneksi = mysqli_connect($host, $username_db, $password_db, $dbname);  // $koneksi

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8");
