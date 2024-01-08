<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>
<?php require_once("../scripts/php/check_connection.php"); ?>

<html>
    <?php
        $title = "Paiement";
        include_once("../views/components/head.php");
    ?>

<body>
    <?php include("../views/components/header.php"); ?>

    <h1>Paiement</h1>
    TODO

    <?php include("../views/components/footer.php"); ?>
</body>

</html>