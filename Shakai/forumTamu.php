<?php
include "koneksi.php";

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

        header h1, header h5 {
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

        .form-label, .form-control {
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

        <!-- daftar topik -->
        <?php while ($topic = mysqli_fetch_assoc($topics)): ?>
            <div class="card mb-3" id="topic-<?php echo $topic['id']; ?>">
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($topic['topic']); ?></h5>

                    <!-- daftar komentar -->
                    <?php
                    $topic_id = $topic['id'];
                    $comments = mysqli_query($koneksi, "SELECT * FROM comments WHERE topic_id = $topic_id ORDER BY created_at DESC");
                    while ($comment = mysqli_fetch_assoc($comments)): ?>
                        <div class="comment-container">
                            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
