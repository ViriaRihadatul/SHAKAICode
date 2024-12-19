<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
  if (isset($_FILES['file']) && isset($_POST['username'])) {
    $username = $_POST['username'];
    $file = $_FILES['file'];

    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
      $uploadDir = 'uploads/';
      $fileName = uniqid() . '.' . $fileType;
      $filePath = $uploadDir . $fileName;

      if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $query = "INSERT INTO photos (username, image) VALUES (?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);

        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "ss", $username, $fileName);
          if (mysqli_stmt_execute($stmt)) {
            session_start();
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
              header("Location: index_admin.php?page=portofolio");
            } else {
              header("Location: index_pengguna.php?page=portofolio");
            }
            exit();
          } else {
            echo "Terjadi kesalahan saat menyimpan data ke database.";
          }
          mysqli_stmt_close($stmt);
        } else {
          echo "Gagal menyiapkan query.";
        }
      } else {
        echo "Gagal mengunggah file.";
      }
    } else {
      echo "Hanya file gambar yang diperbolehkan.";
    }
  } else {
    echo "Formulir upload tidak lengkap.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Foto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background-color: #f4f4f4;
      color: #333;
    }

    .btn-primary {
      background-color: #343a40;
      border: #443a40;
      color: white;
    }

    .btn-primary:hover {
      background-color: #555;
      border: #443a40;
    }

    .btn-primary.btn-lg {
      font-size: 15px;
    }

    .container {
      padding-top: 80px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center mb-4"><b>Upload Foto</b></h2>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="username" class="form-label">Diunggah oleh:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Tulis namamu" required>
          </div>

          <div class="mb-3">
            <label for="file" class="form-label">Pilih Foto:</label>
            <input type="file" id="file" name="file" class="form-control" accept="image/*" required>
          </div>

          <div class="text-center">
            <input type="submit" value="Upload" name="upload" class="btn btn-primary btn-lg">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
