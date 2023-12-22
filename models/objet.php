<?php
    require_once('../config/db.php');
    
    class objet {
        static protected $connexion;

        public static function connect() {
            if (static::$connexion == null) {
                static::$connexion = connexion::connect();
            }
            return static::$connexion;
        }

        public function __construct() {
            
        }

        public function get($attribut) {
            return $this->$attribut;
        }

        public function set($attribut, $valeur) : void {
            $this->$attribut = $valeur;
        }

        public function getId() {
            return static::$identifiant;
        }

        public static function getAll($table = null) {
            $table = $table ?? static::$classe;
            
            static::connect();
            $requete = "SELECT * FROM " . $table;
            $res = static::$connexion->query($requete);
            
            $res->setFetchMode(PDO::FETCH_CLASS, static::$classe);
            $res = $res->fetchAll();
            return $res;
        }

        public static function getOne($id) {
            if ($id == null) {
                throw new ArgumentCountError("L'identifiant doit être renseigné.");
            }

            $classeRecuperee = static::$classe;
            $identifiant = static::$identifiant;
            $requetePreparee = "SELECT * FROM $classeRecuperee WHERE $identifiant = :id;";
            $resultat = connexion::pdo()->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_CLASS, $classeRecuperee);
                $elem = $resultat->fetch();

                if ($elem == false) {
                    throw new NotFoundException("L'élément n'existe pas.");
                }
                return $elem;
            } catch (PDOException $e) {
                echo "Erreur lors de la requête SQL : <br />";
                echo $e->getMessage();
            }
        }

        public static function delete($id) {
            if ($id == null) {
                throw new ArgumentCountError("L'identifiant doit être renseigné.");
            }

            $classeRecuperee = static::$classe;
            $identifiant = static::$identifiant;
            $requetePreparee = "DELETE FROM $classeRecuperee WHERE $identifiant = :id;";
            $resultat = connexion::pdo()->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
            } catch (PDOException $e) {
                echo "Erreur lors de la requête SQL : <br />";
                echo $e->getMessage();
            }
        }
    }
?>
