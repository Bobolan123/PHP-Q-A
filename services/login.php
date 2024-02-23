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
        } else {
            $is_invalid = true;
        }
    } else {
        $is_invalid = true;
    }

    // Redirect after setting session or if login is invalid
    if (!$is_invalid && isset($_SESSION["user_id"])) {
        header("Location: /");
        exit;
    } else {
        header("Location: /questions");
    }
}

