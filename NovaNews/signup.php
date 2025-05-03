<?php
//echo "User registered successfully!";
session_start();
require_once ('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $role = $_POST["role"];

  $sql = "INSERT INTO user (name, email, password, role)
          VALUES ('$name', '$email', '$password', '$role')";

  if (mysqli_query($conn, $sql)) {
    echo "User registered successfully!";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
exit();
?>
