<?php (session_status() == PHP_SESSION_NONE) && session_start(); ?>
<?php include_once('../config/config.php'); ?>
<?php require_once("../scripts/php/check_maintenance.php"); ?>
<?php require_once("../scripts/php/check_connection.php"); ?>

<html>
    <?php
        $title = "Mon compte";
        include_once("../views/components/head.php");
        ?>
    
    <body>
        <?php include("../views/components/header.php"); ?>
        

        <main class="account">
            <?php
                require_once(FTP_ROOT_PATH."/controllers/controllerCompteClient.php");

                // TODO : Déplacer ce code dans ControllerCompteClient
                $controllerCompteClient = new ControllerCompteClient();
                if (isset($_POST['form'])) {
                    try {
                        switch ($_POST['form']) {
                            case 'update_profile_picture':
                                $controllerCompteClient->uploadPhotoDeProfil($_SESSION['account']['idClient'], $_FILES['profile_picture']);
                                break;
                            
                            case 'update_account':
                                $controllerCompteClient->updateAccount($_SESSION['account']['idClient'], $_POST['prenomClient'], $_POST['nomClient'], $_POST['emailClient'], $_POST['telClient']);
                                break;
        
                            case 'update_password':
                                $controllerCompteClient->updatePassword($_SESSION['account']['idClient'], $_POST['old_password'], $_POST['new_password'], $_POST['new_password_confirm']);
                                break;

                            case 'delete_account':
                                $controllerCompteClient->deleteAccount($_SESSION['account']['idClient']);

                                // Open a popup to confirm the account deletion
                                echo "<script type='text/javascript'>";
                                echo "alert('Compte supprimé avec succès');";
                                echo "window.location.href = '$ROOT_PATH/pages/login';";
                                echo "</script>";
                                exit();
                        }
        
                        // Open a popup to confirm the account modification
                        echo "<script type='text/javascript'>";
                        echo "alert('Compte modifié avec succès');";
                        echo "window.location = window.location.href;"; // Reload the page
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
            <form id="update_profile_picture" action="./account.php" method="post" enctype="multipart/form-data">
                <img src="<?= $_SESSION['account']['photoDeProfil'] ?>" alt="Photo de profil" class="profile-picture-img">
                <div>
                    <input type="hidden" name="form" value="update_profile_picture">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/png, image/jpeg, image/jpg" title="L'ajout de photo de profil est désactivé car le serveur n'est pas configuré pour gérer les fichiers" disabled required />
                    <input type="submit" class="primary-button" value="Modifier" title="L'ajout de photo de profil est désactivé car le serveur n'est pas configuré pour gérer les fichiers" disabled>
                </div>
            </form>

            <h2>Informations personnelles</h2>
            <form id="update_account" action="./account.php" method="post" enctype="multipart/form-data">
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
                            $val = $_SESSION['account'][$field];

                            echo "<div class='field'>";
                            echo "<label for='$field'>$label</label>";
                            echo "<input type='text' name='$field' id='$field' value='$val' placeholder='$val' pattern='$pattern' required>";
                            echo "</div>";
                        }
                    ?>
                </div>

                <input type="submit" class="primary-button" value="Modifier">

                <script type="text/javascript">
                    const fields = document.querySelectorAll("form#update_account input:not([type='submit'])");
                    const submitButton = document.querySelector("form#update_account input[type='submit']");

                    // Check if all fields are different from their default value
                    function checkFields() {
                        let allFieldsAreDefault = true;
                        fields.forEach(field => {
                            if (field.value != field.defaultValue) {
                                allFieldsAreDefault = false;
                            }
                        });
                        submitButton.disabled = allFieldsAreDefault;
                        submitButton.title = allFieldsAreDefault ? "Vous devez modifier au moins un champ pour pouvoir modifier votre compte" : "";
                    }

                    // Check if all fields are different from their default value when the page is loaded
                    checkFields();

                    // Check if all fields are different from their default value when the user types in a field
                    fields.forEach(field => {
                        field.addEventListener("input", checkFields);
                    });
                </script>
            </form>


            <h2>Changer de mot de passe</h2>
            <form id="update_password" action="./account.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="update_password">
                <div class="fields">
                    <div class="field">
                        <label for="old_password">Ancien mot de passe</label>
                        <input
                            type="password" name="old_password" id="old_password"
                            placeholder="****************"
                            required
                        >
                    </div>
                    <div class="field">
                        <label for="new_password">Nouveau mot de passe</label>
                        <input
                            type="password" name="new_password" id="new_password"
                            placeholder="****************"
                            pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}"
                            title="Le mot de passe doit contenir au moins 8 caractères, dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial"
                            required
                        >
                    </div>
                    <div class="field">
                        <label for="new_password_confirm">Confirmer le nouveau mot de passe</label>
                        <input
                            type="password" name="new_password_confirm" id="new_password_confirm"
                            placeholder="****************"
                            required
                        >
                    </div>
                </div>

                <input type="submit" class="primary-button" value="Modifier">
            </form>

            <h2>Supprimer le compte</h2>
            <form id="delete_account" action="./account.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="delete_account">
                <input type="button" class="danger-button" value="Supprimer le compte (irréversible)" onclick="if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')) document.getElementById('delete_account').submit();">
            </form>
        </main>

        <?php include("../views/components/footer.php"); ?>
    </body>
</html>