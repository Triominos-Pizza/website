<!--?php session_start(); ?-->
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
            <?php
                include("../controllers/controllerProduit.php");
                include("../controllers/controllerPanier.php");
            ?>

            <div class="page-content">
                <?php
                    $controllerProduit = new controllerProduit();

                    if (isset($_GET['categorie'])) {
                        $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $urlWithoutParameters = strtok($currentUrl, '?');
                        
                        echo "<h1>".$_GET['categorie']."</h1>";
                        echo "<a href='$urlWithoutParameters'>Retirer le filtre 🔎</a>";


                        $controllerProduit->showProduitsGrid($_GET['categorie']);
                    } else {
                        $controllerProduit->showProduitsGrid();
                    }

                    $controllerPanier = new controllerPanier();
                    if (isset($_GET['ajoutPanier'])) {
                        $controllerPanier->addProduit($_GET['ajoutPanier'], isset($_GET['quantite']) ? $_GET['quantite'] : 1);
                    }
                ?>
            </div>

            <?php
                $controllerPanier = new controllerPanier();
                $controllerPanier->showPanier();
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
