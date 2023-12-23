<?php session_start(); ?>
<?php include_once('./config/config.php'); ?>
<?php require_once("./config/db.php"); ?>

<?php require_once("./scripts/check_maintenance.php"); ?>

<html>
    <?php
        $title = "Accueil";
        include_once("./views/components/head.php");
    ?>
    
    <body class="page-accueil">
        <?php include("./views/components/header.php"); ?>
        
        <main style="background-image: url('<?= $ROOT_PATH ?>/assets/images/backgrounds/background-pizza.png');">
            <h1>Bienvenue chez Triomino's Pizza !</h1>
            <p>La première chaine de pizzerias ouvertes dans des IUTs.</p>
            <a class="primary-button large-button" href='<?= $ROOT_PATH ?>/pages/order.php'>Commander maintenant 🢂</a>
        </main>

        <?php include("./views/components/footer.php"); ?>
    </body>

</html>
