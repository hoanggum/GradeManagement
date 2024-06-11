
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
$page = isset($_GET['page']) ? $_GET['page'] : 'create_exam';

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
                // Main content
                echo '<div class="main-content">';
                if (file_exists("./pages/{$page}.php")) {
                    require "./pages/{$page}.php";
                } else {
                    require "./pages/404.php";
                }
                echo '</div>';
            ?>
            
        </div>
</div>
<!-- <?php 
    include './includes/footer.php';
?> -->
<?php
// Include scripts
include './includes/scripts.php';
?> -->
