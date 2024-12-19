<?php
include('koneksi.php');

$query = "SELECT * FROM photos ORDER BY uploaded_at DESC";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $photos = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "<div class='alert alert-danger'>Gagal mengambil data gambar: " . mysqli_error($koneksi) . "</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_photo'])) {
    $photo_id = $_POST['photo_id'];

    $photoQuery = "SELECT image FROM photos WHERE id = $photo_id";
    $photoResult = mysqli_query($koneksi, $photoQuery);

    if ($photoResult && mysqli_num_rows($photoResult) > 0) {
        $photoRow = mysqli_fetch_assoc($photoResult);
        $imagePath = 'uploads/' . $photoRow['image'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $deleteQuery = "DELETE FROM photos WHERE id = $photo_id";
        if (mysqli_query($koneksi, $deleteQuery)) {
            echo "<div class='alert alert-success'>Gambar berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus data gambar: " . mysqli_error($koneksi) . "</div>";
        }
    }

    header("Location: index_admin.php?page=portofolio");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_photo'])) {
    $photo_id = $_POST['photo_id'];
    $new_username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $current_image = $_POST['current_image'];
    $new_image = $_FILES['image'];

    if ($new_image['name']) {
        $imageName = time() . '_' . basename($new_image['name']);
        $targetPath = 'uploads/' . $imageName;

        $oldImagePath = 'uploads/' . $current_image;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        move_uploaded_file($new_image['tmp_name'], $targetPath);

        $updateQuery = "UPDATE photos SET username = '$new_username', image = '$imageName' WHERE id = $photo_id";
    } else {
        $updateQuery = "UPDATE photos SET username = '$new_username' WHERE id = $photo_id";
    }

    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data: " . mysqli_error($koneksi) . "</div>";
    }

    header("Location: index_admin.php?page=portofolio");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        .photo {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #fff;
        }

        .photo img {
            width: 400px;
            height: 400px;
            border-radius: 5px;
            object-fit: cover;
            cursor: pointer;
        }

        .photo h4 {
            margin-top: 15px;
            font-size: 1.2rem;
            color: #333;
        }

        #portfolioGallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        @media (max-width: 1020px) {
            .photo {
                width: 100%;
            }
        }

        .container {
            padding: 80px;
        }
    </style>
</head>

<body>
    <div class="container">
        <section id="portfolio">
            <h2 class="text-center mb-3"><b>Portofolio</b></h2>
            <div id="portfolioGallery">
                <div class="row g-3" style="margin-top: 25px;">
                    <?php
                    if ($photos) {
                        foreach ($photos as $row) {
                            $imagePath = 'uploads/' . $row['image'];
                            echo '<div class="col-md-4 d-flex justify-content-center">';
                            echo '<div class="photo">';
                            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Foto oleh ' . htmlspecialchars($row['username']) . '" data-bs-toggle="modal" data-bs-target="#photoModal' . $row['id'] . '">';
                            echo '<h4>Diunggah oleh: <b><br>' . htmlspecialchars($row['username']) . '</b></h4>';
                            echo '<div class="d-flex justify-content-between w-100">';
                            echo '<button class="btn btn-dark btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#editModal' . $row['id'] . '">Edit</button>';
                            echo '<form method="POST" class="delete-photo-form mt-2"">';
                            echo '<input type="hidden" name="photo_id" value="' . $row['id'] . '">';
                            echo '<button type="submit" name="delete_photo" class="btn btn-danger btn-sm">Hapus</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';



                            echo '<div class="modal fade" id="photoModal' . $row['id'] . '" tabindex="-1" aria-hidden="true">';
                            echo '<div class="modal-dialog modal-dialog-centered modal-lg">';
                            echo '<div class="modal-content d-flex justify-content-center align-items-center bg-transparent border-0">';
                            echo '<div class="modal-body p-0">';
                            echo '<img src="' . htmlspecialchars($imagePath) . '" class="img-fluid" style="max-width: 100%; max-height: 80vh;">';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';

                            echo '<div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">';
                            echo '<div class="modal-dialog modal-dialog-centered">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h5 class="modal-title" id="editModalLabel">Edit Foto</h5>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                            echo '<form method="POST" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="photo_id" value="' . $row['id'] . '">';
                            echo '<input type="hidden" name="current_image" value="' . $row['image'] . '">';
                            echo '<div class="mb-3">';
                            echo '<label for="username" class="form-label">Username</label>';
                            echo '<input type="text" name="username" value="' . htmlspecialchars($row['username']) . '" class="form-control">';
                            echo '</div>';
                            echo '<div class="mb-3">';
                            echo '<label for="image" class="form-label">Gambar Baru</label>';
                            echo '<input type="file" name="image" class="form-control">';
                            echo '</div>';
                            echo '<div class="d-flex justify-content-between">';
                            echo '<button type="submit" name="edit_photo" class="btn btn-dark btn-sm">Simpan Perubahan</button>';
                            echo '<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='col-12'><div style='color: grey;'>Belum ada foto yang diunggah.</div></div>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.photo img').forEach(img => {
                img.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById(img.getAttribute('data-bs-target').replace('#', '')));
                    modal.show();
                });
            });

            document.querySelectorAll('.delete-photo-form button').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>

</html>