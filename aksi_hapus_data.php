<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Cek apakah aksi "Hapus" yang diminta oleh pengguna
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lakukan operasi DELETE ke database sesuai dengan ID data yang akan dihapus
    $sqlDelete = "DELETE FROM data_training WHERE id='$id'";
    $resultDelete = mysqli_query($conn, $sqlDelete);

    // Setelah berhasil menghapus data, arahkan kembali ke halaman utama atau tampilkan pesan sukses
    if ($resultDelete) {
        header("Location: index.php?menu=dataset"); // Ganti "dataset.php" dengan halaman utama Anda
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "Aksi tidak valid.";
}
?>
