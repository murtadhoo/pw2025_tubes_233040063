<?php
require 'function.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    if (hapus($id) > 0) {
        echo "<script>
                alert('Data mobil berhasil dihapus!');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data mobil gagal dihapus!');
                document.location.href = 'index.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID tidak valid!');
            document.location.href = 'index.php';
          </script>";
}
