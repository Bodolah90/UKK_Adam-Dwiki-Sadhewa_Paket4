<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit();
}

// Ambil nama file saat ini
$halaman = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="/perpus/css/navbar.css">

<nav class="navbar">
    <div class="logo">📘 Online Library</div>

    <ul class="menu">
        <li>
            <a href="/perpus/user/dashboard.php"
                class="<?= ($halaman == 'dashboard.php') ? 'active' : '' ?>">
                Home
            </a>
        </li>
        <li>
            <a href="/perpus/user/pinjam_buku.php"
                class="<?= ($halaman == 'pinjam_buku.php') ? 'active' : '' ?>">
                Pinjam Buku
            </a>
        </li>
        <li>
            <a href="/perpus/user/kembalikan_buku.php"
                class="<?= ($halaman == 'pengembalian.php') ? 'active' : '' ?>">
                Pengembalian
            </a>
        </li>
        <li>
            <a href="/perpus/user/history.php"
                class="<?= ($halaman == 'history.php') ? 'active' : '' ?>">
                Riwayat
            </a>
        </li>
    </ul>

    <div class="right">
        <span><?= $_SESSION['username']; ?></span>
        <a href="/perpus/logout.php" class="logout">Logout</a>
    </div>
</nav>