<?php session_start() ?>
<?php include_once('../../config/config.php'); ?>
<?php require_once(FTP_ROOT_PATH."/scripts/php/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Déconnexion";
        include_once(FTP_ROOT_PATH."/views/components/head.php");
    ?>
    
    <body>
        <?php
            unset($_SESSION['adminAccount']);
            echo "Déconnecté, redirection en cours...";
            header("Location: " . ROOT_URL . "/pages/admin/login.php");
            exit();
        ?>
    </body>
</html>