<?php
// Include connection file
require_once("connection.php");
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the answer is provided
    if (isset($_POST['answer']) && !empty($_POST['answer'])) {
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Get the logged-in user's ID from the session
            $user_id = $_SESSION['user_id'];

            // Get the answer text from the form
            $answer_text = $_POST['answer'];

            // Get the question ID from the form
            $question_id = $_POST['question_id'];

            // Insert the answer into the answers table
            $stmt = $conn->prepare("INSERT INTO answers (answer_text, user_id) VALUES (:answer_text, :user_id)");
            $stmt->bindParam(':answer_text', $answer_text);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Retrieve the ID of the inserted answer
            $answer_id = $conn->lastInsertId();

            // Check if the answer is successfully inserted
            if ($stmt->rowCount() > 0) {
                // Insert into the question_answer table
                $stmt = $conn->prepare("INSERT INTO question_answer (question_id, answer_id) VALUES (:question_id, :answer_id)");
                $stmt->bindParam(':question_id', $question_id);
                $stmt->bindParam(':answer_id', $answer_id);
                $stmt->execute();

                // Redirect back to the original page
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Failed to redirect.</div>";
                }
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Failed to submit answer.</div>";
            }
        } else {
            // Display an error message if the user is not logged in
            echo "<div class='alert alert-danger' role='alert'>You must be logged in to submit an answer.</div>";
        }
    } else {
        // Display an error message if the answer is not provided
        echo "<div class='alert alert-danger' role='alert'>Answer is required.</div>";
    }
}
