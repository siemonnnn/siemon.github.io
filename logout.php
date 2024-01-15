<?php
// Mulai session
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Redirect ke halaman login (ganti dengan halaman login sesuai kebutuhan)
header("Location: login.php");
exit();
?>
