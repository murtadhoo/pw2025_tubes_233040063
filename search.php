<?php
session_start();
require 'function.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $conn = koneksi();
    $sql = "SELECT * FROM cars WHERE 
            merk LIKE '%$query%' OR 
            model LIKE '%$query%' OR 
            tahun LIKE '%$query%' OR 
            harga LIKE '%$query%' OR 
            deskripsi LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td><img src="img/' . $row['gambar'] . '" class="car-image"></td>';
            echo '<td>' . $row['merk'] . '</td>';
            echo '<td>' . $row['model'] . '</td>';
            echo '<td>' . $row['tahun'] . '</td>';
            echo '<td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>';
            echo '<td>' . substr($row['deskripsi'], 0, 50) . '...</td>';

            if ($user['role'] == 'admin') {
                echo '<td class="action-buttons">';
                echo '<a href="ubah.php?id=' . $row['id'] . '" class="edit-btn">Ubah</a>';
                echo '<a href="hapus.php?id=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Yakin?\')">Hapus</a>';
                echo '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="8" class="no-data">Tidak ada data ditemukan</td></tr>';
    }
}
