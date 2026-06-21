<?php
session_start();
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit; 
}
include 'config/koneksi.php';

// Mengambil data dari tabel buku
$result = mysqli_query($conn, "SELECT * FROM buku");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-4">
<div class="container bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4">Data Buku</h2>
    
    <div class="mb-3">
        <a href="cetak.php" target="_blank" class="btn btn-danger">Cetak PDF</a>
        <a href="tambah.php" class="btn btn-success">Tambah Data</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['kode_buku']; ?></td>
                <td><?= $row['judul_buku']; ?></td>
                <td><?= $row['kategori']; ?></td>
                <td><?= $row['penulis']; ?></td>
                <td><?= $row['penerbit']; ?></td>
                <td><?= $row['tahun_terbit']; ?></td>
                <td><?= number_format($row['harga'], 2, ',', '.'); ?></td>
                <td>
                    <?php if (!empty($row['gambar'])) : ?>
                        <img src="uploads/<?= $row['gambar']; ?>" width="50" class="img-thumbnail" alt="Gambar Buku">
                    <?php else : ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= isset($row['id']) ? $row['id'] : (isset($row['id_buku']) ? $row['id_buku'] : $row['kode_buku']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= isset($row['id']) ? $row['id'] : (isset($row['id_buku']) ? $row['id_buku'] : $row['kode_buku']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>