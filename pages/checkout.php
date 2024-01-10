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

    <!-- Imports -->
    <?php
        include("../controllers/controllerPanier.php");
        include("../controllers/controllerPaiement.php");
    ?>

    <main class="checkout-page">

        <!-- Show the shopping cart -->
        <?php
            $controllerPanier = new controllerPanier();
            $controllerPanier->showPanier(false);
        ?>
        
        <!-- Show the payment form -->
        <?php
            $controllerPaiement = new controllerPaiement();
            $controllerPaiement->showPaiementForm();
        ?>
        
    </main>

    <?php include("../views/components/footer.php"); ?>
</body>

</html>