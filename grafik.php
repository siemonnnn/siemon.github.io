<!DOCTYPE html>
<html>
<head>
    <title>Grafik Garis Data Variabel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "penjualanikan");

    // Query untuk mengambil data dari tabel data_training
    $queryDataTraining = "SELECT * FROM data_training";
    $resultDataTraining = mysqli_query($conn, $queryDataTraining);

    while ($rowDataTraining = mysqli_fetch_assoc($resultDataTraining)) {
        $dataVariabel = json_decode($rowDataTraining["data_variabel"], true);
        $namaProvinsi = $dataVariabel["X1"];
        $tahun = ["Tahun 2019", "Tahun 2020", "Tahun 2021"];
        $nilaiY = [$dataVariabel["X2"], $dataVariabel["X3"], $dataVariabel["X4"]];
        $kategoriNaikTurun = [];
        
        for ($i = 0; $i < 3; $i++) {
            $firstValue = floatval($nilaiY[0]);
            $lastValue = floatval($nilaiY[$i]);
            if ($lastValue > $firstValue) {
                $kategoriNaikTurun[] = "NAIK";
            } else if ($lastValue < $firstValue) {
                $kategoriNaikTurun[] = "TURUN";
            } else {
                $kategoriNaikTurun[] = "STABIL";
            }
        }

        echo '<canvas id="lineChart_' . $rowDataTraining["id"] . '" width="800" height="400"></canvas>';
        echo '<script>';
        echo 'var ctx = document.getElementById("lineChart_' . $rowDataTraining["id"] . '").getContext("2d");';
        echo 'var lineChart = new Chart(ctx, {';
        echo 'type: "line",';
        echo 'data: {';
        echo 'labels: ' . json_encode($tahun) . ',';
        echo 'datasets: [{';
        echo 'label: "' . $namaProvinsi . ' (' . $kategoriNaikTurun[2] . ')",';
        echo 'data: ' . json_encode($nilaiY) . ',';
        echo 'fill: false,';
        echo 'borderColor: getRandomColor(),';
        echo 'borderWidth: 2,';
        echo 'pointRadius: 5,';
        echo 'pointHoverRadius: 7,';
        echo 'pointBackgroundColor: getRandomColor(),';
        echo '}]},';
        echo 'options: {responsive: false, scales: {y: {beginAtZero: true,}}}});';
        echo 'function getRandomColor() {';
        echo 'var letters = "0123456789ABCDEF";';
        echo 'var color = "#";';
        echo 'for (var i = 0; i < 6; i++) {color += letters[Math.floor(Math.random() * 16)];}';
        echo 'return color;}</script>';
    }

    // Menutup koneksi database
    mysqli_close($conn);
    ?>
</body>
</html>
