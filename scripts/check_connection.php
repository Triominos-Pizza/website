<?php
    (session_status() == PHP_SESSION_NONE) && session_start();
    if (!isset($_SESSION['idClient'])) {
        header("Location: /triominos/pages/connexion.php");
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