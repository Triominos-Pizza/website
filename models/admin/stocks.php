<?php
    require_once("../../models/objet.php");

    class Stock extends objet {
        public function __construct($id=null, $nom=null) {
            parent::__construct();
        }

        public static function getStocksIngredients() {
            static::connect();
            
            $requetePreparee = "
                SELECT *
                FROM Stock
            ";
