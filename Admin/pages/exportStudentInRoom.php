<?php
include_once '../Model/ExamRoom.php';
include_once '../Model/Student.php';

require '../vendor/autoload.php'; // Assuming you are using Composer and PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$ExamRoom = new ExamRoom();
$roomId = $_GET['id']; // Get the exam ID from the URL
$Student = new Student();
// Get exam rooms by exam ID
$examRooms = $ExamRoom->getRoomById($roomId);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row values
$sheet->setCellValue('A1', 'Tên phòng thi');
$sheet->setCellValue('B1', 'Sức chứa');
$sheet->setCellValue('C1', 'Danh sách sinh viên');

// Add data for each exam room
$rowNum = 2;
foreach ($examRooms as $room) {
    $sheet->setCellValue('A' . $rowNum, $room['room_name']);
    $sheet->setCellValue('B' . $rowNum, $room['capacity']);

    // Get student list for this room (assuming you have a method to retrieve it)
    $studentList = $Student->getStudentsByRoomId($room['room_id']);
    
    // Combine student names into a single string
    $studentNames = '';
    foreach ($studentList as $student) {
        $studentNames .= $student['FullName'] . ', ';
    }
    $studentNames = rtrim($studentNames, ', '); // Remove the trailing comma and space

    $sheet->setCellValue('C' . $rowNum, $studentNames);

    $rowNum++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'student_list_by_exam_rooms.xlsx';
$filepath = '../Data/' . $filename; // Change this path to the desired save location on your server

// Save the file to the server
$writer->save($filepath);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List by Exam Rooms</title>
    <style>
        .message-container {
            text-align: center;
            margin-top: 20px;
        }

        .message {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .download-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .download-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="message">File has been saved.</div>
        <a class="download-link" href="<?php echo $filepath; ?>">Download here</a>
    </div>
</body>
</html>
