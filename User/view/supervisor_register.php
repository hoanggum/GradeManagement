<?php
require_once '../Model/Teacher.php';
require_once '../Model/Exam.php';
require_once '../Model/ExamInvigilation.php';

// Khởi tạo đối tượng ExamInvigilation
$examInvigilationObj = new ExamInvigilation();

$teacherId = $_SESSION['TeacherID'];
$teacherObj = new Teacher();
$teacherInfo = $teacherObj->getTeacherByUserId($teacherId);

// Kết nối đến cơ sở dữ liệu
$examObj = new Exam();
$examSchedules = $examObj->getAllExams();

// Lấy danh sách các ca thi đã đăng ký gác thi của giáo viên
$registeredExams = $teacherObj->getRegisteredExams($teacherId);
$registeredExamIds = array_column($registeredExams, 'exam_id');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký gác thi</title>
    <style>
        html, body {
            min-height: 700px;
            margin: 0;
            padding: 0;
        }
        table {
            width: 80%;
            margin: auto auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .submit-container {
            text-align: center;
            margin-top: 20px;
        }
        .disabled {
            pointer-events: none;
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <h1 style="width: 100%; text-align: center;">Đăng ký gác thi</h1>    
    <form id="examForm" method="post" action="../User/view/submit_supervision_registration.php" enctype="multipart/form-data">
        <table>
            <thead>
                <tr>
                    <th>Chọn</th>
                    <th>Mã ca thi</th>
                    <th>Ngày thi</th>
                    <th>Ca thi</th>
                    <th>Thời gian thi</th>
                    <th>Thời lượng</th>
                    <th>Môn thi</th>
                    <th>Phòng thi</th>
                    <th>Đã đăng ký</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examSchedules as $schedule): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="exam_ids[]" value="<?php echo $schedule['Exam_ID']; ?>" <?php echo in_array($schedule['Exam_ID'], $registeredExamIds) ? 'disabled' : ''; ?>>
                    </td>
                    <td><?php echo $schedule['Exam_ID']; ?></td>
                    <td><?php echo $schedule['ExamDate']; ?></td>
                    <td><?php echo $schedule['ExamRound']; ?></td>
                    <td><?php echo $schedule['ExamTime']; ?></td>
                    <td><?php echo $schedule['Duration']; ?> phút</td>
                    <td><?php echo $schedule['SubjectName']; ?></td>
                    <td><?php echo $schedule['room_name']; ?></td>
                    <td>
                    <?php
                            // Lấy id của ca thi và phòng thi
                            $examId = $schedule['Exam_ID'];
                            $roomId = $schedule['room_id'];

                            // Truy vấn để đếm số lượng giáo viên đã đăng ký gác thi cho phòng và ca thi tương ứng
                            $numTeachers = $examInvigilationObj->getNumberOfTeachers($examId, $roomId);
                            echo $numTeachers . '/2'; // In số lượng giáo viên đã đăng ký và số lượng tối đa
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="submit-container">
            <input type="submit" id="submitButton" value="Đăng ký gác thi">
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('examForm');
            var checkboxes = form.querySelectorAll('input[type="checkbox"]');
            var submitButton = document.getElementById('submitButton');

            // Disable submit button by default
            submitButton.disabled = true;

            // Add event listener to checkboxes to enable/disable submit button
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var anyChecked = Array.from(checkboxes).some(function(cb) {
                        return cb.checked;
                    });

                    submitButton.disabled = !anyChecked;
                });
            });
        });
    </script>
</body>
</html>
