
<?php



$page = isset($_GET['page']) ? $_GET['page'] : 'Home';

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
