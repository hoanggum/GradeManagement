<?php

// Giả sử bạn đã có session và UserID của giáo viên


// Lấy thông tin giáo viên
$teacherInfo = $teacherObj->getTeacherByUserId($teacherId);

// Lấy các học phần giáo viên đang dạy
$sections = $teacherObj->getSectionsByTeacherId($teacherId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý điểm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Danh sách lớp học</h2>
        <div class="row mt-3">
            <?php foreach ($sections as $section) : ?>
                <div class="col-6 mb-3">
                    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-<?php echo $section['SectionID']; ?>">
                        Section ID: <?php echo htmlspecialchars($section['SectionID']); ?> - <?php echo htmlspecialchars($section['SubjectName']); ?>
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
                                $students = $teacherObj->getStudentsBySectionId($section['SectionID']);
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
                        <button type="button" class="btn btn-primary" onclick="saveGrades(<?php echo $section['SectionID']; ?>, <?php echo $student['StudentID']; ?>)">Lưu</button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import-modal-<?php echo $section['SectionID']; ?>">Import Excel</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php foreach ($sections as $section) : ?>
        <div class="modal fade" id="import-modal-<?php echo $section['SectionID']; ?>" tabindex="-1" role="dialog" aria-labelledby="import-modal-<?php echo $section['SectionID']; ?>-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="import-modal-<?php echo $section['SectionID']; ?>-label">Import điểm từ Excel cho lớp <?php echo htmlspecialchars($section['SubjectName']); ?> - Section ID: <?php echo htmlspecialchars($section['SectionID']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="import-form-<?php echo $section['SectionID']; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="excel-file-<?php echo $section['SectionID']; ?>">Chọn file Excel:</label>
                                <input type="file" class="form-control-file" id="excel-file-<?php echo $section['SectionID']; ?>" name="excel-file" accept=".xls,.xlsx" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="importGrades('<?php echo $section['SectionID']; ?>')">Import</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to calculate final grade
        function calculateFinalGrade(gradeInClass, finalExamGrade) {
            return (finalExamGrade * 0.7) + (gradeInClass * 0.3);
        }

        // Update final grade when input changes
        $(document).ready(function() {
            $('.gradeInClass, .grade').on('input', function() {
                var $row = $(this).closest('tr');
                var gradeInClass = parseFloat($row.find('.gradeInClass').val()) || 0;
                var finalExamGrade = parseFloat($row.find('.grade').val()) || 0;
                var finalGrade = calculateFinalGrade(gradeInClass, finalExamGrade);
                $row.find('.finalGrade').val(finalGrade.toFixed(2));
            });
        });

        function saveGrades(sectionID, studentID) {
            var gradeInClass = $('input[name="gradeInClass[' + studentID + ']"]').val();
            var grade = $('input[name="grade[' + studentID + ']"]').val();
            data = {
                sectionID: sectionID,
                studentID: studentID,
                grade: grade,
                gradeInClass: gradeInClass
            };
            console.log(data);
            $.ajax({
                url: '?page=saveGrades',
                type: 'POST',
                data: data,

                success: function(response) {

                    alert(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error importing grades:', error);
                }
            });

        }

        function importGrades(sectionID) {
            var formData = new FormData($('#import-form-' + sectionID)[0]);

            // Perform AJAX request to import grades
            function importGrades(sectionID) {
                var formData = new FormData($('#import-form-' + sectionID)[0]);

                // Perform AJAX request to import grades
                $.ajax({
                    url: 'import_grades.php', // Replace with the actual URL to import grades
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle success response
                        console.log('Grades imported successfully:', response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error importing grades:', error);
                    }
                });
            }
        }
    </script>
</body>

</html>