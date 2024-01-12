<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>
<?php require_once("../scripts/php/check_connection.php"); ?>
<html>
    <?php
        $title = "Confirmation de commande";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <main class="order-confirmation-page">
            <h1>Commande validée ! 🍕</h1>
            <?php
                if (isset($_SESSION["idCommande"])) {
                    echo "<h2>Votre numéro de commande : " . $_SESSION["idCommande"] . "</h2>";
                }
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
