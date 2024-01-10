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
    $MAINTENANCE = MAINTENANCE;

    define("SLOGAN", "La première chaine de pizzerias ouvertes dans des IUTs.");
    $SLOGAN = SLOGAN;

    // Le chemin de la racine du site
    define("FTP_ROOT_PATH", "/var/www/html/triominos"); // pas de slash à la fin
    define("ROOT_PATH", ""); // pas de slash à la fin
    define("ROOT_URL", "http://www.example.com/triominos"); // pas de slash à la fin
    $ROOT_PATH = ROOT_PATH;
    $ROOT_URL = ROOT_URL;

    $CONFIG_IMPORTED = true;
?>
