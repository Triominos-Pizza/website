<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>

<html>
    <?php
        $title = "Commander";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <main>
            <?php
                include("../controllers/controllerProduit.php");
                $controllerProduit = new controllerProduit();

                $controllerProduit->showProduitsGrid();
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>