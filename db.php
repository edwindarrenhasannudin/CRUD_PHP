<?php
// Membuat koneksi ke database menggunakan class mysqli.
// Parameter yang diberikan: host (localhost), username (root), password (kosong), dan nama database (crud_php).
$conn = new mysqli('localhost', 'root', '', 'crud_php');

// Mengecek apakah koneksi berhasil atau gagal.
// Jika terjadi kesalahan koneksi, tampilkan pesan error dan hentikan eksekusi dengan die().
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error); // Menampilkan pesan error jika koneksi gagal.
}
?>
