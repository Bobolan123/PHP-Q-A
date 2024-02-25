<?php
require_once("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Check if all required fields are provided
    if (isset($_POST['question_text']) && !empty($_POST['question_text']) && isset($_POST['update_question_id'])) {
        // Get the updated question text and question ID from the form
        $updated_question_text = $_POST['question_text'];
        $update_question_id = $_POST['update_question_id'];

        // Check if an image file is uploaded
        if (isset($_FILES['imgQuestion']) && $_FILES['imgQuestion']['error'] === UPLOAD_ERR_OK) {
            // Upload the image file
            $imgQuestion = $_FILES['imgQuestion'];
            $imgName = $imgQuestion['name'];
            $imgTmpName = $imgQuestion['tmp_name'];
            $imgError = $imgQuestion['error'];

            // Move the uploaded image file to the target directory
            $targetDir = "uploads/";
            $targetFilePath = $targetDir . basename($imgName);
            move_uploaded_file($imgTmpName, $targetFilePath);

            // Update the question text and image in the database
            $sql = "UPDATE questions SET question_text = :question_text, img = :img WHERE id = :update_question_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':question_text', $updated_question_text);
            $stmt->bindParam(':img', $targetFilePath);
            $stmt->bindParam(':update_question_id', $update_question_id);
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                header("Location: /questions");
            exit();
            } else {
                echo "Failed to update question.";
            }
        } else {
            // Update only the question text without changing the image
            $sql = "UPDATE questions SET question_text = :question_text WHERE id = :update_question_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':question_text', $updated_question_text);
            $stmt->bindParam(':update_question_id', $update_question_id);
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                echo "Question text updated successfully.";
            } else {
                echo "Failed to update question text.";
            }
        }
    } else {
        echo "Question text is required.";
    }
}

