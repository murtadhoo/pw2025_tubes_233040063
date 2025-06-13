<?php
session_start();
require 'function.php';

if (!isset($_SESSION['login']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$cars = query("SELECT * FROM cars");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="form-container">
        <h2>Selamat datang, <?= $_SESSION['user']['username'] ?> (Admin)</h2>

        <a href="tambah.php" class="add-btn">Tambah Mobil</a>

        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($cars as $car) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="img/<?= $car['gambar'] ?>" class="car-image"></td>
                        <td><?= $car['merk'] ?></td>
                        <td><?= $car['model'] ?></td>
                        <td><?= $car['tahun'] ?></td>
                        <td>Rp <?= number_format($car['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $car['id'] ?>" class="edit-btn">Edit</a>
                            <a href="hapus.php?id=<?= $car['id'] ?>" class="delete-btn" onclick="return confirm('Yakin?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>