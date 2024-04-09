<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Login
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Log In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="../services/login.php" method="post">
                    <div class="form-group">
                        <label for="username" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="loginButton">Login</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Add an event listener to the "Login" button
    document.getElementById('loginButton').addEventListener('click', function () {
        // Perform the action when the button is clicked
        // For example, you can submit the form
        document.querySelector('#loginForm').submit(); // This submits the form
    });

    // Check if there is a session variable indicating login success
    <?php if (isset($_SESSION["login_success"])): ?>
        <?php if ($_SESSION["login_success"] === true): ?>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'You have successfully logged in!',
            });
        <?php else: ?>
            Swal.fire({
                // position: "top-end",
                icon: 'error',
                showConfirmButton: false,
                title: 'Login Failed',
                text: 'Invalid username or password. Please try again.',
                timer: 2000,
                // backdrop: false,
            });
        <?php endif; ?>
        <?php unset($_SESSION["login_success"]); ?> // Unset the session variable after displaying the SweetAlert
    <?php endif; ?>
</script>