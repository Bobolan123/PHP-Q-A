<button type="button" class="btn btn-warning btn-sm"
    onclick="updateModuleModal(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>')">
    Update
</button>

<!-- Modal -->
<div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Module</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="../services/update_module.php" method="post">
                    <!-- Hidden input field to store the module ID -->
                    <input type="hidden" id="moduleId" name="moduleId">
                    <div class="form-group">
                        <label for="newModuleName" class="col-form-label">New Module Name:</label>
                        <input type="text" class="form-control" id="newModuleName" name="newModuleName">
                        
                    </div>
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
    function updateModuleModal(moduleId, moduleName) {
        // Fill the form fields with module data
        document.getElementById('moduleId').value = moduleId;
        document.getElementById('newModuleName').value = moduleName;

        // Show the modal
        $('#updateModalCenter').modal('show');
    }

    // Attach click event listener to the update button
    document.getElementById('updateButton').addEventListener('click', function () {
        // Retrieve module data from form fields
        var moduleId = document.getElementById('moduleId').value;
        var newModuleName = document.getElementById('newModuleName').value;

        // Send AJAX request to update_module.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../services/update_module.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page or update the module row in the table
                    window.location.reload();
                } else {
                    // Handle update error
                    alert("Failed to update module.");
                }
            }
        };
        // Send module data as parameters
        xhr.send('moduleId=' + encodeURIComponent(moduleId) + '&newModuleName=' + encodeURIComponent(newModuleName));
    });
</script>
