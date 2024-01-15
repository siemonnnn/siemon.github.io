<?php
include 'connect.php';

// Mengambil ID penjualan dari URL
$id_penjualan = $_GET['id'];

// Lakukan koneksi ke database dan ambil detail penjualan berdasarkan ID
$query = "SELECT * FROM kasir WHERE id_k = $id_penjualan";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// Konten struk yang akan dicetak pada halaman baru
$nama_pesanan = $row['nama_pesanan_k'];
$tanggal = $row['tanggal_k'];
$jam = $row['jam_k'];
$namapelanggan = $row['pelanggan_k'];
$totalharga = $row['hargatotal_k'];

// Pisahkan nama pesanan menjadi array
$nama_pesanan_array = explode(',', $nama_pesanan);

$struk = "=============================\n";
$struk .= "        STRUK PENJUALAN       \n";
$struk .= "=============================\n";
$struk .= "Nama Pesanan: \n";
foreach ($nama_pesanan_array as $pesanan) {
    $struk .= "- $pesanan\n";
}
$struk .= "Tanggal: $tanggal\n";
$struk .= "Jam: $jam\n";
$struk .= "Pelanggan: $namapelanggan\n";
$struk .= "Total Harga: $totalharga\n";
$struk .= "=============================\n";

echo "<pre>$struk</pre>";

mysqli_close($conn);
?>
