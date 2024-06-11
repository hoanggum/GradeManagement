<?php
// Include the necessary model file
require_once '../Model/ExamSchedule.php';

// Check if exam_id is provided
if(isset($_GET['exam_id'])) {
    // Get the exam_id from the URL
    $examId = $_GET['exam_id'];

    // Initialize the ExamSchedule object
    $ExamScheduleObj = new ExamSchedule();

    // Retrieve exam rooms by exam_id
    $examRooms = $ExamScheduleObj->getExamRoomsByExamId($examId);

    // Check if there are exam rooms available
    if($examRooms) {
        // Display the list of exam rooms
        echo '<div id="main-content-wp" class="list-product-page">';
        echo '<div class="wrap clearfix">';
        echo '<div id="content" class="fl-right">';
        echo '<div class="section" id="title-page">';
        echo '<div class="clearfix">';
        echo '<h3>Danh sách phòng thi:</h3>';
        echo '</div>';
        echo '</div>';
        echo '<div class="section" id="detail-page">';
        echo '<div class="section-detail">';
        echo '<div class="table-responsive">';
        echo '<table class="table list-table-wp">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th>STT</th>';
        echo '<th>Tên phòng thi</th>';
        echo '<th>Sức chứa</th>';
        echo '<th>Thao tác</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach($examRooms as $key => $room) {
            echo '<tr>';
            echo '<td>'.($key + 1).'</td>';
            echo '<td>'.$room['room_name'].'</td>';
            echo '<td>'.$room['capacity'].'</td>';
            echo '<td>';
            echo '<a href="?page=DetailExamRoom&id='.$room['room_id'].'" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>';
            echo '<a href="?page=exportStudentInRoom&id='.$room['room_id'].'" title="Sửa"><i class="fas fa-print"></i></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Không có phòng thi nào cho lịch thi này.';
    }
} else {
    // If exam_id is not provided, display an error message
    echo 'Không tìm thấy thông tin lịch thi.';
}
?>
