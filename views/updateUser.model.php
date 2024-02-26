<button type="button" class="btn btn-warning btn-sm"
    onclick="updateUserModal(<?php echo $row['id']; ?>, '<?php echo $row['username']; ?>', '<?php echo $row['role']; ?>')">
    Update
</button>

<!-- Modal -->
<div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="../services/update_user.php" method="post">
                    <!-- Hidden input field to store the user ID -->
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group">
                        <label for="newUsername" class="col-form-label">New Username:</label>
                        <input type="text" class="form-control" id="newUsername" name="newUsername">
                    </div>
                    <div class="form-group">
                        <label for="newRole" class="col-form-label">New Role:</label>
                        <select class="form-select" id="newRole" name="newRole">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateButton">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateUserModal(userId, username, role) {
        // Fill the form fields with user data
        document.getElementById('userId').value = userId;
        document.getElementById('newUsername').value = username;
        document.getElementById('newRole').value = role;

        // Show the modal
        $('#updateModalCenter').modal('show');
    }

    // Attach click event listener to the update button
    document.getElementById('updateButton').addEventListener('click', function () {
        // Retrieve user data from form fields
        var userId = document.getElementById('userId').value;
        var newUsername = document.getElementById('newUsername').value;
        var newRole = document.getElementById('newRole').value;

        // Send AJAX request to update_user.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../services/update_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page or update the user row in the table
                    window.location.reload();
                } else {
                    // Handle update error
                    alert("Failed to update user.");
                }
            }
        };
        // Send user data as parameters
        xhr.send('userId=' + encodeURIComponent(userId) + '&newUsername=' + encodeURIComponent(newUsername) + '&newRole=' + encodeURIComponent(newRole));
    });
</script>