<?php
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
