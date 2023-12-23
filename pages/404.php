<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<html>
    <?php
        $title = ""; // Nom de la page
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <?php
            $phrases = [
                "Oups ! Cette page est plus perdue qu'une olive dans une pizza hawaïenne. 🫒",
                "Il semblerait que cette page ait glissé hors de notre four. 🍕",
                "Comme une pâte trop fine, cette page ne peut pas être trouvée. 🍕",
                "Cette page a été emportée plus vite qu'une part de margherita un samedi soir. 🍕",
                "On dirait que vous avez cherché une recette secrète qui n'existe pas ! 🕵️",
                "Page non trouvée. Elle a dû filer, comme le fromage sur une pizza chaude. 🧀",
                "Oups ! Cette page est introuvable, peut-être cachée sous le fromage ? 🧀",
                "Vous êtes tombé sur une croûte, pas sur la page souhaitée. 🍕",
                "Cette page est absente... Peut-être partie livrer des pizzas ? 🛵",
                "Comme une pizza sans sauce, quelque chose manque ici. 🍅",
                "Cette page a été mangée par un monstre de la pizza. 👻",
            ];
        ?>    

        <div style="text-align: center; margin-block: 25vh;">
            <h1>404</h1>
            <h4><?= $phrases[rand(0, count($phrases) - 1)] ?></h4>
        </div>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>