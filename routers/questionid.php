<div class="container">
    <?php
    require_once ("connection.php");

    // Check if the question ID is provided in the URL
    if (isset($_GET['question_id'])) {
        // Get the question ID from the URL
        $question_id = $_GET['question_id'];

        $sql = "SELECT q.question_text, q.img, u.username AS asker, COUNT(DISTINCT a.id) AS answer_count
            FROM questions q
            INNER JOIN users u ON q.user_id = u.id
            LEFT JOIN answers a ON q.id = a.question_id
            WHERE q.id = :question_id
            GROUP BY q.id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();

        $question = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display the question, its asker, and the answer count
        if ($question) {
            ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3 bg-white rounded p-3">
                        <p class="fs-5 fw-bold mb-1">Question:</p>
                        <p class="fs-6">
                            <?php echo $question['question_text']; ?>
                        </p>
                        <img src="../services/<?php echo $question['img']; ?>" alt="" class="img-fluid"
                            style="max-width: 800px; width:100%;">
                    </div>

                    <!-- Add code to display answers if needed -->
                    <div class="mb-3 bg-white rounded p-3">
                        <p class="fs-4 fw-bold mb-1">Answer ·
                            <?php echo $question['answer_count']; ?>
                        </p>

                        <!-- Form for submitting answers -->
                        <form method="post" action="../services/submit_answer.php">
                            <!-- Changed action to submit_answer.php -->
                            <input type="hidden" name="question_id" value="<?php echo $_GET['question_id']; ?>">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control m-2" placeholder="Answer" aria-label="Username"
                                    aria-describedby="basic-addon1" name="answer">
                                <button type="submit" class="btn btn-primary m-2">Comment</button>
                            </div>
                        </form>
                        <?php
                        // Fetch answers for the question
                        $sql_answers = "SELECT u.username AS commenter, a.answer_text
                                        FROM answers a
                                        INNER JOIN users u ON a.user_id = u.id
                                        WHERE a.question_id = :question_id";
                        $stmt_answers = $conn->prepare($sql_answers);
                        $stmt_answers->bindParam(':question_id', $question_id);
                        $stmt_answers->execute();

                        // Loop through the answers and display each one
                        while ($answer = $stmt_answers->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="mb-3">
                                <div class="input-group-prepend d-flex align-items-center">
                                    <img class="rounded-circle" style="width: 30px; height: 30px;"
                                        src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg" alt="">
                                    <p class="fs-5 fw-bold m-2">
                                        <?php echo $answer['commenter']; ?>
                                    </p>
                                </div>
                                <div style="margin-left: 40px; max-width: 600px; overflow-wrap: break-word;">
                                    <p>
                                        <?php echo $answer['answer_text']; ?>
                                    </p>
                                </div>

                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white rounded p-4 d-flex flex-column">
                        <div class="input-group-prepend d-flex flex-column justify-content-center align-items-center">
                            <!-- Add code to display user information if needed -->
                            <img class="rounded-circle" style="width: 150px; height: 150px;"
                                src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg" alt="">
                            <p class="fs-5 fw-bold m-2">
                                <?php echo $question['asker']; ?>
                            </p>
                        </div>
                        <button type="button" class="btn btn-warning">Follow</button>
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo "Question not found.";
        }
    } else {
        echo "Question ID is missing in the URL.";
    }
    ?>
</div>