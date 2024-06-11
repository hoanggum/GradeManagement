<?php

// Giả sử bạn đã có session và UserID của giáo viên


// Lấy thông tin giáo viên
$teacherInfo = $teacherObj->getTeacherByUserId($teacherId);

// Lấy các học phần giáo viên đang dạy
$sections = $teacherObj->getSectionsByTeacherId($teacherId);

?>


<body>

    <div class="container mt-5">
        <h2 class="text-center">Danh sách lớp học</h2>
        <div class="row mt-3">
            <?php foreach ($sections as $section) : ?>
                <div class="col-6 mb-3">
                    <button class="btn btn-primary btn-block" style="width: 100%;" data-toggle="modal" data-target="#modal-<?php echo $section['SectionID']; ?>">
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
                        <button type="button" class="btn btn-primary" onclick="saveGrades(<?php echo $section['SectionID']; ?>, '<?php echo $section['Semester']; ?>')">Lưu</button>
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
                        <form id="import-form-<?php echo $section['SectionID']; ?>" method="post" action="?page=import_grades&id_setion=<?php echo $section['SectionID'];?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="excel-file-<?php echo $section['SectionID']; ?>">Chọn file Excel:</label>
                                <input type="file" class="form-control-file" id="excel-file-<?php echo $section['SectionID']; ?>" name="excel-file" accept=".xls,.xlsx" required>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="btn_import_file_excel">Import</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        document.getElementById("closeModalButton").addEventListener("click", function() {
            var modal = document.getElementById("modalId"); // Thay "modalId" bằng id của modal bạn muốn ẩn
            modal.style.display = "none";
        });


        // function saveGrades(sectionID, studentID, semester) {
        //     var gradeInClass = $('input[name="gradeInClass[' + studentID + ']"]').val();
        //     var grade = $('input[name="grade[' + studentID + ']"]').val();
        //     data = {
        //         sectionID: sectionID,
        //         studentID: studentID,
        //         grade: grade,
        //         gradeInClass: gradeInClass,
        //         semester: semester
        //     };
        //     console.log(data);
        //     $.ajax({
        //         url: '?page=saveGrades',
        //         type: 'POST',
        //         data: data,
        //         success: function(response) {
        //             alert(response);
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error response
        //             console.error('Error importing grades:', error);
        //         }
        //     });
        // }
        function saveGrades(sectionID, semester) {
        var grades = [];
        $('#modal-' + sectionID + ' tbody tr').each(function() {
            var studentID = $(this).find('td:first').text();
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
            semester: semester,
            grades: grades
        };
        
        console.log(data); // Log the data to see the structure and values of grades

        $.ajax({
            url: '?page=saveGrades',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                console.log(response); // Log the response to check the status
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    $('#successModal').modal('show');
                } else {
                    alert(result.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error importing grades:', error);
            }
        });
    }
    </script>
</body>

</html>