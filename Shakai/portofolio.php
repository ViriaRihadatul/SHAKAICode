<?php
include('koneksi.php');

$query = "SELECT * FROM photos ORDER BY uploaded_at DESC";
$result = mysqli_query($koneksi, $query);

if ($result) {
  $photos = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  echo "<div class='alert alert-danger'>Gagal mengambil data gambar: " . mysqli_error($koneksi) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portofolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    .modal-dialog {
      max-width: 700px;
      max-height: 80vh;
      border-radius: 8px;
      overflow: hidden;
    }

    .modal-body {
      padding: 0;
      box-shadow: 0 0px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-img {
      width: 100%;
      height: auto;
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
            foreach ($photos as $index => $row) {
              $imagePath = 'uploads/' . $row['image'];

              echo '<div class="col-md-4 d-flex justify-content-center">';
              echo '<div class="photo">';
              echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Foto oleh ' . htmlspecialchars($row['username']) . '" data-bs-toggle="modal" data-bs-target="#photoModal' . $row['id'] . '">';
              echo '<h4>Diunggah oleh:<br><br><b>' . htmlspecialchars($row['username']) . '</b></h4>';
              echo '</div>';
              echo '</div>';

              echo '<div class="modal fade" id="photoModal' . $row['id'] . '" tabindex="-1" aria-labelledby="photoModalLabel' . $row['id'] . '" aria-hidden="true">';
              echo '<div class="modal-dialog modal-dialog-centered modal-lg">';
              echo '<div class="modal-content">';
              echo '<div class="modal-body p-0">';
              echo '<img src="' . htmlspecialchars($imagePath) . '" class="modal-img" alt="Foto oleh ' . htmlspecialchars($row['username']) . '">';
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
    });
  </script>
</body>

</html>