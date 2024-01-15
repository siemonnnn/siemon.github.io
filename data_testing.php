<!DOCTYPE html>
<html>

<head>
    <title>Data Testing</title>
    <!-- Memanggil library dan stylesheet yang diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+3iEmM8M5F9f3Ze3mzC3Xjx3y1PMv2ivznaG5Vc8ZISpECN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800">Data Testing</h1>

        <form method="post" action="index.php?menu=hasil">

            <?php
            // Include file koneksi.php untuk mendapatkan koneksi database
            include "koneksi.php";

            // Query untuk mengambil data dari tabel data_training
            $sqlDataTraining = "SELECT * FROM data_training";
            $resultDataTraining = mysqli_query($conn, $sqlDataTraining);

            // Inisialisasi array untuk menyimpan pilihan X1
            $pilihanX1 = [];
            $dataVariabelByX1 = []; // Ini adalah array asosiatif untuk menyimpan data variabel berdasarkan X1

            // Loop untuk mengambil data variabel dari kolom "data_variabel" dan menyimpannya dalam array
            while ($rowDataTraining = mysqli_fetch_assoc($resultDataTraining)) {
                $dataVariabel = json_decode($rowDataTraining['data_variabel'], true);
                if (isset($dataVariabel['X1'])) {
                    $pilihanX1[] = $dataVariabel['X1'];
                    $dataVariabelByX1[$dataVariabel['X1']] = $dataVariabel;
                }
            }

            // Hapus duplikat dan urutkan array pilihan X1
            $pilihanX1 = array_unique($pilihanX1);
            sort($pilihanX1);

            // Tampilkan dropdown untuk memilih X1
            echo '<div class="form-group">';
            echo '<label for="nilaiX1">Pilih X1:</label>';
            echo '<select class="form-control" id="nilaiX1" name="nilaiX1" required>';

            // Loop untuk menambahkan pilihan X1 ke dalam dropdown
            foreach ($pilihanX1 as $x1) {
                echo '<option value="' . $x1 . '">' . $x1 . '</option>';
            }

            echo '</select>';
            echo '</div>';
            ?>

            <!-- Tampilkan input teks untuk nilai variabel X2, X3, X4, dst. -->
            <div class="form-group" id="dynamicInputs">
                <!-- Placeholder untuk input teks X2, X3, X4, dst. akan ditambahkan di sini oleh JavaScript -->
            </div>

            <!-- Tambahkan textfield untuk nilai K -->
            <div class="form-group">
                <label for="nilaiK">Nilai K:</label>
                <input type="number" class="form-control" id="nilaiK" name="nilaiK" required>
            </div>

            <button type="submit" class="btn btn-primary" id="btnHitung" name="hitung" value="Hitung">Hitung</button>

        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen form untuk dinamis input teks variabel X2, X3, X4, dst.
    const dynamicInputs = document.getElementById("dynamicInputs");
    const nilaiX1 = document.getElementById("nilaiX1");

    // Fungsi untuk membuat input teks variabel berdasarkan data yang diterima
    function createDynamicInputs(dataVariabel) {
        dynamicInputs.innerHTML = ""; // Reset konten sebelumnya

        for (const [key, value] of Object.entries(dataVariabel)) {
            if (key !== "X1" && key !== "Y") {
                const inputGroup = document.createElement("div");
                inputGroup.className = "form-group";
                inputGroup.innerHTML = `
                    <label for="nilai${key}">${key}:</label>
                    <input type="text" class="form-control" id="nilai${key}" name="nilai${key}" value="${value}" readonly>
                `;
                dynamicInputs.appendChild(inputGroup);
            }
        }
    }

    // Menampilkan input teks variabel berdasarkan pilihan X1 yang dipilih
    nilaiX1.addEventListener("change", function () {
        const selectedX1 = nilaiX1.value;
        const selectedDataVariabel = <?php echo json_encode($dataVariabelByX1); ?>[selectedX1];

        if (selectedDataVariabel) {
            createDynamicInputs(selectedDataVariabel);
        } else {
            dynamicInputs.innerHTML = "";
        }
    });
});
</script>
    <!-- Memanggil library JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-vP4QApRfK/8fW6bdWgO7z9H9i0HhRb0epznFV8eez3Ikkv5AHeS/+bdE6b1Js1hZ" crossorigin="anonymous"></script>
</body>

</html>
