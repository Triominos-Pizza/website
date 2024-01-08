<?php
    require_once("../models/produit.php");

    class pizza extends produit {
        public static $classe = "pizza";

        // Recette de la pizza
        public int $idRecettePizza;
        public string $texteRecettePizza;

        // Options de la pizza
        public int $idPate;
        public int $idSauce;
        public int $idTaillePizza;
        public array $ingredientsRetires = array();
        public array $ingredientsAjoutes = array();

        public function __construct($id=null, $idPate=null, $idSauce=null, $idTaillePizza=null, $ingredientsRetires=null, $ingredientsAjoutes=null) {
            // Produit
            parent::__construct($id);

            if (!is_null($id)) {
                // Recette de la pizza
                $this->idRecettePizza = static::getIdRecettePizza($id);
                $this->texteRecettePizza = static::getTexteRecettePizza($id);

                // Options de la pizza
                $this->idPate = $idPate;
                $this->idSauce = $idSauce;
                $this->idTaillePizza = $idTaillePizza;
                $this->ingredientsRetires = $ingredientsRetires;
                $this->ingredientsAjoutes = $ingredientsAjoutes;

                // Autres
                $this->categories = static::getCategoriesFromId($id);
                $this->ingredients = static::getIngredientsFromId($id);
                $this->allergenes = static::getAllergenesFromId($id);
            }
        }

        public static function getIdRecettePizza($id) {
            static::connect();
            $requetePreparee = "
                SELECT idRecettePizza
                FROM RecettePizza
                WHERE idFicheProduit = :id
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $idRecettePizza = $resultat->fetch();
                return $idRecettePizza["idRecettePizza"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getTexteRecettePizza($id) {
            static::connect();
            $requetePreparee = "
                SELECT texteRecettePizza
                FROM RecettePizza
                WHERE idFicheProduit = :id
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $recettePizza = $resultat->fetch();
                return $recettePizza["texteRecettePizza"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getAllTaillePizza() {
            static::connect();
            $requete = "SELECT * FROM TaillePizza";
            try {
                $resultat = static::$connexion->query($requete);
                $taillesPizza = $resultat->fetchAll();
                return $taillesPizza;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getAllPate() {
            static::connect();
            $requete = "SELECT * FROM PatePizza";
            try {
                $resultat = static::$connexion->query($requete);
                $pates = $resultat->fetchAll();
                return $pates;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getAllSauce() {
            static::connect();
            $requete = "SELECT * FROM BaseSaucePizza";
            try {
                $resultat = static::$connexion->query($requete);
                $sauces = $resultat->fetchAll();
                return $sauces;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public function getPrix() {
            $prix = parent::getPrix();
            $prix += $this->getPrixPate();
            $prix += $this->getPrixSauce();
            $prix += $this->getPrixTaillePizza();
            $prix += $this->getPrixIngredientsAjoutes();
            $prix -= $this->getPrixIngredientsRetires();
            return $prix;
        }
    }

?>