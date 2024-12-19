<?php
require 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $query_delete = "DELETE FROM kritik_saran WHERE id = $id";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        echo "<script>alert('Data berhasil dihapus.'); window.location='index_admin.php?page=krisar';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location='index_admin.php?page=krisar';</script>";
    }
}

$query = "SELECT * FROM kritik_saran ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik dan Saran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header h1,
        header h5 {
            font-family: 'Arial', sans-serif;
        }
        .container {
            padding: 80px;
        }
        .empty-message {
            color: grey;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location = 'krisar.php?hapus=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-5"><b>Kritik dan Saran</b></h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pesan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                        echo "<td><button class='btn btn-danger btn-sm' onclick='confirmDelete(" . $row['id'] . ")'>Hapus</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">Belum ada kritik dan saran.</p>
        <?php endif; ?>
    </div>
</body>
</html>
