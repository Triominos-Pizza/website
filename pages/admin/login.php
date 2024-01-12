<?php session_start(); ?>
<?php include_once('../../config/config.php'); ?>
<?php require_once(FTP_ROOT_PATH . "/scripts/php/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Se connecter";
        include_once(FTP_ROOT_PATH . "/views/components/head.php");
    ?>
    
    <body>
        <?php include(FTP_ROOT_PATH . "/views/components/header.php"); ?>
        
        <main>
            <?php
                if (isset($_POST['id']) && isset($_POST['password'])) {
                    $_SESSION['adminAccount'] = 'OK';
                    echo "Connecté, redirection en cours...";
                    header("Location: " . ROOT_URL . "/pages/admin/stats.php");
                    exit();
                }
            ?>

            <form method="post" action=<?=ROOT_URL."/pages/admin/login.php"?>>
                <h1>Connexion administrateur</h1>

                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="id">Identifiant</label>
                        <input type="text" name="id" required>
                    </div>

                    <div style="width: 48%;">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                </div>

                <button type="submit" class="primary-button" style="margin-top: 1rem; width: 350px;">Se connecter</button>
            </form>

            <hr style="margin-block: 2rem;">
        </main>

        <?php include(FTP_ROOT_PATH . "/views/components/footer.php"); ?>
    </body>
</html>
