<?php (session_status() == PHP_SESSION_NONE) && session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/check_maintenance.php"); ?>
<?php require_once("../scripts/check_connection.php"); ?>

<html>
    <?php
        $title = "Mon compte";
        include_once("../views/components/head.php");
        ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        

        <main class="account">
            <?php
                require_once("../controllers/ControllerCompteClient.php");
                $controllerCompteClient = new ControllerCompteClient();
                if (isset($_POST['form'])) {
                    try {
                        switch ($_POST['form']) {
                            case 'update_profile_picture':
                                $controllerCompteClient->uploadPhotoDeProfil($_SESSION['idClient'], $_FILES['profile_picture']);
                                break;
                            
                            case 'update_account':
                                $controllerCompteClient->updateAccount($_SESSION['idClient'], $_POST['prenomClient'], $_POST['nomClient'], $_POST['emailClient'], $_POST['telClient']);
                                break;
        
                            case 'update_password':
                                $controllerCompteClient->updatePassword($_SESSION['idClient'], $_POST['old_password'], $_POST['new_password'], $_POST['new_password_confirm']);
                                break;
                        }
        
                        // Open a popup to confirm the account modification
                        echo "<script type='text/javascript'>";
                        echo "alert('Compte modifié avec succès');";
                        // echo "window.location.href = '$ROOT_PATH/pages/account.php';";
                        echo "</script>";
                        exit();
        
                    } catch (Exception $e) {
                        echo "<div class='error-message'>";
                        echo "Erreur lors de la modification du compte : " . $e->getMessage();
                        echo "</div>";
                    }
                }
            ?>

            <h1>Mon compte</h1>

            <h2>Photo de profil</h2>
            <form action="./account.php" method="post" enctype="multipart/form-data">
                <img src="<?= $ROOT_PATH . $_SESSION['photoDeProfil'] ?>" alt="Photo de profil" class="profile-picture-img">
                <div>
                    <input type="hidden" name="form" value="update_profile_picture">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/png, image/jpeg, image/jpg" required disabled>
                    <input type="submit" value="Modifier" disabled>
                </div>
            </form>

            <h2>Informations personnelles</h2>
            <form action="./account.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="update_account">
                <div class="fields">
                    <?php
                        $fields = array(
                            "prenomClient" => array("Prénom", null),
                            "nomClient" => array("Nom", null),
                            "emailClient" => array("Email", "[^@]+@[^@]+\.[a-zA-Z]{2,}"),
                            "telClient" => array("Téléphone", "[0-9]{11}"),
                        );

                        foreach ($fields as $field => $array) {
                            $label = $array[0];
                            $pattern = $array[1] ?? ".*";
                            $val = $_SESSION[$field];

                            echo "<div class='field'>";
                            echo "<label for='$field'>$label</label>";
                            echo "<input type='text' name='$field' id='$field' value='$val' placeholder='$val' pattern='$pattern' required>";
                            echo "</div>";
                        }
                    ?>
                </div>

                <input type="submit" value="Modifier">
            </form>


            <h2>Changer de mot de passe</h2>
            <form action="./account.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="update_password">
                <div class="fields">
                    <div class="field">
                        <label for="old_password">Ancien mot de passe</label>
                        <input type="password" name="old_password" id="old_password" required>
                    </div>
                    <div class="field">
                        <label for="new_password">Nouveau mot de passe</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="field">
                        <label for="new_password_confirm">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="new_password_confirm" id="new_password_confirm" required>
                    </div>
                </div>

                <input type="submit" value="Modifier">
            </form>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>