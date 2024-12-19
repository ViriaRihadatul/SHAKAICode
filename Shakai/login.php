<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "rpl");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

$error_message = "";

if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: index_admin.php");
        exit();
    } elseif ($_SESSION['role'] == 'pengguna') {
        header("Location: index_pengguna.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];

                if (isset($_POST['remember'])) {
                    setcookie("username", $username, time() + (86400 * 30), "/");
                    setcookie("role", $row['role'], time() + (86400 * 30), "/");
                    setcookie("password", $password, time() + (86400 * 30), "/");
                } else {
                    setcookie("username", "", time() - 3600, "/");
                    setcookie("role", "", time() - 3600, "/");
                    setcookie("password", "", time() - 3600, "/");
                }

                if ($row['role'] == 'admin') {
                    header("Location: index_admin.php");
                } elseif ($row['role'] == 'pengguna') {
                    header("Location: index_pengguna.php");
                } else {
                    header("Location: error.php"); 
                }
                exit();
            } else {
                $error_message = "Password salah.";
            }
        } else {
            $error_message = "Username tidak ditemukan.";
        }
    } else {
        $error_message = "Terjadi kesalahan pada query: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        @media (max-width: 768px) {
            .card {
                max-width: 67%;
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
            <h5 class="card-title text-center"><b>LOGIN</b></h5>
            <form action="" method="POST">
                <div class="form-group mb-3">
                    <label for="username">Username :</label>
                    <input type="text" name="username" class="form-control" 
                        value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" required>
                    <?php if ($error_message): ?>
                        <div class="text-danger mt-2"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password :</label>
                    <input type="password" name="password" class="form-control" 
                        value="<?php echo isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : ''; ?>" required>
                </div>
                <div class="form-check mb-4">
                    <input type="checkbox" name="remember" class="form-check-input" 
                        id="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
            <p class="text-center mt-3">Belum punya akun? <a href="register.php" class="text-primary">Daftar</a></p>
        </div>
    </div>
</body>
</html>
