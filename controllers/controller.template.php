<?php
    require_once("../models/XXX.php");
    class_exists('controllerObjet') ? null : require("../controllers/controllerObjet.php");

    class controllerXXX extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showXXX() {
        
        }
    }
?>
