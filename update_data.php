<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $status = $_POST["status"];
    $keterangan = $_POST["keterangan"];

    $sql_update = "UPDATE datavariabel SET nama=?, status=?, keterangan=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $status, $keterangan, $id);

    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil diupdate, kirim respons 200 OK
        http_response_code(200);
    } else {
        // Jika terjadi kesalahan, kirim respons 500 Internal Server Error
        http_response_code(500);
    }
    echo '
    <script>
        alert("Data telah disimpan.");
        window.location.href = "index.php?menu=data_training";
    </script>';
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
