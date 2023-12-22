<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Mot de passe oublié";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <div style="text-align: center; margin-block: 25vh;">
            <h1>Cheh</h1>
            <script>document.write('<a href="' + document.referrer + '">↩ Retour</a>');</script>
        </div>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>