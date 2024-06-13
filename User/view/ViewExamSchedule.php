<?php

require '../Model/ExamSchedule.php';

// Bắt đầu phiên làm việc nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy StudentID từ session nếu có
if (isset($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];
} else {
    // Nếu không có StudentID, có thể điều hướng người dùng đến trang khác hoặc xử lý theo ý của bạn
    // Ví dụ: header('Location: login.php');
    exit(); // Dừng xử lý script nếu không có StudentID
}

// Lấy lịch thi của sinh viên từ CSDL
if ($studentId) {
    $examSchedule = new ExamSchedule();
    $schedule = $examSchedule->getStudentExamSchedule($studentId);
} else {
    $schedule = [];
}

// Xử lý ngày bắt đầu và ngày kết thúc cho từng tuần
if (isset($_GET['week'])) {
    $currentDate = new DateTime($_GET['week']);
} else {
    $currentDate = new DateTime(); // Nếu không có tham số tuần, lấy ngày hiện tại
}

// Lấy ngày đầu tiên của tuần (thứ 2)
$currentDate->modify('Monday this week');

// Lấy ngày cuối cùng của tuần (Chủ Nhật)
$endOfWeek = clone $currentDate;
$endOfWeek->modify('Sunday this week');

// Định nghĩa mảng ngày cho tuần hiện tại (bao gồm cả Thứ Bảy và Chủ Nhật)
$days = [];
$interval = new DateInterval('P1D'); // Khoảng cách là 1 ngày

while ($currentDate <= $endOfWeek) {
    $days[] = $currentDate->format('Y-m-d');
    $currentDate->add($interval);
}

// Định nghĩa các buổi trong ngày
$periodsOfDay = [
    "Sáng" => ["08:00", "10:00"],
    "Trưa" => ["13:00"],
    "Chiều" => ["15:00"]
];

// Định nghĩa mảng ngày từ 2 năm trước đến 2 năm sau (dành cho việc hiển thị tiêu đề)
$allDays = [];
$startDateTime = new DateTime();
$startDateTime->modify('-2 years');
$endDateTime = (new DateTime())->modify('+2 years');

while ($startDateTime <= $endDateTime) {
    $allDays[] = $startDateTime->format('Y-m-d');
    $startDateTime->add($interval);
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Thi Sinh Viên</title>
    <style>

        .container_S {
            max-width: 100%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        .schedule-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
            grid-column: span 2; /* Chia cả 2 cột */
        }
        .schedule-table {
            display: grid;
            width: 100%;
            grid-template-columns: 100px repeat(7, 1fr); /* Số lượng cột dựa trên số lượng ngày */
            gap: 10px;
        }
        .schedule-table .day-header, .schedule-table .time-slot {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }
        .schedule-table .day-header {
            background-color: #4CAF50;
            color: white;
        }
        .schedule-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 10px; /* Khoảng cách giữa các lịch thi */
        }
        .empty-slot {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            height: 100px;
        }
        .week-nav {
            text-align: center;
            margin-bottom: 20px;
        }
        .week-nav a {
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            border-radius: 4px;
        }
        .day-periods {
            display: flex;
            flex-direction: column;
        }
        .day-period {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container_S">
    <div class="week-nav">
        <a href="?week=<?php echo urlencode($currentDate->modify('-1 week')->format('Y-m-d')); ?>"><i class="fa-solid fa-arrow-left"></i></a>
        <?php echo $currentDate->format('d/m/Y') . ' - ' . $endOfWeek->format('d/m/Y'); ?>
        <a href="?week=<?php echo urlencode($currentDate->modify('+1 week')->format('Y-m-d')); ?>"><i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <h2 class="schedule-header">Lịch Thi Sinh Viên</h2>


    <div class="schedule-table">
        <!-- Header cho các ngày và thời gian -->
        <div class="day-header">Thời gian</div>
        <?php 
        // Hiển thị các ngày
        foreach ($days as $day) {
            echo "<div class='day-header'>" . date('D, d/m', strtotime($day)) . "</div>";
        }
        ?>

        <!-- Khe thời gian và lịch thi tương ứng -->
        <?php 
        // Định nghĩa các khe thời gian (ví dụ: 8:00, 10:00, 13:00)
        $timeSlots = ["Sáng", "Trưa", "Chiều"];
        
        foreach ($timeSlots as $timeSlot) {
            // Hiển thị cột khe thời gian
            echo "<div class='time-slot'>$timeSlot</div>";

            // Hiển thị các lịch thi cho mỗi ngày tại khe thời gian hiện tại
            foreach ($days as $day) {
                $examFound = false;
                foreach ($schedule as $exam) {
                    if (strpos($exam["ExamDate"], $day) !== false && strpos($exam["ExamTime"], $timeSlot) !== false) {
                        echo "<div class='schedule-item'>
                                <h4>" . htmlspecialchars($exam["SubjectName"]) . "</h4>
                                <p><strong>Vòng:</strong> " . htmlspecialchars($exam["ExamRound"]) . "</p>
                                <p><strong>Thời Lượng:</strong> " . htmlspecialchars($exam["Duration"]) . " phút</p>
                                <p><strong>Phòng:</strong> " . htmlspecialchars($exam["room_name"]) . "</p>
                              </div>";
                        $examFound = true;
                        break;
                    }
                }
                if (!$examFound) {
                    echo "<div class='empty-slot'></div>";
                }
            }
        }
        ?>
    </div>
</div>

</body>
</html>
