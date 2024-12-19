<?php
include "koneksi.php";

// tambah topik
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_topic'])) {
    $topic = mysqli_real_escape_string($koneksi, $_POST['topic']);
    $sql = "INSERT INTO topics (topic) VALUES ('$topic')";
    mysqli_query($koneksi, $sql);

    $last_topic_id = mysqli_insert_id($koneksi);

    header("Location: index_admin.php?page=forum#topic-$last_topic_id");
    exit;
}

// tambah komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_comment'])) {
    $topic_id = $_POST['topic_id'];
    $comment = mysqli_real_escape_string($koneksi, $_POST['comment']);
    $sql = "INSERT INTO comments (topic_id, comment) VALUES ('$topic_id', '$comment')";
    mysqli_query($koneksi, $sql);

    header("Location: index_admin.php?page=forum#topic-$topic_id");
    exit;
}

// hapus topik
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_topic'])) {
    $topic_id = $_POST['topic_id'];
    $sql = "DELETE FROM topics WHERE id = $topic_id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index_admin.php?page=forum");
        exit;
    }
}

// hapus komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];
    $sql = "DELETE FROM comments WHERE id = $comment_id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index_admin.php?page=forum");
        exit;
    }
}

$topics = mysqli_query($koneksi, "SELECT * FROM topics ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header h1,
        header h5 {
            font-family: 'Arial', sans-serif;
        }

        .comment-box {
            margin-top: 20px;
        }

        .comment-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            background-color: #f9f9f9;
        }

        .comment-container p {
            margin: 0;
        }

        .form-label,
        .form-control {
            font-family: Arial, sans-serif;
        }

        .btn-dark {
            background-color: #343a40;
            color: white;
        }

        .container {
            padding: 80px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-5"><b>Forum Diskusi</b></h2>

        <!-- form tambah topik -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="topic" class="form-label">Tulis pesanmu di sini!</label>
                <textarea name="topic" id="topic" class="form-control" rows="2" placeholder="Tulis pesan" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" name="new_topic" class="btn btn-dark">Kirim</button>
            </div>
        </form>

        <!-- daftar topik -->
        <?php while ($topic = mysqli_fetch_assoc($topics)): ?>
            <div class="card mb-3" id="topic-<?php echo $topic['id']; ?>">
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($topic['topic']); ?></h5>

                    <!-- Tombol hapus topik -->
                    <form method="POST" class="delete-topic-form" style="text-align: right;">
                        <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                        <button type="submit" name="delete_topic" class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                    <!-- form tambah komentar -->
                    <form method="POST" class="comment-box">
                        <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="1" placeholder="Tulis komentar" required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" name="new_comment" class="btn btn-dark">Kirim</button>
                        </div>
                    </form>

                    <!-- daftar komentar -->
                    <?php
                    $topic_id = $topic['id'];
                    $comments = mysqli_query($koneksi, "SELECT * FROM comments WHERE topic_id = $topic_id ORDER BY created_at DESC");
                    while ($comment = mysqli_fetch_assoc($comments)): ?>
                        <div class="comment-container">
                            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                            <!-- Tombol hapus komentar -->
                            <form method="POST" class="delete-comment-form" style="text-align: right;">
                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" name="delete_comment" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-comment-form button').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                        e.target.form.submit();
                    } else {
                        e.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.delete-topic-form button').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
                        e.target.form.submit();
                    } else {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>

</html>