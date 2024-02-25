<?php
// Include your database connection
include("connection.php");

// Check if the user_id parameter is set and not empty
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    // Sanitize the input to prevent SQL injection
    $userId = $_POST['user_id'];
    try {
        // Delete associated records in the questions table
        $deleteQuestionsQuery = "DELETE FROM questions WHERE user_id = :user_id";
        $deleteQuestionsStatement = $conn->prepare($deleteQuestionsQuery);
        $deleteQuestionsStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteQuestionsStatement->execute();

        // Delete associated records in the answers table
        $deleteAnswersQuery = "DELETE FROM answers WHERE user_id = :user_id";
        $deleteAnswersStatement = $conn->prepare($deleteAnswersQuery);
        $deleteAnswersStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteAnswersStatement->execute();

        // Prepare and execute the DELETE query for the user
        $deleteUserQuery = "DELETE FROM users WHERE id = :user_id";
        $deleteUserStatement = $conn->prepare($deleteUserQuery);
        $deleteUserStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($deleteUserStatement->execute()) {
            // Deletion successful
            echo "User deleted successfully.";
        } else {
            // Deletion failed
            http_response_code(500);
            echo "Failed to delete user.";
        }
    } catch (PDOException $e) {
        // Handle PDO exceptions
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
} else {
    // Invalid request
    http_response_code(400);
    echo "Invalid request.";
}
