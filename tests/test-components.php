<html>
    <head>
        <?php include_once('../config/config.php'); ?>
        <title>Triomino's Pizza - Test</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/png" href="<?=$ROOT_PATH?>assets/images/logos/logo.svg" />
        <link rel="stylesheet" href="<?= $ROOT_PATH ?>/css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>
    
    <body>
        <h1>Titre 1</h1>
        <h2>Titre 2</h2>
        <h3>Titre 3</h3>
        <h4>Sous-titre</h4>
        
        <p>Paragraphe</p>
        <p><i>Paragraphe italique</i></p>
        <p><b>Paragraphe gras</b></p>
        <p><u>Paragraphe souligné</u></p>

        <h1>Boutons</h1>
        <h4>&#60;button&#62;</h4>
        <div>
            <button class="primary-button large-button">Lorem ipsum dolor</button>
            <button class="primary-button">Lorem ipsum dolor</button>
            <button class="primary-button mini-button">Lorem ipsum dolor</button>
        </div>
        <div>
            <button class="secondary-button large-button">Lorem ipsum dolor</button>
            <button class="secondary-button">Lorem ipsum dolor</button>
            <button class="secondary-button mini-button">Lorem ipsum dolor</button>
        </div>

        <h4>Disabled &#60;button&#62;</h4>
        <div>
            <button class="primary-button large-button" disabled>Lorem ipsum dolor</button>
            <button class="primary-button" disabled>Lorem ipsum dolor</button>
            <button class="primary-button mini-button" disabled>Lorem ipsum dolor</button>
        </div>
        <div>
            <button class="secondary-button large-button" disabled>Lorem ipsum dolor</button>
            <button class="secondary-button" disabled>Lorem ipsum dolor</button>
            <button class="secondary-button mini-button" disabled>Lorem ipsum dolor</button>
        </div>
        
        <h4>&#60;a&#62;</h4>
        <div>
            <a href="#" class="primary-button large-button">Lorem ipsum dolor</a>
            <a href="#" class="primary-button">Lorem ipsum dolor</a>
            <a href="#" class="primary-button mini-button">Lorem ipsum dolor</a>
        </div>
        <div>
            <a href="#" class="secondary-button large-button">Lorem ipsum dolor</a>
            <a href="#" class="secondary-button">Lorem ipsum dolor</a>
            <a href="#" class="secondary-button mini-button">Lorem ipsum dolor</a>
        </div>

        
    </body>