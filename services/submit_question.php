<?php
session_start(); // Start the session
require_once ("connection.php");

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get the user ID from the session
    $userId = $_SESSION["user_id"];

    // Get form data including module_id
    $questionText = $_POST['question_text'];
    $imgQuestion = $_FILES['imgQuestion'];
    $moduleId = $_POST['module_id']; // Get selected module_id

    // Check if all fields are filled
    if (empty($questionText) || empty($imgQuestion['name']) || empty($moduleId)) {
        $_SESSION["createQuestion_error"] = "All fields are required";
        $_SESSION["createQuestion_success"] = false;
        header("Location: /createQuestion");
        exit;
    }

    // Save image file
    $targetDirectory = "uploads/"; // Directory to save images
    // Save image file with user ID appended to the filename
    $targetFile = $targetDirectory . "_" . $userId . basename($imgQuestion["name"]);

    if (move_uploaded_file($imgQuestion["tmp_name"], $targetFile)) {
        $_SESSION["createQuestion_success"] = true;
    } else {
        $_SESSION["createQuestion_error"] = "Sorry, there was an error uploading your file.";
        $_SESSION["createQuestion_success"] = false;
        header("Location: /createQuestion");
        exit;
    }

    // Insert data into database using prepared statements to prevent SQL injection
    $sql = "INSERT INTO questions (question_text, img, user_id, module_id) VALUES (:questionText, :img, :userId, :moduleId)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':questionText', $questionText);
    $stmt->bindParam(':img', $targetFile);
    $stmt->bindParam(':userId', $userId); // Bind the user ID
    $stmt->bindParam(':moduleId', $moduleId); // Bind the module ID

    try {
        $stmt->execute();
        $_SESSION["createQuestion_success"] = true;
    } catch (PDOException $e) {
        $_SESSION["createQuestion_error"] = "Error: " . $e->getMessage();
        $_SESSION["createQuestion_success"] = false;
        header("Location: /createQuestion");
        exit;
    }

    // Close connection
    $conn = null;

    // Redirect back to the form page
    header("Location: /createQuestion");
    exit;
}
?>