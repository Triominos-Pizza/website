<head>
    <title>Triomino's Pizza<?php if (isset($title)) echo " - $title"; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- logo -->
    <link rel="icon" type="image/png" href="<?=$ROOT_PATH?>/assets/images/logos/logo.svg" />

    <!-- style -->
    <link rel="stylesheet" href="<?=$ROOT_PATH?>/css/style.css">
    
    <!-- PWA Manifest (doesn't work) -->
    <link rel="manifest" href="<?=$ROOT_PATH?>/manifest.json">

    <!-- Social media meta tags -->
    <meta property="og:title" content="Triomino's Pizza<?php if (isset($title)) echo " - $title"; ?>" />
    <meta property="og:description" content="<?=$SLOGAN?>" />
    <meta property="og:image" content="<?=$ROOT_URL?>/assets/images/logos/logo_text_vertical.png" />
    <meta property="og:url" content="<?=$ROOT_URL?>" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="fr_FR" />
    <meta name="theme-color" content="#136990">

    <!-- scripts -->
    <script src="<?= $ROOT_PATH ?>/scripts/js/konami.js"></script>
    <script src="<?= $ROOT_PATH ?>/scripts/js/noe.js"></script>
    <script>var easter_egg = new Konami(function() { noe(document.body); });</script>
</head>