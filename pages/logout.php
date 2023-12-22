<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Déconnexion";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <?php
            include("../controllers/controllerCompteClient.php");
            $controllerCompteClient = new controllerCompteClient();

            try {
                $controllerCompteClient->disconnect();
                echo "Déconnecté, redirection en cours...";
                header("Location: $ROOT_PATH/index.php");
            } catch (Exception $e) {
                echo "<p class='error-message'>" . $e->getMessage() . "</p>";
            }

        ?>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>