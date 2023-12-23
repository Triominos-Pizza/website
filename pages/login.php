<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Se connecter";
        include_once("../views/components/head.php");
    ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        
        <main>
            <?php
                include("../controllers/controllerCompteClient.php");
                
                if (isset($_POST['email']) && isset($_POST['password'])) {
                    $controllerCompteClient = new controllerCompteClient();
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    
                    try {
                        $compteClient = $controllerCompteClient->connect($email, hash('sha256', $password));
                        header("Location: $ROOT_PATH/index.php");
                    } catch (Exception $e) {
                        echo "<div class='error-message'>" . $e->getMessage() . "</div>";
                    }
                }
            ?>

            <form method="post" action="./login.php">
                <h1>Connexion</h1>

                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="email">Adresse e-mail</label>
                        <input type="text" name="email" placeholder="Adresse e-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    </div>

                    <div style="width: 48%;">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                </div>

                <button type="submit" class="primary-button" style="margin-top: 1rem; width: 350px;">Se connecter</button>
            </form>

            <hr style="margin-block: 2rem;">

            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <p>Nouveau client ? <button class="secondary-button mini-button" onclick="window.location.href='<?=$ROOT_PATH?>/pages/signup.php'">Créer un compte</button></p>
                <button class="secondary-button mini-button" onclick="window.location.href='<?=$ROOT_PATH?>/pages/forgot-password.php'">Mot de passe oublié ?</button>
            </div>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>