<?php
session_start();
include '../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include 'navbar.php';
?>

<link rel="stylesheet" href="../css/user/kelola_user.css">
    <link rel="stylesheet" href="../css/dashboard_admin.css">


<div class="main-content">
    <h2>Kelola User</h2>

    <div class="filter-card">
    <form method="GET" class="filter-form">

        <input 
            type="text" 
            name="search" 
            placeholder="Cari username..."
            value="<?= $_GET['search'] ?? '' ?>">

        <select name="role">
            <option value="">Semua Role</option>
            <option value="admin" <?= (@$_GET['role']=='admin')?'selected':'' ?>>Admin</option>
            <option value="user" <?= (@$_GET['role']=='user')?'selected':'' ?>>User</option>
        </select>

        <select name="urut">
            <option value="">Urutkan</option>
            <option value="nama_asc" <?= (@$_GET['urut']=='nama_asc')?'selected':'' ?>>Username A–Z</option>
            <option value="nama_desc" <?= (@$_GET['urut']=='nama_desc')?'selected':'' ?>>Username Z–A</option>
            <option value="id_asc" <?= (@$_GET['urut']=='id_asc')?'selected':'' ?>>ID Terkecil</option>
            <option value="id_desc" <?= (@$_GET['urut']=='id_desc')?'selected':'' ?>>ID Terbesar</option>
        </select>

        <button type="submit">Terapkan</button>
        <a href="kelola_user.php" class="btn-reset">Reset</a>

    </form>
</div>

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
                $where = [];
$order = "ORDER BY id ASC";

if (!empty($_GET['role'])) {
    $role = mysqli_real_escape_string($koneksi, $_GET['role']);
    $where[] = "role = '$role'";
}

if (!empty($_GET['urut'])) {
    switch ($_GET['urut']) {
        case 'nama_asc':
            $order = "ORDER BY username ASC";
            break;
        case 'nama_desc':
            $order = "ORDER BY username DESC";
            break;
        case 'id_asc':
            $order = "ORDER BY id ASC";
            break;
        case 'id_desc':
            $order = "ORDER BY id DESC";
            break;
    }
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$query = "SELECT * FROM users $whereSQL $order";
$users = mysqli_query($koneksi, $query);

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
                                <a href="../admin/config_user/edit_role.php?id=<?= $u['id']; ?>">Ubah Role</a>|
                                <a href="../admin/config_user/hapus_user.php?id=<?= $u['id']; ?>"
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