<?php
    require_once("../models/objet.php");

    class XXX extends objet {
        public static $classe = "XXX";
        public static $identifiant = "idXXX";

        // Attributs
        public int $idXXX;
        public string $nomXXX;


        public function __construct($id=null, $nom=null) {
            parent::__construct();
            if (!is_null($id)) {
                $this->idFicheProduit = $id;
                $this->nomProduit = $nom;
            }
        }

        public static function getAllXXX() {
            $produits = static::getAll("XXX");
            return $produits;
        }

        public static function getXXX($id) {
            $produit = static::getOne($id, "XXX");
            return $produit;
        }

        public static function deleteXXX($id) {
            static::delete($id, "XXX");
        }
    }
?>