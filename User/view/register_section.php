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
        
    <div class="col">
            <label for="semester">Select Semester:</label>
            <select class="form-select" id="semester" onchange="loadSections($('#subjectId').val(), $(this).val())">>
                <option value="">All Semesters</option>
                <option value="1">Học kì 1</option>
                <option value="2">Học kì 2</option>
                <option value="3">Học kì 3</option>
                <option value="4">Học kì 4</option>
                <option value="5">Học kì 5</option>
                <option value="6">Học kì 6</option>
                <option value="7">Học kì 7</option>
                <option value="8">Học kì 8</option>
            </select>
        </div>
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
                                <button class="btn btn-primary" onclick="loadSections(<?php echo $subject['SubjectID']; ?>, getSelectedSemester())">
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
function loadSections(subjectId, semester) {
    $.ajax({
        url: '?page=get_section',
        type: 'GET',
        data: { subjectId: subjectId, semester: semester }, // Thêm semester vào dữ liệu gửi đi
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
function getSelectedSemester() {
    return document.getElementById('semester').value;
}

</script>
</body>
</html>
