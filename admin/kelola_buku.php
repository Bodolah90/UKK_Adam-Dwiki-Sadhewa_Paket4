<?php
session_start();
include '../config/config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<?php include 'navbar.php'; ?>

    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/buku/kelola_buku.css">


<div class="main-content">
    <div class="header-section">
        <h2>Kelola Data Buku</h2>
        <a href="/admin/config_buku/tambah_buku.php" class="btn-add">+ Tambah Buku</a>
    </div>

    <div class="filter-card">
    <form method="GET" class="filter-form">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nama buku, pengarang, penerbit..."
            value="<?= $_GET['search'] ?? '' ?>">

        <select name="status">
            <option value="">Semua Status</option>
            <option value="Tersedia" <?= (@$_GET['status']=='Tersedia')?'selected':'' ?>>Tersedia</option>
            <option value="Dipinjam" <?= (@$_GET['status']=='Dipinjam')?'selected':'' ?>>Dipinjam</option>
              <option value="Tidak" <?= (@$_GET['status']=='Tidak')?'selected':'' ?>>Tidak</option>
        </select>

        <select name="tahun">
            <option value="">Semua Tahun</option>
            <?php
            $tahunQ = mysqli_query($koneksi, "SELECT DISTINCT tahun_terbit FROM buku ORDER BY tahun_terbit DESC");
            while($t = mysqli_fetch_assoc($tahunQ)){
                $selected = (@$_GET['tahun']==$t['tahun_terbit'])?'selected':'';
                echo "<option value='{$t['tahun_terbit']}' $selected>{$t['tahun_terbit']}</option>";
            }
            ?>
        </select>

        <select name="urut">
            <option value="">Urutkan</option>
            <option value="nama_asc" <?= (@$_GET['urut']=='nama_asc')?'selected':'' ?>>Nama A–Z</option>
            <option value="nama_desc" <?= (@$_GET['urut']=='nama_desc')?'selected':'' ?>>Nama Z–A</option>
            <option value="tahun_asc" <?= (@$_GET['urut']=='tahun_asc')?'selected':'' ?>>Tahun Terlama</option>
            <option value="tahun_desc" <?= (@$_GET['urut']=='tahun_desc')?'selected':'' ?>>Tahun Terbaru</option>
        </select>

        <button type="submit">Terapkan</button>
        <a href="kelola_buku.php" class="btn-reset">Reset</a>
    </form>
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
                $where = [];
$order = "ORDER BY id_buku ASC";

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $where[] = "(nama_buku LIKE '%$search%' 
                OR pengarang LIKE '%$search%' 
                OR penerbit LIKE '%$search%')";
}

if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
    $where[] = "status = '$status'";
}

if (!empty($_GET['tahun'])) {
    $tahun = mysqli_real_escape_string($koneksi, $_GET['tahun']);
    $where[] = "tahun_terbit = '$tahun'";
}

if (!empty($_GET['urut'])) {
    switch ($_GET['urut']) {
        case 'nama_asc':
            $order = "ORDER BY nama_buku ASC";
            break;
        case 'nama_desc':
            $order = "ORDER BY nama_buku DESC";
            break;
        case 'tahun_asc':
            $order = "ORDER BY tahun_terbit ASC";
            break;
        case 'tahun_desc':
            $order = "ORDER BY tahun_terbit DESC";
            break;
    }
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$query = "SELECT * FROM buku $whereSQL $order";
$data = mysqli_query($koneksi, $query);
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