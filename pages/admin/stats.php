<?php session_start(); ?>
<?php include_once('../../config/config.php'); ?>
<?php require_once(FTP_ROOT_PATH . "/scripts/php/check_connection_admin.php"); ?>
<html>
    <?php
        $title = "Admin - NOM PAGE"; // Nom de la page
        include_once(FTP_ROOT_PATH . "/views/components/head.php");
    ?>
    
    <body class="admin-page">
        <?php include(FTP_ROOT_PATH . "/views/components/admin/navbar.php"); ?> <!-- Navbar -->
        <?php include(FTP_ROOT_PATH . "/views/components/admin/header.php"); ?> <!-- Header -->

        <!-- Imports -->
        <?php
            include(FTP_ROOT_PATH . "/controllers/admin/controllerStats.php");
        ?>

        <main class="admin-page-main">
            <h1>Statistiques</h1>
            <p>
                <a href="stats.php?periode=j">Jour</a> |
                <a href="stats.php?periode=s">Semaine</a> |
                <a href="stats.php?periode=m">Mois</a> |
                <a href="stats.php?periode=a">Année</a> |
                <a href="stats.php?periode=t">Total</a>
            </p>

            <?php
                if (!isset($_GET['periode'])) {
                    $periode = "m";
                } else {
                    $periode = $_GET['periode'];
                    if (!in_array($periode, array("j", "s", "m", "a", "t"))) {
                        $periode = "m";
                    }
                }
                
                $controllerStats = new controllerStats();

                $annee = isset($_GET['annee']) ? $_GET['annee'] : date("Y");
                $mois = isset($_GET['mois']) ? $_GET['mois'] : date("m");
                $jour = isset($_GET['jour']) ? $_GET['jour'] : date("d");

                switch ($periode) {
                    case "j":
                        echo "<h2>Chiffre d'affaires du $jour/$mois/$annee</h2>";
                        $controllerStats->showCAJournalier($annee, $mois, $jour);
                        break;

                    case "s":
                        echo "<h2>Chiffre d'affaires de la semaine du $jour/$mois/$annee</h2>";
                        $controllerStats->showCAHebdomadaire($annee, $mois, $jour);
                        break;

                    case "m":
                        echo "<h2>Chiffre d'affaires du mois de $mois/$annee</h2>";
                        $controllerStats->showCAMensuel($annee, $mois);
                        break;

                    case "a":
                        echo "<h2>Chiffre d'affaires de l'année $annee</h2>";
                        $controllerStats->showCAAnnuel($annee);
                        break;

                    case "t":
                        echo "<h2>Chiffre d'affaires total</h2>";
                        $controllerStats->showCATotal();
                        break;
                }
            ?>
        </main>
    </body>
</html>
