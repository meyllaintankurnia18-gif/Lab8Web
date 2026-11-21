<?php
require_once 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = (float)($_POST['harga_jual'] ?? 0);
    $harga_beli = (float)($_POST['harga_beli'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);
    $gambar = '';

    if ($nama === '') {
        $error = 'Nama barang wajib diisi.';
    } else {
        if (isset($_FILES['file_gambar']) && $_FILES['file_gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['file_gambar'];
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($file['error'] !== UPLOAD_ERR_OK || !in_array($ext, $allowed, true)) {
                $error = 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.';
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $error = 'Ukuran gambar maksimal 2 MB.';
            } else {
                $newName = uniqid('barang_', true) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], __DIR__ . '/gambar/' . $newName)) {
                    $gambar = 'gambar/' . $newName;
                } else {
                    $error = 'Gagal mengunggah gambar.';
                }
            }
        }

        if ($error === '') {
            $stmt = mysqli_prepare($conn, "INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssddis", $nama, $kategori, $harga_jual, $harga_beli, $stok, $gambar);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php?status=tambah');
                exit;
            }
            $error = 'Data gagal disimpan: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <a class="back-link" href="index.php">← Kembali ke Data Barang</a>
    <section class="form-card">
        <p class="eyebrow">DATA BARANG</p>
        <h1>Tambah Barang</h1>
        <p class="subtitle">Masukkan informasi barang baru ke dalam database.</p>
        <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post" action="tambah.php" enctype="multipart/form-data">
            <label>Nama Barang
                <input type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>" placeholder="Contoh: Laptop Asus">
            </label>
            <label>Kategori
                <select name="kategori" required>
                    <?php foreach (['Komputer', 'Elektronik', 'Hand Phone'] as $item): ?>
                    <option value="<?= $item; ?>" <?= (($_POST['kategori'] ?? 'Elektronik') === $item) ? 'selected' : ''; ?>><?= $item; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="form-grid">
                <label>Harga Jual
                    <input type="number" name="harga_jual" min="0" required value="<?= htmlspecialchars($_POST['harga_jual'] ?? ''); ?>">
                </label>
                <label>Harga Beli
                    <input type="number" name="harga_beli" min="0" required value="<?= htmlspecialchars($_POST['harga_beli'] ?? ''); ?>">
                </label>
            </div>
            <label>Stok
                <input type="number" name="stok" min="0" required value="<?= htmlspecialchars($_POST['stok'] ?? ''); ?>">
            </label>
            <label>File Gambar <span class="hint">(opsional, JPG/PNG/WEBP maks. 2 MB)</span>
                <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.webp">
            </label>
            <button class="button full" type="submit">Simpan Barang</button>
        </form>
    </section>
</div>
</body>
</html>
