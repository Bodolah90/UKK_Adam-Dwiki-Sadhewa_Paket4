<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Total buku
$qTotal = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
$totalBuku = mysqli_fetch_assoc($qTotal)['total'];

// Buku tersedia
$qTersedia = mysqli_query($koneksi, "SELECT COUNT(*) AS tersedia FROM buku WHERE status='Tersedia'");
$bukuTersedia = mysqli_fetch_assoc($qTersedia)['tersedia'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/css/dashboard_admin.css">

</head>
<body>

<?php include 'navbar.php'; ?>

<div class="dashboard">
    <h2>Halaman Admin</h2>
    <p class="welcome">Selamat datang, <b><?= $_SESSION['username']; ?></b></p>

    <div class="card-container">
        <div class="card">
            <h3>Total Buku</h3>
            <p><?= $totalBuku; ?></p>
        </div>

        <div class="card available">
            <h3>Buku Tersedia</h3>
            <p><?= $bukuTersedia; ?></p>
        </div>
    </div>
</div>


</body>
</html>
