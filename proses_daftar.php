<?php
// Fungsi untuk mendaftarkan akun baru
function daftarAkun($username, $email, $password) {
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
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash password sebelum menyimpannya ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data pengguna ke tabel users
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika pendaftaran berhasil
        return true;
    } else {
        // Jika pendaftaran gagal
        return false;
    }

    // Tutup koneksi database
    mysqli_close($conn);
}

// Jika ada data POST dari form pendaftaran akun
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi input
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            echo "Semua kolom harus diisi.";
            exit();
        }

        if ($password !== $confirm_password) {
            echo "Konfirmasi password tidak cocok.";
            exit();
        }

        // Proses pendaftaran akun
        if (daftarAkun($username, $email, $password)) {
            // Jika pendaftaran berhasil
            echo '
            <script>
                alert("Daftar Akun Berhasil");
                window.location.href = "index.php?menu=dataset";
            </script>';
        } else {
            // Jika pendaftaran gagal
            echo "Gagal mendaftarkan akun. Silakan coba lagi.";
        }
    }
}
?>
