<?php
$conn = new mysqli('localhost', 'root', '', 'crud_php');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
