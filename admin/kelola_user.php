<?php
session_start();
include '../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include 'navbar.php';
?>

<link rel="stylesheet" href="/perpus/css/user/kelola_user.css">

<div class="main-content">
    <h2>Kelola User</h2>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $users = mysqli_query($koneksi, "SELECT * FROM users");

                while ($u = mysqli_fetch_assoc($users)) {
                    $isSelf = ($_SESSION['id'] == $u['id']);
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $u['username']; ?></td>
                        <td>
                            <span class="badge <?= ($u['role'] == 'admin') ? 'bg-green' : 'bg-blue'; ?>">
                                <?= $u['role']; ?>
                            </span>
                        </td>
                        <td style="text-align:center">
                            <?php if (!$isSelf): ?>
                                <a href="/perpus/admin/config_user/edit_role.php?id=<?= $u['id']; ?>">Ubah Role</a> |
                                <a href="/perpus/admin/config_user/hapus_user.php?id=<?= $u['id']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    Hapus
                                </a>
                            <?php else: ?>
                                <span style="color:#999;">(Ini akun kamu)</span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>