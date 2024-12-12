<?php
require 'functions.php';

// Handle Tambah Data
if (isset($_POST['add'])) {
    addData($_POST['name'], $_POST['nim'], $_POST['email'], $_POST['asal'], $_POST['semester']);
}

// Handle Hapus Data
if (isset($_GET['delete'])) {
    deleteData($_GET['delete']);
}

// Handle Update Data
if (isset($_POST['update'])) {
    updateData($_POST['id'], $_POST['name'], $_POST['nim'], $_POST['email'], $_POST['asal'], $_POST['semester']);
}

// Ambil Data untuk Ditampilkan
$result = getData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Informatika ITERA</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="http://if.itera.ac.id/wp-content/uploads/2021/11/cropped-Log%E3%81%8A.png" alt="ITERA" class="image">
    <h1>Pendaftaran Mahasiswa Informatika ITERA</h1>

    <!-- Form Tambah dan Edit Data -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
        <input type="text" name="name" placeholder="Nama" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
        <input type="text" name="nim" placeholder="Nim" value="<?php echo isset($_GET['nim']) ? htmlspecialchars($_GET['nim']) : ''; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
        <input type="text" name="asal" placeholder="Asal" value="<?php echo isset($_GET['asal']) ? htmlspecialchars($_GET['asal']) : ''; ?>" required>
        <input type="number" name="semester" placeholder="Semester" value="<?php echo isset($_GET['semester']) ? $_GET['semester'] : ''; ?>" required min="1" max="8"> 
        <button type="submit" class="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'add'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?>
        </button>
        <?php if (isset($_GET['edit'])) { ?>
            <button type="button" class="batal-edit" onclick="window.location.href='index.php';">Batal Edit</button>
        <?php } ?>
    </form>

    <!-- Tabel Data -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Nim</th>
            <th>Email</th>
            <th>Asal</th>
            <th>Semester</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['nim']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['asal']); ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&nim=<?php echo urlencode($row['nim']); ?>&email=<?php echo urlencode($row['email']); ?>&asal=<?php echo urlencode($row['asal']); ?>&semester=<?php echo urlencode($row['semester']);?>">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
