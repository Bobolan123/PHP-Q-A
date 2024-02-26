<?php
session_start(); // Start session before any output

include('header.php');
require("./views/navbar.php");

$url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '/';
$parts = parse_url($url);
$path = $parts['path'];
$queryParams = [];
if (isset($parts['query'])) {
    parse_str($parts['query'], $queryParams);
}

switch ($path) {
    case '/':
        // Handle request for the home page
        include './routers/home.php';
        break;
    case '/admin':
        // Handle request for the home page
        include './routers/admin.php';
        break;
    case '/admin/user':
        // Handle request for the home page
        include './routers/admin/user.php';
        break;
    case '/admin/module':
        // Handle request for the home page
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

include('footer.php');
$pdo = null;
?>