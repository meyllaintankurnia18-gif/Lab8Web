<?php
require_once 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT gambar FROM data_barang WHERE id_barang = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    $stmt = mysqli_prepare($conn, "DELETE FROM data_barang WHERE id_barang = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if ($data && !empty($data['gambar']) && is_file(__DIR__ . '/' . $data['gambar'])) {
        unlink(__DIR__ . '/' . $data['gambar']);
    }
}

header('Location: index.php?status=hapus');
exit;
?>
