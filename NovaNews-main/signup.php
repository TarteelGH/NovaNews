<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST["name"];
    $email    = $_POST["email"];
    $password = $_POST["password"];
    $role     = $_POST["role"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashedPassword', '$role')";

    if (mysqli_query($conn, $sql)) {
        if ($role == "author") {
            header("Location: author-dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

