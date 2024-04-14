<?php
require_once ("connection.php");

$searchTerm = $_POST['name'];

try {
        $sql = "SELECT * FROM questions WHERE question_text LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$searchTerm%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
                foreach ($results as $row) {
                        $question_text = htmlspecialchars($row['question_text']); // Sanitize output
                        echo "<option value='" . $question_text . "' data-id = " . $row['id'] . ">" . "</option>";
                }
        } else {
                echo "<option>No results found</option>";
        }
} catch (PDOException $e) {
        echo "<option>Error: " . $e->getMessage() . "</option>";
}

