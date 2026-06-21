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
    <title>Dashboard Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
           font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh; 
    }
    
    .main-card {
        border: none;
        border-radius: 15px;
    }
        
        .main-card {
            border: none;
            border-radius: 15px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .img-book {
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            transition: transform 0.2s;
        }
        .img-book:hover {
            transform: scale(1.1);
        }
        .badge-kategori {
            background-color: #e3f2fd;
            color: #0d6efd;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 20px;
        }
    </style>
</head>
<body class="py-5">
<div class="container">
    
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1"><i class="fa-solid fa-book-bookmark text-primary me-2"></i>Katalog Data Buku</h2>
            <p class="text-muted mb-0">Kelola informasi koleksi perpustakaan dengan mudah</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="cetak.php" target="_blank" class="btn btn-danger btn-custom px-3 me-2">
                <i class="fa-solid fa-file-pdf me-2"></i>Cetak PDF
            </a>
            <a href="tambah.php" class="btn btn-success btn-custom px-3">
                <i class="fa-solid fa-plus me-2"></i>Tambah Data Baru
            </a>
        </div>
    </div>

    <div class="card main-card shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-center">
                            <th scope="col" class="py-3">Kode</th>
                            <th scope="col" class="py-3 text-start">Judul Buku</th>
                            <th scope="col" class="py-3">Kategori</th>
                            <th scope="col" class="py-3">Penulis / Penerbit</th>
                            <th scope="col" class="py-3">Tahun</th>
                            <th scope="col" class="py-3">Harga</th>
                            <th scope="col" class="py-3">Cover</th>
                            <th scope="col" class="py-3">Aksi Opsional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) : ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="text-center">
                                <td class="fw-semibold text-secondary">#<?= $row['kode_buku']; ?></td>
                                <td class="text-start">
                                    <span class="fw-bold text-dark d-block"><?= $row['judul_buku']; ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-kategori"><?= $row['kategori']; ?></span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark"><?= $row['penulis']; ?></span>
                                    <small class="text-muted"><?= $row['penerbit']; ?></small>
                                </td>
                                <td><span class="badge bg-secondary rounded-pill"><?= $row['tahun_terbit']; ?></span></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if (!empty($row['gambar'])) : ?>
                                        <img src="uploads/<?= $row['gambar']; ?>" width="45" height="60" class="img-book" alt="Cover">
                                    <?php else : ?>
                                        <div class="text-muted bg-light rounded d-inline-block p-2" style="font-size: 11px;">
                                            <i class="fa-solid fa-image d-block mb-1 fs-5 text-secondary"></i>No Cover
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit.php?id=<?= isset($row['id']) ? $row['id'] : (isset($row['id_buku']) ? $row['id_buku'] : $row['kode_buku']); ?>" class="btn btn-warning btn-sm btn-custom text-white px-3" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="hapus.php?id=<?= isset($row['id']) ? $row['id'] : (isset($row['id_buku']) ? $row['id_buku'] : $row['kode_buku']); ?>" class="btn btn-danger btn-sm btn-custom px-3" onclick="return confirm('Yakin ingin menghapus data buku ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open display-4 d-block mb-3 text-secondary"></i>
                                    Belum ada data buku yang tersimpan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>