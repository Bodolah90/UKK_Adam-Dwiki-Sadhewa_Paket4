<?php
$halaman = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="/perpus/css/navbar.css">
<nav class="navbar">
    <!-- KIRI: Judul -->
    <div class="logo">
        Online Library
    </div>

    <!-- TENGAH: Menu -->
    <ul class="menu">
        <li>
            <a href="/perpus/admin/dashboard.php"
                class="<?= ($halaman == 'dashboard.php') ? 'active' : '' ?>">
                Home
            </a>
        </li>
        <li>
            <a href="/perpus/admin/kelola_user.php"
                class="<?= ($halaman == 'kelola_user.php') ? 'active' : '' ?>">
                Kelola User
            </a>
        </li>
        <li>
            <a href="/perpus/admin/kelola_buku.php"
                class="<?= ($halaman == 'kelola_buku.php') ? 'active' : '' ?>">
                Kelola Buku
            </a>
        </li>
        <li>
            <a href="/perpus/admin/kelola_transaksi.php"
                class="<?= ($halaman == 'kelola_transaksi.php') ? 'active' : '' ?>">
                Kelola Transaksi
            </a>
        </li>
    </ul>

    <!-- KANAN: Logout -->
    <div class="right">
        <span class="user">
            <?= $_SESSION['username']; ?>
        </span>
        <a href="/perpus/logout.php" class="logout"
            onclick="return confirm('Yakin mau logout?')">
            Logout
        </a>
    </div>
</nav>