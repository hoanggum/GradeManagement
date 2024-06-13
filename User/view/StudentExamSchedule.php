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
        body {
            font-family: Arial, sans-serif;
        }
        .schedule-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 columns for Monday to Friday */
            gap: 10px;
            padding: 20px;
        }
        .schedule-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .schedule-header {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1 class="schedule-header">Lịch Thi Sinh Viên</h1>

<div class="schedule-container">
    <?php if (!empty($schedule)): ?>
        <?php foreach ($schedule as $exam): ?>
            <div class="schedule-item">
                <h4><?php echo htmlspecialchars($exam["SubjectName"]); ?></h4>
                <p><strong>Ngày:</strong> <?php echo htmlspecialchars($exam["ExamDate"]); ?></p>
                <p><strong>Vòng:</strong> <?php echo htmlspecialchars($exam["ExamRound"]); ?></p>
                <p><strong>Giờ:</strong> <?php echo htmlspecialchars($exam["ExamTime"]); ?></p>
                <p><strong>Thời Lượng:</strong> <?php echo htmlspecialchars($exam["Duration"]); ?> phút</p>
                <p><strong>Phòng:</strong> <?php echo htmlspecialchars($exam["room_name"]); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có lịch thi cho sinh viên này.</p>
    <?php endif; ?>
</div>

</body>
</html>