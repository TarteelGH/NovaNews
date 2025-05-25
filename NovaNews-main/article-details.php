<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NovaNews - Article Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-dark text-light">
  <?php include 'db.php'; ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container">
      <a class="navbar-brand" href="index.php">NovaNews</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#politics">Politics</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#economy">Economy</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#sports">Sports</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#health">Health</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <?php
    if (isset($_GET['id'])) {
      $id = intval($_GET['id']);

      // زيادة عدد القراءات
      mysqli_query($conn, "UPDATE articles SET read_count = read_count + 1 WHERE id = $id");

      $result = mysqli_query($conn, "SELECT * FROM articles WHERE id = $id AND status = 'published' LIMIT 1");

      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo '<h1 class="mb-4">' . htmlspecialchars($row['title']) . ': ' . htmlspecialchars($row['subtitle']) . '</h1>';
        echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" class="img-fluid rounded mb-4" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';
        echo '<p class="mt-4"><small class="text-muted">By ' . htmlspecialchars($row['author_id']) . ' | ' . htmlspecialchars($row['created_at']) . '</small></p>';

        // FORM لإضافة تعليق
        echo '<div class="mt-5">';
        echo '<h3>Comments</h3>';
        echo '<form action="add_comment.php" method="POST" class="mb-4">';
        echo '<input type="hidden" name="article_id" value="' . $id . '">';
        echo '<div class="mb-3">';
        echo '<label for="user_name" class="form-label">Your Name</label>';
        echo '<input type="text" class="form-control" id="user_name" name="user_name" required>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="comment_text" class="form-label">Your Comment</label>';
        echo '<textarea class="form-control" id="comment_text" name="comment_text" rows="3" required></textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Submit Comment</button>';
        echo '</form>';

        echo '<button class="btn btn-outline-info mb-3" onclick="toggleComments()">Show Comments</button>';
        echo '<div id="commentsSection" style="display: none;">';

        $comments = mysqli_query($conn, "SELECT * FROM comments WHERE article_id = $id ORDER BY created_at DESC");
        if (mysqli_num_rows($comments) > 0) {
          while ($comment = mysqli_fetch_assoc($comments)) {
            echo '<div class="card bg-secondary text-light mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($comment['user_name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($comment['comment_text']) . '</p>';
            echo '<small class="text-muted">' . htmlspecialchars($comment['created_at']) . '</small>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo '<p>No comments yet.</p>';
        }

        echo '</div>'; // end comment section
        echo '</div>'; // end wrapper
      } else {
        echo '<p>Sorry, this article does not exist.</p>';
      }
    } else {
      echo '<p>No article selected.</p>';
    }
    ?>

    <a href="index.php" class="btn btn-outline-light mt-4">&larr; Back to Home</a>
  </div>

  <footer class="bg-black text-light text-center py-3 mt-5">
    <p class="mb-0">&copy; 2025 NovaNews. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleComments() {
      const commentsSection = document.getElementById('commentsSection');
      const button = document.querySelector('button[onclick="toggleComments()"]');
      if (commentsSection.style.display === 'none') {
        commentsSection.style.display = 'block';
        button.textContent = 'Hide Comments';
      } else {
        commentsSection.style.display = 'none';
        button.textContent = 'Show Comments';
      }
    }
  </script>
</body>

</html>
