<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>
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
                        // connexion
                        $compteClient = $controllerCompteClient->connect($email, hash('sha256', $password));

                        // redirection (à un URL prédéfini dans l'URL le cas échéant, à la page précédente sinon si elle est sur le même site, sinon à l'accueil)
                        if (isset($_GET['callback_url'])) {
                            header("Location: " . ROOT_URL . $_GET['callback_url']);
                        } else {
                            header("Location: " . ROOT_URL);
                        }
                        exit();
                    } catch (Exception $e) {
                        echo "<div class='error-message'>" . $e->getMessage() . "</div>";
                    }
                }
            ?>

            <form method="post" action=<?= "./login.php" . (isset($_GET['callback_url']) ? "?callback_url=".$_GET['callback_url'] : "") ?>>
                <h1>Connexion</h1>

                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="email">Adresse e-mail</label>
                        <input type="text" name="email" placeholder="Adresse e-mail" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" value="<?= (isset($_POST['email']) ? $_POST['email'] : '') ?>" required>
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
                <p>
                    Nouveau client ?
                    <button
                        class="secondary-button mini-button"
                        onclick="window.location.href='<?=$ROOT_PATH?>/pages/signup.php<?= (isset($_GET['callback_url']) ? '?callback_url=' . $_GET['callback_url'] : '') ?>'">
                            Créer un compte
                    </button>
                </p>
                <button
                    class="secondary-button mini-button"
                    onclick="window.location.href='<?=$ROOT_PATH?>/pages/forgot-password.php<?= (isset($_GET['callback_url']) ? '?callback_url=' . $_GET['callback_url'] : '') ?>'">
                        Mot de passe oublié ?
                </button>
            </div>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>
