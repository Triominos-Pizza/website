<?php

    class controllerObjet {
        static protected $connexion;

        public function __construct() {
            !isset($CONFIG_IMPORTED) ? require_once(FTP_ROOT_PATH.'/config/config.php') : null;
            require_once(FTP_ROOT_PATH.'/config/db.php');

            static::$connexion = connexion::connect(); // à retirer après avoir déplacé les appels à la BDD dans les modèles
        }
    }

?>
