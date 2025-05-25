<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: sign.php");
    exit();
}

$msg = '';
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'approved') {
        $msg = '<div class="alert alert-success">✅ Article approved and published successfully.</div>';
    } elseif ($_GET['action'] == 'deleted') {
        $msg = '<div class="alert alert-danger">❌ Article deleted.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NovaNews | Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0a101c;
      color: white;
    }
    .dashboard {
      max-width: 900px;
      margin: 60px auto;
    }
    .card {
      background-color: #121c2c;
      border: none;
    }
    .card-title, .btn {
      color: white;
    }
    .btn-approve {
      background-color: #198754;
      border: none;
    }
    .btn-reject {
      background-color: #dc3545;
      border: none;
    }
    .alert {
      border: none;
    }
  </style>
</head>
<body>
  <div class="container dashboard">
    <h1 class="text-center mb-4">Admin Dashboard</h1>
    <?= $msg ?>

    <h4>Pending Articles</h4>
    <div class="row g-4">
      <?php
      $result = mysqli_query($conn, "SELECT a.*, u.name AS author_name 
                                     FROM articles a 
                                     JOIN users u ON a.author_id = u.id 
                                     WHERE status = 'unpublished' 
                                     ORDER BY created_at DESC");

      while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="col-md-6">
                  <div class="card p-3 h-100">
                      <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                      <p class="card-text">' . htmlspecialchars($row['summary']) . '</p>
                      <p class="small text-muted">By: ' . htmlspecialchars($row['author_name']) . '</p>
                      <div class="d-flex justify-content-between">
                          <a href="handle_article.php?id=' . $row['id'] . '&action=approve" class="btn btn-approve btn-sm">✔️ Approve</a>
                          <a href="handle_article.php?id=' . $row['id'] . '&action=delete" class="btn btn-reject btn-sm">✖️ Reject</a>
                      </div>
                  </div>
                </div>';
      }
      ?>
    </div>
  </div>
</body>
</html>
