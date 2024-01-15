<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Query untuk mengambil data dari kolom "nama" pada tabel datavariabel
$sql = "SELECT nama FROM datavariabel";
$result = mysqli_query($conn, $sql);

// Loop untuk menambahkan kolom-kolom baru ke dalam tabel data_training
while ($row = mysqli_fetch_assoc($result)) {
    $columnName = $row["nama"];
    $query = "ALTER TABLE data_training ADD COLUMN `$columnName` VARCHAR(255)";
    mysqli_query($conn, $query);
}

// Tutup koneksi database
mysqli_close($conn);
?>
