<?php
session_start();
include '../config/config.php';
include 'navbar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
// Query ini akan menampilkan semuanya (yang masih pinjam maupun sudah kembali)
// Ganti baris 13-19 dengan ini untuk tes:
$query = mysqli_query($koneksi, "SELECT * FROM transaksi_user ORDER BY id DESC");
?>

<div style="padding: 20px;">
    <h2>Riwayat Transaksi Perpustakaan</h2>
    <table border="1" width="100%" cellpadding="10" cellspacing="0">
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1;
        while ($t = mysqli_fetch_assoc($query)) {
            // --- AMBIL DATA USER SECARA MANUAL ---
            $id_u = $t['user_id'];
            $u_cek = mysqli_query($koneksi, "SELECT username FROM users WHERE id = '$id_u'");
            $u_data = mysqli_fetch_assoc($u_cek);
            $view_username = $u_data['username'] ?? 'User tidak ditemukan';

            // --- AMBIL DATA BUKU SECARA MANUAL ---
            $id_b = $t['buku_id'];
            $b_cek = mysqli_query($koneksi, "SELECT nama_buku FROM buku WHERE id_buku = '$id_b'");
            $b_data = mysqli_fetch_assoc($b_cek);
            $view_nama_buku = $b_data['nama_buku'] ?? 'Buku tidak ditemukan';

            // --- LOGIKA STATUS ---
            // Di dalam file kelola_transaksi.php bagian logika status
            $st = $t['status']; // Akan berisi 'Dipinjam' atau 'Kembali'

            if ($st == 'Dipinjam') {
                $warna = 'red';
                $teks = 'Sedang Dipinjam';
            } else if ($st == 'Kembali') {
                $warna = 'green';
                $teks = 'Sudah Dikembalikan';
            }
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><strong><?= $view_username ?></strong></td>
                <td><?= $view_nama_buku ?></td>
                <td><?= $t['tgl_pinjam'] ?></td>
                <td><?= $t['tgl_kembali'] ?? '-' ?></td>
                <td><b style="color: <?= $warnaStatus ?>;"><?= $teksStatus ?></b></td>
                <td>
                    <?php if ($status_db == 'pinjam'): ?>
                        <a href="config_transaksi/transaksi_hapus.php?id=<?= $t['id'] ?>&id_buku=<?= $t['buku_id'] ?>"
                            onclick="return confirm('Buku sudah dikembalikan?')"
                            style="background-color: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px;">
                            Selesaikan
                        </a>
                    <?php else: ?>
                        <span style="color: gray;">Selesai</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>