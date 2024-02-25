<?php
// Include your database connection file
include("connection.php");

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user ID, new username, and new role from the POST data
    $userId = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newRole = $_POST['newRole'];

    // Prepare and execute the SQL UPDATE statement
    $query = "UPDATE users SET username = :newUsername, role = :newRole WHERE id = :userId";
    $statement = $conn->prepare($query);
    $statement->bindValue(':newUsername', $newUsername);
    $statement->bindValue(':newRole', $newRole);
    $statement->bindValue(':userId', $userId);
    $result = $statement->execute();
} else {
    // Send an error response if the form data was not submitted properly
    echo json_encode(array("message" => "Form data not submitted."));
}
