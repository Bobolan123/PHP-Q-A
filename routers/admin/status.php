<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2 class="">Questions:</h2>
        <div>
            <?php
            include ("C:\\xampp\\htdocs\\Final_project\\views\\create_module.php");
            ?>
            <a href="/admin/module" class="btn btn-primary"><-- Module </a>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Question Text</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include connection file
            require_once ("connection.php");

            // Fetch data from modules table
            $query = "SELECT id, question_text, status_question FROM questions";
            $statement = $conn->query($query);

            // Loop through each row and generate table rows
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id'] . "</th>";
                echo "<td>" . $row['question_text'] . "</td>";
                echo "<td>" . $row['status_question'] . "</td>";
                echo "<td>";
                // Add buttons for update and delete actions
                include ("C:\\xampp\\htdocs\\Final_project\\views\\updateQuestionStatus.php");
                // Add onclick event to call JavaScript function for delete confirmation
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

