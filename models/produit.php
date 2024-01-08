<?php
    require_once("../models/objet.php");

    class produit extends objet {
        public static $classe = "produit";
        public static $identifiant = "idFicheProduit";

        public int $idFicheProduit;
        public string $nomProduit;
        public float $prixProduit;
        public string $urlImageProduit;
        public bool $estProduitDuMoment;

        public array $categories = array();
        public array $ingredients = array();
        public array $allergenes = array();

        // Constructeur
        public function __construct($id=null) {
            parent::__construct();

            if (!is_null($id)) {
                $this->idFicheProduit = $id;

                $infos = static::getInfosProduitFromId($id);
                $this->nomProduit = $infos["nomProduit"];
                $this->prixProduit = $infos["prixProduit"];
                $this->urlImageProduit = $infos["urlImageProduit"];
                $this->estProduitDuMoment = $infos["estProduitDuMoment"];

                $this->categories = static::getCategoriesFromId($id);
                $this->ingredients = static::getIngredientsFromId($id);
                $this->allergenes = static::getAllergenesFromId($id);
            }
        }

        // Getters
        public function getId() { return $this->idFicheProduit; }

        public function getPrix() { return $this->prixProduit; }
        public function getNom() { return $this->nomProduit; }
        public function getUrlImage() { return $this->urlImageProduit; }
        public function getCategories() { return $this->categories; }
        public function getIngredients() { return $this->ingredients; }
        public function getAllergenes() { return $this->allergenes; }

        public static function isPizza($id) {
            // uses the PLSQL function isPizza
            static::connect();
            $requetePreparee = "
                SELECT isPizza(:id) as isPizza
                FROM dual
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $isPizza = $resultat->fetch();
                return $isPizza["isPizza"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
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

        public static function deleteProduitFromId($id) {
            static::delete($id, "FicheProduit");
        }

        public static function getInfosProduitFromId($id) {
            static::connect();
            $requetePreparee = "
                SELECT *
                FROM FicheProduit
                WHERE idFicheProduit = :id
                ";
                $resultat = static::$connexion->prepare($requetePreparee);
                $tags = array(':id' => $id);
                try {
                    $resultat->execute($tags);
                    $produit = $resultat->fetch();
                    return $produit;
                } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }
        
        public static function getProduitFromId($id) {
            require_once("../models/pizza.php");
            if (static::isPizza($id)) {
                $produit = pizza::getOne($id, "FicheProduit");
            } else {
                $produit = static::getOne($id, "FicheProduit");
            }
            return $produit;
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