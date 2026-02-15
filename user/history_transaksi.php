<?php

session_start();

include '../config/config.php';

include 'navbar.php';

$user_id = $_SESSION['user_id'];

$query = mysqli_query($koneksi, "
    SELECT t.*, b.nama_buku 
    FROM transaksi_user t
    JOIN buku b ON t.buku_id = b.id_buku
    WHERE t.user_id = '$user_id'
    ORDER BY t.id DESC
");
?>

<link rel="stylesheet" href="/perpus/css/kembali/kembalikan_buku.css">
<link rel="stylesheet" href="../css/testing.css">


<div class="main-content">
    <h2>History Transaksi</h2>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="text-align:center; width:50px;">No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($query) > 0):
                    while ($t = mysqli_fetch_assoc($query)):
                ?>
                        <tr>
                            <td style="text-align:center;"><?= $no++; ?></td>
                            <td><strong><?= $t['nama_buku']; ?></strong></td>
                            <td><?= $t['tgl_pinjam']; ?></td>
                            <td>
                                <?php if ($t['status'] == 'Dipinjam'): ?>
                                    <span class="badge badge-warning">Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if ($t['status'] == 'Dipinjam'): ?>
                                    <a href="config_kembali/proses_kembali.php?id=<?= $t['id']; ?>"
                                        class="btn-kembali"
                                        onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        Kembalikan
                                    </a>
                                <?php else: ?>
                                    <span style="color:#95a5a6;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px; color:#95a5a6;">
                            Belum ada history transaksi.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>