<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "rpl");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM user WHERE username='$username'";
    $check_result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Username telah terdaftar.";
    } else {
        $sql = "INSERT INTO user (username, password, role) VALUES ('$username', '$password', 'pengguna')";
        if (mysqli_query($koneksi, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($koneksi);
        }
    }
}

mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: black;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 27rem;
            border-radius: 10px;
            box-shadow: 0 0 35px rgba(255, 255, 255, 0.49);
        }

        .card-body {
            padding: 2rem;
        }

        .img {
            width: 110px;
            height: 60px;
        }

        .form-control {
            background-color: #fff;
            border-color: #ccc;
            color: #333;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .btn-primary {
            background-color: #000;
            border-color: #000;
        }

        .btn-primary:hover {
            background-color: #333;
            border-color: #333;
        }

        .text-danger {
            font-size: 0.9rem;
        }

        .container {
            padding: 50px;
        }

        @media (max-width: 768px) {
            .card {
                max-width: 70%;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="logo2.png" class="img rounded" alt="logo">
                <hr>
            </div>
            <h5 class="card-title text-center"><b>DAFTAR</b></h5>
            <form action="" method="POST">
                <div class="form-group mb-3">
                    <label for="username">Username :</label>
                    <input type="text" name="username" class="form-control" required>
                    <?php if ($error_message): ?>
                        <div class="text-danger mt-2"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password :</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
            </form>
            <p class="text-center mt-3">Sudah punya akun? <a href="login.php" class="text-primary">Login</a></p>
        </div>
    </div>
</body>

</html>