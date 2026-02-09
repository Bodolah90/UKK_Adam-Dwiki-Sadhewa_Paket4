<?php
session_start();
include '../../config/config.php';

$id = $_GET['id'];

$buku = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'")
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="/perpus/css/buku/edit_buku.css">
</head>

<body>

    <?php include '../navbar.php'; ?>

    <div class="container">
        <div class="form-card">
            <h2>Edit Data Buku</h2>
            <form method="post" action="proses_edit_buku.php">
                <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">

                <div class="form-group">
                    <label>Nama Buku</label>
                    <input type="text" name="nama_buku" value="<?= $buku['nama_buku']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" value="<?= $buku['pengarang']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="<?= $buku['penerbit']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Status Ketersediaan</label>
                    <select name="status">
                        <option value="Tersedia" <?= ($buku['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="tidak" <?= ($buku['status'] == 'tidak') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" name="update" class="btn-update">Update Data</button>
                    <a href="/perpus/admin/kelola_buku.php" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>