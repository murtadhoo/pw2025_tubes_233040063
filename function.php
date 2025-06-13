<?php
function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "", "pw2025_tubes_233040063");
    return $conn;
}

function tambah($data)
{
    $conn = koneksi();

    // Retrieve and sanitize form data
    $merk = htmlspecialchars($data['merk']);
    $model = htmlspecialchars($data['model']);
    $tahun = htmlspecialchars($data['tahun']);
    $harga = htmlspecialchars($data['harga']);
    $deskripsi = htmlspecialchars($data['deskripsi']);

    // Handle file upload
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];
    $folder = 'img/';

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = $_FILES['gambar']['type'];

    if (!in_array($file_type, $allowed_types)) {
        echo "<script>
                alert('Hanya file gambar (JPEG, PNG, GIF) yang diizinkan!');
                document.location.href = 'tambah.php';
              </script>";
        return 0;
    }

    if ($error === UPLOAD_ERR_OK) {
        $unique_name = uniqid() . '_' . $gambar;
        $destination = $folder . $unique_name;

        if (move_uploaded_file($tmp_name, $destination)) {
            $query = "INSERT INTO cars (gambar, merk, model, tahun, harga, deskripsi)
                      VALUES ('$unique_name', '$merk', '$model', '$tahun', '$harga', '$deskripsi')";

            mysqli_query($conn, $query) or die(mysqli_error($conn));
            return mysqli_affected_rows($conn);
        }
    }
    return 0;
}

function hapus($id)
{
    $conn = koneksi();
    $id = intval($id);

    if ($id > 0) {
        // Hapus file gambar terlebih dahulu
        $query = "SELECT gambar FROM cars WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $file_to_delete = 'img/' . $row['gambar'];

        if (file_exists($file_to_delete)) {
            unlink($file_to_delete);
        }

        $query = "DELETE FROM cars WHERE id = $id";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
        return mysqli_affected_rows($conn);
    }
    return 0;
}

function query($query)
{
    $conn = koneksi();
    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function cari($keyword)
{
    $query = "SELECT * FROM cars WHERE 
              merk LIKE '%$keyword%' OR
              model LIKE '%$keyword%' OR
              tahun LIKE '%$keyword%' OR
              harga LIKE '%$keyword%' OR
              deskripsi LIKE '%$keyword%'";
    return query($query);
}

function loginfungsion($data)
{
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    // cek dulu username nya // 
    $user = query("SELECT * FROM user WHERE username = '$username'");

    if (count($user) > 0) {

        if (password_verify($password, $user[0]['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['user'] = $user[0];
            header("Location: index.php");


            exit;
        }
    }

    return [
        'error' => true,
        'pesan' => 'Username/ Password Salah'
    ];
}

function registrasi($data)
{
    $conn = koneksi();

    $username = htmlspecialchars(strtolower($data['username']));
    $password1 = mysqli_real_escape_string($conn, $data['password1']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    if (empty($username) || empty($password1) || empty($password2)) {
        echo "<script>
                alert('username /password tidak boleh kosong!')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika username sudah ad

    if (query("SELECT * FROM user WHERE username = '$username'")) {
        echo "<script>
                alert('username sudah terdaftar')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    if ($password1 !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika password < 5
    if (strlen($password1) < 5) {
        echo "<script>
                alert('password terlalu pendek')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika username & password sudah sesuai
    $password_baru = password_hash($password1, PASSWORD_DEFAULT);
    // insert ke tabel user
    $query = "INSERT INTO user VALUES
            (null, '$username', '$password_baru')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    return mysqli_affected_rows($conn);
}
