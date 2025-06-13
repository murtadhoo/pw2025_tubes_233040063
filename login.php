<?php
session_start(); // PASTIKAN INI BARIS PERTAMA
require 'function.php';

// Jika sudah login, redirect ke halaman sesuai role
if (isset($_SESSION['user'])) {
    header("Location: " . ($_SESSION['user']['role'] == 'admin' ? 'admin.php' : 'index.php'));
    exit;
}

if (isset($_POST["login"])) {
    if (loginfungsion($_POST)) {
        header("Location: admin.php"); // Force redirect ke admin.php
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoShow</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="img/logo.png" alt="AutoShow Logo" class="logo">
                <h2>AutoShow Admin</h2>
            </div>

            <?php if (isset($error)) : ?>
                <div class="alert"><?= $error ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn-login">Login</button>
                <div class="register-link">
                    Belum punya akun? <a href="register.php">Daftar disini</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>