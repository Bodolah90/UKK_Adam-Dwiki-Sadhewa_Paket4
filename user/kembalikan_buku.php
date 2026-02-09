<?php
session_start();
include '../config/config.php';
include 'navbar.php';

// Pastikan namanya $user_id (Gunakan huruf kecil semua)
$user_id = $_SESSION['user_id'];

// Menggunakan UPPER() agar semua tulisan di database dianggap huruf besar saat dicari
// Gunakan LIKE agar pencarian lebih fleksibel
$query = mysqli_query($koneksi, "SELECT t.*, b.nama_buku 
    FROM transaksi_user t 
    JOIN buku b ON t.buku_id = b.id_buku 
    WHERE t.user_id = '$user_id' AND t.status LIKE '%Dipinjam%'");
?>

<link rel="stylesheet" href="/perpus/css/kembali/kembalikan_buku.css">

<div class="main-content">
    <h2>Buku yang Kamu Pinjam</h2>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert-success">Buku berhasil dikembalikan!</div>
    <?php endif; ?>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 50px;">No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($t = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><strong><?= $t['nama_buku']; ?></strong></td>
                        <td><?= $t['tgl_pinjam']; ?></td>
                        <td style="text-align: center;">
                            <a href="config_kembali/proses_kembali.php?id=<?= $t['id']; ?>"
                                class="btn-kembali"
                                onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                Kembalikan
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #95a5a6;">
                            Kamu belum meminjam buku apapun.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>