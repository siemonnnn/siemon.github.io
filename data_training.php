<!DOCTYPE html>
<html>
<head>
    <title>Data Training - SB Admin 2 Template</title>
   
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
                    <h1 class="h3 mb-4 text-gray-800">Data Training</h1>
                    <button onclick="openModal()" class="btn btn-primary">Tambah Variabel</button>
                    <!-- Tabel data training bisa diisi dengan komponen datatables.js -->
                    <div class="table-responsive">
                    <?php
        // Include file koneksi.php untuk mendapatkan koneksi database
        include "koneksi.php";

        if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql_delete = "DELETE FROM datavariabel WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql_delete);
            mysqli_stmt_bind_param($stmt, "i", $id);
        
            if (mysqli_stmt_execute($stmt)) {
                echo '<div class="alert alert-success">Data berhasil dihapus.</div>';
            } else {
                echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
            }
        
            mysqli_stmt_close($stmt);
        }
        
        // Query untuk mengambil data dari tabel datavariabel dan mengurutkannya
        $sql = "SELECT * FROM datavariabel ORDER BY id";
        $result = mysqli_query($conn, $sql);
        $nomor = 1;
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>' . $nomor . '</td>
                        <td>' . $row["nama"] . '</td>
                        <td>' . $row["status"] . '</td>
                        <td>' . $row["keterangan"] . '</td>
                        <td>
                        <!-- Ganti warna teks "Edit" menjadi biru -->
                        <a href="#" onclick="openEditModal(' . $row["id"] . ')" style="background-color: blue; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none;">Edit</a>
                        
                        <!-- Ganti warna teks "Hapus" menjadi merah -->
                        <a href="#" onclick="confirmDelete(' . $row["id"] . ')" style="background-color: red; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none;">Hapus</a>
                        
                        </td>
                      </tr>';
                      $nomor++;
            }
            echo '</table>';
        } else {
            echo "Tidak ada data yang ditemukan.";
        }

        // Tutup koneksi database
        mysqli_close($conn);
        ?>
                    </div>
                </div>
                <!-- Akhir Isi konten halaman -->
            </div>
        </div>
        <!-- Akhir konten halaman -->
    </div>

    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Variabel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_data.php" method="post">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="data">Data</option>
                                <option value="target">Target</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit data -->
    <div id="editModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Training</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="update_data.php" method="post">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editNama">Nama:</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status:</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="data">Data</option>
                                <option value="target">Target</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editKeterangan">Keterangan:</label>
                            <textarea class="form-control" id="editKeterangan" name="keterangan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript untuk mengontrol tampilan popup
        function openModal() {
            var modal = document.getElementById("modal");
            modal.style.display = "block";
        }

        function closeModal() {
            var modal = document.getElementById("modal");
            modal.style.display = "none";
        }

        function confirmDelete(id) {
            var result = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (result) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "hapus_variabel.php?id=" + id, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.reload();
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        alert("Terjadi kesalahan saat menghapus data.");
                    }
                };
                xhr.send();
            }
        }

        function openEditModal(id) {
            var editModal = document.getElementById("editModal");
            var editForm = document.getElementById("editForm");
            var editId = document.getElementById("editId");
            var editNama = document.getElementById("editNama");
            var editStatus = document.getElementById("editStatus");
            var editKeterangan = document.getElementById("editKeterangan");

            // Populate form fields with the existing data
            editId.value = id;
            var namaElement = document.querySelector('tr:nth-child(' + (id + 1) + ') td:nth-child(2)');
            var statusElement = document.querySelector('tr:nth-child(' + (id + 1) + ') td:nth-child(3)');
            var keteranganElement = document.querySelector('tr:nth-child(' + (id + 1) + ') td:nth-child(4)');

            var nama = namaElement ? namaElement.innerText : '';
            var status = statusElement ? statusElement.innerText : '';
            var keterangan = keteranganElement ? keteranganElement.innerText : '';

            editNama.value = nama;
            editStatus.value = status;
            editKeterangan.value = keterangan;

            editModal.style.display = "block";
        }

        // JavaScript untuk mengaktifkan datatables.js
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
