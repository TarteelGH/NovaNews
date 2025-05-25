<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email    = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
      $_SESSION["user_id"]   = $user["id"];
      $_SESSION["user_name"] = $user["name"];
      $_SESSION["user_role"] = $user["role"];

  

      if ($user["role"] === "admin") {
    header("Location: admin-dashboard.php");
} elseif ($user["role"] === "author") {
    header("Location: author-dashboard.php");
} else {
    header("Location: index.php"); // للقارئ
}

      exit;
    } else {
      echo "❌ Incorrect password.";
    }
  } else {
    echo "❌ Email not found.";
  }

  $stmt->close();
  $conn->close();
}
?>