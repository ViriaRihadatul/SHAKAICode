<?php
session_start();

if (!isset($_SESSION['username'])) {
  if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
  } else {
    header("location: login.php");
    exit();
  }
}

include('koneksi.php');

$username = $_SESSION['username'];
$query = "SELECT role FROM user WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $role);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($role !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.'); window.location.href='login.php';</script>";
    exit();
  }
} else {
  echo "<script>alert('Terjadi kesalahan saat memeriksa role pengguna.'); window.location.href='login.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shakai Fotografi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles.css">
  <style>
    @media (max-width: 768px) {
      header img {
        max-width: 120px;
      }
    }

    .navbar-nav .nav-link {
      color: white !important;
      font-weight: bold !important;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
      transition: background-color 0.3s, color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      background-color: #ffffff !important;
      color: black !important;
    }
  </style>
  <script>
    function confirmLogout(event) {
      event.preventDefault();
      const confirmation = confirm("Apakah Anda yakin ingin logout?");
      if (confirmation) {
        window.location.href = "?page=logout";
      }
    }
  </script>
</head>

<body>
  <header style="background-color:rgb(0, 0, 0);" class="py-3">
    <div class="text-center">
      <img src="logo1.png" alt="Logo Shakai" class="img-fluid" style="max-width: 170px; height: auto;">
    </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(0, 0, 0);">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="?page=">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=forum">Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=portofolio">Portofolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=upload">Upload</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=kontak">Kontak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=krisar">Kritik & Saran</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=logout" onclick="confirmLogout(event)">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div>
    <?php
    $page = isset($_GET["page"]) ? htmlspecialchars($_GET["page"]) : "";

    if ($page == "") {
      include "beranda.php";
    } elseif ($page == "forum") {
      include "forumAdmin.php";
    } elseif ($page == "portofolio") {
      include "portofolioAdmin.php";
    } elseif ($page == "upload") {
      include "upload.php";
    } elseif ($page == "kontak") {
      include "kontak.php";
    } elseif ($page == "krisar") {
      include "krisar.php";
    } elseif ($page == "logout") {
      include "logout.php";
    } else {
      echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
    }
    ?>
  </div>

</body>

</html>