<?php
session_start();
include '../../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'];

// ❌ Cegah admin ubah dirinya sendiri
if ($_SESSION['id'] == $id) {
    header("Location: ../kelola_user.php");
    exit();
}

$user = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'")
);

include '../navbar.php';
?>

<link rel="stylesheet" href="/css/user/edit_user.css">

<div class="main-content">
    <h2>Ubah Role User</h2>

    <div class="form-card">
        <form method="post" action="proses_edit_role.php">
            <input type="hidden" name="id_user" value="<?= $user['id']; ?>">

            <div class="input-box">
                <label>Username</label>
                <input type="text" value="<?= $user['username']; ?>" disabled>
            </div>

            <div class="input-box">
                <label>Role</label>
                <select name="role">
                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>
                        Admin
                    </option>
                    <option value="user" <?= ($user['role'] == 'user') ? 'selected' : ''; ?>>
                        User
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan">Simpan</button>
                <a href="../kelola_user.php">Batal</a>
            </div>
        </form>
    </div>
</div>