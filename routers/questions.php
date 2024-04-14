<?php
require_once ("connection.php"); ?>
<div class="container">
    <div class="col-12 rounded mb-3">
        <div class="row">
            <div class="col-11">
                <input type="text" id="searchInput" class="form-control p-3" aria-label="Default"
                    aria-describedby="inputGroup-sizing-default" placeholder="Enter your questions" list="output">
                <datalist id="output">
                    <option value="what is data" data-id="1"></option>
                    <option value="what is dom" data-id="2"></option>
                </datalist>
            </div>
            <div class="col-1">
                <button type="button" id="submitButton" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
    <?php
    require_once ("connection.php");

    // Query execution with JOIN to include module name
    $sql = "SELECT q.id, q.question_text, q.img, q.user_id, u.username, m.name AS module_name, COUNT(a.id) AS comment_count
            FROM questions q
            INNER JOIN users u ON q.user_id = u.id
            LEFT JOIN answers a ON q.id = a.question_id
            LEFT JOIN modules m ON q.module_id = m.id
            GROUP BY q.id";
    $stmt = $conn->query($sql);

    // Display results
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col-12 rounded">
                <div class="mb-3 bg-white rounded p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="fs-5 fw-bold mb-1">Name:
                            <?php echo $row['username']; ?>
                        </p>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown">
                            </button>
                            <ul class="dropdown-menu ">
                                <li><button class="dropdown-item update-btn" data-question-id="<?php echo $row['id']; ?>"
                                        data-user-id="<?php echo $row['user_id']; ?>" id="updateBtn">Update</button></li>
                                <li><button class="dropdown-item delete-btn" data-question-id="<?php echo $row['id']; ?>"
                                        data-user-id="<?php echo $row['user_id']; ?>">Delete</button></li>
                            </ul>
                        </div>
                    </div>

                    <h3>
                        <?php echo $row['question_text']; ?>
                    </h3>
                    <p class="text-success">
                        Module:
                        <?php echo $row['module_name']; ?> <!-- Displaying module name -->
                    </p>
                    <!-- Display number of comments -->
                    <a href="http://localhost:8000/questions?question_id=<?php echo $row['id']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat"
                            viewBox="0 0 16 16">
                            <path
                                d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                        </svg>
                        <?php echo $row['comment_count']; ?> Comments
                    </a>

                    <div class="text-center"> <!-- Aligning image to center -->
                        <?php if (!empty($row['img'])) { ?>
                            <img src="../services/<?php echo $row['img']; ?>" alt="" class="img-fluid"
                                style="max-width: 800px; max-height: 800px; width:100%;">
                        <?php } ?>
                    </div>

                    <!-- Form for submitting answers -->
                    <form method="post" action="../services/submit_answer.php"> <!-- Changed action to submit_answer.php -->
                        <input type="hidden" name="question_id" value="<?php echo $row['id']; ?>">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control m-2" placeholder="Answer" aria-label="Username"
                                aria-describedby="basic-addon1" name="answer">
                            <button type="submit" class="btn btn-primary m-2">Comment</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No questions found";
    }
    ?>
</div>


<script>
    // Add event listener to delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const questionId = button.getAttribute('data-question-id');

            // Fetch the user ID from the session
            const userId = <?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "null"; ?>;

            // Fetch the user ID associated with the question
            const questionUserId = button.getAttribute('data-user-id');

            // Check if the user ID matches the user who posted the question
            if (userId == questionUserId) { // using == for loose comparison
                const confirmDelete = confirm('Are you sure you want to delete this question?');
                if (confirmDelete) {
                    // Submit the form to delete the question
                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = '../services/delete_question.php';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_question_id';
                    input.value = questionId;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            } else {
                alert("You're not allowed to delete this question");
            }

        });
    });
</script>

<script>
    // Add event listener to update buttons
    const updateButtons = document.querySelectorAll('.update-btn');
    updateButtons.forEach(button => {
        button.addEventListener('click', () => {
            const questionId = button.getAttribute('data-question-id');

            // Fetch the user ID from the session
            const userId = <?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "null"; ?>;

            // Fetch the user ID associated with the question
            const questionUserId = button.getAttribute('data-user-id');

            // Check if the user ID matches the user who posted the question
            if (userId == questionUserId) { // using == for loose comparison
                // Redirect to the update page with the question ID parameter
                window.location.href = 'http://localhost:8000/questions?update_question_id=' + questionId;
            } else {
                alert("You're not allowed to update this question.");
            }

        });
    });
</script>

<script>
    document.getElementById('submitButton').addEventListener('click', function () {
        // Get the value and data-id attribute of the selected option
        var selectedOption = document.querySelector('#output option[value="' + document.getElementById('searchInput').value + '"]');
        if (selectedOption) {
            var questionId = selectedOption.getAttribute('data-id');
            // Redirect to the questions page with the question_id parameter
            window.location.href = 'http://localhost:8000/questions?question_id=' + questionId;
        } else {
            // alert('Please select a question from the list.');
            Swal.fire({
                icon: 'error',
                title: 'Type something',
                text: "Find the question's title",
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#searchInput").on('input', function () {
            var searchQuery = $(this).val();
            if (searchQuery !== "") {
                $.ajax({
                    type: 'POST',
                    url: 'search.php',
                    data: {
                        name: searchQuery
                    },
                    success: function (data) {
                        $("#output").html(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            } else {
                $("#output").html("");
            }
        });
    });
</script>