<?php
// Include file koneksi.php untuk mendapatkan koneksi database
include "koneksi.php";

// Tangkap data dari form
$dataBaru = array();
foreach ($_POST as $key => $value) {
  if ($key !== 'submit') {
    $dataBaru[$key] = $value;
  }
}

// Lakukan validasi dan pembersihan data jika diperlukan
// ...

// Siapkan query untuk menyimpan data baru ke dalam tabel "dataset"
$columns = implode(", ", array_keys($dataBaru));
$values = "'" . implode("', '", $dataBaru) . "'";
$sql = "INSERT INTO dataset ($columns) VALUES ($values)";

// ...
if ($conn->query($sql) === TRUE) {
    // Jika berhasil menyimpan data baru, kirimkan respons ke JavaScript
    $response = array('status' => 'success');
    echo json_encode($response);
  
    // Tutup koneksi database
    mysqli_close($conn);
    
    // Buka koneksi database kembali untuk menambahkan foreign key
    include "koneksi.php";
  
    // Tambahkan foreign key untuk kolom "NamaDataTraining"
    $fkColumnName = "NamaDataTraining";
    $fkReferenceTable = "datavariabel";
    $fkReferenceColumn = "nama";
    $fkConstraintName = "fk_" . $fkColumnName;
  
    $alterSql = "ALTER TABLE dataset ADD CONSTRAINT $fkConstraintName FOREIGN KEY ($fkColumnName) REFERENCES $fkReferenceTable ($fkReferenceColumn)";
    if ($conn->query($alterSql) === TRUE) {
      echo "Foreign key berhasil ditambahkan.";
    } else {
      echo "Terjadi kesalahan saat menambahkan foreign key: " . $conn->error;
    }
  } else {
    // Jika terjadi kesalahan saat menyimpan data baru, kirimkan respons ke JavaScript
    $response = array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data baru.');
    echo json_encode($response);
    // Cetak pesan kesalahan query SQL di sini
    echo $conn->error;
    // Tutup koneksi database
    mysqli_close($conn);
  }
  // ...
  

?>
