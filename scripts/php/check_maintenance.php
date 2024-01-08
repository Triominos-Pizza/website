<?php
    // Redirection en cas de maintenance (ou si la base de données est indisponible)

    // require_once("../config/db.php");
    // $pdo = connexion::connect();
    
    // if (MAINTENANCE || !$pdo) {
    //     if (!$pdo) {
    //         $reason = "La base de données est actuellement indisponible. Veuillez réessayer plus tard.";
    //     } else {
    //         $reason = "Maintenance";
    //     }
    //     header("Location: " . ROOT_PATH . "/pages/maintenance?reason=$reason");
    // }
?>