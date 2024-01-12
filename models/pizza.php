<?php
    require_once("../models/produit.php");

    class pizza extends produit {
        public static $classe = "pizza";

        // Recette de la pizza
        public int $idRecettePizza;
        public string $texteRecettePizza;
        public float $prixRecettePizza;

        // Options de la pizza
        public ?int $idPate;
        public ?int $idSauce;
        public ?int $idTaillePizza;
        public ?array $ingredientsRecette = array(); // ingredients par defaut de la recette
        public ?array $ingredientsRetires = array(); // ingredients à retirer de la recette
        public ?array $ingredientsAjoutes = array(); // ingredients à ajouter à la recette
        public ?float $prixPizzaAvecOptions;

        public function __construct($id=null, $idPate=null, $idSauce=null, $idTaillePizza=null, $ingredients=null) {
            if (!is_null($id)) {
                // Produit
                parent::__construct($id);

                // Recette de la pizza
                $this->idRecettePizza = static::getIdRecettePizza($id);
                $this->texteRecettePizza = static::getTexteRecettePizza($id);
                $this->prixRecettePizza = $this->getPrix();

                // Options de la pizza
                $this->idPate = $idPate;
                $this->idSauce = $idSauce;
                $this->idTaillePizza = $idTaillePizza;
                $this->ingredientsRecette = static::getIngredientsRecette($this->idRecettePizza);
                $this->ingredientsRetires = static::getIngredientsRetires($ingredients, $this->idRecettePizza);
                $this->ingredientsAjoutes = static::getIngredientsAjoutes($ingredients, $this->idRecettePizza);
                $this->prixPizzaAvecOptions = $this->getPrixAvecOptions();
            }
        }

        // Getters
        public function getPrixRecettePizza() { return $this->prixRecettePizza; }
        public function getIdPate() { return $this->idPate; }
        public function getIdSauce() { return $this->idSauce; }
        public function getIdTaillePizza() { return $this->idTaillePizza; }
        public function getPrixStr() { return isset($this->prixPizzaAvecOptions) ? sprintf("%0.2f", $this->prixPizzaAvecOptions) : "erreur"; }

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

        public static function getNomTaillePizzaFromId($idTaillePizza) {
            static::connect();
            $requetePreparee = "
                SELECT nomTaille
                FROM TaillePizza
                WHERE idTaille = :idTaillePizza
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idTaillePizza' => $idTaillePizza);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $nomTaillePizza = $resultat->fetch();
                return $nomTaillePizza["nomTaille"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            } 
        }

        public static function getNomPateFromId($idPate) {
            static::connect();
            $requetePreparee = "
                SELECT nomPate
                FROM PatePizza
                WHERE idPate = :idPate
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idPate' => $idPate);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $nomPate = $resultat->fetch();
                return $nomPate["nomPate"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            } 
        }

        public static function getNomSauceFromId($idSauce) {
            static::connect();
            $requetePreparee = "
                SELECT nomSauce
                FROM BaseSaucePizza
                WHERE idSauce = :idSauce
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idSauce' => $idSauce);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $nomSauce = $resultat->fetch();
                return $nomSauce["nomSauce"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            } 
        }

        public function getPrixAvecOptions() {
            $prix = $this->prixRecettePizza;
            $prix += $this->getPrixPate($this->idPate);
            $prix += $this->getPrixSauce($this->idSauce);
            $prix += $this->getPrixTaillePizza($this->idTaillePizza);
            $prix += $this->getPrixIngredientsAjoutes();
            return $prix;
        }

        public static function getPrixPate($idPate) {
            if (is_null($idPate)) return 0;

            static::connect();
            $requetePreparee = "
                SELECT prixSupplementPate
                FROM PatePizza
                WHERE idPate = :idPate
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idPate' => $idPate);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $prixPate = $resultat->fetch();
                return $prixPate["prixSupplementPate"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getPrixSauce($idSauce) {
            if (is_null($idSauce)) return 0;

            static::connect();
            $requetePreparee = "
                SELECT prixSupplementBase
                FROM BaseSaucePizza
                WHERE idSauce = :idSauce
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idSauce' => $idSauce);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $prixSauce = $resultat->fetch();
                return $prixSauce["prixSupplementBase"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getPrixTaillePizza($idTaillePizza) {
            if (is_null($idTaillePizza)) return 0;

            static::connect();
            $requetePreparee = "
                SELECT prixSupplementTaille
                FROM TaillePizza
                WHERE idTaille = :idTaillePizza
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idTaillePizza' => $idTaillePizza);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $prixTaillePizza = $resultat->fetch();
                return $prixTaillePizza["prixSupplementTaille"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getAllIngredients() {
            static::connect();
            $requete = "SELECT * FROM Ingredient";
            try {
                $resultat = static::$connexion->query($requete);
                $res = $resultat->fetchAll(PDO::FETCH_ASSOC);

                $ingredients = array();
                foreach ($res as $ingredient) {
                    $ingredients[$ingredient["idIngredient"]] = $ingredient;
                }

                return $ingredients;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getIngredientsRecette($idRecettePizza) {
            static::connect();
            $requetePreparee = "
                SELECT Ingredient.*, IngredientRecette.quantite, IngredientRecette.estModifiable
                FROM Ingredient
                INNER JOIN IngredientRecette
                ON Ingredient.idIngredient = IngredientRecette.idIngredient
                WHERE IngredientRecette.idRecettePizza = :idRecettePizza
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':idRecettePizza' => $idRecettePizza);
            try {
                $resultat->execute($tags);
                $ingredients = array();
                $res = $resultat->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $ingredient) {
                    $ingredients[$ingredient["idIngredient"]] = $ingredient;
                }
                
                return $ingredients;

            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            } 
        }

        /* Récupérer parmi une liste d'ingrédients ceux qui on étés ajoutés (i.e. ne sont pas par défaut dans la recette) */
        public static function getIngredientsAjoutes($qteIngredients, $idRecettePizza) {
            $allIngredients = static::getAllIngredients();

            $ingredientsRecette = static::getIngredientsRecette($idRecettePizza);
            if (is_null($qteIngredients)) return null;

            $ingredientsAjoutes = array();

            foreach ($qteIngredients as $idIngredient => $qteTotaleIngredient) {
                // Récupérer la quantité ajoutée de l'ingrédient
                $qteAjouteeIngredient = $qteTotaleIngredient;
                if (array_key_exists($idIngredient, $ingredientsRecette)) {
                    // Si l'ingrédient est dans la recette, on retire sa quantité par défaut
                    $qteAjouteeIngredient -= $ingredientsRecette[$idIngredient]["quantite"];
                }
                
                // Si la quantité ajoutée est positive, on ajoute l'ingrédient à la liste des ingrédients ajoutés
                if ($qteAjouteeIngredient > 0) {
                    $ingredient = $allIngredients[$idIngredient];
                    $ingredient["quantite"] = $qteAjouteeIngredient;
                    $ingredientsAjoutes[$idIngredient] = $ingredient;
                }
            }

            return $ingredientsAjoutes;
        }

        /* Récupérer parmi une liste d'ingrédients ceux qui on étés retirés (i.e. sont par défaut dans la recette mais ne sont pas dans la liste) */
        public static function getIngredientsRetires($qteIngredients, $idRecettePizza) {
            $ingredientsRecette = static::getIngredientsRecette($idRecettePizza);
            if (is_null($qteIngredients)) return null;

            $ingredientsRetires = array();

            foreach ($qteIngredients as $idIngredient => $qteTotaleIngredient) {
                // Si l'ingrédient n'est pas dans la recette, il ne peut pas avoir été retiré
                if (!array_key_exists($idIngredient, $ingredientsRecette)) continue;
                $ingredientRecette = $ingredientsRecette[$idIngredient];

                // Récupérer la quantité retirée de l'ingrédient
                $qteRetireeIngredient = $ingredientRecette["quantite"];
                if (array_key_exists($idIngredient, $ingredientsRecette)) {
                    // Si l'ingrédient est dans la liste, on retire sa quantité ajoutée
                    $qteRetireeIngredient -= $qteTotaleIngredient;
                }
                
                // Si la quantité retirée est positive, on ajoute l'ingrédient à la liste des ingrédients retirés
                if ($qteRetireeIngredient > 0) {
                    echo "<p style='color: red;'>A été retiré : $qteRetireeIngredient</p>";
                    $ingredientRecette["quantite"] = $qteRetireeIngredient;
                    $ingredientsRetires[$idIngredient] = $ingredientRecette;
                }
            }

            return $ingredientsRetires;
        }


        public function getPrixIngredientsAjoutes() {
            if (is_null($this->ingredientsAjoutes)) return 0;

            $prix = 0;
            foreach ($this->ingredientsAjoutes as $ingredient) {
                $prix += $ingredient["prixVenteIngredient"] * $ingredient["quantite"];
            }
            return $prix;
        }

        public static function updateStockIngredient($ingredients) {
            // TODO
        }
    }

?>