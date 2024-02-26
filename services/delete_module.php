<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "connection.php";

    // Retrieve module ID from POST data
    $moduleId = $_POST["moduleId"];

    try {
        // Begin a transaction
        $conn->beginTransaction();

        // Delete associated questions first
        $deleteQuestionsSql = "DELETE FROM questions WHERE module_id = ?";
        $stmt = $conn->prepare($deleteQuestionsSql);
        $stmt->execute([$moduleId]);

        // Then delete the module
        $deleteModuleSql = "DELETE FROM modules WHERE id = ?";
        $stmt = $conn->prepare($deleteModuleSql);
        $stmt->execute([$moduleId]);

        // Commit the transaction
        $conn->commit();

        // Return success message
        echo "Module and associated questions deleted successfully!";
    } catch (PDOException $e) {
        // Rollback the transaction in case of any errors
        $conn->rollBack();
        // Return error message
        echo "Failed to delete module: " . $e->getMessage();
    }
} else {
    // Redirect if accessed directly
    header("Location: ../index.php");
    exit();
}

