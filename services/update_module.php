<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "connection.php";

    // Retrieve module ID and new module name from POST data
    $moduleId = $_POST["moduleId"];
    $newModuleName = $_POST["newModuleName"];

    // Update the module name in the database
    $sql = "UPDATE modules SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql); // Use $conn instead of $pdo
    $stmt->execute([$newModuleName, $moduleId]);

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Update successful
        echo "Module name updated successfully!";
    } else {
        // Update failed
        echo "Failed to update module name.";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../index.php");
    exit();
}

