<?php
$sectionID = $_POST['sectionID'];
$studentID = $_POST['studentID'];
$grade = $_POST['grade'];
$gradeInClass = $_POST['gradeInClass'];
$teacherInfo = $teacherObj->saveGrade($studentID, $sectionID, $gradeInClass, $grade);
if ($teacherInfo > 0) {
    echo "Đã cập nhật thành công điểm của sinh viên ";
} else {
    echo "Bạn đã không cập nhật thành công. Vui lòng thử lại sau !";
}
?>
