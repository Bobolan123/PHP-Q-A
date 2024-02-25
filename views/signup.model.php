<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#signUpModal">
    Sign up
</button>

<!-- Modal -->
<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../services/process-signup.php" method="post">
                    <div class="form-group">
                        <label for="username" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password" class="col-form-label" name="confirm-password">Confirm
                            Password:</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="signupButton">Sign up</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Add an event listener to the "Sign up" button
    document.getElementById('signupButton').addEventListener('click', function () {
        // Perform the action when the button is clicked
        // For example, you can submit the form
        document.querySelector('#signUpModal form').submit(); // This submits the form
    });
</script>