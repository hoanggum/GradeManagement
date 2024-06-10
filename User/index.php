
<?php
include_once '../config.php';
include_once '../Library/Db.class.php';



require_once '../Model/Teacher.php';
require_once '../Model/Semester.php';
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['UserID'])) {
    header('location: ../index.html');
    exit;
}
$teacherId = $_SESSION['TeacherID'];
$teacherObj = new Teacher();
$semesterObj = new Semester();
$page = isset($_GET['page']) ? $_GET['page'] : 'grade_entry';
$path = "./View/{$page}.php";

$callFooter = true;

?>

            <?php
            // Main content
            if (file_exists($path)) {
                if ($page !== 'saveGrades') {
                    require './inc/header.php';
                    echo '<div class="main-content">';
                } else {
                    $callFooter = false;
                }
                require "{$path}";
            } else {
                require "./View/404.php";
            }

            ?>
            
<?php
if ($callFooter === true) {
    echo '</div>';
    require './inc/footer.php';
    include './inc/script.php';
}

?>

