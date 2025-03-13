<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
    <link rel="stylesheet" href="../../assets/css/subjects_styles.css">
</head>
<body>
    <?php
        $activePage = 'subjects'; 
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>

    <div class="subjects-container">
        <h1>Subjects</h1>
        <p id="subjectCount"></p>
        <button class="btn add-subject-button" id="addsubjectButton">+ Add New Subject</button>

        <!-- Add Subject Modal -->
        <div id="addsubjectModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php require_once(__DIR__ . '/../partials/add_subject_form.php'); ?>
            </div>
        </div>

        <!-- Subjects List -->
        <div id="subjectsGrid" class="subjects-grid">
            <!-- Dynamically populated -->
        </div>
    </div>

    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/subject.js"></script>
</body>
</html>
