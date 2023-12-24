<?php
    require_once("../models/produit.php");
    require("../controllers/controllerObjet.php");

class controllerProduit extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showProduitsGrid() {
            $produits = produit::getProduits();

            echo "<div class='products-grid'>";
            foreach ($produits as $produit) {
                echo "<div class='product'>";
                echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                echo "<h3>$produit->nomProduit</h3>";
                echo "<p>$produit->prixProduit €</p>";
                echo "<a href='product.php?id=$produit->idFicheProduit'>Voir le produit</a>";
                echo "</div>";
            }
            echo "</div>";
        }

        public static function showProduitDetails($id) {
            $produit = produit::getOne($id, "FicheProduit");

            // echo "<div class='product'>";
            echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' style='width: 250px; height: auto;' />";
            echo "<h3>$produit->nomProduit</h3>";
            echo "<p>$produit->prixProduit €</p>";
            // echo "</div>";

            echo "<pre>";
            print_r($produit);
            print_r(produit::getCategories($id));
            print_r(produit::getIngredients($id));
            print_r(produit::getAllergenes($id));
            echo "</pre>";
        }

        public static function getProduit($id) {
            $produit = produit::getOne($id, "FicheProduit");
            return $produit;
        }

        public static function deleteProduit($id) {
            produit::delete($id);
        }
    }