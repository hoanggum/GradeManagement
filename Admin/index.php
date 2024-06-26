<?php
include_once '../config.php';
include_once '../Library/Db.class.php';
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['UserID'])){
    header('location: ../index.html');exit;
}
if ($_SESSION['Role'] != 'Admin') {
    header('Location: ../user/index.php');
    exit();
}
?>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'overview';
$path = "./pages/{$page}.php";
$callFooter = true;

if (file_exists($path)) {
    if ($page !== 'saveGrades' && $page !== 'get_exam_rooms'&& $page !== 'add_section'&& $page !== 'get_sections' && $page !== 'xl_create_exam') {
?>
        <div class="wrapper">
            <div id="sidebar">
                <?php
                include './includes/navbar.php';
                ?>
            </div>
            <div class="main">
                <?php
                include './includes/header.php';
                ?>
                <?php
                echo '<div class="main-content">';
                require "{$path}";
                echo '</div>';
                ?>

            </div>
        </div>
<?php
    } else {
        $callFooter = false;
        require "{$path}";
    }
} else {
    require "./pages/404.php";
}
?>


<?php
if ($callFooter === true) {

    // include './includes/footer.php';
    include './includes/scripts.php';
}

?>