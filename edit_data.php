<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Training - SB Admin 2 Template</title>
   
    <style>
        /* CSS untuk tampilan modal */
        .modal-sm {
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div id="wrapper">
     
        <!-- Konten halaman -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
              
                <!-- Akhir Topbar -->
                <!-- Isi konten halaman -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Edit Data Training</h1>
                    <!-- Form edit data training -->
                    <div class="table-responsive">
                    <?php
                    include "koneksi.php";
                    
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM datavariabel WHERE id = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $data = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);
                    }
                    ?>
                    <form action="update_data.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data["nama"]; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="data" <?php if ($data["status"] === "data") echo "selected"; ?>>Data</option>
                                <option value="target" <?php if ($data["status"] === "target") echo "selected"; ?>>Target</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" required><?php echo $data["keterangan"]; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                    </div>
                    <!-- Akhir form edit data training -->
                </div>
                <!-- Akhir Isi konten halaman -->
            </div>
        </div>
        <!-- Akhir konten halaman -->
    </div>
</body>
</html>
