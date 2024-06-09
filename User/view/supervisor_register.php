<?php
// Kết nối đến cơ sở dữ liệu
require_once '../../config.php'; // Đảm bảo đường dẫn chính xác tới file config.php
require_once '../../Library/Db.class.php'; // Đảm bảo đường dẫn chính xác tới file Db.class.php

try {
    // Tạo đối tượng Db
    $db = new Db();

    // Lấy dữ liệu từ bảng exam_room_assignments
    $tableName = 'exam_room_assignments';
    $examRoomAssignments = $db->getTable($tableName);

    // Kiểm tra và hiển thị kết quả
    if (!empty($examRoomAssignments)) {
        echo "<table border='1'>
                <tr>
                    <th>Exam_ID</th>
                    <th>Room_ID</th>
                </tr>";
        foreach ($examRoomAssignments as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Exam_ID']) . "</td>
                    <td>" . htmlspecialchars($row['room_id']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
?>
