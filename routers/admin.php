<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-3">Admin Dashboard:</h1>
        <a href="admin/module" class="btn btn-primary">Module --></a>
    </div>

    <table class="table table-hover">
        <thead class="bg-primary">
            <tr>
                <th scope="col">id</th>
                <th scope="col">username</th>
                <th scope="col">role</th>
                <th scope="col">Post's Number</th>
                <th scope="col">Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have a database connection established
            include ("connection.php");

            // Fetch users and count their posts from the database
            $query = "SELECT u.id, u.username, u.role, COUNT(q.id) AS post_count
                      FROM users u
                      LEFT JOIN questions q ON u.id = q.user_id
                      GROUP BY u.id";
            $statement = $conn->query($query);

            // Loop through the users and generate table rows
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id'] . "</th>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>" . $row['post_count'] . "</td>";
                echo "<td>";
                // Include the modal for updating user information
                include ("C:\\xampp\\htdocs\\Final_project\\views\\updateUser.model.php");
                // Add a delete button for each user
                echo "<button type='button' class='btn btn-danger btn-sm' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            // Send an AJAX request to delete the user
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../services/delete_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Reload the page after successful deletion
                        window.location.reload();
                    } else {
                        // Handle deletion error
                        alert("Failed to delete user.");
                    }
                }
            };
            xhr.send('user_id=' + userId);
        }
    }
</script>