<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>

<html>
    <?php
        $title = "Commander";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <main class="order-page">
            <!-- imports -->
            <?php
                include("../controllers/controllerProduit.php");
                include("../controllers/controllerPanier.php");
            ?>

            <div class="page-content">
            <!-- Show products grid -->
                <?php
                    $controllerProduit = new controllerProduit();

                    // filter by category
                    if (isset($_GET['categorie'])) {
                        $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $urlWithoutParameters = strtok($currentUrl, '?');
                        
                        // Title with an uppercase first letter
                        echo "<h1>" . ucfirst($_GET['categorie']) . "</h1>";
                        echo "<a href='$urlWithoutParameters'>Retirer le filtre 🔎</a>";


                        $controllerProduit->showProduitsGrid($_GET['categorie']);
                    }
                    
                    // Show all products
                    else {
                        $controllerProduit->showProduitsGrid();
                    }
                ?>
            </div>

            <!-- Show the shopping cart -->
            <?php
                $controllerPanier = new controllerPanier();
                $controllerPanier->showPanier();
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
