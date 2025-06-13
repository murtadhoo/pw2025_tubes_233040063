<?php
session_start();
require 'function.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$cars = query("SELECT * FROM cars");

if (isset($_POST["cari"])) {
    $cars = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mazda </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .navbar {
            background-color: #343a40;
            color: white;
            padding: 15px;
        }

        .table img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <h2 class="navbar-brand">MAZDA</h2>
            <div class="d-flex">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" placeholder="Cari mobil..." name="keyword" autocomplete="off">
                    <button class="btn btn-outline-light" type="submit" name="cari">Cari</button>
                </form>
            </div>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 80px;">
        <h2 class="my-4">Daftar Mobil</h2>

        <?php if ($user['role'] == 'admin') : ?>
            <a href="tambah.php" class="btn btn-primary mb-3">Tambah Data Mobil</a>
        <?php endif; ?>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <?php if ($user['role'] == 'admin') : ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($cars as $car) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><img src="img/<?= $car['gambar']; ?>" alt="<?= $car['merk']; ?>" class="img-thumbnail"></td>
                        <td><?= $car['merk']; ?></td>
                        <td><?= $car['model']; ?></td>
                        <td><?= $car['tahun']; ?></td>
                        <td>Rp <?= number_format($car['harga'], 0, ',', '.'); ?></td>
                        <td><?= $car['deskripsi']; ?></td>
                        <?php if ($user['role'] == 'admin') : ?>
                            <td>
                                <a href="ubah.php?id=<?= $car['id']; ?>" class="btn btn-warning btn-sm">Ubah</a>
                                <a href="hapus.php?id=<?= $car['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>