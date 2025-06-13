<?php
// Pastikan ini baris pertama file
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
session_start();

// Hapus semua data session
$_SESSION = [];

// Hapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect dengan JavaScript fallback
echo '<script>
    localStorage.removeItem("session_data");
    sessionStorage.clear();
    window.location.href = "login.php";
</script>';
exit;
