<button type="button" class="btn btn-primary btn-sm" onclick="createModuleModal()">
    Create Module
</button>

<!-- Create Module Modal -->
<div class="modal fade" id="createModalCenter" tabindex="-1" role="dialog" aria-labelledby="createModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Module</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" action="../services/create_module.php" method="post">
                    <div class="form-group">
                        <label for="moduleName" class="col-form-label">Module Name:</label>
                        <input type="text" class="form-control" id="moduleName" name="moduleName">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createButton">Create</button>
            </div>
        </div>
    </div>
</div>

<script>
    function createModuleModal() {
        // Clear any previous input value
        document.getElementById('moduleName').value = '';

        // Show the modal
        $('#createModalCenter').modal('show');
    }

    // Attach click event listener to the create button
    document.getElementById('createButton').addEventListener('click', function () {
        // Retrieve module name from form field
        var moduleName = document.getElementById('moduleName').value;

        // Send AJAX request to create_module.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../services/create_module.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page after successful creation
                    window.location.reload();
                } else {
                    // Handle creation error
                    alert("Failed to create module.");
                }
            }
        };
        // Send module name as parameter
        xhr.send('moduleName=' + encodeURIComponent(moduleName));
    });
</script>
