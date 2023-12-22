<?php
    require_once("../models/objet.php");

    class produit extends objet {
        public static $classe = "produit";
        public static $identifiant = "idFicheProduit";

        public int $idFicheProduit;
        public string $nomProduit;
        public float $prixProduit;
        public string $urlImageProduit;

        public function __construct($id=null, $nom=null, $prix=null, $urlImage=null) {
            parent::__construct();
            if (!is_null($id)) {
                $this->idFicheProduit = $id;
                $this->nomProduit = $nom;
                $this->prixProduit = $prix;
                $this->urlImageProduit = $urlImage;
            }
        }

        public static function getProduits() {
            static::connect();

            // $sql = "SELECT * FROM FicheProduit";
            
            // $resultat = static::$connexion->query($sql);
            // $resultat->setFetchMode(PDO::FETCH_CLASS, static::$classe);
            // $produits = $resultat->fetchAll();

            $produits = static::getAll("FicheProduit");

            return $produits;
        }
    }