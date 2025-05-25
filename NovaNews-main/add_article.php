<?php
session_start();
include('db.php');

// تحقق من صلاحية الدخول
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'author') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title     = $_POST["title"];
    $subtitle  = $_POST["subtitle"];
    $category  = $_POST["category"];
    $content   = $_POST["content"];
    $image     = $_POST["image"];
    $author_id = $_SESSION['user_id'];

    // توليد الملخص من أول 20 كلمة
    $summary = implode(" ", array_slice(explode(" ", strip_tags($content)), 0, 20)) . "...";

    $status = "unpublished";

    // إضافة subtitle لجملة الإدخال
    $sql = "INSERT INTO articles (title, subtitle, summary, content, image, category_id, author_id, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssis", $title, $subtitle, $summary, $content, $image, $category, $author_id, $status);

    if ($stmt->execute()) {
        header("Location: author-dashboard.php?success=1");
        exit();
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
