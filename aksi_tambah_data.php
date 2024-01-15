<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Fungsi untuk menyimpan data ke dalam database
function insertDataToDatabase($conn, $data)
{
    $data_json = json_encode($data);

    // Query untuk menyimpan data JSON ke dalam database
    $query = "INSERT INTO data_training (data_variabel) VALUES ('$data_json')";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
    }
}

// Fungsi untuk menangani file Excel yang diunggah
function handleUploadedExcelFile($conn)
{
    require 'vendor/autoload.php'; // Sertakan library "PhpSpreadsheet"

    // Dapatkan detail file yang diunggah
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $fileName = $_FILES['excelFile']['name'];

    // Periksa apakah file yang diunggah adalah file CSV (Anda dapat menambahkan pemeriksaan lain jika diperlukan)
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if ($fileExtension === 'csv') {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmpPath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Mengasumsikan baris pertama berisi nama kolom
        $columnNames = array_shift($data);

        // Menyimpan data ke dalam database
        foreach ($data as $row) {
            $dataRow = array();
            foreach ($row as $key => $value) {
                $dataRow[$columnNames[$key]] = mysqli_real_escape_string($conn, $value);
            }
            insertDataToDatabase($conn, $dataRow);
        }

        echo '
<script>
    alert("Data telah disimpan.");
    window.location.href = "index.php?menu=dataset";
</script>';
        exit;
    } else {
        echo "Format file tidak valid. Harap unggah file CSV.";
    }
}

// Cek apakah data telah dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data yang dikirimkan melalui POST (kecuali file excel)
    $data = array();
    foreach ($_POST as $key => $value) {
        // Validasi data jika diperlukan
        // ...
        // Simpan nilai ke dalam array $data dengan nama kolom sebagai kunci
        $data[$key] = mysqli_real_escape_string($conn, $value);
    }

    // Periksa apakah file excel diunggah dan proses
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        handleUploadedExcelFile($conn);
    } else {
        // Simpan data ke dalam database
        insertDataToDatabase($conn, $data);
    }
}
echo '
<script>
    alert("Data telah disimpan.");
    window.location.href = "index.php?menu=dataset";
</script>';

// Tutup koneksi database
mysqli_close($conn);
?>
