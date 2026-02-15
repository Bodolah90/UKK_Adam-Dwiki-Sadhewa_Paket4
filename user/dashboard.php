<?php
session_start();
include '../config/config.php';

// Proteksi user
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit();
}

// ================== QUERY ==================

// Total buku
$qTotal = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
$dataTotal = mysqli_fetch_assoc($qTotal);
$totalBuku = $dataTotal['total'];

// Buku tersedia
$qTersedia = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS tersedia FROM buku WHERE status='Tersedia'"
);
$dataTersedia = mysqli_fetch_assoc($qTersedia);
$bukuTersedia = $dataTersedia['tersedia'];

// ================== NAVBAR ==================
include 'navbar.php';
?>

<link rel="stylesheet" href="../css/dashboard_user.css">

<div class="dashboard">
    <h2>Dashboard User</h2>

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