<?php
function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "", "pw2025_tubes_233040063");
    return $conn;
}
