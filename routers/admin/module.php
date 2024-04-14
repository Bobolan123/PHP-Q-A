<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2 class="">Module:</h2>
        <div>
            <?php
            include ("C:\\xampp\\htdocs\\Final_project\\views\\create_module.php");
            ?>
            <a href="/admin" class="btn btn-primary"><-- Users </a>
            <a href="/admin/status" class="btn btn-primary"> Questions --> </a>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include connection file
            require_once ("connection.php");

            // Fetch data from modules table
            $query = "SELECT id, name FROM modules";
            $statement = $conn->query($query);

            // Loop through each row and generate table rows
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id'] . "</th>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>";
                // Add buttons for update and delete actions
                include ("C:\\xampp\\htdocs\\Final_project\\views\\updateModule.module.php");
                // Add onclick event to call JavaScript function for delete confirmation
                echo "<button type='button' class='btn btn-danger btn-sm' onclick='deleteModule(" . $row['id'] . ", \"" . $row['name'] . "\")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- JavaScript code for module deletion confirmation -->
<script>
    function deleteModule(moduleId, moduleName) {
        // Confirm deletion of associated questions
        if (confirm("Are you sure you want to delete module '" + moduleName + "' and its associated questions?")) {
            // Send AJAX request to delete_module.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../services/delete_module.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Reload the page after successful deletion
                        window.location.reload();
                    } else {
                        // Handle deletion error
                        alert("Failed to delete module.");
                    }
                }
            };
            // Send module ID as parameter
            xhr.send('moduleId=' + encodeURIComponent(moduleId));
        }
    }
</script>