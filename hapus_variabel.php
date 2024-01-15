<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Proses hapus data jika ada permintaan "id" yang terdefinisi
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_delete = "DELETE FROM datavariabel WHERE id = '$id'";
    if (mysqli_query($conn, $sql_delete)) {
        // Jika data berhasil dihapus, redirect kembali ke halaman sebelumnya (index.php)
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>
