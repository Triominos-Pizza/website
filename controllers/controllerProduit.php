<?php
    require_once("../models/produit.php");

    class controllerProduit {
        public static function showProduitsGrid() {
            produit::connect();
            $produits = produit::getProduits();

            echo "<div class='products-grid'>";
            foreach ($produits as $produit) {
                echo "<div class='product'>";
                echo "<img src='" . ROOT_PATH . "$produit->urlImageProduit' alt='$produit->nomProduit' />";
                echo "<h3>$produit->nomProduit</h3>";
                echo "<p>$produit->prixProduit €</p>";
                echo "<a href='produit.php?id=$produit->idFicheProduit'>Voir le produit</a>";
                echo "</div>";
            }
            echo "</div>";
        }

        public static function getProduit($id) {
            $produit = produit::getOne($id);
            return $produit;
        }

        public static function deleteProduit($id) {
            produit::delete($id);
        }
    }