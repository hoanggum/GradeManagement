<?php

require '../Model/ExamSchedule.php';
if (isset($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];
}

if ($studentId) {
    $examSchedule = new ExamSchedule();
    $schedule = $examSchedule->getStudentExamSchedule($studentId);
} else {
    $schedule = [];
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Thi Sinh Viên</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Lịch Thi Sinh Viên</h2>

<table>
    <thead>
        <tr>
            <th>Mã Thi</th>
            <th>Ngày Thi</th>
            <th>Vòng Thi</th>
            <th>Giờ Thi</th>
            <th>Thời Lượng</th>
            <th>Môn Học</th>
            <th>Tên Phòng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($schedule)): ?>
            <?php foreach ($schedule as $exam): ?>
                <tr>
                    <td><?php echo htmlspecialchars($exam["Exam_ID"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["ExamDate"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["ExamRound"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["ExamTime"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["Duration"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["SubjectName"]); ?></td>
                    <td><?php echo htmlspecialchars($exam["room_name"]); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Không có lịch thi cho sinh viên này.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
