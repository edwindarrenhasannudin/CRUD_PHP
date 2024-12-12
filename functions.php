<?php
require 'db.php';

// Fungsi untuk menambahkan data
function addData($name, $nim, $email, $asal, $semester) {
    global $conn;
    $sql = "INSERT INTO users (name, nim, email, asal, semester) VALUES ('$name', '$nim', '$email', '$asal', '$semester')";
    return $conn->query($sql);
}

// Fungsi untuk menghapus data
function deleteData($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id=$id";
    return $conn->query($sql);
}

function updateData($id, $name, $nim, $email, $asal, $semester) {
    global $conn;

    // Validasi input data
    if (!is_numeric($id) || !is_numeric($semester)) {
        return false; // Pastikan ID dan Semester berupa angka
    }

    // Persiapkan statement SQL
    $stmt = $conn->prepare("UPDATE users SET name = ?, nim = ?, email = ?, asal =?, semester = ? WHERE id = ?");

    if (!$stmt) {
        // Jika statement gagal dipersiapkan
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }

    // Bind parameter ke statement
    $stmt->bind_param("ssssis", $name, $nim, $email, $asal, $semester, $id);

    // Eksekusi statement
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        $stmt->close();
        return false;
    }

    // Tutup statement
    $stmt->close();

    // Redirect untuk membersihkan parameter URL
    header("Location: index.php");
    exit;
}

// Fungsi untuk mendapatkan semua data
function getData() {
    global $conn;
    $sql = "SELECT * FROM users";
    return $conn->query($sql);
}
?>
