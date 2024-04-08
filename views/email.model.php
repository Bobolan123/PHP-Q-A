<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal">
    Open Email Form
</button>

<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalTitle">Email Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="emailForm" action="../services/send_email.php" method="post" class="h5">
                    <div class="form-group">
                        <label for="emailTitle">Title</label>
                        <input type="text" class="form-control" id="emailTitle" name="emailTitle">
                    </div>
                    <div class="form-group">
                        <label for="emailContent">Content</label>
                        <textarea class="form-control" id="emailContent" name="emailContent" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendEmailButton">Send Email</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Add an event listener to the "Send Email" button
    document.getElementById('sendEmailButton').addEventListener('click', function () {
        // Perform the action when the button is clicked
        // For example, you can submit the form
        document.querySelector('#emailForm').submit(); // This submits the form
    });
</script>