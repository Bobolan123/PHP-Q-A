<?php
session_start(); // Start session before any output

include('header.php');
require("./views/navbar.php");


$url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '/';

switch ($url) {
    case '/':
        // Handle request for the home page
        include './routers/home.php';
        break;
    case '/questions':
        // Include logic to fetch questions
        include './routers/questions.php';
        break;
    // Add more routes as needed
    default:
        // Handle 404 Not Found error
        include './routers/404.php';
        break;
}

include('footer.php');
$pdo = null;
