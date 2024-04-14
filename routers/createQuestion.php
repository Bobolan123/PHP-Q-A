<?php
include("connection.php");

// Fetch module names from the database
$sql = "SELECT id, name FROM modules";
$stmt = $conn->query($sql);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <form action="../services/submit_question.php" method="post" enctype="multipart/form-data">
        <h1>Create Question:</h1>
        <div class="form-group">
            <label for="question_text">Your question:</label>
            <textarea class="form-control" id="question_text" rows="3" name="question_text"></textarea>
        </div>
        <div class="mb-3">
            <label for="imgQuestion" class="form-label">Image for question:</label>
            <input class="form-control" type="file" id="imgQuestion" name="imgQuestion">
        </div>
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="module_id" style="max-width:95px">
            <?php foreach ($modules as $module): ?>
                <option value="<?php echo $module['id']; ?>"><?php echo $module['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>

<script>
    <?php if(isset($_SESSION["createQuestion_success"])): ?>
        <?php if($_SESSION["createQuestion_success"] === true): ?>
            Swal.fire({
                icon: 'success',
                title: 'create question Successful',
                text: 'You have successfully created a question!',
            });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'create question Failed',
                text: '<?php echo $_SESSION["createQuestion_error"]; ?>',
            });
        <?php endif; ?>
        <?php unset($_SESSION["createQuestion_success"]); ?>
        <?php unset($_SESSION["createQuestion_error"]); ?> // Unset the session variables after displaying the SweetAlert
    <?php endif; ?>
</script>
