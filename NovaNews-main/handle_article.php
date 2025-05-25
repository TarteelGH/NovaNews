<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location:  sign.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        mysqli_query($conn, "UPDATE articles SET status = 'published' WHERE id = $id");
        header("Location: admin-dashboard.php?action=approved");
    } elseif ($action === 'delete') {
        mysqli_query($conn, "DELETE FROM articles WHERE id = $id");
        header("Location: admin-dashboard.php?action=deleted");
    } else {
        header("Location: admin-dashboard.php");
    }
}
?>
