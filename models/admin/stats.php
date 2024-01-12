<?php
    require_once("../../models/objet.php");

    class Stats extends objet {
        public function __construct($id=null, $nom=null) {
            parent::__construct();
        }

        public static function getCA($dateDebut, $dateFin) {
            static::connect();

            // check if dateDebut and dateFin are valid dates (YYYY-MM-DD) with regex
            foreach (array($dateDebut, $dateFin) as $date) {
                if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date) ||
                    !checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)) ) {
                    throw new Exception("Dates invalides");
                }
            }
            
            if ($dateDebut > $dateFin) {
                throw new Exception("Date de début supérieure à la date de fin");
            }
            
            $requetePreparee = "
                SELECT SUM(montantFactureCommande) as CA
                FROM Commande
                WHERE dateHeureCommande >= :dateDebut
                AND dateHeureCommande < :dateFin
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            try {
                $resultat->execute(array(':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $CA = $resultat->fetch();
                return $CA["CA"] ?? 0;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }

        public static function getCAJournalier($year=null, $month=null, $day=null) {
            if (is_null($year)) { $year = date("Y"); }
            if (is_null($month)) { $month = date("m"); }
            if (is_null($day)) { $day = date("d"); }

            $dateDebut = $year."-".$month."-".$day;
            $dateFin = date("Y-m-d", strtotime("+1 day", strtotime($dateDebut)));

            return static::getCA($dateDebut, $dateFin);
        }
        
        public static function getCAHebdomadaire($year=null, $month=null, $day=null) {
            if (is_null($year)) { $year = date("Y"); }
            if (is_null($month)) { $month = date("m"); }
            if (is_null($day)) { $day = date("d"); }

            $dateDebut = date("Y-m-d", strtotime("last monday", strtotime($year."-".$month."-".$day)));
            $dateFin = date("Y-m-d", strtotime("next monday", strtotime($year."-".$month."-".$day)));

            return static::getCA($dateDebut, $dateFin);
        }

        public static function getCAMensuel($month=null, $year=null) {
            if (is_null($month)) { $month = date("m"); }
            if (is_null($year)) { $year = date("Y"); }

            $dateDebut = $year."-".sprintf("%02d", $month)."-01";
            $dateFin = ($month == 12) ? ($year+1)."-01-01" : $year."-". sprintf("%02d", $month+1)."-01";

            return static::getCA($dateDebut, $dateFin);
        }

        public static function getCAAnnuel($year=null) {
            if (is_null($year)) { $year = date("Y"); }

            $dateDebut = $year."-01-01";
            $dateFin = ($year+1)."-01-01";

            return static::getCA($dateDebut, $dateFin);
        }

        public static function getCAtotal() {
            return static::getCA("1970-01-01", date("Y-m-d"));
        }

        public static function getNbCommandesMensuel($month=null, $year=null) {
            static::connect();
            
            if (is_null($month)) { $month = date("m"); }
            if (is_null($year)) { $year = date("Y"); }

            $dateDebut = $year."-".$month."-01";
            $dateFin = ($month == 12) ? ($year+1)."-01-01" : $year."-".($month+1)."-01";

            $requetePreparee = "
                SELECT COUNT(*) as nbCommandes
                FROM Commande
                WHERE dateCommande >= DATE_SUB(
            ";
            $resultat = static::$connexion->prepare($requetePreparee);
            try {
                $resultat->execute(array(':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
                $resultat->setFetchMode(PDO::FETCH_ASSOC);
                $nbCommandes = $resultat->fetch();
                return $nbCommandes["nbCommandes"];
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la requête SQL : <br />" . $e->getMessage());
            }
        }
    }
?>