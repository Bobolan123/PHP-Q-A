<?php
// Include connection file
require_once("connection.php");

// Check if the delete_question_id is provided
if(isset($_POST['delete_question_id'])) {
    // Get the question ID to delete
    $question_id = $_POST['delete_question_id'];

    try {
        // First, delete related records from question_answer table
        $stmt = $conn->prepare("DELETE FROM question_answer WHERE question_id = :question_id");
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();

        // Then, delete the question itself
        $stmt = $conn->prepare("DELETE FROM questions WHERE id = :question_id");
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();

        // Check if the question is successfully deleted
        if($stmt->rowCount() > 0) {
            // Redirect back to the questions page after successful deletion
            header("Location: /questions");
            exit();
        } else {
            // If the question is not found, display an error message
            echo "Question not found.";
        }
    } catch(PDOException $e) {
        // If an error occurs, display the error message
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the delete_question_id is not provided, display an error message
    echo "Question ID is missing.";
}
