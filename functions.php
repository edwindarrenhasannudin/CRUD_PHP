<?php
// Memasukkan file 'db.php' yang berisi koneksi database.
require 'db.php';

// Fungsi untuk menambahkan data baru ke tabel 'users'.
function addData($name, $nim, $email, $asal, $semester) {
    global $conn; // Mengakses variabel koneksi database dari global scope.
    // SQL query untuk memasukkan data ke tabel 'users'.
    $sql = "INSERT INTO users (name, nim, email, asal, semester) VALUES ('$name', '$nim', '$email', '$asal', '$semester')";
    return $conn->query($sql); // Menjalankan query dan mengembalikan hasilnya.
}

// Fungsi untuk menghapus data berdasarkan ID.
function deleteData($id) {
    global $conn; // Mengakses variabel koneksi database dari global scope.
    // SQL query untuk menghapus data dari tabel 'users' berdasarkan ID.
    $sql = "DELETE FROM users WHERE id=$id";
    return $conn->query($sql); // Menjalankan query dan mengembalikan hasilnya.
}

// Fungsi untuk memperbarui data berdasarkan ID.
function updateData($id, $name, $nim, $email, $asal, $semester) {
    global $conn; // Mengakses variabel koneksi database dari global scope.

    // Validasi untuk memastikan ID dan Semester adalah angka.
    if (!is_numeric($id) || !is_numeric($semester)) {
        return false; // Jika tidak valid, kembalikan nilai false.
    }

    // Persiapkan query SQL menggunakan prepared statement untuk keamanan.
    $stmt = $conn->prepare("UPDATE users SET name = ?, nim = ?, email = ?, asal = ?, semester = ? WHERE id = ?");

    if (!$stmt) {
        // Jika gagal mempersiapkan statement, catat error ke log.
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }

    // Mengikat parameter ke dalam query.
    $stmt->bind_param("ssssis", $name, $nim, $email, $asal, $semester, $id);

    // Menjalankan statement yang telah dipersiapkan.
    if (!$stmt->execute()) {
        // Jika gagal menjalankan query, catat error ke log.
        error_log("Error executing statement: " . $stmt->error);
        $stmt->close(); // Tutup statement sebelum mengembalikan nilai false.
        return false;
    }

    // Tutup statement setelah berhasil dijalankan.
    $stmt->close();

    // Redirect ke 'index.php' untuk membersihkan parameter URL.
    header("Location: index.php");
    exit; // Menghentikan eksekusi kode setelah redirect.
}

// Fungsi untuk mendapatkan semua data dari tabel 'users'.
function getData() {
    global $conn; // Mengakses variabel koneksi database dari global scope.
    $sql = "SELECT * FROM users"; // SQL query untuk mengambil semua data dari tabel 'users'.
    return $conn->query($sql); // Menjalankan query dan mengembalikan hasilnya.
}
?>
