<?php
    require_once("../models/objet.php");

    class Panier {
        public static function getProduitsSeuls() {
            return $_SESSION['panier']['produits'];
        }

        public static function getMenus() {
            return $_SESSION['panier']['menus'];
        }

        public static function getPanier() {
            return $_SESSION['panier'];
        }

        public static function set() {
            $_SESSION['panier'] = array(
                "produits" => array(),
                "menus" => array()
            );
        }

        public static function empty() {
            static::set();
        }
        
        public static function getPos($produit) {
            for ($i=0; $i < count($_SESSION['panier']['produits']); $i++) {
                echo "getPos()<br />";
                echo "i = " . $i . "<br />";
                echo "idFicheProduit = " . $_SESSION['panier']['produits'][$i]['produit']->idFicheProduit . "<br />";
                if ($_SESSION['panier']['produits'][$i]['produit']->idFicheProduit == $produit->idFicheProduit) {
                    echo "found<br />";
                    return $i;
                }
            }
            return false;
        }

        public static function get($produit) {
            echo "get()<br />";
            $pos = static::getPos($produit);
            echo "pos = " . $pos . "<br />";
            if ($pos !== false) {
                return $_SESSION['panier']['produits'][$pos];
            } else {
                return false;
            }
        }

        public static function delete($pos) {
            // remove product from cart array at index $pos and reindex array
            unset($_SESSION['panier']['produits'][$pos]);
            $_SESSION['panier']['produits'] = array_values($_SESSION['panier']['produits']);
        }

        public static function addProduit($produit, $quantite = 1) {
            echo "addProduit()<br />";
            if (static::getPos($produit) !== false) {
                echo "1<br />";
                $pos = static::getPos($produit);
                $_SESSION['panier']['produits'][$pos]['quantite'] += $quantite;
            } else {
                echo "2<br />";
                $_SESSION['panier']['produits'][] = array(
                    "produit" => $produit,
                    "quantite" => $quantite
                );
            }
        }

        public static function addMenu($id, $nom, $prix) {
            if (isset($_SESSION['panier']['menus'][$id])) {
                // using get() method
                $menu = static::get($id);
                $menu['quantite'] += 1;
            } else {
                $_SESSION['panier']['menus'][] = array(
                    "nom" => $nom,
                    "prix" => $prix,
                    "quantite" => 1
                );
            }
        }

        public static function getTotal() {
            $total = 0;
            foreach ($_SESSION['panier']['produits'] as $produit) {
                $total += $produit['produit']->prixProduit * $produit['quantite'];
            }
            return $total;
        }
    }
?>