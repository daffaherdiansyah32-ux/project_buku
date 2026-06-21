<?php
include 'config/koneksi.php'; // disesuaikan dengan folder config milikmu
$query = mysqli_query($conn, "SELECT * FROM buku"); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="window.print()">
<div class="container mt-5">
    <h2 class="text-center mb-4">LAPORAN DATA BUKU</h2>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td><?= $row['kode_buku']; ?></td>
                <td><?= $row['judul_buku']; ?></td>
                <td><?= $row['kategori']; ?></td>
                <td><?= $row['penulis']; ?></td>
                <td><?= $row['penerbit']; ?></td>
                <td><?= $row['tahun_terbit']; ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
