<?php
require 'function.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$car = query("SELECT * FROM cars WHERE id = $id")[0];

if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data mobil berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data mobil gagal diubah!');
                document.location.href = 'index.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mobil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Ubah Data Mobil</h2>
        <a href="index.php" class="back-btn">Kembali</a>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $car['id']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $car['gambar']; ?>">

            <div class="form-group">
                <label for="gambar">Gambar Mobil</label>
                <input type="file" id="gambar" name="gambar">
                <small>Biarkan kosong jika tidak ingin mengubah gambar</small>
                <div class="image-preview">
                    <img src="img/<?= $car['gambar']; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="merk">Merk Mobil</label>
                    <input type="text" id="merk" name="merk" value="<?= $car['merk']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="model">Model Mobil</label>
                    <input type="text" id="model" name="model" value="<?= $car['model']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tahun">Tahun Produksi</label>
                    <input type="number" id="tahun" name="tahun" value="<?= $car['tahun']; ?>" min="1900" max="2099" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" value="<?= $car['harga']; ?>" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" required><?= $car['deskripsi']; ?></textarea>
            </div>

            <button type="submit" name="ubah" class="submit-btn">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>