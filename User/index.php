
<?php
include_once '../config.php';
include_once '../Library/Db.class.php';

if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['UserID'])){
    header('location: ../index.html');exit;
}
$page = isset($_GET['page']) ? $_GET['page'] : 'supervisor_register';

?>
         <?php 
                include './inc/header.php';
            ?>
            <?php 
                // Main content
                echo '<div class="main-content">';
                if (file_exists("./View/{$page}.php")) {
                    require "./View/{$page}.php";
                } else {
                    require "./View/404.php";
                }
                echo '</div>';
            ?>
            
<?php 
    include './inc/footer.php';
?>
<?php
// Include scripts
include './inc/script.php';
?>
