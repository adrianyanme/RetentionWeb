<?php
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan pengguna ke halaman login atau halaman utama
header("Location: index.php");
exit();
?>
