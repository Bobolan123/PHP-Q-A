<?php
require_once("connection.php");


if (empty($_POST["username"])) {
    die("Username is required");
}

if (strlen($_POST["password"]) < 2) {
    die("Password must be at least 2 characters");
}

if ($_POST["password"] !== $_POST["confirm-password"]) {
    die("Passwords must match");
}

// Check if the username already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST["username"]]);
if ($stmt->fetch()) {
    die("Username already taken");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

if (!$stmt) {
    die("SQL error: " . $conn->errorInfo()[2]);
}

// Bind parameters
$stmt->bindParam(1, $_POST["username"]);
$stmt->bindParam(2, $password_hash);

// Execute the statement
if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    die($errorInfo[2] . " " . $errorInfo[1]);
}

