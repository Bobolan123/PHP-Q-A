<?php
require_once ("connection.php");

// Check if the update_question_id is provided in the URL
if (isset($_GET['update_question_id'])) {
    // Get the question ID from the URL
    $update_question_id = $_GET['update_question_id'];

    // Fetch the question details from the database
    $sql = "SELECT question_text, img FROM questions WHERE id = :update_question_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':update_question_id', $update_question_id);
    $stmt->execute();

    // Fetch the question details
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch module names from the database
    $sql = "SELECT id, name FROM modules";
    $stmt = $conn->query($sql);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <form action="../services/update_question.php" method="post" enctype="multipart/form-data">
            <h1>Update Question:</h1>
            <div class="form-group">
                <label for="question_text">Your question:</label>
                <textarea class="form-control" id="question_text" rows="3"
                    name="question_text"><?php echo $question['question_text']; ?></textarea>
            </div>
            <?php if (!empty($question['img'])) { ?>
                <img src="../services/<?php echo $question['img']; ?>" alt="" class="img-fluid"
                    style="max-width: 800px; max-height: 800px; width:100%;">
            <?php } ?>
            <div class="mb-3">
                <label for="imgQuestion" class="form-label">Image for question:</label>
                <input class="form-control" type="file" id="imgQuestion" name="imgQuestion">
            </div>
            <input type="hidden" name="update_question_id" value="<?php echo $update_question_id; ?>">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="module_id"
                style="max-width:95px">
                <?php foreach ($modules as $module): ?>
                    <option value="<?php echo $module['id']; ?>">
                        <?php echo $module['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
    <?php
} else {
    echo "Question ID is missing in the URL.";
}
?>