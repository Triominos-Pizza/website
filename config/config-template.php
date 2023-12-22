<?php
    // Connexion à la base de données
    define("HOSTNAME", "<URL_DE_LA_BASE_DE_DONNEES:PORT>");
    define("DATABASE", "<NOM_DE_LA_BASE_DE_DONNEES>");
    define("DB_LOGIN", "<LOGIN>");
    define("DB_PASSWORD", "<MOT_DE_PASSE>");

    // Connexion au serveur SFTP
    define("SFTP_HOST", "<URL_DU_SERVEUR_SFTP>");
    define("SFTP_PORT", "<PORT> (int)");
    define("SFTP_LOGIN", "<LOGIN>");
    define("SFTP_PASSWORD", "<MOT_DE_PASSE>");

    // Si true, alors le site est en maintenance
    // et on affiche la page maintenance.php
    define("MAINTENANCE", FALSE);

    // Le chemin de la racine du site
    define("ROOT_PATH", "/triominos");
    $ROOT_PATH = ROOT_PATH;
?>
