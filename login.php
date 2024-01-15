<?php
// Fungsi untuk mendaftarkan akun baru
function daftarAkun($username, $password) {
    // Gantikan dengan koneksi ke database Anda
    $host = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $database = 'penjualanikan';

    // Koneksi ke database
    $conn = mysqli_connect($host, $username_db, $password_db, $database);

    // Cek koneksi berhasil atau tidak
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Lakukan sanitasi pada data masukan
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash password sebelum menyimpannya ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data pengguna ke tabel users
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        echo "Akun berhasil didaftarkan!";
    } else {
        echo "Gagal mendaftarkan akun. Pesan error: " . mysqli_error($conn);
    }
    

    // Tutup koneksi database
    mysqli_close($conn);
}

// Mulai session
session_start();

// Jika pengguna sudah login, redirect ke halaman utama (ganti dengan halaman utama sesuai kebutuhan)
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

// Jika ada data POST dari form login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gantikan dengan koneksi ke database Anda
    $host = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $database = 'penjualanikan';

    // Koneksi ke database
    $conn = mysqli_connect($host, $username_db, $password_db, $database);

    // Cek koneksi berhasil atau tidak
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Mendapatkan data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan sanitasi pada data masukan
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query untuk mencari data pengguna berdasarkan username
    $query = "SELECT * FROM users WHERE username='$username'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika data pengguna dengan username tersebut ditemukan
        if (mysqli_num_rows($result) === 1) {
            $user_data = mysqli_fetch_assoc($result);

            // Verifikasi password yang dimasukkan dengan password di database
            if (password_verify($password, $user_data['password'])) {
                // Set session untuk menandakan bahwa pengguna sudah login
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user_data['username'];

                // Redirect ke halaman utama (ganti dengan halaman utama sesuai kebutuhan)
                header("Location: index.php");
                exit();
            } else {
                // Jika password tidak cocok, tampilkan pesan error (opsional)
                $error_message = "Username atau password salah.";
            }
        } else {
            // Jika data pengguna dengan username tersebut tidak ditemukan, tampilkan pesan error (opsional)
            $error_message = "Username dan Password tidak ditemukan";
        }

        // Bebaskan memory dari hasil query
        mysqli_free_result($result);
    } else {
        die("Query gagal: " . mysqli_error($conn));
    }

    // Tutup koneksi database
    mysqli_close($conn);
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

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                       
                       
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                    </div>
                                    <?php
                                    // Tampilkan pesan error jika ada
                                    if (isset($error_message)) {
                                        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                                    }
                                    ?>
                                    <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#daftarAkunModal">
                                            Belum punya akun? Daftar disini!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Modal Pendaftaran Akun -->
    <div class="modal fade" id="daftarAkunModal" tabindex="-1" role="dialog" aria-labelledby="daftarAkunModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="daftarAkunModalLabel">Form Pendaftaran Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form pendaftaran akun -->
                    <form class="user" action="proses_daftar.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="confirm_password" placeholder="Konfirmasi Password">
                        </div>
                        <button type="submit" name="register" class="btn btn-primary btn-user btn-block">Daftar Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
