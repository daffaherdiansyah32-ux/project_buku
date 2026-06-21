<?php
session_start();
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit; 
}
include 'config/koneksi.php';

// Mengambil id dari URL
$id = $_GET['id'];

// Deteksi nama kolom primary key di database kamu otomatis (id / id_buku)
$fields_query = mysqli_query($conn, "SHOW KEYS FROM buku WHERE Key_name = 'PRIMARY'");
$field_data = mysqli_fetch_assoc($fields_query);
$primary_key = $field_data['Column_name'];

// Ambil data buku berdasarkan primary key yang terdeteksi
$result = mysqli_query($conn, "SELECT * FROM buku WHERE $primary_key = '$id'");
$buku = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $kode_buku     = $_POST['kode_buku'];
    $judul_buku    = $_POST['judul_buku'];
    $kategori      = $_POST['kategori'];
    $penulis       = $_POST['penulis'];
    $penerbit      = $_POST['penerbit'];
    $tahun_terbit  = $_POST['tahun_terbit'];
    $harga         = $_POST['harga'];
    $gambar_lama   = $_POST['gambar_lama'];

    // Cek apakah user mengupload gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $filename = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_gambar = explode('.', $filename);
        $ekstensi_gambar = strtolower(end($ekstensi_gambar));

        if (in_array($ekstensi_gambar, $ekstensi_valid)) {
            $gambar = uniqid() . '.' . $ekstensi_gambar;
            move_uploaded_file($tmp_name, 'uploads/' . $gambar);
            
            if (file_exists("uploads/" . $gambar_lama) && $gambar_lama != '') {
                unlink("uploads/" . $gambar_lama);
            }
        } else {
            echo "<script>alert('Format gambar harus JPG, JPEG, atau PNG!'); window.history.back();</script>";
            exit;
        }
    }

    // Query UPDATE dinamis menyesuaikan nama primary key database
    $query = "UPDATE buku SET 
                kode_buku = '$kode_buku', 
                judul_buku = '$judul_buku', 
                kategori = '$kategori', 
                penulis = '$penulis', 
                penerbit = '$penerbit', 
                tahun_terbit = '$tahun_terbit', 
                harga = '$harga', 
                gambar = '$gambar' 
              WHERE $primary_key = '$id'";

    $update = mysqli_query($conn, $query);

    if ($update) {
        echo "<script>alert('Data berhasil diubah!'); window.location='index.php';</script>";
    } else {
        die("Gagal update data. Error: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Edit Data Buku</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="gambar_lama" value="<?= $buku['gambar']; ?>">
                
                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode_buku" class="form-control" value="<?= $buku['kode_buku']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" value="<?= $buku['judul_buku']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="<?= $buku['kategori']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?= $buku['penulis']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?= $buku['penerbit']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="<?= $buku['tahun_terbit']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" value="<?= $buku['harga']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Sekarang</label><br>
                    <?php if (!empty($buku['gambar'])) : ?>
                        <img src="uploads/<?= $buku['gambar']; ?>" width="100" class="img-thumbnail mb-2"><br>
                    <?php else : ?>
                        <span class="text-muted d-block mb-2">Belum ada gambar</span>
                    <?php endif; ?>
                    <label class="form-label">Ganti Gambar (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                
                <div class="mt-4">
                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>