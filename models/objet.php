<?php
    require_once(FTP_ROOT_PATH.'/config/db.php');
    
    class objet {
        static protected $connexion;
        static protected $classe;
        static protected $identifiant;

        public static function connect() {
            if (static::$connexion == null) {
                static::$connexion = connexion::connect();
            }
            return static::$connexion;
        }

        public function __construct() {
            require_once('../config/config.php');
            require_once('../config/db.php');
            static::$connexion = connexion::connect();
        }

        public function getId() {
            return static::$identifiant;
        }

        public static function getAll($table = null) {
            static::connect();
            $table = $table ?? static::$classe;
            
            $requete = "SELECT * FROM " . $table;
            $res = static::$connexion->query($requete);
            
            $res->setFetchMode(PDO::FETCH_CLASS, static::$classe);
            $res = $res->fetchAll();
            return $res;
        }

        public static function getOne($id, $table = null) {
            if ($id == null) {
                throw new ArgumentCountError("L'identifiant doit être renseigné.");
            }

            static::connect();
            $table = $table ?? static::$classe;
            
            $identifiant = static::$identifiant;
            $requetePreparee = "SELECT * FROM $table WHERE $identifiant = :id;";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
                $resultat->setFetchMode(PDO::FETCH_CLASS, static::$classe);
                $elem = $resultat->fetch();

                if ($elem == false) {
                    throw new Exception("L'élément n'existe pas.");
                }
                return $elem;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function delete($id, $table = null) {
            if ($id == null) {
                throw new ArgumentCountError("L'identifiant doit être renseigné.");
            }

            static::connect();
            $table = $table ?? static::$classe;

            $identifiant = static::$identifiant;
            $requetePreparee = "DELETE FROM $table WHERE $identifiant = :id;";
            $resultat = static::$connexion->prepare($requetePreparee);
            $tags = array(':id' => $id);
            try {
                $resultat->execute($tags);
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }
    }
?>
