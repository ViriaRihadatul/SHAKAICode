<?php

include('koneksi.php');

$query = "SELECT role FROM user WHERE username = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if (!isset($role)) {
    $role = 'Guest';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Shakai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
        }

        .welcome-text {
            text-align: center;
            margin-top: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .beranda-header {
            height: 84vh;
            width: 100%;
            background: url('dark3.jpg') no-repeat center center/cover;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            margin: 0;
            padding: 0;
            top: 0;
        }


        .beranda-header h1 {
            font-size: 3rem;
            font-weight: bold;
            z-index: 2;
            color: white;
        }

        .beranda-header p {
            font-size: 1.2rem;
            margin-top: 10px;
            z-index: 2;
            color: white;
        }

        .beranda-header h1,
        .beranda-header h2,
        .beranda-header p {
            text-shadow: 0px 5px 5px rgb(0, 0, 0);
        }


        .beranda-header::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
            display: none;
        }

        main {
            background: white;
            padding: 2rem;
        }

        .content {
            font-family: 'Lora', serif;
            font-size: 20px;
            padding-top: 20px;
        }

        .card {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: bold;
        }
        
        .card-text {
            font-family: 'Lora', sans-serif;
        }

        .carousel {
            max-width: 900px;
            margin: 30px auto;
        }

        .img2 {
            width: 100%;
            max-width: 200px;
            height: auto;
        }

        .carousel img {
            width: 100%;
            height: auto;
            max-height: 900px;
            object-fit: cover;
        }

        .container.text-center.col-md-4 {
            width: 80%;
            margin: 0 auto;
        }

        .footer-text {
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .container {
            padding: 80px;
        }
    </style>
</head>

<body>
    <header class="beranda-header">
        <div>
            <section id="home">
                <div class="text-center">
                    <?php
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
                    ?>
                    <h2>Selamat Datang di Shakai!</h2>
                    <h1><b>Halo, <?php echo $username; ?>!</b></h1>
                    <p class="welcome-text">
                        <?php
                        if ($username == 'Guest') {
                            echo "Silakan login untuk menikmati fitur komunitas fotografi kami.";
                        } else {
                            echo "Kami sangat senang memiliki Anda di komunitas fotografi kami.";
                        }
                        ?>
                    </p>
                </div>
            </section>
        </div>
    </header>
    <br>
    <div class="container md-4">
        <div class="bg-overlay"></div><br>
        <div class="content">
            <hr>
            <h3 class="text-center"><b>TENTANG SHAKAI</b></h3>
            <p style="text-align: justify; text-indent: 30px;">
                Ekstrakurikuler fotografi bertujuan untuk mengembangkan keterampilan fotografi anggotanya melalui berbagai kegiatan praktis.
                Anggota belajar dasar-dasar fotografi, seperti pengaturan kamera dan komposisi foto, serta berlatih di lapangan, baik di luar ruangan maupun dalam acara sekolah.
                Mereka juga dilatih dalam editing foto menggunakan perangkat lunak seperti Adobe Photoshop dan berkesempatan mengikuti kompetisi, workshop, atau seminar dengan fotografer profesional.
                Selain itu, mereka berpartisipasi dalam pameran foto dan mendokumentasikan acara sekolah, yang meningkatkan kreativitas dan keterampilan teknis mereka.
            </p>
            <p style="text-align: justify; text-indent: 30px;">
                Shakai, yang merupakan singkatan dari bahasa Jepang "Shashin Kai" (写真会) yang berarti "Komunitas Fotografi," adalah sebuah platform web yang dirancang untuk anggota ekstrakurikuler fotografi.
                Shakai menyediakan fitur portofolio, forum, dan kontak yang memungkinkan anggota untuk berbagi karya, berdiskusi, dan berinteraksi.
                Tujuan utama Shakai adalah menjadi ruang untuk menyalurkan hasil karya fotografi anggota serta memperkuat keterlibatan komunitas dalam dunia fotografi.
            </p>
            <hr>
        </div>
    </div><br>
    <div class="container">
        <h3 class="text-center" style="font-family: 'Lora', serif;"><b>MENU</b></h3><br><br>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card">
                    <img src="1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">PORTOFOLIO</h5>
                        <p class="card-text">Jelajahi koleksi karya menarik oleh anggota kami, yang menunjukkan bakat dan kreativitas mereka dalam bidang fotografi</p>
                        <?php
                        if ($role == 'admin') {
                            echo '<a href="index_admin.php?page=portofolio" class="btn btn-primary">See more</a>';
                        } elseif ($role == 'pengguna') {
                            echo '<a href="index_pengguna.php?page=portofolio" class="btn btn-primary">See more</a>';
                        } else {
                            echo '<a href="index.php?page=portofolio" class="btn btn-primary">See more</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="2.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">FORUM</h5>
                        <p class="card-text">Temukan berbagai informasi dan wawasan baru yang menarik dalam forum diskusi, tempat berbagi pemikiran, ide, dan pengalaman.</p>
                        <?php
                        if ($role == 'admin') {
                            echo '<a href="index_admin.php?page=forum" class="btn btn-primary">See more</a>';
                        } elseif ($role == 'pengguna') {
                            echo '<a href="index_pengguna.php?page=forum" class="btn btn-primary">See more</a>';
                        } else {
                            echo '<a href="index.php?page=forum" class="btn btn-primary">See more</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="3.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">KONTAK</h5>
                        <p class="card-text">Untuk pertanyaan lebih lanjut atau jika Anda ingin menghubungi kami, silakan kunjungi halaman kontak yang telah kami sediakan.</p>
                        <?php
                        if ($role == 'admin') {
                            echo '<a href="index_admin.php?page=kontak" class="btn btn-primary">See more</a>';
                        } elseif ($role == 'pengguna') {
                            echo '<a href="index_pengguna.php?page=kontak" class="btn btn-primary">See more</a>';
                        } else {
                            echo '<a href="index.php?page=kontak" class="btn btn-primary">See more</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center"><br>
        <h2><img src="logo2.png" class="img2"></h2><br>
        <div id="carouselExampleCaptions" class="carousel slide text-center" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="4.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="5.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="6.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="7.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <script>
        const myCarouselElement = document.querySelector('#carouselExampleCaptions');
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 2000,
            touch: false
        });
    </script>
    <br> <br>
    <hr>
    <div class="text-center footer-text" style="font-family: 'Lora', serif;">
        <p>
            - Terimakasih telah Berkunjung -
        </p>
    </div>
</body>

</html>