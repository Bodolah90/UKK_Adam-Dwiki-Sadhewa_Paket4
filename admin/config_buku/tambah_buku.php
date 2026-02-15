<?php
session_start();
include '../../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

include '../navbar.php';
?>

<link rel="stylesheet" href="/css/buku/tambah_buku.css">

<div class="main-content">
    <h2>Tambah Buku</h2>

    <div class="form-card">
        <form method="post" action="proses_tambah.php">
            <div class="form-grid">
                <div class="input-box">
                    <label>Nama Buku</label>
                    <input type="text" name="nama_buku" required>
                </div>

                <div class="input-box">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" required>
                </div>

                <div class="input-box">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" required>
                </div>

                <div class="input-box">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" required>
                </div>

                <div class="input-box">
                    <label>Status</label>
                    <select name="status">
                        <option value="Tersedia">Tersedia</option>
                        <option value="tidak">Tidak Tersedia</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn-save">Simpan</button>
                <a href="../kelola_buku.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>