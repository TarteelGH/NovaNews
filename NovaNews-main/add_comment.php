<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = isset($_POST['article_id']) ? intval($_POST['article_id']) : 0;
    $user_name = isset($_POST['user_name']) ? mysqli_real_escape_string($conn, $_POST['user_name']) : '';
    $comment_text = isset($_POST['comment_text']) ? mysqli_real_escape_string($conn, $_POST['comment_text']) : '';

    if ($article_id > 0 && !empty($user_name) && !empty($comment_text)) {
        $query = "INSERT INTO comments (article_id, user_name, comment_text) VALUES ('$article_id', '$user_name', '$comment_text')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: article-details.php?id=$article_id");
            exit();
        } else {
            echo "Error adding comment: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>