<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Cek apakah aksi "Simpan Edit" yang diminta oleh pengguna
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Dapatkan data yang ingin diubah dari form
    $dataVariabel = array();
    $sqlDataVariabel = "SELECT nama FROM datavariabel";
    $resultDataVariabel = mysqli_query($conn, $sqlDataVariabel);
    while ($row = mysqli_fetch_assoc($resultDataVariabel)) {
        $namaKolom = $row["nama"];
        $dataVariabel[$namaKolom] = $_POST[$namaKolom];
    }

    // Ubah data variabel menjadi bentuk JSON
    $jsonVariabel = json_encode($dataVariabel);

    // Lakukan operasi UPDATE ke database sesuai dengan data yang diubah
    $sqlUpdate = "UPDATE data_training SET data_variabel='$jsonVariabel' WHERE id='$id'";
    $resultUpdate = mysqli_query($conn, $sqlUpdate);

    // Setelah berhasil melakukan update, arahkan kembali ke halaman utama atau tampilkan pesan sukses
    if ($resultUpdate) {
        header("Location: index.php?menu=dataset"); // Ganti "dataset.php" dengan halaman utama Anda
        exit();
    } else {
        echo "Gagal mengupdate data.";
    }
} else {
    echo "Aksi tidak valid.";
}
?>
