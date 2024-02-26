<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once "connection.php";

    // Retrieve module name from POST data
    $moduleName = $_POST["moduleName"];

    try {
        // Prepare SQL statement to insert new module
        $sql = "INSERT INTO modules (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters and execute the statement
        $stmt->execute([$moduleName]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            // Module creation successful
            echo "Module created successfully!";
        } else {
            // Module creation failed
            echo "Failed to create module.";
        }
    } catch (PDOException $e) {
        // Error occurred, display error message
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect if accessed directly
    header("Location: ../index.php");
    exit();
}
