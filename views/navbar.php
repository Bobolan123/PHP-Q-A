<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Question-Answer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse container-fluid" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                <a class="nav-link active" aria-current="page" href="/questions">Questions</a>
            </div>
            <div class="navbar-nav">
                <?php
                if (isset($_SESSION["user_id"])) {
                    echo '
                    
                <div class="dropdown mr-5">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle" style="width: 25px; height: 25px;"
                            src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg" alt="">
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Link 1</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                        <li><a class="dropdown-item" href="#">Link 3</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item" id="logoutBtn">Log Out</button></li>
                        </ul>
                </div>    
                          ';

                } else {
                    echo '<div class="mr-1">';
                    include './views/login.model.php';
                    echo '</div>';
                    include './views/signup.model.php';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById("logoutBtn").addEventListener("click", function() {
    // Send AJAX request to logout.php
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../services/logout.php", true);
    xhr.onload = function() {
        // Reload the page after logout
        if (xhr.status === 200) {
            window.location.reload();
        } else {
            console.log("Error occurred while logging out.");
        }
    };
    xhr.send();
});
</script>
