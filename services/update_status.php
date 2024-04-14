<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "connection.php";

    // Retrieve status ID and new status name from POST data
    $statusId = $_POST["statusId"];
    $newStatusName = $_POST["newStatusName"];

    // Update the status name in the database
    $sql = "UPDATE questions SET status_question = ? WHERE id = ?";
    $stmt = $conn->prepare($sql); // Use $conn instead of $pdo
    $stmt->execute([$newStatusName, $statusId]);

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Update successful
        echo "status name updated successfully!";
    } else {
        // Update failed
        echo "Failed to update status name.";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../index.php");
    exit();
}

