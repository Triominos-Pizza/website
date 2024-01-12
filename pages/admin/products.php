<?php session_start(); ?>
<?php include_once('../../config/config.php'); ?>
<?php require_once(FTP_ROOT_PATH . "/scripts/php/check_connection_admin.php"); ?>
<html>
    <?php
        $title = "Admin - NOM PAGE"; // Nom de la page
        include_once(FTP_ROOT_PATH . "/views/components/head.php");
    ?>
    
    <body class="admin-page">
        <?php include(FTP_ROOT_PATH . "/views/components/admin/navbar.php"); ?>
        
        <?php include(FTP_ROOT_PATH . "/views/components/admin/header.php"); ?>

        <main class="admin-page-main">
            <h1>Produits</h1>
            <p>TODO</p>
        </main>
    </body>
</html>
