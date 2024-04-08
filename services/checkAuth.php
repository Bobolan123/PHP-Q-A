<?php
// Assuming you have a database connection established
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: http://localhost:8000/");
    exit();
}

// Retrieve the role of the logged-in user
$query = "SELECT role FROM users WHERE id = :user_id";
$statement = $conn->prepare($query);
$statement->bindParam(':user_id', $_SESSION["user_id"]);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the user has the 'admin' role
if ($user['role'] !== 'admin') {
    header("Location: http://localhost:8000/"); // Redirect to homepage
    exit();
}
