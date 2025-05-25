<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'author') {
    header("Location: sign.php");
    exit();
}

$author_id = $_SESSION['user_id'];
$author_name = $_SESSION['user_name'];

$msg = '';
if (isset($_GET['success'])) {
    $msg = '<div class="alert alert-success">✅ Article submitted and is awaiting admin approval.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NovaNews | Author Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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

        .card-title,
        .btn {
            color: white;
        }

        .btn-add {
            background-color: #0dcaf0;
            color: black;
        }

        .alert {
            background-color: #198754;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container dashboard">
        <h1 class="text-center mb-4">Welcome, <span class="text-info"><?= htmlspecialchars($author_name) ?></span></h1>

        <?= $msg ?>

        <!-- Add New Article -->
        <div class="mb-4">
            <h4>Add New Article</h4>
            <form action="add_article.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" required>
                        <option value="1">Politics</option>
                        <option value="2">Economy</option>
                        <option value="3">Sports</option>
                        <option value="4">Health</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Choose an Image</label>
                    <select class="form-select" name="image" required>
                        <?php
                        $images = glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                        foreach ($images as $img) {
                            $imgName = basename($img);
                            echo "<option value='$imgName'>$imgName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
    <label class="form-label">Subtitle</label>
    <input type="text" class="form-control" name="subtitle" required>
</div>


                <div class="mb-3">
                    <label class="form-label">Article Content</label>
                    <textarea class="form-control" name="content" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-add">Publish</button>
            </form>
        </div>

        <!-- List of Existing Articles -->
        <hr class="my-4">
        <h4>Your Articles</h4>
        <div class="row g-4">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM articles WHERE author_id = $author_id ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-6">
                        <div class="card p-3 h-100">
                            <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                            <p class="card-text">' . htmlspecialchars($row['summary']) . '</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Status: ' . htmlspecialchars($row['status']) . '</span>
                                <a href="#" class="btn btn-outline-info btn-sm">Edit</a>
                            </div>
                        </div>
                      </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>
