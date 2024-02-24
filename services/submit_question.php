<?php
session_start(); // Start the session
// Check if form is submitted
if (isset($_POST['submit'])) {
    require_once("connection.php");

    // Get the user ID from the session
    $userId = $_SESSION["user_id"];

    // Get form data
    $questionText = $_POST['question_text'];
    $imgQuestion = $_FILES['imgQuestion'];

    // Save image file
    $targetDirectory = "uploads/"; // Directory to save images
    // Save image file with user ID appended to the filename
    $targetFile = $targetDirectory . "_" . $userId. basename($imgQuestion["name"]) ;

    if (move_uploaded_file($imgQuestion["tmp_name"], $targetFile)) {
        echo "The file " . htmlspecialchars(basename($imgQuestion["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Insert data into database using prepared statements to prevent SQL injection
    $sql = "INSERT INTO questions (question_text, img, user_id) VALUES (:questionText, :img, :userId)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':questionText', $questionText);
    $stmt->bindParam(':img', $targetFile);
    $stmt->bindParam(':userId', $userId); // Bind the user ID

    try {
        $stmt->execute();
        echo "New record created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
}
