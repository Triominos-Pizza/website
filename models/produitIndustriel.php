<?php
    require_once("../models/produit.php");

    class pizza extends produit {
        public static $classe = "pizza";

        public int $idRecettePizza;
        public string $texteRecettePizza;
        public int $idPate;
        public int $idSauce;
        public int $idTaillePizza;
        
        public array $categories = array();
        public array $ingredients = array();
        public array $allergenes = array();

        public function __construct($id=null, $nom=null, $prix=null, $urlImage=null) {
            parent::__construct();
            if (!is_null($id)) {
                $this->idFicheProduit = $id;
                $this->nomProduit = $nom;
                $this->prixProduit = $prix;
                $this->urlImageProduit = $urlImage;
                $this->categories = static::getCategoriesFromId($id);
                $this->ingredients = static::getIngredientsFromId($id);
                $this->allergenes = static::getAllergenesFromId($id);
            }
        }

        public static function getAllProduits($categorie=null) {
            if (is_null($categorie)) {
                $produits = static::getAll("FicheProduit");
            } else {
                $produits = static::getProduitsByCategorie($categorie);
            }
            return $produits;
        }

        public static function getProduitsByCategorie($categorie=null) {
            static::connect();
            $requetePreparee = "
                SELECT DISTINCT FicheProduit.*
                FROM FicheProduit
                INNER JOIN TypeProduitFicheProduit
                ON FicheProduit.idFicheProduit = TypeProduitFicheProduit.idFicheProduit
                INNER JOIN TypeProduit
                ON TypeProduit.idTypeProduit = TypeProduitFicheProduit.idTypeProduit
            ";
            $tags = array();

            if (!is_null($categorie)) {
                $requetePreparee .= "WHERE TypeProduit.nomTypeProduit = :categorie";
                $tags[':categorie'] = $categorie;
            }

            $resultat = static::$connexion->prepare($requetePreparee);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_CLASS, static::$classe);
                $produits = $resultat->fetchAll();
                return $produits;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getProduitFromId($id) {
            $produit = static::getOne($id, "FicheProduit");
            return $produit;
        }

        public static function deleteProduit($id) {
            static::delete($id, "FicheProduit");
        }

        
        public static function getCategoriesFromId($id) {
            static::connect();
            $requetePreparee = "
                SELECT *
                FROM TypeProduit
                INNER JOIN TypeProduitFicheProduit
                ON TypeProduit.idTypeProduit = TypeProduitFicheProduit.idTypeProduit
                WHERE TypeProduitFicheProduit.idFicheProduit = :id
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $categories = $resultat->fetchAll();
                return $categories;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getIngredientsFromId($id) {
            static::connect();
            $requetePreparee = "
                SELECT *
                FROM Ingredient
                INNER JOIN IngredientFicheProduit
                ON Ingredient.idIngredient = IngredientFicheProduit.idIngredient
                WHERE IngredientFicheProduit.idFicheProduit = :id
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $ingredients = $resultat->fetchAll();
                return $ingredients;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getAllergenesFromId($id) {
            static::connect();
            $requetePreparee = "
                SELECT *
                FROM Allergene
                INNER JOIN AllergeneFicheProduit
                ON Allergene.idAllergene = AllergeneFicheProduit.idAllergene
                WHERE AllergeneFicheProduit.idFicheProduit = :id
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $allergenes = $resultat->fetchAll();
                return $allergenes;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

    }
?>