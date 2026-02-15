<?php
session_start();
include '../config/config.php';
include 'navbar.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

/*
  Query FINAL (PAKAI JOIN)
  - Lebih cepat
  - Lebih rapi
  - Tidak ada query di dalam while
*/
$query = mysqli_query($koneksi, "
    SELECT 
        t.id,
        t.tgl_pinjam,
        t.tgl_kembali,
        t.status,
        u.username,
        b.nama_buku,
        b.id_buku
    FROM transaksi_user t
    JOIN users u ON t.user_id = u.id
    JOIN buku b ON t.buku_id = b.id_buku
    ORDER BY t.id DESC
");

if (!$query) {
    die(mysqli_error($koneksi));
}
?>

<link rel="stylesheet" href="../css/dashboard_admin.css">
<link rel="stylesheet" href="../css/transaksi/keloka_transaksi.css">

<div class="main-content">

    <div class="header-section">
        <h2>Kelola Transaksi</h2>
    </div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($t = mysqli_fetch_assoc($query)) {

                    $status_db  = $t['status'];
                    $badgeClass = 'bg-red';
                    $teksStatus = 'Sedang Dipinjam';

                    if ($status_db === 'Dikembalikan') {
                        $badgeClass = 'bg-green';
                        $teksStatus = 'Sudah Dikembalikan';
                    }
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($t['username']) ?></strong></td>
                        <td><?= htmlspecialchars($t['nama_buku']) ?></td>
                        <td><?= $t['tgl_pinjam'] ?></td>
                        <td><?= $t['tgl_kembali'] ?? '-' ?></td>
                        <td>
                            <span class="badge <?= $badgeClass ?>">
                                <?= $teksStatus ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($status_db === 'Dipinjam'): ?>
                                    <a href="config_transaksi/transaksi_hapus.php?id=<?= $t['id'] ?>&id_buku=<?= $t['id_buku'] ?>"
                                        class="link-edit"
                                        onclick="return confirm('Selesaikan transaksi ini?')">
                                        Selesaikan
                                    </a>
                                <?php else: ?>
                                    <span class="link-delete">Selesai</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>