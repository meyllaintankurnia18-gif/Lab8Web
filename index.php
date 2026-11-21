<?php
require_once 'koneksi.php';

$sql = "SELECT * FROM data_barang ORDER BY id_barang DESC";
$result = mysqli_query($conn, $sql);

function rupiah($angka) {
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="page-header">
        <div>
            <p class="eyebrow">PRAKTIKUM 8 · PHP & MYSQL</p>
            <h1>Data Barang</h1>
            <p class="subtitle">Aplikasi sederhana untuk mengelola data barang.</p>
        </div>
        <a class="button" href="tambah.php">+ Tambah Barang</a>
    </header>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert success">
            <?php
            $messages = [
                'tambah' => 'Data barang berhasil ditambahkan.',
                'ubah' => 'Data barang berhasil diperbarui.',
                'hapus' => 'Data barang berhasil dihapus.'
            ];
            echo htmlspecialchars($messages[$_GET['status']] ?? 'Proses berhasil.');
            ?>
        </div>
    <?php endif; ?>

    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?php if (!empty($row['gambar']) && file_exists(__DIR__ . '/' . $row['gambar'])): ?>
                                <img class="product-image" src="<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>">
                            <?php else: ?>
                                <span class="no-image">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($row['nama']); ?></strong></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><?= rupiah($row['harga_beli']); ?></td>
                        <td><?= rupiah($row['harga_jual']); ?></td>
                        <td><?= (int)$row['stok']; ?></td>
                        <td class="actions">
                            <a class="link-edit" href="ubah.php?id=<?= (int)$row['id_barang']; ?>">Ubah</a>
                            <a class="link-delete" href="hapus.php?id=<?= (int)$row['id_barang']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="empty">Belum ada data barang. Klik “Tambah Barang” untuk mulai mengisi.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer>Praktikum Pemrograman Web · CRUD PHP & MySQL</footer>
</div>
</body>
</html>
