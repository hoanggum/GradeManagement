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
$page = isset($_GET['page']) ? $_GET['page'] : 'create_exam';
$path = "./pages/{$page}.php";
$callFooter = true;

if (file_exists($path)) {
    if ($page !== 'saveGrades') {
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
    require "./View/404.php";
}
?>


<?php
if ($callFooter === true) {

    include './includes/footer.php';
    include './includes/scripts.php';
}

?>