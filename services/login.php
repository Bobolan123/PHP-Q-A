<?php
session_start();

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("connection.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement to select user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["login_success"] = true;
            // Redirect to the homepage
            header("Location: /");
            exit;
        } else {
            $is_invalid = true;
        }
    } else {
        $is_invalid = true;
    }

    if ($is_invalid) {
        $_SESSION["login_success"] = false;
        // Redirect back to login page
        header("Location: /");
        exit;
    }
}
