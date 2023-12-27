<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>
<!-- ?php require_once("../scripts/check_connection.php"); ? -->
<html>
    <?php
        $title = ""; // Nom de la page
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <!-- Content -->

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
