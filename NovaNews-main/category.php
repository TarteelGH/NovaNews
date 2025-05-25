<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NovaNews - Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-dark text-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container">
      <a class="navbar-brand" href="index.php">NovaNews</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#Politics">Politics</a></li>
          <li class="nav-item"><a class="nav-link" href="#Economy">Economy</a></li>
          <li class="nav-item"><a class="nav-link" href="#Sports">Sports</a></li>
          <li class="nav-item"><a class="nav-link" href="#Health">Health</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <?php
    if (isset($_GET['id'])) {
      $cat_id = $_GET['id'];
      $cat_query = mysqli_query($conn, "SELECT name FROM category WHERE id = $cat_id LIMIT 1");

      if (mysqli_num_rows($cat_query) > 0) {
        $cat = mysqli_fetch_assoc($cat_query);
        echo '<h1 class="mb-4">' . htmlspecialchars($cat['name']) . ' News</h1>';

        $articles = mysqli_query($conn, "
          SELECT a.*, u.name AS author_name
          FROM articles a
          JOIN users u ON a.author_id = u.id
          WHERE a.category_id = $cat_id AND a.status = 'published'
          ORDER BY a.created_at DESC
        ");

        if (mysqli_num_rows($articles) > 0) {
          echo '<div class="row g-4">';
          while ($row = mysqli_fetch_assoc($articles)) {
            echo '<div class="col-md-4">
                    <div class="card h-100">
                      <img src="uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row['summary']) . '</p>
                        <small class="text-muted">By <span class="text-info">' . htmlspecialchars($row['author_name']) . '</span></small>
                        <div class="mt-2">
                          <a href="article-details.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">More</a>
                        </div>
                      </div>
                    </div>
                  </div>';
          }
          echo '</div>';
        } else {
          echo '<p>No articles found in this category.</p>';
        }
      } else {
        echo '<p>Invalid category.</p>';
      }
    } else {
      echo '<p>No category selected.</p>';
    }
    ?>
  </div>

  <footer class="bg-black text-light text-center py-3 mt-5">
    <p class="mb-0">&copy; 2025 NovaNews. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
