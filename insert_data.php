<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST["nama"];
    $status = $_POST["status"];
    $keterangan = $_POST["keterangan"];

    // Perintah SQL untuk menyimpan data ke tabel datavariabel
    $sql = "INSERT INTO datavariabel (nama, status, keterangan) VALUES ('$nama', '$status', '$keterangan')";

    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    echo '
    <script>
        alert("Data telah disimpan.");
        window.location.href = "index.php?menu=data_training";
    </script>';
    // Tutup koneksi database
    mysqli_close($conn);
}
?>
