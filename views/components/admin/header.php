<header class="header-admin">
    <div id='header-account'>
        <div id='header-account-name'>
            <?php
                // Profile picture and name
                echo "<a href='$ROOT_URL/pages/account.php' id='header-profile'>";
                echo "<p>Bonjour " . $_SESSION['account']['prenomClient'] . " " . $_SESSION['account']['nomClient'] . " !</p>";
                echo "<img " .
                "src='".$_SESSION['account']['photoDeProfil']."' " .
                "alt='Photo de profil de ".$_SESSION['account']['prenomClient']." ".$_SESSION['account']['nomClient']."'".
                "'/>";
                echo "</a>";
            ?>
        </div>    
        

        <div id='header-buttons'>
            <?php
                // Buttons
                echo "<a class='secondary-button mini-button' href='$ROOT_URL/pages/admin/logout.php'>Se déconnecter</a>";
            ?>
        </div>
    </div>
</header>