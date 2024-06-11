<?php
// Đảm bảo các file model đã được bao gồm
require_once '../Model/SubjectSection.php';

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận các giá trị từ form
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $schedule = $_POST['schedule'];
    $semester = $_POST['semester'];
    $subjectID = $_POST['subjectID'];
    
    // Tạo một đối tượng SubjectSection
    $section = new SubjectSection();

    // Gọi phương thức addSection để thêm lớp học phần
    $result = $section->addSection($subjectID, $startDate, $endDate, $schedule, $semester);
    // Kiểm tra kết quả của hoạt động và trả về thông báo tương ứng
    if ($result) {
        $success_message = "Schedule has been added successfully.";
        $redirect_url = "/admin/index.php?page=create_section_classes";
    } else {
        $error_message = "Failed to add schedule. The schedule conflicts with existing entries or another error occurred.";
        $redirect_url = "/admin/index.php?page=createSchedule";
    }
}

echo "<script>";
if (isset($success_message)) {
    echo "alert('$success_message');";
}
if (isset($error_message)) {
    echo "alert('$error_message');";
}
echo "window.location='$redirect_url';";
echo "</script>";
?>
