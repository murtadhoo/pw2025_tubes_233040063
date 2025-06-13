<?php
require "function.php";
if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal!');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AutoShow</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="register-container">
        <div class="register-box">
            <div class="register-header">
                <img src="img/logo.png" alt="AutoShow Logo" class="logo">
                <h2>Daftar Akun Baru</h2>
            </div>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" id="password1" name="password1" required>
                </div>
                <div class="form-group">
                    <label for="password2">Konfirmasi Password</label>
                    <input type="password" id="password2" name="password2" required>
                </div>
                <button type="submit" name="register" class="btn-register">Daftar</button>
                <div class="login-link">
                    Sudah punya akun? <a href="login.php">Login disini</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>