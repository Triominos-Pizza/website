<?php
    (session_status() == PHP_SESSION_NONE) && session_start();
    if (!isset($_SESSION['adminAccount'])) {
        $callback_url = substr($_SERVER['HTTP_REFERER'], strlen(ROOT_URL));
        header("Location: $ROOT_URL/pages/admin/login.php?callback_url=$callback_url");
    }
?>