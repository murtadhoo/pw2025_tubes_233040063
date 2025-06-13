<?php
require 'function.php';

if (isset($_POST['tambah'])) {
    if (tambah($_POST) > 0) {
        echo "<script>
                alert('Data mobil berhasil ditambahkan!');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data mobil gagal ditambahkan!');
                document.location.href = 'index.php';
              </script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container col-8">
        <h1 class="mt-4 mb-2">Tambah Data Mobil</h1>
        <a href="index.php" class="btn btn-primary mt-2 mb-4">Kembali</a>

        <form action="tambah.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Mobil</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
            </div>
            <div class="mb-3">
                <label for="merk" class="form-label">Merk Mobil</label>
                <input type="text" class="form-control" id="merk" name="merk" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model Mobil</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun Produksi</label>
                <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="2099" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" min="0" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>

            <button type="submit" name="tambah" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
</body>

</html>