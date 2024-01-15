<?php
// Mulai session
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, redirect ke halaman login (ganti dengan halaman login sesuai kebutuhan)
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('topbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php
                    // Cek apakah ada parameter 'menu' dan load konten sesuai dengan nilainya
                    if (isset($_GET['menu'])) {
                        $menu = $_GET['menu'];
                        if ($menu === 'dataset') {
                            include('dataset.php');
                        } elseif ($menu === 'data_testing') {
                            include('data_testing.php');
                        } elseif ($menu === 'grafik') {
                            include('grafik.php');
                        } elseif ($menu === 'data_training') {
                            include('data_training.php');
                        } elseif ($menu === 'hasil') {
                            include('hasil.php');
                        } elseif ($menu === 'pengaturan') {
                            include('pengaturan.php');
                        } else {
                            // Jika nilai parameter 'menu' tidak valid, tampilkan halaman utama
                            echo '<h1>Selamat datang di halaman utama!</h1>';
                        }
                    } else {
                        // Jika parameter 'menu' tidak ada, tampilkan halaman utama
                        echo 
                        '<div class="container-fluid">
                            <h1 class="h3 mb-4 text-gray-800">Penjelasan Singkat Algoritma K-Nearest Neighbors (KNN)</h1>
                            <p>
                                Algoritma K-Nearest Neighbors (KNN) adalah metode klasifikasi dan regresi yang digunakan dalam analisis data dan pembelajaran mesin. KNN adalah salah satu algoritma yang paling sederhana dalam pembelajaran mesin, tetapi juga sangat efektif dalam banyak kasus.
                            </p>
                            <p>
                                Konsep utama dari KNN adalah mencari k tetangga terdekat dari data baru dalam ruang fitur dan menggunakan mayoritas kelas tetangga tersebut untuk mengklasifikasikan data baru tersebut. Jarak antara data baru dan data latih dihitung menggunakan rumus jarak Euclidean:
                            </p>
                            <p style="text-align: center;">
                                \( \text{Jarak Euclidean} = \sqrt{\sum_{i=1}^{n}(X_i - Y_i)^2} \)
                            </p>
                            <p>
                                di mana \( X_i \) adalah nilai atribut data baru dan \( Y_i \) adalah nilai atribut data latih.
                            </p>
                            <p>
                                Kelebihan KNN adalah sederhana dalam implementasi dan tidak memerlukan proses pelatihan, sehingga cocok untuk klasifikasi data dengan jumlah atribut yang tidak terlalu besar. Namun, KNN juga memiliki beberapa kelemahan, seperti kinerja yang lambat ketika jumlah data latih besar dan rentan terhadap data pencilan (outliers).
                            </p>
                            <p>
                                Untuk meningkatkan kinerja KNN, pemilihan parameter k yang tepat dan normalisasi data dapat menjadi langkah-langkah yang diperlukan. Selain itu, penggunaan metode jarak lain atau teknik bobot pada tetangga dapat diterapkan untuk meningkatkan akurasi dan ketahanan terhadap data pencilan.
                            </p>
                        </div>';
                    }
                    ?>
                </div>
                <!-- End of Page Content -->

                <?php include('footer.php'); ?>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
<!-- Tambahkan kode berikut sebelum </head> tag -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>
