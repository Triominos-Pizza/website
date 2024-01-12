<?php
    class_exists('controllerObjet') ? null : require("../controllers/controllerObjet.php");
    require_once("../controllers/controllerProduit.php");

    require_once("../models/panier.php");
    require_once("../models/produit.php");
    require_once("../models/pizza.php");
    
    // Reset session to avoid conflicts
    session_reset();
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_POST["form"])) {
        switch ($_POST["form"]) {
            case "supprimerProduit":
                // Delete product from cart
                panier::remove($_POST["posProduitASupprimer"]);
                break;

            case "ajouterProduit":
                // construct Produit or Pizza object
                if (produit::isPizza($_POST["id"])) {
                    $produit = new pizza($_POST["id"], $_POST["pate"], $_POST["sauce"], $_POST["taille"], $_POST["ingredients"]);
                    // echo "<pre><h1>\$produit</h1>"; var_dump($produit); echo "</pre>";
                    // echo "<pre><h1>\$_POST</h1>"; var_dump($_POST); echo "</pre>";
                    // exit();
                } else {
                    $produit = new produit($_POST["id"]);
                }
                
                // Add product to cart
                panier::addProduit($produit, $_POST["quantite"]);
                break;
            
            case "viderPanier":
                // Empty cart
                panier::empty();
                break;
            
            case "commander":
                // Redirect to checkout page
                header("Location: ".ROOT_URL."/pages/checkout.php");
                exit();
            
            default:
                break;
        }

        // Redirect to last page
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    class controllerPanier extends controllerObjet {
        public static $panier;

        public function __construct() {
            parent::__construct();
            static::$panier = new Panier();
        }

        public static function showPanier($editable=true) {
            // Make sure the class "produit" is loaded before accessing its properties
            !isset($produit["produit"]) ? $produit["produit"] = new produit() : null;
            
            echo "<div class='panier'>";
                echo "<h2>Mon panier</h2>";

                if (!isset($_SESSION['panier'])) { static::$panier->set(); }
                $produits = static::$panier->getProduitsSeuls();

                // Record the number of products in the cart to use it in js scripts
                echo "<input type='hidden' id='nbProduitsDansPanier' value='".count($produits)."' />";


                if (is_null($produits) or count($produits) == 0) {
                    echo "<div class='error-message'>";
                    echo "Aucun produit dans le panier";
                    echo "</div>";
                }

                else {
                    echo "<div class='panier-produits'>";
                        echo "<ul class='panier-liste'>";

                            for ($i = 0; $i < count($produits); $i++) {
                                $produit = static::$panier->getProduitsSeuls()[$i];
                                $isPizza = produit::isPizza($produit["produit"]->idFicheProduit);

                                // echo "<pre>"; var_dump($produit); echo "</pre>";

                                echo "<li class='panier-produit'>";

                                    // Image
                                    echo "<div class='panier-produit-image'>";
                                        echo "<img src='" .ROOT_URL . $produit["produit"]->urlImageProduit . "' alt='" . $produit["produit"]->nomProduit . "' />";
                                    echo "</div>";
                                
                                    echo "<div class='panier-produit-infos'>";
                                        // Nom
                                        echo "<div class='panier-produit-nom'>";
                                            echo "<b>".$produit["quantite"]."x</b> " . ($isPizza ? "Pizza " : "") . $produit["produit"]->nomProduit;
                                        echo "</div>";

                                        // Suppléments
                                        if (produit::isPizza($produit["produit"]->idFicheProduit)) {
                                            echo "<div class='panier-produit-options'>";
                                                // Options
                                                echo "<ul class='panier-produit-supplements'>";
                                                    $nomSauce = pizza::getNomSauceFromId($produit['produit']->idSauce);
                                                    echo "<li>Base ". $nomSauce ."</li>";
                                                    $nomPate = pizza::getNomPateFromId($produit['produit']->idPate);
                                                    echo "<li>". $nomPate ."</li>";
                                                    $nomTaillePizza = pizza::getNomTaillePizzaFromId($produit['produit']->idTaillePizza);
                                                    echo "<li>Taille : ". $nomTaillePizza ."</li>";

                                                echo "</ul>";

                                                // Ingredients retirés
                                                echo "<ul class='panier-produit-ingredients-retires'>";
                                                    foreach ($produit['produit']->ingredientsRetires as $ingredient) {
                                                        echo "<li><i>" . $ingredient['quantite'] . "x</i> " . $ingredient['nomIngredient'] . "</li>";
                                                    }
                                                echo "</ul>";

                                                // Ingredients ajoutés
                                                echo "<ul class='panier-produit-ingredients-ajoutes'>";
                                                    foreach ($produit['produit']->ingredientsAjoutes as $ingredient) {
                                                        echo "<li><i>" . $ingredient['quantite'] . "x</i> " . $ingredient['nomIngredient'] . "</li>";
                                                    }
                                                echo "</ul>";
                                            echo "</div>";
                                        }
                                    
                                        // Prix
                                        echo "<div class='panier-produit-prix'>";
                                            echo $produit["produit"]->getPrixStr() . " €";
                                        echo "</div>";
                                    echo "</div>";

                                    // Bouton supprimer
                                    if ($editable) {
                                        echo "<div class='panier-produit-supprimer'>";
                                            echo "<form method='post' action='".ROOT_URL."/controllers/controllerPanier.php'>";
                                                echo "<input type='hidden' name='form' value='supprimerProduit' />";
                                                echo "<input type='hidden' name='posProduitASupprimer' value='$i' />";
                                                echo "<input type='submit' value='🗑️' />";
                                            echo "</form>";
                                        echo "</div>";
                                    }
                                
                                echo "</li>";
                            }
                        echo "</ul>";
                    echo "</div>";
                }
  
                echo "<div class='panier-total'>";
                    echo "<h3 class='total'>Total</h3>";
                    echo "<p class='price'>" . static::$panier->getTotal() . " €</p>";
                echo "</div>";

                if ($editable) {
                    echo "<div class='panier-actions'>";
                        echo "<form method='post' action='".ROOT_URL."/controllers/controllerPanier.php'>";
                            echo "<input type='hidden' name='form' value='commander' />";
                            echo "<input type='submit' class='primary-button' value='Commander 🛒' />";
                        echo "</form>";
                        echo "<form method='post' action='".ROOT_URL."/controllers/controllerPanier.php'>";
                            echo "<input type='hidden' name='form' value='viderPanier' />";
                            echo "<input type='submit' class='secondary-button mini-button' value='Vider le panier 🗑️' />";
                        echo "</form>";
                    echo "</div>";
                }

            echo "</div>";
        }

        public static function addProduit($idProduit, $quantite) {
            panier::addProduit($idProduit, $quantite);
        }
    }
?>
