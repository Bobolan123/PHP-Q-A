<?php
require_once("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer']) && !empty($_POST['answer'])) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $answer_text = $_POST['answer'];
            $question_id = $_POST['question_id'];

            try {
                // Insert the answer into the answers table
                $stmt = $conn->prepare("INSERT INTO answers (answer_text, user_id, question_id) VALUES (:answer_text, :user_id, :question_id)");
                $stmt->bindParam(':answer_text', $answer_text);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':question_id', $question_id);
                $stmt->execute();

                // Redirect back to the original page
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Failed to redirect.</div>";
                }
                exit();
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>You must be logged in to submit an answer.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Answer is required.</div>";
    }
}
