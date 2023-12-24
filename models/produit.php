<?php
    require_once("../models/objet.php");

    class produit extends objet {
        public static $classe = "produit";
        public static $identifiant = "idFicheProduit";

        public int $idFicheProduit;
        public string $nomProduit;
        public float $prixProduit;
        public string $urlImageProduit;

        public array $categories = array();
        public array $ingredients = array();
        public array $allergenes = array();

        public function __construct($id=null, $nom=null, $prix=null, $urlImage=null) {
            parent::__construct();
            if (!is_null($id)) {
                echo "id non null";
                $this->idFicheProduit = $id;
                $this->nomProduit = $nom;
                $this->prixProduit = $prix;
                $this->urlImageProduit = $urlImage;
                $this->categories = static::getCategories($id);
                $this->ingredients = static::getIngredients($id);
                $this->allergenes = static::getAllergenes($id);
            }
        }

        public static function getProduits() {
            $produits = static::getAll("FicheProduit");
            return $produits;
        }

        public static function getProduit($id) {
            $produit = static::getOne($id, "FicheProduit");
            return $produit;
        }

        public static function deleteProduit($id) {
            static::delete($id, "FicheProduit");
        }

        
        public static function getCategories($id) {
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
                echo "Erreur lors de la requête SQL : <br />";
                echo $e->getMessage();
            }
        }

        public static function getIngredients($id) {
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
                echo "Erreur lors de la requête SQL : <br />";
                echo $e->getMessage();
            }
        }

        public static function getAllergenes($id) {
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
                echo "Erreur lors de la requête SQL : <br />";
                echo $e->getMessage();
            }
        }

    }
?>