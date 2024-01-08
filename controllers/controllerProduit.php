<?php
    require_once("../models/produit.php");
    require_once("../controllers/controllerObjet.php");

class controllerProduit extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showProduitsGrid($categorie=null) {
            $produits = produit::getAllProduits($categorie);

            // S'il n'y a aucun produit, afficher un message d'erreur
            if (count($produits) == 0) {
                echo "<div class='error-message' style='margin-block: 20vh;'>";
                echo "Aucun produit trouvé";
                echo "</div>";
                return;
            }

            // Déplacer le(s) produit(s) du moment au début
            $produitsDuMoment = array();
            foreach ($produits as $key => $produit) {
                if ($produit->estProduitDuMoment) {
                    $produitsDuMoment[] = $produit;
                    unset($produits[$key]);
                }
            }
            $produits = $produitsDuMoment + $produits;

            // Afficher la grille
            echo "<div class='products-grid'>";
            foreach ($produits as $produit) {
                echo "<div class='product". ($produit->estProduitDuMoment ? ' produitdumoment' : '') ."' onclick='window.location.href=\"product.php?id=$produit->idFicheProduit\"'>";
                echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                echo "<h3>$produit->nomProduit</h3>";
                if ($produit->estProduitDuMoment) {
                    echo "<p class='produitdumoment-label'>Produit du moment</p>";
                }
                echo "<p>$produit->prixProduit €</p>";
                echo "<a href='product.php?id=$produit->idFicheProduit'>Voir le produit</a>";
                echo "</div>";
            }
            echo "</div>";
        }

        public static function showProduitDetails($id) {
            try {
                $produit = produit::getProduitFromId($id);
            } catch (Exception $e) {
                echo "<div class='error-message'>Produit introuvable</div>";
                return;
            }

            echo "<div class='page-content'>";
                static::showCategories($id);
                
                echo "<script>document.write('<a href=\'' + document.referrer + '\'>↩ Retour</a>');</script>";
                
                echo "<div class='product-title'>";
                    echo "<h1>$produit->nomProduit</h1>";
                    if ($produit->estProduitDuMoment) {
                        echo "<p class='produitdumoment-label'>Produit du moment</p>";
                    }
                echo "</div>";

                echo "<div class='product-info'>";
                    echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                    echo "<div class='product-details'>";
                        echo "<div class='product-description'>";
                            static::showIngredients($id);
                            static::showAllergenes($id);
                        echo "</div>";
                        static::showForm($id);
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        
        public static function showForm($id) {
            $produit = produit::getProduitFromId($id);
            echo "<form action='".ROOT_URL."/controllers/controllerPanier.php' method='post' class='product-form'>";

                // hidden inputs for the controller
                echo "<input type='hidden' name='form' value='ajouterProduit' />";
                echo "<input type='hidden' name='id' value='$produit->idFicheProduit' />";

                // form
                echo "<div class='product-form'>";

                    // Si c'est une pizza, on affiche les options de taille, pâte et sauce
                    if (produit::isPizza($id)) {
                        // taille
                        $tailles = pizza::getAllTaillePizza();
                        echo "<div class='product-form-taille'>";
                            echo "<label for='taille'>Taille : </label>";
                            echo "<select name='taille' id='taille'>";
                                foreach ($tailles as $taille) {
                                    echo "<option value='" . $taille["idTaille"] . "'>" . $taille["nomTaille"];
                                    if ($taille["prixSupplementTaille"] > 0) {
                                        echo " (+" . $taille["prixSupplementTaille"] . " €)";
                                    }
                                    echo "</option>";
                                }
                            echo "</select>";
                        echo "</div>";

                        // pâte
                        $pates = pizza::getAllPate();
                        echo "<div class='product-form-pate'>";
                            echo "<label for='pate'>Pâte : </label>";
                            echo "<select name='pate' id='pate'>";
                                foreach ($pates as $pate) {
                                    echo "<option value='" . $pate["idPate"] . "'>" . $pate["nomPate"];
                                    if ($pate["prixSupplementPate"] > 0) {
                                        echo " (+" . $pate["prixSupplementPate"] . " €)";
                                    }
                                    echo "</option>";
                                }
                            echo "</select>";
                        echo "</div>";

                        // sauce
                        $sauces = pizza::getAllSauce();
                        echo "<div class='product-form-sauce'>";
                            echo "<label for='sauce'>Sauce : </label>";
                            echo "<select name='sauce' id='sauce'>";
                                foreach ($sauces as $sauce) {
                                    echo "<option value='" . $sauce["idSauce"] . "'>" . $sauce["nomSauce"];
                                    if ($sauce["prixSupplementBase"] > 0) {
                                        echo " (+" . $sauce["prixSupplementBase"] . " €)";
                                    }
                                    echo "</option>";
                                }
                            echo "</select>";
                        echo "</div>";

                        // ingredients
                        $ingredients = produit::getIngredientsFromId($id);
                        echo "<div class='product-form-ingredients'>";
                            echo "<label for='ingredients'>Ingrédients : </label>";
                            echo "<div class='product-form-ingredients-list'>";
                                foreach ($ingredients as $ingredient) {
                                    echo "<div class='product-form-ingredient'>";
                                        echo "<input type='checkbox' name='ingredientsAjoutes[]' id='ingredient-" . $ingredient["idIngredient"] . "' value='" . $ingredient["idIngredient"] . "' checked />";
                                        echo "<input type='checkbox' name='ingredientsRetires[]' id='ingredient-" . $ingredient["idIngredient"] . "' value='" . $ingredient["idIngredient"] . "' checked />";
                                        echo "<label for='ingredient-" . $ingredient["idIngredient"] . "'>" . $ingredient["nomIngredient"];
                                        echo "</label>";
                                    echo "</div>";
                                }
                            echo "</div>";
                        echo "</div>";
                    }

                    // quantity
                    echo "<div class='product-form-quantite'>";
                        echo "<label for='quantite'>Quantité : </label>";
                        echo "<input type='number' name='quantite' id='quantite' value='1' min='1' max='10' />";
                    echo "</div>";

                    // submit
                    echo "<div class='product-form-submit'>";
                        echo "<div class='product-buy'>";
                            echo "<input type='submit' class='primary-button large-button' value='Ajouter au panier 🛒'>";
                            echo "<script type='text/javascript' src='".ROOT_URL."/scripts/js/calculate_price.js'></script>";
                            echo "<h3 class='product-price'>$produit->prixProduit €</h3>";
                        echo "</div>";
                    echo "</div>";

                echo "</div>";
            echo "</form>";
        }

        public static function showCategories($id) {
            $categories = produit::getCategoriesFromId($id);
            echo "<div class='categories'>";
            echo "<h4>Catégories : </h4>";
            foreach ($categories as $categorie) {
                // echo "<div class='categorie'>";
                echo "<a class='categorie' href='".ROOT_URL."/pages/order?categorie=".$categorie["nomTypeProduit"]."'>" . $categorie["nomTypeProduit"] . "</a>";
                // echo "</div>";
            }
            echo "</div>";
        }

        public static function showAllergenes($id) {
            $allergenes = produit::getAllergenesFromId($id);
            if (count($allergenes) == 0) return;

            echo "<div class='allergenes'>";
            echo "<h4>Allergènes : </h4>";
            echo "<div class='allergenes-icons'>";
            foreach ($allergenes as $allergene) {
                echo "<div class='allergene'>";
                echo "<img src='" . ROOT_URL . $allergene["urlIconneAllergene"] . "' alt='" . $allergene["nomAllergene"] . "' />";
                echo "<p>" . $allergene["nomAllergene"] . "</p>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }

        public static function showIngredients($id) {
            $ingredients = produit::getIngredientsFromId($id);
            if (count($ingredients) == 0) return;

            echo "<div class='ingredients'>";
            echo "<h4>Ingrédients : </h4>";
            echo "<div class='ingredients-icons'>";
            foreach ($ingredients as $ingredient) {
                echo "<div class='ingredient'>";
                echo "<img src='" . ROOT_URL . $ingredient["urlImageIngredient"] . "' alt='" . $ingredient["nomIngredient"] . "' />";
                echo "<p>" . $ingredient["nomIngredient"] . "</p>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }

        public static function getProduit($id) {
            $produit = produit::getProduitFromId($id);
            return $produit;
        }

        public static function deleteProduit($id) {
            produit::delete($id);
        }
    }
?>
