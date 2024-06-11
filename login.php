<?php
session_start();
include_once "connect.php"; // Kết nối tới cơ sở dữ liệu

$response = array('success' => false);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

    // Xác thực thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {

        if (md5($password) === $user['Password']) {
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['FullName'] = $user['FullName'];
            $_SESSION['Role'] = $user['Role'];
            if ($user['Role'] === 'Teacher') {
                $sqlTeacher = "SELECT TeacherID FROM teacher WHERE UserID = :userId";
                $stmtTeacher = $conn->prepare($sqlTeacher);
                $stmtTeacher->bindParam(':userId', $user['UserID']);
                $stmtTeacher->execute();
                $teacher = $stmtTeacher->fetch(PDO::FETCH_ASSOC);
                if ($teacher) {
                    $_SESSION['TeacherID'] = $teacher['TeacherID'];
                    $response['TeacherID'] = $teacher['TeacherID'];
                } else {
                    $response['error'] = "Không tìm thấy thông tin giáo viên.";
                }
            }
            if ($user['Role'] === 'Student') {
                $sqlStudent = "SELECT StudentID FROM student WHERE UserID = :userId";
                $stmtStudent = $conn->prepare($sqlStudent);
                $stmtStudent->bindParam(':userId', $user['UserID']);
                $stmtStudent->execute();
                $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);
                
                if ($student) {
                    $_SESSION['StudentID'] = $student['StudentID'];
                    $response['StudentID'] = $student['StudentID'];
                } else {
                    $response['error'] = "Student information not found.";
                }
            }
            if ($remember == "on") {
                // Thiết lập cookie để lưu tên người dùng và mật khẩu
                setcookie("username", $username, time() + (86400 * 30), "/"); // 30 ngày
                setcookie("password", $password, time() + (86400 * 30), "/"); // 30 ngày
            }
            $response['success'] = true;
            $response['role'] = $user['Role'];
            
            if ($user['Role'] === 'Admin') {
                $response['redirect'] = 'Admin/index.php';
            } else {
                $response['redirect'] = 'User/index.php';
            }
        } else {
            $response['error'] = "Mật khẩu không chính xác.";
        }
    } else {
        $response['error'] = "Tên đăng nhập không tồn tại.";
    }
}

echo json_encode($response);
?>
