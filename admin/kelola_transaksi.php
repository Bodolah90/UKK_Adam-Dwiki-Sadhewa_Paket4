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
$where = [];
$order = "ORDER BY t.id DESC";

/* SEARCH */
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $where[] = "(u.username LIKE '%$search%' 
                OR b.nama_buku LIKE '%$search%')";
}

/* FILTER STATUS */
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
    $where[] = "t.status = '$status'";
}

/* FILTER TANGGAL PINJAM */
if (!empty($_GET['tgl_pinjam_dari'])) {
    $dari = mysqli_real_escape_string($koneksi, $_GET['tgl_pinjam_dari']);
    $where[] = "t.tgl_pinjam >= '$dari'";
}

if (!empty($_GET['tgl_pinjam_sampai'])) {
    $sampai = mysqli_real_escape_string($koneksi, $_GET['tgl_pinjam_sampai']);
    $where[] = "t.tgl_pinjam <= '$sampai'";
}

/* FILTER TANGGAL KEMBALI */
if (!empty($_GET['tgl_kembali_dari'])) {
    $dari = mysqli_real_escape_string($koneksi, $_GET['tgl_kembali_dari']);
    $where[] = "t.tgl_kembali >= '$dari'";
}

if (!empty($_GET['tgl_kembali_sampai'])) {
    $sampai = mysqli_real_escape_string($koneksi, $_GET['tgl_kembali_sampai']);
    $where[] = "t.tgl_kembali <= '$sampai'";
}

/* SORTING */
if (!empty($_GET['urut'])) {
    switch ($_GET['urut']) {
        case 'id_asc':
            $order = "ORDER BY t.id ASC";
            break;
        case 'id_desc':
            $order = "ORDER BY t.id DESC";
            break;
        case 'tgl_asc':
            $order = "ORDER BY t.tgl_pinjam ASC";
            break;
        case 'tgl_desc':
            $order = "ORDER BY t.tgl_pinjam DESC";
            break;
    }
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

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
    $whereSQL
    $order
");

if (!$query) {
    die(mysqli_error($koneksi));
}

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

    <div class="filter-card">
    <form method="GET" class="filter-form">

        <input 
            type="text" 
            name="search" 
            placeholder="Cari nama peminjam / judul buku..."
            value="<?= $_GET['search'] ?? '' ?>">

        <select name="status">
            <option value="">Semua Status</option>
            <option value="Dipinjam" <?= (@$_GET['status']=='Dipinjam')?'selected':'' ?>>
                Sedang Dipinjam
            </option>
            <option value="Dikembalikan" <?= (@$_GET['status']=='Dikembalikan')?'selected':'' ?>>
                Sudah Dikembalikan
            </option>
        </select>

        <div class="filter-group">
    <label><strong>Tanggal Pinjam</strong></label>
    <input type="date" name="tgl_pinjam_dari">
    <span>sampai</span>
    <input type="date" name="tgl_pinjam_sampai">
</div>

<div class="filter-group">
    <label><strong>Tanggal Kembali</strong></label>
    <input type="date" name="tgl_kembali_dari">
    <span>sampai</span>
    <input type="date" name="tgl_kembali_sampai">
</div>

        <select name="urut">
            <option value="">Urutkan</option>
            <option value="id_desc" <?= (@$_GET['urut']=='id_desc')?'selected':'' ?>>ID Terbaru</option>
            <option value="id_asc" <?= (@$_GET['urut']=='id_asc')?'selected':'' ?>>ID Terlama</option>
            <option value="tgl_desc" <?= (@$_GET['urut']=='tgl_desc')?'selected':'' ?>>Tgl Pinjam Terbaru</option>
            <option value="tgl_asc" <?= (@$_GET['urut']=='tgl_asc')?'selected':'' ?>>Tgl Pinjam Terlama</option>
        </select>

        <button type="submit">Terapkan</button>
        <a href="kelola_transaksi.php" class="btn-reset">Reset</a>

    </form>
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