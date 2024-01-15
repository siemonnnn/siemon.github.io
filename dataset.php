
<!DOCTYPE html>
<html>
<head>
    <title>Dataset</title>
    <!-- Memanggil library dan stylesheet yang diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+3iEmM8M5F9f3Ze3mzC3Xjx3y1PMv2ivznaG5Vc8ZISpECN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800">Dataset</h1>

        <!-- Elemen form untuk mengunggah file CSV -->
        <form method="post" action="aksi_tambah_data.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="excelFile">Upload Excel File (CSV only):</label>
                <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".csv">
            </div>


            <!-- Tombol Modal Pop-up untuk Menambahkan Data -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahDataModal">
                Tambah Data
            </button>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <!-- Modal Pop-up -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Isi form untuk menambahkan data baru ke dalam tabel -->
                    <?php
                    // Include file koneksi.php untuk mendapatkan koneksi database
                    include "koneksi.php";

                    // Query untuk mengambil data dari kolom "nama" pada tabel datavariabel
                    $sql = "SELECT nama FROM datavariabel";
                    $result = mysqli_query($conn, $sql);

                    // Loop untuk membuat input textfield secara dinamis sesuai dengan nilai kolom "nama"
                    echo '<form method="post" action="aksi_tambah_data.php">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $namaKolom = $row["nama"];
                        echo '<div class="form-group">';
                        echo '<label for="' . $namaKolom . '">' . $namaKolom . ':</label>';
                        echo '<input type="text" class="form-control" id="' . $namaKolom . '" name="' . $namaKolom . '" required>';
                        echo '</div>';
                    }
                    ?>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel untuk menampilkan data dari database -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="font-size: 12px;">No</th>
                <?php
                // Include file koneksi.php untuk mendapatkan koneksi database
                include "koneksi.php";

                // Query untuk mengambil data dari kolom "nama" pada tabel datavariabel
                $sql = "SELECT nama, keterangan FROM datavariabel";
                $result = mysqli_query($conn, $sql);

                // Loop untuk membuat header tabel sesuai dengan nilai kolom "nama"
                while ($row = mysqli_fetch_assoc($result)) {
                    $namaKolom = $row["nama"];
                    $namaKeterangan = $row["keterangan"];
                    echo '<th  style="font-size: 12px;">' . $namaKolom . ' (' . $namaKeterangan . ')</th>';
                }
                ?>
                <th style="font-size: 12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data dari tabel data_training
            $sqlDataTraining = "SELECT * FROM data_training";
            $resultDataTraining = mysqli_query($conn, $sqlDataTraining);
            $nomor = 1;

            // Loop untuk menampilkan data pada tabel
            while ($rowDataTraining = mysqli_fetch_assoc($resultDataTraining)) {
                echo '<tr>';
                echo '<td >' . $nomor . '</td>';

                // Mengambil data variabel dari kolom "data_variabel" dan mengubahnya menjadi array
                $dataVariabel = json_decode($rowDataTraining['data_variabel'], true);

                // Loop untuk menampilkan nilai variabel sesuai dengan kolom-kolom yang ada pada tabel
                $sqlDataVariabel = "SELECT nama FROM datavariabel";
                $resultDataVariabel = mysqli_query($conn, $sqlDataVariabel);
                while ($row = mysqli_fetch_assoc($resultDataVariabel)) {
                    $namaKolom = $row["nama"];
                    echo '<td >' . $dataVariabel[$namaKolom] . '</td>';
                }

                // Kolom untuk aksi (misalnya tombol edit dan delete)
                echo '<td>';
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal' . $rowDataTraining['id'] . '">Edit</button>';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal' . $rowDataTraining['id'] . '">Hapus</button>';
                echo '</td>';

                echo '</tr>';
                $nomor++;
            }
            ?>
        </tbody>
    </table>
<!-- Modal Pop-up untuk Edit -->
<?php
$resultDataTraining = mysqli_query($conn, $sqlDataTraining);
while ($rowDataTraining = mysqli_fetch_assoc($resultDataTraining)) {
    echo '<div class="modal fade" id="editModal' . $rowDataTraining['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $rowDataTraining['id'] . '" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="editModalLabel' . $rowDataTraining['id'] . '">Edit Data</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';

    echo '<div class="modal-body">';
    // Isi form untuk mengedit data pada tabel
    echo '<form method="post" action="aksi_edit_data.php">';
    echo '<input type="hidden" name="id" value="' . $rowDataTraining['id'] . '">'; // Form input hidden untuk menyimpan ID data

    // Mendapatkan data variabel dari kolom "data_variabel" dan mengubahnya menjadi array
    $dataVariabel = json_decode($rowDataTraining['data_variabel'], true);

    // Loop untuk menampilkan nilai variabel sesuai dengan kolom-kolom yang ada pada tabel datavariabel
    $sqlDataVariabel = "SELECT nama FROM datavariabel";
    $resultDataVariabel = mysqli_query($conn, $sqlDataVariabel);
    while ($row = mysqli_fetch_assoc($resultDataVariabel)) {
        $namaKolom = $row["nama"];
        $value = isset($dataVariabel[$namaKolom]) ? $dataVariabel[$namaKolom] : '';
        echo '<div class="form-group">';
        echo '<label for="' . $namaKolom . '">' . $namaKolom . ':</label>';
        echo '<input type="text" class="form-control" id="' . $namaKolom . '" name="' . $namaKolom . '" value="' . $value . '" required>';
        echo '</div>';
    }

    echo '<button type="submit" class="btn btn-primary">Simpan Perubahan</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>


<!-- Modal Pop-up untuk Hapus -->
<?php
$resultDataTraining = mysqli_query($conn, $sqlDataTraining);
while ($rowDataTraining = mysqli_fetch_assoc($resultDataTraining)) {
    echo '<div class="modal fade" id="hapusModal' . $rowDataTraining['id'] . '" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel' . $rowDataTraining['id'] . '" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="hapusModalLabel' . $rowDataTraining['id'] . '">Konfirmasi Hapus Data</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';

    echo '<div class="modal-body">';
    echo 'Apakah Anda yakin ingin menghapus data ini?';
    echo '</div>';

    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
    echo '<a href="aksi_hapus_data.php?id=' . $rowDataTraining['id'] . '" class="btn btn-danger">Hapus</a>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

    <!-- Memanggil library JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-vP4QApRfK/8fW6bdWgO7z9H9i0HhRb0epznFV8eez3Ikkv5AHeS/+bdE6b1Js1hZ" crossorigin="anonymous"></script>
</body>
</html>
