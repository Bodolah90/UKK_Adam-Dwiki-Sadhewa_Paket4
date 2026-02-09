<?php
session_start();
include '../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<?php include 'navbar.php'; ?>

<link rel="stylesheet" href="/perpus/css/buku/kelola_buku.css">

<div class="main-content">
    <div class="header-section">
        <h2>Kelola Data Buku</h2>
        <a href="/perpus/admin/config_buku/tambah_buku.php" class="btn-add">+ Tambah Buku</a>
    </div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM buku");
                while ($b = mysqli_fetch_assoc($data)) {
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><strong><?= $b['nama_buku']; ?></strong></td>
                        <td><?= $b['pengarang']; ?></td>
                        <td><?= $b['penerbit']; ?></td>
                        <td><?= $b['tahun_terbit']; ?></td>
                        <td>
                            <span class="badge <?= ($b['status'] == 'Tersedia') ? 'bg-green' : 'bg-red'; ?>">
                                <?= $b['status']; ?>
                            </span>
                        </td>
                        <td class="action-buttons">
                            <a href="config_buku/edit_buku.php?id=<?= $b['id_buku']; ?>" class="link-edit">Edit</a>
                            <a href="config_buku/hapus_buku.php?id=<?= $b['id_buku']; ?>"
                                class="link-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>