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
            if ($remember == "on") {
                // Thiết lập cookie để lưu tên người dùng và mật khẩu
                setcookie("username", $username, time() + (86400 * 30), "/"); // 30 ngày
                setcookie("password", $password, time() + (86400 * 30), "/"); // 30 ngày
            }
            $response['success'] = true;
            $response['role'] = $user['Role'];
        } else {
            $response['error'] = "Mật khẩu không chính xác.";
        }
    } else {
        $response['error'] = "Tên đăng nhập không tồn tại.";
    }
}

echo json_encode($response);
?>
