<?php
session_start(); // Start the session
require_once("connection.php");

// Check if the username, password, and confirm-password fields are provided
if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirm-password"])) {
    $_SESSION["signup_error"] = "All fields are required";
    header("Location: /"); // Redirect back to the page where the modal is displayed
    $_SESSION["signup_success"] = false;

    exit;
}

if (strlen($_POST["password"]) < 2) {
    $_SESSION["signup_error"] = "Password must be at least 2 characters";
    header("Location: /");
    $_SESSION["signup_success"] = false;

    exit;
}

if ($_POST["password"] !== $_POST["confirm-password"]) {
    $_SESSION["signup_error"] = "Passwords must match";
    header("Location: /");
    $_SESSION["signup_success"] = false;
    exit;
}

// Check if the username already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST["username"]]);
if ($stmt->fetch()) {
    $_SESSION["signup_error"] = "Username already taken";
    header("Location: /");
    $_SESSION["signup_success"] = false;
    exit;
}

// Set default role to 'user'
$role = 'user';

// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Prepare the SQL statement for user insertion
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");

if (!$stmt) {
    $_SESSION["signup_error"] = "SQL error: " . $conn->errorInfo()[2];
    header("Location: /");
    $_SESSION["signup_success"] = false;

    exit;
}

// Bind parameters
$stmt->bindParam(1, $_POST["username"]);
$stmt->bindParam(2, $password_hash);
$stmt->bindParam(3, $role);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION["signup_success"] = true;
    header("Location: /");
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    $_SESSION["signup_error"] = $errorInfo[2] . " " . $errorInfo[1];
    header("Location: /");
    exit;
}
