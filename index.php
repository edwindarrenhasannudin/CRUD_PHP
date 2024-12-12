<?php
// Memasukkan file 'functions.php' yang berisi definisi fungsi untuk database.
require 'functions.php';

// Menangani aksi tambah data.
if (isset($_POST['add'])) {
    // Memanggil fungsi addData dengan data yang diinputkan pengguna dari form.
    addData($_POST['name'], $_POST['nim'], $_POST['email'], $_POST['asal'], $_POST['semester']);
}

// Menangani aksi hapus data.
if (isset($_GET['delete'])) {
    // Memanggil fungsi deleteData dengan ID data yang akan dihapus.
    deleteData($_GET['delete']);
}

// Menangani aksi update data.
if (isset($_POST['update'])) {
    // Memanggil fungsi updateData dengan data baru yang diinputkan pengguna dari form.
    updateData($_POST['id'], $_POST['name'], $_POST['nim'], $_POST['email'], $_POST['asal'], $_POST['semester']);
}

// Mengambil semua data dari database untuk ditampilkan dalam tabel.
$result = getData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Menentukan encoding karakter halaman. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Agar halaman responsif di perangkat apapun. -->
    <title>Mahasiswa Informatika ITERA</title> <!-- Judul halaman. -->
    <link rel="stylesheet" href="styles.css"> <!-- Menghubungkan file CSS untuk styling. -->
</head>
<body>
    <!-- Menampilkan logo ITERA. -->
    <img src="http://if.itera.ac.id/wp-content/uploads/2021/11/cropped-Log%E3%81%8A.png" alt="ITERA" class="image">
    <h1>Pendaftaran Mahasiswa Informatika ITERA</h1>

    <!-- Form untuk menambah atau mengedit data. -->
    <form method="POST" action="">
        <!-- Input tersembunyi untuk menyimpan ID saat mode edit. -->
        <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
        <!-- Input untuk nama. -->
        <input type="text" name="name" placeholder="Nama" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
        <!-- Input untuk NIM. -->
        <input type="text" name="nim" placeholder="Nim" value="<?php echo isset($_GET['nim']) ? htmlspecialchars($_GET['nim']) : ''; ?>" required>
        <!-- Input untuk email. -->
        <input type="email" name="email" placeholder="Email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
        <!-- Input untuk asal. -->
        <input type="text" name="asal" placeholder="Asal" value="<?php echo isset($_GET['asal']) ? htmlspecialchars($_GET['asal']) : ''; ?>" required>
        <!-- Input untuk semester (hanya angka dari 1-8). -->
        <input type="number" name="semester" placeholder="Semester" value="<?php echo isset($_GET['semester']) ? $_GET['semester'] : ''; ?>" required min="1" max="8"> 
        <!-- Tombol submit untuk menambah atau mengedit data. -->
        <button type="submit" class="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'add'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> <!-- Teks tombol disesuaikan. -->
        </button>
        <!-- Tombol untuk membatalkan mode edit (hanya muncul saat edit). -->
        <?php if (isset($_GET['edit'])) { ?>
            <button type="button" class="batal-edit" onclick="window.location.href='index.php';">Batal Edit</button>
        <?php } ?>
    </form>

    <!-- Tabel untuk menampilkan data dari database. -->
    <table border="1">
        <tr>
            <th>ID</th> <!-- Kolom ID. -->
            <th>Nama</th> <!-- Kolom Nama. -->
            <th>Nim</th> <!-- Kolom NIM. -->
            <th>Email</th> <!-- Kolom Email. -->
            <th>Asal</th> <!-- Kolom Asal. -->
            <th>Semester</th> <!-- Kolom Semester. -->
            <th>Aksi</th> <!-- Kolom Aksi (Edit/Hapus). -->
        </tr>
        <!-- Mengulangi setiap baris data untuk ditampilkan di tabel. -->
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <!-- Menampilkan data dari kolom tabel users. -->
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['nim']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['asal']); ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td>
                    <!-- Tombol Edit dengan data dikodekan ke URL untuk mode edit. -->
                    <a href="?edit=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&nim=<?php echo urlencode($row['nim']); ?>&email=<?php echo urlencode($row['email']); ?>&asal=<?php echo urlencode($row['asal']); ?>&semester=<?php echo urlencode($row['semester']);?>">Edit</a>
                    <!-- Tombol Hapus dengan konfirmasi. -->
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
