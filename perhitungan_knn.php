// Data testing
$dataTesting = array(4, 5, 2);

// Data training
$dataTraining = array(
    array('X1' => 'ACEH', 'X2' => 9, 'X3' => 8, 'X4' => 7, 'Y' => 'NAIK'),
    array('X1' => 'LAMPUNG', 'X2' => 7, 'X3' => 8, 'X4' => 9, 'Y' => 'NAIK'),
    array('X1' => 'JATIM', 'X2' => 9, 'X3' => 8, 'X4' => 7, 'Y' => 'TURUN'),
    array('X1' => 'LAMONGAN', 'X2' => 1, 'X3' => 2, 'X4' => 3, 'Y' => 'NAIK'),
);

// Hitung jarak terdekat dengan Euclidean distance
$jarakTerdekat = array();
foreach ($dataTraining as $data) {
    $jarak = 0;
    for ($i = 1; $i <= 3; $i++) { // Mulai dari X2 sampai X4, skip X1
        $jarak += pow($data['X' . $i] - $dataTesting[$i - 1], 2);
    }
    $jarak = sqrt($jarak);
    $jarakTerdekat[] = array('data_training' => $data, 'jarak' => $jarak);
}

// Urutkan berdasarkan jarak terdekat (dari yang terkecil ke terbesar)
usort($jarakTerdekat, function ($a, $b) {
    return $a['jarak'] <=> $b['jarak'];
});

// Tentukan jumlah tetangga terdekat yang ingin dipertimbangkan
$k = 3;

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
    'data_testing' => array('X1' => 'GRESIK', 'X2' => $dataTesting[0], 'X3' => $dataTesting[1], 'X4' => $dataTesting[2]),
    'tetangga_terdekat' => $tetanggaTerdekat,
    'prediksiY' => $hasilPrediksiY,
);
