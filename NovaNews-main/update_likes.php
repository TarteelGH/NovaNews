<?php
include 'db.php';

if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']);

    $update = mysqli_query($conn, "UPDATE articles SET likes_count = likes_count + 1 WHERE id = $article_id");

    if ($update) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No ID provided"]);
}
?>
