<?php

// session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit();
}

// Ambil nama file saat ini
$halaman = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="../css/navbar.css">

<nav class="navbar">
    <div class="logo">📘 Online Library</div>

    <ul class="menu">
        <li>
            <a href="dashboard.php"
                class="<?= ($halaman == 'dashboard.php') ? 'active' : '' ?>">
                Home
            </a>
        </li>
        <li>
            <a href="pinjam_buku.php"
                class="<?= ($halaman == 'pinjam_buku.php') ? 'active' : '' ?>">
                Pinjam Buku
            </a>
        </li>
        <!-- <li>
            <a href="kembalikan_buku.php"
                class="<?= ($halaman == 'pengembalian.php') ? 'active' : '' ?>">
                Pengembalian
            </a>
        </li> -->
        <li>
            <a href="history_transaksi.php"
                class="<?= ($halaman == 'history.php') ? 'active' : '' ?>">
                Riwayat
            </a>
        </li>
    </ul>

    <div class="right">
        <span><?= $_SESSION['username']; ?></span>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
</nav>