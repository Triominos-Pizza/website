<header>
    <img
        id="header-logo"
        src="<?=$ROOT_PATH?>/assets/images/logos/logo_text_horizontal.svg"
        alt="Logo de Triomino's Pizza"
        onclick="window.location.href='<?=$ROOT_PATH?>/index.php'"
        style="cursor: pointer;"
    />
    
    <div id='header-account'>
        <?php
            // If the user is connected, display his profile picture, his name and a button to access his account
            if (isset($_SESSION['idClient'])) {
                // Buttons
                echo "<div id='header-buttons'>";
                echo "<a class='primary-button' href='$ROOT_URL/pages/account.php'>Mon compte</a>";
                echo "<a class='secondary-button' href='$ROOT_URL/pages/logout.php'>Se déconnecter</a>";
                echo "</div>";
                
                // Profile picture and name
                echo "<a href='$ROOT_URL/pages/account.php' id='header-profile'>";
                echo "<img " .
                    "src='".$_SESSION['photoDeProfil']."' " .
                    "alt='Photo de profil de ".$_SESSION['prenomClient']." ".$_SESSION['nomClient']."'".
                "'/>";
                echo "<p>" . $_SESSION['prenomClient'] . " " . $_SESSION['nomClient'] . "</p>";
                echo "</a>";
            }
            
            // If the user is not connected, display buttons to connect or create an account
            else {
                echo "<div id='header-buttons'>";
                echo "<a class='secondary-button' href='$ROOT_URL/pages/login.php'>Se connecter</a>";
                echo "<a class='primary-button' href='$ROOT_URL/pages/signup.php'>Créer un compte</a>";
                echo "</div>";
            }
        ?>
    </div>
</header>
