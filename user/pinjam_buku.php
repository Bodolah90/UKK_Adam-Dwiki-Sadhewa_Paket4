<?php
session_start();
include '../config/config.php';
include 'navbar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id']; // pastikan session menyimpan id user
$where = [];

/* SEARCH */
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $where[] = "(nama_buku LIKE '%$search%' OR pengarang LIKE '%$search%')";
}

/* FILTER STATUS */
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
    $where[] = "status = '$status'";
}

/* GABUNGKAN QUERY */
$sql = "SELECT * FROM buku";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id_buku DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die(mysqli_error($koneksi));
}
?>
<link rel="stylesheet" href="../css/pinjam/pinjam_buku.css">

<div class="main-content">
    <h2>Daftar Buku</h2>

    <div class="filter-card">
    <form method="GET" class="filter-form">

        <input
            type="text"
            name="search"
            placeholder="Cari judul / pengarang..."
            value="<?= $_GET['search'] ?? '' ?>">

        <select name="status">
            <option value="">Semua Status</option>
            <option value="Tersedia" <?= (@$_GET['status']=='Tersedia')?'selected':'' ?>>Tersedia</option>
            <option value="Dipinjam" <?= (@$_GET['status']=='Dipinjam')?'selected':'' ?>>Dipinjam</option>
            <option value="Tidak Tersedia" <?= (@$_GET['status']=='Tidak Tersedia')?'selected':'' ?>>Tidak Tersedia</option>
        </select>

        <button type="submit">Terapkan</button>
        <a href="pinjam_buku.php" class="btn-reset">Reset</a>

    </form>
</div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($b = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $b['nama_buku']; ?></strong></td>
                        <td><?= $b['pengarang']; ?></td>
                        <td>
                            <?php
                            $statusClass = (strtolower($b['status']) == 'tersedia') ? 'tersedia' : (strtolower($b['status']) == 'dipinjam' ? 'dipinjam' : 'tidak-ada');
                            ?>
                            <span class="status-label <?= $statusClass; ?>"><?= $b['status']; ?></span>
                        </td>
                        <td style="text-align: center;">
                            <?php if (strtolower($b['status']) == 'tersedia'): ?>
                                <a href="config_pinjam/proses_pinjam.php?id=<?= $b['id_buku']; ?>" class="btn-pinjam">Pinjam Buku</a>
                            <?php elseif (strtolower($b['status']) == 'dipinjam'): ?>
                                <span class="text-muted">Sudah Dipinjam</span>
                            <?php else: ?>
                                <span class="text-muted">Tidak Tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>