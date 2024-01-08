<?php session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>
<html>
    <?php
        $title = "Créer un compte";
        include_once("../views/components/head.php");
    ?>
    
    <?php include("../views/components/header.php"); ?>

    <body>    
        <main>
            <?php
                include("../controllers/controllerCompteClient.php");

                // Check if all required fields are set
                $required_fields = array("prenom","nom","email","tel","mdp","mdp_confirm");
                $all_set = true;
                foreach ($required_fields as $field) {
                    if (!isset($_POST[$field])) {
                        $all_set = false;
                        break;
                    }
                }

                // If all required fields are set, create the account
                if ($all_set) {
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $email = $_POST['email'];
                    $tel = $_POST['tel'];
                    $mdp = hash('sha256', $_POST['mdp']);
                    $mdp_confirm = hash('sha256', $_POST['mdp_confirm']);
                    // $photoDeProfil = (isset($_FILES['urlPhotoProfil'])) ? $_FILES['urlPhotoProfil'] : null;

                    $controllerCompteClient = new controllerCompteClient();
                    try {
                        if (isset($_FILES['urlPhotoProfil'])) {
                            $photoDeProfil = $_FILES['urlPhotoProfil'];
                            $controllerCompteClient->creerCompteClient_photoDeProfil($prenom, $nom, $email, $tel, $mdp, $mdp_confirm, $photoDeProfil);
                        } else {
                            $controllerCompteClient->creerCompteClient($prenom, $nom, $email, $tel, $mdp, $mdp_confirm);
                        }

                        // Open a popup to confirm the account creation
                        echo "<script type='text/javascript'>";
                        echo "alert('Compte créé avec succès');";
                        echo "window.location.href = '$ROOT_PATH/pages/login.php" . (isset($_GET['callback_url']) ? '?callback_url=' . $_GET['callback_url'] : '') . "';";
                        echo "</script>";
                    } catch (Exception $e) {
                        echo "<div class='error-message'>";
                        echo "Erreur lors de la création du compte : " . $e->getMessage();
                        echo "</div>";
                    }
                }
            ?>

            <form action="./signup.php<?= (isset($_GET['callback_url']) ? '?callback_url=' . $_GET['callback_url'] : '') ?>" method="post" enctype="multipart/form-data">
                <h1>Créer un compte</h1>

                <label for="urlPhotoProfil">Photo de profil</label>
                <input type="file" name="urlPhotoProfil" accept="image/png, image/jpeg, image/jpg" disabled>

                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" placeholder="Jean" required>
                    </div>
                    
                    <div style="width: 48%;">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="Dupont" required>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="email">Adresse e-mail</label>
                        <input
                            type="text" name="email" placeholder="jean.dupont@example.com"
                            pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}"
                            title="Veuillez entrer une adresse e-mail valide"
                            required
                        >
                    </div>
                    
                    <div style="width: 48%;">
                        <label for="tel">Numéro de téléphone</label>
                        <input
                            type="tel" name="tel" placeholder="33612345678"
                            pattern="[0-9]{11}"
                            title="Veuillez entrer un numéro de téléphone valide"
                            required
                        >
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="width: 48%;">
                        <label for="mdp">Mot de passe</label>
                        <input
                            type="password" name="mdp" placeholder="****************"
                            pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}"
                            title="Le mot de passe doit contenir au moins 8 caractères, dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial"
                            required
                        >
                    </div>
                    
                    <div style="width: 48%;">  
                        <label for="mdp_confirm">Confirmer le mot de passe</label>
                        <input type="password" name="mdp_confirm" placeholder="****************" required>
                    </div>
                </div>
                        
                <p>En créant un compte, vous acceptez les <a href="<?=$ROOT_PATH?>/pages/legal/cgu.php">Conditions générales d'utilisation</a> et la <a href="<?= $ROOT_PATH ?>/pages/legal/privacy.php">Politique de confidentialité</a> de Triomino's Pizza.</p>
                <button type="submit" class="primary-button">Créer un compte</button>

                <hr style="margin-block: 2rem;">

                <p>
                    Déjà client ?
                    <button
                        class="secondary-button mini-button"
                        onclick="window.location.href='<?=$ROOT_PATH?>/pages/login.php<?= (isset($_GET['callback_url']) ? '?callback_url=' . $_GET['callback_url'] : '') ?>'"
                    >Se connecter</button>
                </p>
            </form>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>