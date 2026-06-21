<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config/koneksi.php';
if(!isset($_SESSION['login'])){
    die("Session login tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

<h2>Data Buku</h2>

<a href="cetak.php" target="_blank" class="btn btn-danger mb-3">Cetak PDF</a>
<a href="tambah.php" class="btn btn-success mb-3">
Tambah Data
</a>

<table class="table table-bordered">

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

<?php
$data=mysqli_query($conn,"SELECT * FROM buku");

while($d=mysqli_fetch_array($data)){
?>

<tr>
<td><?= $d['kode_buku']; ?></td>
<td><?= $d['judul_buku']; ?></td>
<td><?= $d['kategori']; ?></td>
<td><?= $d['penulis']; ?></td>
<td><?= $d['penerbit']; ?></td>
<td><?= $d['tahun_terbit']; ?></td>
<td><?= $d['harga']; ?></td>

<td>
<img src="uploads/<?= $row['gambar']; ?>" width="80" class="img-thumbnail" alt="Gambar Buku">
</td>

<td>
<a href="edit.php?id=<?= $d['id_buku']; ?>" class="btn btn-warning btn-sm">
Edit
</a>

<a href="hapus.php?id=<?= $d['id_buku']; ?>" class="btn btn-danger btn-sm">
Hapus
</a>
</td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>