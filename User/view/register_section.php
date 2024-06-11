<?php
require_once '../Model/Subject.php';
require_once '../Model/SubjectSection.php';

$subjectObj = new Subject();
$subjects = $subjectObj->getAllSubjects();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Registration</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Course Registration</h2>

    <div class="row mt-3">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Subject Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject['SubjectID']); ?></td>
                            <td><?php echo htmlspecialchars($subject['SubjectName']); ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="loadSections(<?php echo $subject['SubjectID']; ?>)">
                                    View Sections
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="sections-container" class="mt-5">
        <!-- Sections will be loaded here -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
function loadSections(subjectId) {
    $.ajax({
      
        url: '?page=get_section',
        type: 'GET',
        data: { subjectId: subjectId },
        success: function(response) {
           $('#sections-container').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error loading sections:', error);
        }
    });
}
function registerSection(sectionId, semester, studentId) {

    if (confirm("Are you sure you want to register for this section?")) {
        $.ajax({
            url: '?page=Process_register_section',
            type: 'POST',
            data: { sectionId: sectionId, studentId: studentId, semester: semester },
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error('Error registering section:', error);
            }
        });
    }
}

</script>
</body>
</html>
