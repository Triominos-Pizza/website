<?php
    (session_status() == PHP_SESSION_NONE) && session_start();
    if (!isset($_SESSION['account']['idClient'])) {
        // The everything after "triominos/" not included in the URL
        $callback_url = substr($_SERVER['HTTP_REFERER'], strlen(ROOT_URL));
        header("Location: $ROOT_URL/pages/login.php?callback_url=$callback_url");
    }

    // Example of a session variable:
    // Array
    // (
    //     [idClient] => 492b3a07-9c72-11ee-87a7-00163ed28d69
    //     [prenomClient] => Jean
    //     [nomClient] => Dupont
    //     [emailClient] => jean.dupont@gmail.com
    //     [telClient] => 336123456789
    //     [photoDeProfil] => /assets/images/profile_pictures/client/photoProfil_492b3a07-9c72-11ee-87a7-00163ed28d69.png
    //     [ptsFideliteClient] => 0
    // )
?>