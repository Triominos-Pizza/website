<?php
    // Faire une champ de texte avec un bouton qui enregistre le contenu du champ de texte dans un cookie
    // et qui affiche le contenu du cookie dans le champ de texte
    
    setcookie("cookie","value", 0,"/");
    echo "cookie : " . $_COOKIE["cookie"] . "<br>";
?>