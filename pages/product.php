<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>

<html>
    <?php
        require_once("../controllers/controllerProduit.php");
        $controllerProduit = new controllerProduit();
        $produit = $controllerProduit->getProduit($_GET['id']);
        $title = "Produit (" . $produit->nomProduit . ")";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <main>
            <script>document.write('<a href="' + document.referrer + '">↩ Retour</a>');</script>

            <?php
                $controllerProduit = new controllerProduit();
                $controllerProduit->showProduitDetails($_GET['id']);
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>