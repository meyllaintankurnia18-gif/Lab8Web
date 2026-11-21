<?php
require_once 'koneksi.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = mysqli_prepare($conn, "SELECT * FROM data_barang WHERE id_barang = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die('Data barang tidak ditemukan. <a href="index.php">Kembali</a>');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = (float)($_POST['harga_jual'] ?? 0);
    $harga_beli = (float)($_POST['harga_beli'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);
    $gambar = $data['gambar'];

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
                    if ($gambar && is_file(__DIR__ . '/' . $gambar)) {
                        unlink(__DIR__ . '/' . $gambar);
                    }
                    $gambar = 'gambar/' . $newName;
                } else {
                    $error = 'Gagal mengunggah gambar.';
                }
            }
        }

        if ($error === '') {
            $stmt = mysqli_prepare($conn, "UPDATE data_barang SET nama=?, kategori=?, harga_jual=?, harga_beli=?, stok=?, gambar=? WHERE id_barang=?");
            mysqli_stmt_bind_param($stmt, "ssddisi", $nama, $kategori, $harga_jual, $harga_beli, $stok, $gambar, $id);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php?status=ubah');
                exit;
            }
            $error = 'Data gagal diperbarui: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <a class="back-link" href="index.php">← Kembali ke Data Barang</a>
    <section class="form-card">
        <p class="eyebrow">DATA BARANG</p>
        <h1>Ubah Barang</h1>
        <p class="subtitle">Perbarui informasi barang yang dipilih.</p>
        <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post" action="ubah.php?id=<?= $id; ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <label>Nama Barang
                <input type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? $data['nama']); ?>">
            </label>
            <label>Kategori
                <select name="kategori" required>
                    <?php foreach (['Komputer', 'Elektronik', 'Hand Phone'] as $item): ?>
                    <option value="<?= $item; ?>" <?= (($_POST['kategori'] ?? $data['kategori']) === $item) ? 'selected' : ''; ?>><?= $item; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="form-grid">
                <label>Harga Jual
                    <input type="number" name="harga_jual" min="0" required value="<?= htmlspecialchars($_POST['harga_jual'] ?? $data['harga_jual']); ?>">
                </label>
                <label>Harga Beli
                    <input type="number" name="harga_beli" min="0" required value="<?= htmlspecialchars($_POST['harga_beli'] ?? $data['harga_beli']); ?>">
                </label>
            </div>
            <label>Stok
                <input type="number" name="stok" min="0" required value="<?= htmlspecialchars($_POST['stok'] ?? $data['stok']); ?>">
            </label>
            <?php if (!empty($data['gambar']) && file_exists(__DIR__ . '/' . $data['gambar'])): ?>
                <div class="current-image"><span>Gambar saat ini:</span><img class="product-image" src="<?= htmlspecialchars($data['gambar']); ?>" alt="Gambar barang"></div>
            <?php endif; ?>
            <label>Ganti Gambar <span class="hint">(opsional)</span>
                <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.webp">
            </label>
            <button class="button full" type="submit">Simpan Perubahan</button>
        </form>
    </section>
</div>
</body>
</html>
