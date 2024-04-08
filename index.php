<?php
session_start();

include ('header.php');
require ("./views/navbar.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<script>console.log('Connected DB successfully' );</script>";

} catch (PDOException $e) {
    echo "<script>console.log('Connection failed: ' );</script>" . $e->getMessage();
}

$url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '/';
$parts = parse_url($url);
$path = $parts['path'];
$queryParams = [];
if (isset($parts['query'])) {
    parse_str($parts['query'], $queryParams);
}

// Fetch user role based on user ID from session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userRole = $user['role'];
}

switch ($path) {
    case '/':
        // Handle request for the home page
        include './routers/home.php';
        break;
    case '/admin':
        // Check if the user is logged in and has admin role
        if (!isset($_SESSION['user_id']) || $userRole !== 'admin') {
            // Redirect or show unauthorized message
            ?>
            <div class="container">
                You need to login to create question
            </div>
            <?php

            exit();
        }
        // Include logic for admin dashboard
        include './routers/admin.php';
        break;
    case '/admin/module':
        // Check if the user is logged in and has admin role
        if (!isset($_SESSION['user_id']) || $userRole !== 'admin') {
            // Redirect or show unauthorized message
            ?>
            <div class="container">
                You need to login to create question
            </div>
            <?php
            exit();
        }
        // Include logic for admin module
        include './routers/admin/module.php';
        break;
    case '/questions':
        // Check if the question_id is provided in the query parameters
        if (isset($queryParams['question_id'])) {
            // Include logic to fetch a specific question based on the question_id
            include './routers/questionid.php';
        } elseif (isset($queryParams['update_question_id'])) {
            include './routers/update-question.php';
        } else {
            // Include logic to fetch all questions
            include './routers/questions.php';
        }
        break;
    case '/createQuestion':
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5>You need to login to create question</h5>
            </div>
            <?php
            exit(); // Stop further execution
        }
        // Include logic to create a question
        include './routers/createQuestion.php';
        break;
    // Add more routes as needed
    default:
        // Handle 404 Not Found error
        include './routers/404.php';
        break;
}

include ('footer.php');
$conn = null;
?>