<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT id, password FROM users");

while ($user = mysqli_fetch_assoc($result)) {
    $id = $user['id'];
    $plain = $user['password'];

    // إذا الباسورد مش مشفّر (عادة أقل من 60 حرف)
    if (strlen($plain) < 60) {
        $hashed = password_hash($plain, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password = '$hashed' WHERE id = $id";
        mysqli_query($conn, $update);
        echo "🔒 Password for user ID $id hashed successfully.<br>";
    } else {
        echo "✅ User ID $id already has hashed password.<br>";
    }
}
?>
