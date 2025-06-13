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

function ubah($data)
{
    $conn = koneksi();

    $id = $data['id'];
    $gambarLama = $data['gambarLama'];

    // Cek apakah user upload gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        // Hapus gambar lama
        if (file_exists('img/' . $gambarLama)) {
            unlink('img/' . $gambarLama);
        }

        // Upload gambar baru
        $gambar = upload();
        if (!$gambar) {
            return false;
        }
    }

    $merk = htmlspecialchars($data['merk']);
    $model = htmlspecialchars($data['model']);
    $tahun = htmlspecialchars($data['tahun']);
    $harga = htmlspecialchars($data['harga']);
    $deskripsi = htmlspecialchars($data['deskripsi']);

    $query = "UPDATE cars SET
                gambar = '$gambar',
                merk = '$merk',
                model = '$model',
                tahun = '$tahun',
                harga = '$harga',
                deskripsi = '$deskripsi'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function query($query)
{
    $conn = koneksi();
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

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
    $conn = koneksi();

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);

    // Cek username
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'] // Simpan role di session
            ];

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }

    return [
        'error' => true,
        'pesan' => 'Username/Password Salah'
    ];
}
function registrasi($data)
{
    $conn = koneksi();

    $username = htmlspecialchars(strtolower($data['username']));
    $password1 = mysqli_real_escape_string($conn, $data['password1']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    // Cek username sudah ada
    if (query("SELECT * FROM users WHERE username = '$username'")) {
        echo "<script>
                alert('Username sudah terdaftar');
                document.location.href = 'register.php';
              </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password1 !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai');
                document.location.href = 'register.php';
              </script>";
        return false;
    }

    // Cek panjang password
    if (strlen($password1) < 5) {
        echo "<script>
                alert('Password terlalu pendek (minimal 5 karakter)');
                document.location.href = 'register.php';
              </script>";
        return false;
    }

    // Enkripsi password
    $password_baru = password_hash($password1, PASSWORD_DEFAULT);

    // Query INSERT yang sesuai dengan struktur tabel
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password_baru', 'user')";

    mysqli_query($conn, $query) or die("Error registrasi: " . mysqli_error($conn));
    return mysqli_affected_rows($conn);
}
