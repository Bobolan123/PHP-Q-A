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
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>
