<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $message = mysqli_real_escape_string($koneksi, $_POST['message']);

    $query = "INSERT INTO kritik_saran (nama, email, pesan) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Kritik dan saran berhasil dikirim!'); window.location.href=index_pengguna.php?page=portofolio';</script>";
    } else {
        echo "<script>alert('Gagal mengirim kritik dan saran: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .contact-details {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0px 6px rgba(0, 0, 0, 0.1);
        }

        .social-media-icons {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .social-media-icons i {
            font-size: 32px;
            margin-right: 10px;
            color: #343a40;
        }

        .form-control, .btn {
            font-family: Arial, sans-serif;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .container {
            padding: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-5"><b>Hubungi Kami</b></h2>

        <div class="contact-details mb-5">
            <h4><b>Email</b></h4>
            <p>shakai@gmail.com</p>

            <h4><b>Nomor Telepon</b></h4>
            <p>081234567890</p>

            <h4><b>Sosial Media</b></h4>
            <div class="social-media-icons">
                <i class="fab fa-instagram"></i>
                <a href="" target="_self">@shakaifotografi</a>
            </div>
            <div class="social-media-icons">
                <i class="fab fa-twitter"></i>
                <a href="" target="_self">@shakaifotografi</a>
            </div>
            <div class="social-media-icons">
                <i class="fab fa-facebook"></i>
                <a href="" target="_self">Shakai Fotografi</a>
            </div>
            <div class="social-media-icons">
                <i class="fab fa-youtube"></i>
                <a href="" target="_self">Shakai Fotografi</a>
            </div>
        </div>

        <h2 class="text-center mb-4"><b>Kritik dan Saran</b></h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Kritik dan Saran</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Tulis kritik dan saran Anda di sini" required></textarea>
            </div>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-dark">Kirim</button>
            </div>
        </form>
    </div>
</body>
</html>
