<?php
    require_once("../models/produit.php");
    require_once("../controllers/controllerProduit.php");
    
    require_once("../models/pizza.php");
    
    require_once("../controllers/controllerPanier.php");
    require_once("../models/panier.php");

    // Style
    $title = "Test session";
    include_once("../views/components/head.php");

    if (!isset($_SESSION)) {
        session_start();
    }

    function panierTest() {
        $_SESSION['panier'] = array(
            "produits" => array(),
            "menus" => array()
        );
        
        // produits
        $controllerProduit = new controllerProduit();
        $produits = array();
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(1),
            "quantite" => 1
        );
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(2),
            "quantite" => 2
        );
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(3),
            "quantite" => 3
        );
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(6),
            "quantite" => 6
        );
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(7),
            "quantite" => 7
        );
        
        $produits[] = array(
            "produit" => $controllerProduit->getProduit(8),
            "quantite" => 8
        );
    
        // menus
        $menus = array();
        
        // panier
        $_SESSION['panier'] = array(
            "produits" => $produits,
            "menus" => $menus,
        );
    }



    // ----------------------------- ACTIONS -----------------------------
    
    echo "<style>
        label {margin-right: 10px;} 
        input {margin-right: 10px; width: auto;}
    </style>";

    echo "<h1>ACTIONS</h1>";

    // button "ajouter produit"
    echo "<h2>Ajouter un produit</h2>";
    echo "<label for='idProduitAAjouter'>idProduit</label>";
    echo "<input type='number' id='idProduitAAjouter'>";
    echo "<label for='quantiteAAjouter'>Quantité</label>";
    echo "<input type='number' id='quantiteAAjouter' value='1'>";
    echo "<button onclick='window.location.href=\"test-session.php?ajouterProduit&idProduitAAjouter=\"+document.getElementById(\"idProduitAAjouter\").value+\"&quantiteAAjouter=\"+document.getElementById(\"quantiteAAjouter\").value'>Ajouter un produit</button><br>";
    if (isset($_GET['ajouterProduit'])) {
        panier::addProduit(produit::getProduitFromId($_GET['idProduitAAjouter']), $_GET['quantiteAAjouter']);
    }

    // button "supprimer produit"
    echo "<h2>Supprimer un produit</h2>";
    echo "<label for='idProduitASupprimer'>pos</label>";
    echo "<input type='number' id='idProduitASupprimer'>";
    echo "<button onclick='window.location.href=\"test-session.php?supprimerProduit&idProduitASupprimer=\"+document.getElementById(\"idProduitASupprimer\").value'>Supprimer un produit</button><br>";
    if (isset($_GET['supprimerProduit'])) {
        panier::remove($_GET['idProduitASupprimer']);
    }

    // button "vider session"
    echo "<h2>Vider la session</h2>";
    echo "<button onclick='window.location.href=\"test-session.php?resetSession\"'>Reset la session</button><br>";
    if (isset($_GET['resetSession'])) {
        session_unset();
    }

    // button "vider panier"
    echo "<h2>Vider le panier</h2>";
    echo "<button onclick='window.location.href=\"test-session.php?viderPanier\"'>Vider le panier</button><br>";
    if (isset($_GET['viderPanier'])) {
        panier::empty();
    }
    
    // button "test"
    if (isset($_GET['test'])) {
        panierTest();
    } else {
        echo "<h2>Tester avec des données de test</h2>";
        echo "<button onclick='window.location.href=\"test-session.php?test\"'>Tester avec des données de test</button><br>";
    }



    // ----------------------------- AFFICHAGE -----------------------------
    
    echo "<hr>";
    echo "<h1>AFFICHAGE</h1>";

    // session
    echo "<h2>SESSION</h2>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    // json
    echo "<h2>JSON</h2>";
    echo "<pre>";
    $json = json_encode($_SESSION);
    echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
    echo "</pre>";
    
    // Panier
    echo "<h2>Panier</h2>";
    echo "<style>.panier {width:80%; margin: 0 auto;}</style>";
    $controllerPanier = new controllerPanier();
    $controllerPanier->showPanier();
    ?>