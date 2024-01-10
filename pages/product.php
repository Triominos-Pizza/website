<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>

<html>
    <!-- Imports -->
    <?php
        include("../controllers/controllerProduit.php");
        include("../controllers/controllerPanier.php");
    ?>
    
    <?php
        // Set the page title
        try {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $controllerProduit = new controllerProduit();
                $produit = $controllerProduit->getProduit($_GET['id']);
                $title = "Produit (" . $produit->nomProduit . ")";
            } else {
                $title = "Produit introuvable";
            }    
        } catch (Exception $e) {
            $title = "Produit introuvable";
        }    

        include_once("../views/components/head.php");
    ?>    
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <!-- Get the product details -->
        <?php
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $controllerProduit = new controllerProduit();
            } else {
                echo "<div class='error-message'>Aucun produit sélectionné</div>";
            }
        ?>
        
        <main class="product-page">
            <!-- Show the product header -->
            <?php $controllerProduit->showProduitHeader($_GET['id']); ?>

            <div class="product-page-main">
                <!-- Show the product details -->
                <?php $controllerProduit->showProduitDetails($_GET['id']); ?>

                <!-- Show the shopping cart -->
                <?php
                    $controllerPanier = new controllerPanier();
                    $controllerPanier->showPanier();
                ?>
            </div>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>