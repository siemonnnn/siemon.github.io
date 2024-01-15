<!DOCTYPE html>
<html>
<head>
    <title>Hasil Perhitungan KNN</title>
    <!-- Memanggil library dan stylesheet yang diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+3iEmM8M5F9f3Ze3mzC3Xjx3y1PMv2ivznaG5Vc8ZISpECN" crossorigin="anonymous">
<!-- Memanggil library dan stylesheet yang diperlukan -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+3iEmM8M5F9f3Ze3mzC3Xjx3y1PMv2ivznaG5Vc8ZISpECN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800">Hasil Perhitungan KNN</h1>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fungsi untuk menghitung jarak Euclidean
    function hitungJarakEuclidean($dataTraining, $dataTesting) {
        $jarak = 0;

        $isSame = true; // Flag untuk menandakan apakah data uji sama dengan data pelatihan

        foreach ($dataTraining as $columnName => $value) {
            if ($columnName !== "Y") { // Jika bukan kolom Y
                $dataTestingValue = isset($dataTesting[$columnName]) ? (float) $dataTesting[$columnName] : 0;
                $dataTrainingValue = (float) $value;
                $jarak += pow($dataTrainingValue - $dataTestingValue, 2);

                // Periksa apakah nilai kolom pada data uji sama dengan data pelatihan
                if ($dataTestingValue !== $dataTrainingValue) {
                    $isSame = false;
                }
            }
        }

        // Jika data uji sama dengan data pelatihan, set jarak menjadi 0
        if ($isSame) {
            return 0;
        }

        return sqrt($jarak);
    }
    

    // Fungsi untuk mendapatkan data training dari database
    function getDataTrainingFromDatabase() {
        // Ganti dengan informasi koneksi ke database Anda
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'penjualanikan';

        // Buat koneksi ke database
        $conn = new mysqli($host, $username, $password, $dbname);

        // Periksa apakah koneksi berhasil
        if ($conn->connect_error) {
            die('Koneksi ke database gagal: ' . $conn->connect_error);
        }

        // Query untuk mengambil data dari kolom "data_variabel" pada tabel data_training
        $sql = "SELECT data_variabel FROM data_training";

        // Eksekusi query
        $result = $conn->query($sql);

        // Tampung data training dalam array
        $dataTraining = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataTraining[] = json_decode($row['data_variabel'], true);
            }
        } else {
            die('Tidak ada data training yang ditemukan.');
        }

        // Tutup koneksi database
        $conn->close();

        return $dataTraining;
    }

    // Data training
    $dataTraining = getDataTrainingFromDatabase();

    // Ambil nilai dari inputan halaman data testing untuk kolom "nama"
    $dataTesting = array();
    $numColumns = 0; // Inisialisasi jumlah kolom data testing yang diinginkan

    // Loop untuk mengambil nilai dari $_POST
    for ($i = 1; $i <= $numColumns; $i++) {
        $columnName = 'nilaiX' . $i;
        if (isset($_POST[$columnName])) {
            $dataTesting[$columnName] = $_POST[$columnName];
        }
    }

    // Ganti dengan informasi koneksi ke database Anda
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'penjualanikan';

    // Buat koneksi ke database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Periksa apakah koneksi berhasil
    if ($conn->connect_error) {
        die('Koneksi ke database gagal: ' . $conn->connect_error);
    }

    // Query untuk mengambil semua data dari kolom "nama" pada tabel data_variabel
    $sql = "SELECT nama, keterangan FROM datavariabel";

    // Eksekusi query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataVariabelColumns[] = array(
                'nama' => $row['nama'],
                'keterangan' => $row['keterangan'],
            );
            $numColumns++;
        }
    }

    // Tutup koneksi database
    $conn->close();

            for ($i = 0; $i < $numColumns; $i++) {
                $columnName = 'X' . ($i + 1);
                if (isset($_POST[$columnName])) {
                    $dataTesting[$columnName] = $_POST[$columnName];
                }
            }

         // Hitung jarak terdekat dengan Euclidean distance dan simpan hasilnya
         $jarakTerdekat = array();
         foreach ($dataTraining as $data) {
             $jarak = hitungJarakEuclidean($data, $dataTesting);

             $jarakTerdekat[] = array('data_training' => $data, 'jarak' => $jarak);
         }

            // Urutkan berdasarkan jarak terdekat (dari yang terkecil ke terbesar)
            usort($jarakTerdekat, function ($a, $b) {
                if ($a['jarak'] == $b['jarak']) {
                    return 0;
                }
                return ($a['jarak'] < $b['jarak']) ? -1 : 1;
            });

            // Cek apakah ada nilai k yang dikirim dari form
            if (isset($_POST["nilaiK"])) {
                // Ambil nilai k dari form
                $k = (int) $_POST["nilaiK"];
            } else {
                // Jika nilai k tidak ada atau tidak valid, gunakan nilai default yaitu 3
                $k = 3;
            }

            // Ambil data tetangga terdekat sebanyak k
            $tetanggaTerdekat = array_slice($jarakTerdekat, 0, $k);

            // Lakukan mayoritas voting untuk mendapatkan prediksi Y
            $prediksiY = array();
            foreach ($tetanggaTerdekat as $tetangga) {
                $prediksiY[] = $tetangga['data_training']['Y'];
            }

            // Hasil prediksi Y adalah mayoritas nilai dari prediksi tetangga terdekat
            $hasilPrediksiY = array_count_values($prediksiY);
            arsort($hasilPrediksiY);
            $hasilPrediksiY = key($hasilPrediksiY);

            // Hasil perhitungan KNN
            $hasilKNN = array(
                'data_testing' => $dataTesting,
                'tetangga_terdekat' => $tetanggaTerdekat,
                'prediksiY' => $hasilPrediksiY,
            );

            // Cek apakah ada hasil perhitungan KNN yang tersedia
            if (!empty($hasilKNN)) {
                echo "<p>Data Testing:</p>";
                echo "<p>Pilih Provinsi: " . $_POST["nilaiX1"] . "</p>";
        
                // Iterasi melalui $_POST untuk menampilkan nilai variabel X secara dinamis
                $counter = 1;
                foreach ($_POST as $key => $value) {
                    if (strpos($key, "nilaiX") === 0) {
                        $varName = "X" . $counter;
                        echo "<p>$varName: $value</p>";
                        $counter++;
                    }
                }
        
                echo "<p>Nilai K: " . $_POST["nilaiK"] . "</p>";
            
               // Tampilkan tetangga terdekat
echo '<h3>Tetangga Terdekat:</h3>';
echo '<table class="table">';
echo '<thead><tr><th>No</th>';

// Loop untuk menampilkan header kolom berdasarkan variabel yang ada pada data tetangga terdekat
foreach ($hasilKNN['tetangga_terdekat'][0]['data_training'] as $key => $value) {
    echo '<th>' . $key . '</th>';
}

echo '<th>Jarak</th></tr></thead>';
echo '<tbody>';
foreach ($hasilKNN['tetangga_terdekat'] as $key => $tetangga) {
    $dataTraining = $tetangga['data_training'];
    echo '<tr>';
    echo '<td>' . ($key + 1) . '</td>';

    // Loop untuk menampilkan nilai variabel sesuai dengan kolom-kolom yang ada pada data tetangga terdekat
    foreach ($dataTraining as $value) {
        echo '<td>' . $value . '</td>';
    }

    echo '<td>' . $tetangga['jarak'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';



                // Tampilkan hasil prediksi Y
                echo '<h3>Hasil Prediksi Y(Target Tahun):</h3>';
                echo '<p>' . $hasilKNN['prediksiY'] . '</p>';
            } else {
                echo '<p>Tidak ada hasil perhitungan KNN yang ditemukan.</p>';
            }
        } else {
            echo '<p>Tidak ada data testing yang ditemukan.</p>';
        }
        ?>
        <canvas id="myChart"></canvas>
    </div>
<!-- Memanggil library JavaScript Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-vP4QApRfK/8fW6bdWgO7z9H9i0HhRb0epznFV8eez3Ikkv5AHeS/+bdE6b1Js1hZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    <?php if (!empty($hasilKNN)) { ?>
        // Data untuk grafik
        var tetanggaTerdekat = <?php echo json_encode($hasilKNN['tetangga_terdekat']); ?>;

        // Siapkan array untuk menyimpan label dan data nilai dari tetangga terdekat
        var labelsTetangga = [];
        var nilaiJarak = [];

        // Loop melalui tetangga terdekat dan memasukkan label dan nilai ke array
        for (var key in tetanggaTerdekat) {
            labelsTetangga.push(tetanggaTerdekat[key]['data_training']['X1']); // Ganti 'X1' sesuai dengan kolom yang diinginkan
            nilaiJarak.push(tetanggaTerdekat[key]['jarak']);
        }
        
        // Buat elemen canvas
        var ctx = document.getElementById('myChart').getContext('2d');

        // Buat grafik menggunakan Chart.js
        var myChart = new Chart(ctx, {
            type: 'bar', // Anda bisa mengganti tipe grafik sesuai kebutuhan (bar, line, dll)
            data: {
                labels: labelsTetangga,
                datasets: [{
                    label: 'Grafik dari Tetangga Terdekat',
                    data: nilaiJarak,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang batang grafik
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis tepi batang grafik
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    <?php } ?>
    </script>


</body>
</html>
