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
            $produits = array_merge($produitsDuMoment, $produits);

            // Afficher la grille
            echo "<div class='products-grid'>";
            foreach ($produits as $produit) {
                echo "<div class='product". ($produit->estProduitDuMoment ? ' produitdumoment' : '') ."' onclick='window.location.href=\"product.php?id=$produit->idFicheProduit\"'>";
                echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                echo "<h3>$produit->nomProduit</h3>";
                if ($produit->estProduitDuMoment) {
                    echo "<p class='produitdumoment-label'>Produit du moment</p>";
                }
                echo "<p>".$produit->getPrixStr()." €</p>";
                echo "<a href='product.php?id=$produit->idFicheProduit'>Voir le produit</a>";
                echo "</div>";
            }
            echo "</div>";
        }

        public static function showProduitHeader($id) {
            echo "<div class='product-page-header'>";
                // Bouton retour
                echo "<a class='primary-button' href='".ROOT_URL."/pages/order.php'>↩ Retour à la liste des produits</a>";

                // Catégories
                static::showCategories($id);
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
                echo "<div class='product-title'>";
                    echo "<h1>$produit->nomProduit</h1>";
                    if ($produit->estProduitDuMoment) {
                        echo "<p class='produitdumoment-label'>Produit du moment</p>";
                    }
                echo "</div>";

                echo "<div class='product-info'>";
                    echo "<div class='product-left'>";
                        echo "<img class='product-img' src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                        static::showAllergenes($id);
                    echo "</div>";
                    echo "<div class='product-details'>";
                        static::showForm($id);
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        
        public static function showForm($id) {
            $produit = produit::getProduitFromId($id);
            
            // import script
            echo "<script type='text/javascript' src='".ROOT_URL."/scripts/js/product_form.js' defer></script>";

            echo "<form action='".ROOT_URL."/controllers/controllerPanier.php' method='post' class='product-form'>";

                // hidden inputs for the controller
                echo "<input type='hidden' name='form' value='ajouterProduit' />";
                echo "<input type='hidden' name='id' value='$produit->idFicheProduit' />";
                echo "<input type='hidden' name='price' value='".$produit->getPrixStr()."' />";

                // form
                echo "<div class='product-form'>";

                    // pizza options
                    static::showFormPizza($id);

                    // quantity
                    echo "<div class='product-form-quantite'>";
                        echo "<label for='quantite'><h4>Quantité</h4></label>";
                        echo "<div class='product-form-quantite-input'>";
                            echo "<input type='number' name='quantite' id='quantite' value='1' min='1' max='10'/>";
                            echo "<button type='button' class='secondary-button mini-button' onclick='decrQuantite()'>-</button>";
                            echo "<button type='button' class='secondary-button mini-button' onclick='incrQuantite()'>+</button>";
                        echo "</div>";
                    echo "</div>";

                    // submit
                    echo "<div class='product-form-submit'>";
                        echo "<div class='product-buy'>";
                        echo "<h3 class='product-price'>".$produit->getPrixStr()." €</h3>";
                            echo "<input type='submit' class='primary-button large-button' value='Ajouter au panier 🛒'>";
                        echo "</div>";
                    echo "</div>";

                echo "</div>";
            echo "</form>";
        }

        public static function showFormPizza($id) {
            // Si c'est une pizza, on affiche les options de taille, pâte et sauce ainsi que les ingrédients
            if (produit::isPizza($id)) {
                // taille
                $tailles = pizza::getAllTaillePizza();
                echo "<div class='product-form-taille'>";
                    echo "<label for='taille'><h4>Taille</h4></label>";
                    echo "<select class='product-form-taille-input' name='taille' id='taille'>";
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
                    echo "<label for='pate'><h4>Pâte</h4></label>";
                    echo "<select class='product-form-pate-input' name='pate' id='pate'>";
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
                    echo "<label for='sauce'><h4>Sauce</h4></label>";
                    echo "<select class='product-form-sauce-input' name='sauce' id='sauce'>";
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
                $ingredientsRecette = pizza::getIngredientsRecette($id);
                $ingredients = pizza::getAllIngredients();

                // Déplacer les ingrédients présents dans la recette au début
                foreach ($ingredientsRecette as $ingredientRecette) {
                    foreach ($ingredients as $key => $ingredient) {
                        if ($ingredientRecette["idIngredient"] == $ingredient["idIngredient"]) {
                            unset($ingredients[$key]);
                            array_unshift($ingredients, $ingredient);
                        }
                    }
                }

                echo "<div class='product-form-ingredients'>";
                    echo "<label for='ingredients'><h4>Ingrédients</h4></label>";
                    echo "<div class='product-form-ingredients-list fade-right'>";
                        foreach ($ingredients as $ingredient) {
                            // get the current ingredient in $ingredientsRecette with the same id as $ingredient
                            $ingredientRecette = null;
                            foreach ($ingredientsRecette as $ingredientRecetteTemp) {
                                if ($ingredientRecetteTemp["idIngredient"] == $ingredient["idIngredient"]) {
                                    $ingredientRecette = $ingredientRecetteTemp;
                                    break;
                                }
                            }

                            echo "<div class='product-form-ingredient'>";
                                // price supplement
                                echo "<input type='hidden' name='ingredientsSupplement[".$ingredient["idIngredient"]."]' value='" . $ingredient["prixVenteIngredient"] . "' />";

                                // label
                                echo "<label for='ingredient-" . $ingredient["idIngredient"] . " default='" . $ingredient["nomIngredient"] . "'>";
                                    echo $ingredient["nomIngredient"];
                                echo "</label>";

                                // image
                                echo "<img src='" . ROOT_PATH . $ingredient["urlImageIngredient"] . "' alt='" . $ingredient["nomIngredient"] . "' />";

                                // input
                                echo "<input
                                    type='number'
                                    name='ingredients[".$ingredient["idIngredient"]."]'
                                    id='ingredient-" . $ingredient["idIngredient"] . "'
                                    value='" . (!is_null($ingredientRecette) ? $ingredientRecette["quantite"] : 0) . "'
                                    min='0' max='10'" .
                                    (!is_null($ingredientRecette) ? ($ingredientRecette["estModifiable"] ? "" : "disabled") : "") .
                                "/>";

                                echo "<div class='product-form-ingredient-input'>";
                                    echo "<button type='button' class='secondary-button mini-button' onclick='decrIngredient(".$ingredient["idIngredient"].")'>-</button>";
                                    echo "<button type='button' class='secondary-button mini-button' onclick='resetIngredient(".$ingredient["idIngredient"].")'>↺</button>";
                                    echo "<button type='button' class='secondary-button mini-button' onclick='incrIngredient(".$ingredient["idIngredient"].")'>+</button>";
                                echo "</div>";
                                
                            echo "</div>";
                        }
                    echo "</div>";
                echo "</div>";
            }
        }

        public static function showCategories($id) {
            $categories = produit::getCategoriesFromId($id);
            echo "<div class='categories'>";
            echo "<h4>Catégories : </h4>";
            foreach ($categories as $categorie) {
                echo "<a class='categorie' href='".ROOT_URL."/pages/order.php?categorie=".$categorie["nomTypeProduit"]."'>" . $categorie["nomTypeProduit"] . "</a>";
            }
            echo "</div>";
        }

        public static function showAllergenes($id) {
            $allergenes = produit::getAllergenesFromId($id);
            if (count($allergenes) == 0) return;

            echo "<div class='allergenes'>";
            echo "<h4>Allergènes</h4>";
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
            $ingredients = pizza::getIngredientsRecette($id);
            if (count($ingredients) == 0) return;

            echo "<div class='ingredients'>";
            echo "<h4>Ingrédients</h4>";
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
