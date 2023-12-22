<?php

    class controllerObjet {
        static protected $connexion;

        public function __construct() {
            require_once('../config/config.php');
            require_once('../config/db.php');
            static::$connexion = connexion::connect();
        }
    }

?>
