<button type="button" class="btn btn-warning btn-sm"
    onclick="updateStatusModal(<?php echo $row['id']; ?>, '<?php echo $row['status_question']; ?>')">
    Update
</button>

<!-- Modal -->
<div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="../services/update_status.php" method="post">
                    <!-- Hidden input field to store the status ID -->
                    <input type="hidden" id="statusId" name="statusId">
                    <div class="form-group">
                        <label for="newStatusName" class="col-form-label">New Status:</label>
                        <select class="form-select" aria-label="Default select example" class="form-control"
                            id="newStatusName" name="newStatusName">
                            <option value="1">Approved</option>
                            <option value="0">Pending</option>
                        </select>
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
    function updateStatusModal(statusId, statusName) {
        // Fill the form fields with status data
        document.getElementById('statusId').value = statusId;
        document.getElementById('newStatusName').value = statusName;

        // Show the modal
        $('#updateModalCenter').modal('show');
    }

    // Attach click event listener to the update button
    document.getElementById('updateButton').addEventListener('click', function () {
        // Retrieve status data from form fields
        var statusId = document.getElementById('statusId').value;
        var newStatusName = document.getElementById('newStatusName').value;

        // Send AJAX request to update_status.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../services/update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page or update the status row in the table
                    window.location.reload();
                } else {
                    // Handle update error
                    alert("Failed to update status.");
                }
            }
        };
        // Send status data as parameters
        xhr.send('statusId=' + encodeURIComponent(statusId) + '&newStatusName=' + encodeURIComponent(newStatusName));
    });
</script>