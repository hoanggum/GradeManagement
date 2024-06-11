<?php
// Include the necessary model files
require_once '../Model/Teacher.php';
require_once '../Model/SubjectSection.php';
require_once '../Model/Semester.php';

// Initialize objects
$teacherObj = new Teacher();
$sectionObj = new SubjectSection();
$semesterObj = new Semester();

// Lấy thông tin giáo viên từ session (giả sử đã có session và UserID của giáo viên)


// Lấy các học phần giáo viên đang dạy
$sections = $sectionObj->getAllSection();
?>


<div class="container mt-5">
    <h2 class="text-center">Danh sách điểm các lớp học phần theo môn</h2>
    <div class="row mt-3">
        <?php foreach ($sections as $section) : ?>
            <div class="col-6 mb-3">
                <button class="btn btn-primary btn-block" style="width: 100%;" data-toggle="modal" data-target="#modal-<?php echo $section['SectionID']; ?>">
                    <?php echo htmlspecialchars($section['SubjectName']); ?> - Section ID: <?php echo htmlspecialchars($section['SectionID']); ?>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php foreach ($sections as $section) : ?>
    <div class="modal fade" id="modal-<?php echo $section['SectionID']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?php echo $section['SectionID']; ?>-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-<?php echo $section['SectionID']; ?>-label"><?php echo htmlspecialchars($section['SubjectName']); ?> - Section ID: <?php echo htmlspecialchars($section['SectionID']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID sinh viên</th>
                                <th>Tên sinh viên</th>
                                <th>Điểm tại lớp</th>
                                <th>Điểm thi</th>
                                <th>Điểm tổng kết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách sinh viên theo SectionID
                            $students = $sectionObj->getStudentsBySectionId($section['SectionID']);
                            foreach ($students as $student) :
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['StudentID']); ?></td>
                                    <td><?php echo htmlspecialchars($student['FullName']); ?></td>
                                    <td><input type="number" step="0.01" name="gradeInClass[<?php echo $student['StudentID']; ?>]" value="<?php echo htmlspecialchars($student['GradeInClass']); ?>" class="form-control gradeInClass" required></td>
                                    <td><input type="number" step="0.01" name="grade[<?php echo $student['StudentID']; ?>]" value="<?php echo htmlspecialchars($student['Grade']); ?>" class="form-control grade" required></td>
                                    <td><input type="number" step="0.01" value="<?php echo $semesterObj->calculateFinalGrade($student['GradeInClass'], $student['Grade']); ?>" class="form-control finalGrade" disabled></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="saveGrades(<?php echo $section['SectionID']; ?>)">Lưu</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Update final grade when input changes
    $(document).ready(function() {
        $('.gradeInClass, .grade').on('input', function() {
            var $row = $(this).closest('tr');
            var gradeInClass = parseFloat($row.find('.gradeInClass').val()) || 0;
            var finalExamGrade = parseFloat($row.find('.grade').val()) || 0;
            var finalGrade = (finalExamGrade * 0.7) + (gradeInClass * 0.3);
            $row.find('.finalGrade').val(finalGrade.toFixed(2));
        });
    });

    // Function to save grades
    function saveGrades(sectionID) {
        var grades = [];
        $('#modal-' + sectionID + ' tbody tr').each(function() {
            var studentID = $(this).find('td:first-child').text();
            var gradeInClass = $(this).find('input.gradeInClass').val();
            var grade = $(this).find('input.grade').val();

            grades.push({
                StudentID: studentID,
                GradeInClass: gradeInClass,
                Grade: grade
            });
        });

        var data = {
            sectionID: sectionID,
            grades: grades
        };

        // Send AJAX request to save grades
        $.ajax({
            url: 'save_grades.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Đã lưu điểm thành công');
                } else {
                    alert('Đã xảy ra lỗi: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lưu điểm:', error);
            }
        });
    }
</script>

