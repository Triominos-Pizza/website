<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<html>
    <?php
        $title = "Maintenance";
        include_once("../views/components/head.php");
    ?>

    <body class="maintenance">
        <?php include("../views/components/header.php"); ?>
        
        <main style="background-image: url('<?=$ROOT_PATH?>/assets/images/backgrounds/background-pizza.png');">
            <h1>Bienvenue chez Triomino's Pizza !</h1>
            <p>🚧 Notre site est actuellement en maintenance, merci de revenir plus tard. 🚧</p>
            <?php
                if (isset($_GET['reason']) && $_GET['reason'] != "") {
                    $reason = $_GET['reason'];
                    echo "<p><i><b>Raison</b> : $reason</i></p>";
                }
            ?>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
