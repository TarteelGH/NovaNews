<?php
session_start();
require('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NovaNews - Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="world-news.png" alt="Logo" style="width: 30px;">
                <span>NovaNews</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
  <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
  <li class="nav-item"><a class="nav-link" href="#Politics">Politics</a></li>
  <li class="nav-item"><a class="nav-link" href="#Economy">Economy</a></li>
  <li class="nav-item"><a class="nav-link" href="#Sports">Sports</a></li>
  <li class="nav-item"><a class="nav-link" href="#Health">Health</a></li>

  <?php if (isset($_SESSION['user_id'])): ?>
    <li class="nav-item"><a class="nav-link text-warning" href="logout.php">Logout</a></li>
  <?php else: ?>
    <li class="nav-item"><a class="nav-link text-info" href="sign.php">Login</a></li>
  <?php endif; ?>
</ul>


                <form class="d-flex ms-lg-3 mt-3 mt-lg-0" role="search">
                    <input id="searchInput" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container text-center py-5">
        <h1 class="display-4">Welcome to NovaNews</h1>
        <p class="lead">Stay updated with the latest top stories from around the world.</p>
    </div>

<?php
require 'db.php';
$mostRead = mysqli_query($conn, "SELECT * FROM articles WHERE status = 'published' ORDER BY read_count DESC LIMIT 4");
?>
<div class="container my-5">
    <h2 class="mb-4">Most Read Articles</h2>
    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($mostRead)) { ?>
            <div class="col-md-3"> 
                <div class="card h-100">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['summary']); ?></p>
                        <small class="text-muted">Reads: <?php echo $row['read_count']; ?></small>
                        <div class="d-flex mt-3">
                            <a href="article-details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">More</a>
                            <button class="btn btn-outline-danger btn-sm ms-2" onclick="likeArticle(this, <?php echo $row['id']; ?>)">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
$mostLiked = mysqli_query($conn, "SELECT * FROM articles WHERE status = 'published' ORDER BY likes_count DESC LIMIT 4");
?>
<div class="container my-5">
    <h2 class="mb-4">Most Liked Articles</h2>
    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($mostLiked)) { ?>
            <div class="col-md-3"> 
                <div class="card h-100">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['summary']); ?></p>
                        <small class="text-muted likes-count">Likes: <?php echo $row['likes_count']; ?></small>
                        <div class="d-flex mt-3">
                        <a href="article-details.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">More</a>
                        <button class="btn btn-outline-danger btn-sm ms-2" onclick="likeArticle(this, <?= $row['id'] ?>)">
                         <i class="bi bi-heart"></i>
                        </button>
                        </div>   
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
$categories = mysqli_query($conn, "SELECT * FROM category");
while ($cat = mysqli_fetch_assoc($categories)) {
    echo '<div class="container my-5" id="' . $cat['name'] . '">';
    echo '<h2 class="mb-4">' . htmlspecialchars($cat['name']) . '</h2>';
    echo '<a href="category.php?id=' . $cat['id'] . '" class="btn btn-outline-info mb-4">View All ' . htmlspecialchars($cat['name']) . ' News</a>';

    $news = mysqli_query($conn, "SELECT a.*, u.name AS author_name FROM articles a JOIN users u ON a.author_id = u.id WHERE a.category_id = " . $cat['id'] . " AND a.status = 'published' ORDER BY created_at DESC LIMIT 3");
    echo '<div class="row g-4">';
    while ($row = mysqli_fetch_assoc($news)) {
        echo '<div class="col-md-4">
                <div class="card h-100">
                    <img src="uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row['summary']) . '</p>
                        <small class="text-muted">
                            By <a href="#" class="text-info text-decoration-none">' . htmlspecialchars($row['author_name']) . '</a>
                        </small>
                        <div class="d-flex mt-3">
                            <a href="article-details.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">More</a>
                            <button class="btn btn-outline-danger btn-sm ms-2" onclick="likeArticle(this, ' . $row['id'] . ')">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
              </div>';
    }
    echo '</div></div>';
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="index.js"></script>
<div id="noResults" class="text-center text-light py-5" style="display: none;">
    No matching news found.
</div>


    </footer>

 
    <script>
function likeArticle(button, articleId) {
  fetch('update_likes.php?id=' + articleId)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        button.classList.toggle("btn-danger");
        button.classList.toggle("btn-outline-danger");
        const icon = button.querySelector("i");
        icon.classList.toggle("bi-heart");
        icon.classList.toggle("bi-heart-fill");

        const likesText = button.closest(".card-body").querySelector(".likes-count");
        if (likesText) {
          let current = parseInt(likesText.textContent.replace(/\D/g, '')) || 0;
          likesText.textContent = `Likes: ${current + 1}`;
        }
      } else {
        console.log("Failed to update like.");
      }
    })
    .catch(error => console.error('Error:', error));
}

</script>
<footer class="bg-black text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-3 mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="world-news.png" alt="Logo" style="width: 50px;">
                        <span class="fs-5 fw-bold text-light">NovaNews</span>
                    </div>
                    <p class="small">
                        Comprehensive news coverage connecting you to a diverse network of political, economic, and
                        social programs.
                    </p>

                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#politics" class="text-light text-decoration-none">Politics</a></li>
                        <li><a href="#economy" class="text-light text-decoration-none">Economy</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Arts & Culture</a></li>
                        <li><a href="#sports" class="text-light text-decoration-none">Sports</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Variety</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">About</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Who We Are</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Advertise With Us</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">Contact Us</h5>
                    <div class="d-flex justify-content-center justify-content-md-start gap-2 mt-2">
                        <a href="#"><span class="btn btn-outline-light rounded-circle px-3 py-2"><i
                                    class="bi bi-facebook"></i></span></a>
                        <a href="#"><span class="btn btn-outline-light rounded-circle px-3 py-2"><i
                                    class="bi bi-twitter"></i></span></a>
                        <a href="#"><span class="btn btn-outline-light rounded-circle px-3 py-2"><i
                                    class="bi bi-instagram"></i></span></a>
                        <a href="#"><span class="btn btn-outline-light rounded-circle px-3 py-2"><i
                                    class="bi bi-youtube"></i></span></a>
                        <a href="#"><span class="btn btn-outline-light rounded-circle px-3 py-2"><i
                                    class="bi bi-envelope"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
