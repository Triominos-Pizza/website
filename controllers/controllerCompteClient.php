<?php
    require("../controllers/controllerObjet.php");

    class controllerCompteClient extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function creerCompteClient($prenom, $nom, $email, $tel, $mdp, $mdp_confirm) {
            // Vérifier que les mots de passe correspondent
            if ($mdp != $mdp_confirm) {
                throw new Exception("Les mots de passe ne correspondent pas");
            }

            // Vérifier que l'email et le numéro de téléphone ne sont pas déjà utilisés
            if (static::getCompteClientByEmail($email) != null) {
                throw new Exception("Cet email est déjà utilisé");
            } else if (static::getCompteClientByTel($tel) != null) {
                throw new Exception("Ce numéro de téléphone est déjà utilisé");
            }

            // Créer le compte
            $requetePreparee = "
                INSERT INTO `CompteClient` (`prenomClient`, `nomClient`, `emailClient`, `telClient`, `mdpClient`, `urlPhotoProfilClient`, `ptsFideliteClient`)
                VALUES (:prenom, :nom, :email, :tel, :mdp, :urlPhotoProfil, :ptsFidelite);
            ";
            $res = static::$connexion->prepare($requetePreparee);

            $tags = array(
                "prenom" => $prenom,
                "nom" => $nom,
                "email" => $email,
                "tel" => $tel,
                "mdp" => $mdp,
                "urlPhotoProfil" => null,
                "ptsFidelite" => 0,
            );
            
            $res->execute($tags);
        }

        public static function creerCompteClient_photoDeProfil($prenom, $nom, $email, $tel, $mdp, $mdp_confirm, $photoProfil) {
            static::creerCompteClient($prenom, $nom, $email, $tel, $mdp, $mdp_confirm);
            $uuid = static::getCompteClientByEmail($email)['idClient'];

            try {
                static::uploadPhotoDeProfil($uuid, $photoProfil);
            } catch (Exception $e) {
                throw new Exception("Le compte a été créé mais l'image n'a pas pu être uploadée");
            }
        }
        
        /* On a pas les perms d'upload des fichiers donc tant pis 💀 */
        public static function uploadPhotoDeProfil($idClient, $photoProfil) {
            $target_dir = ROOT_PATH . "/assets/images/profile_pictures/client/";
            $file_name = "photoProfil_$idClient.png";
            $target_file = $target_dir . $file_name;
            
            // Upload on the SFTP server
            $ftp = ftp_connect(SFTP_HOST, SFTP_PORT);
            ftp_login($ftp, SFTP_LOGIN, SFTP_PASSWORD);

            $ret = ftp_nb_put($ftp, $target_file, $photoProfil["tmp_name"], FTP_BINARY);

            while (FTP_MOREDATA == $ret) {
                // display progress bar, or something
                $ret = ftp_nb_continue($ftp);
            }

            if (FTP_FINISHED != $ret) {
                throw new Exception("L'image n'a pas pu être uploadée");
            }

            ftp_close($ftp);

            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // // Check if image file is a actual image or fake image
            // $check = getimagesize($_FILES['urlPhotoProfil']["tmp_name"]);
            // if($check !== false) {
            //     $uploadOk = 1;
            // } else {
            //     throw new Exception("Le fichier n'est pas une image");
            //     $uploadOk = 0;
            // }

            // // Check if file already exists
            // if (file_exists($target_file)) {
            //     throw new Exception("Une image avec ce nom existe déjà");
            //     $uploadOk = 0;
            // }

            // // Check file size
            // if ($_FILES['urlPhotoProfil']["size"] > 500000) {
            //     throw new Exception("L'image est trop volumineuse");
            //     $uploadOk = 0;
            // }

            // // Allow certain file formats
            // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            //     throw new Exception("Seuls les fichiers JPG, JPEG et PNG sont autorisés");
            //     $uploadOk = 0;
            // }

            // // Check if $uploadOk is set to 0 by an error
            // if ($uploadOk == 0) {
            //     throw new Exception("L'image n'a pas pu être uploadée");
            // // if everything is ok, try to upload file
            // } else {
            //     if (!move_uploaded_file($_FILES['urlPhotoProfil']["tmp_name"], $target_file)) {
            //         throw new Exception("L'image n'a pas pu être uploadée");
            //     }
            // }

            // Update the database
            $requetePreparee = "UPDATE `CompteClient` SET `urlPhotoProfilClient` = :urlPhotoProfil WHERE `idClient` = :idClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array(
                "urlPhotoProfil" => $target_file,
                "idClient" => $idClient,
            );
            $res->execute($tags);
        }

        public static function getCompteClient($idClient) {
            $requetePreparee = "SELECT * FROM `CompteClient` WHERE `idClient` = :idClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array("idClient"=> $idClient);
            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        }

        public static function getCompteClientByEmail($emailClient) {
            $requetePreparee = "SELECT * FROM `CompteClient` WHERE `emailClient` = :emailClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array("emailClient"=> $emailClient);
            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        }

        public static function getCompteClientByTel($telClient) {
            $requetePreparee = "SELECT * FROM `CompteClient` WHERE `telClient` = :telClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array("telClient"=> $telClient);
            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        }

        public static function checkPassword($idClient, $mdpClient) : bool {
            $requetePreparee = "SELECT * FROM `CompteClient` WHERE `idClient` = :idClient AND `mdpClient` = :mdpClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array(
                "idClient"=> $idClient,
                "mdpClient"=> hash('sha256', $mdpClient)
            );
            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            return $resultat != null;
        }

        public static function updateAccount($id, $prenom, $nom, $email, $tel) {
            $requetePreparee = "
                UPDATE `CompteClient`
                SET `prenomClient` = :prenom, `nomClient` = :nom, `emailClient` = :email, `telClient` = :tel
                WHERE `idClient` = :id
            ";
            $res = static::$connexion->prepare($requetePreparee);
            
            $tags = array(
                "prenom"=> $prenom,
                "nom"=> $nom,
                "email"=> $email,
                "tel"=> $tel,
                "id"=> $id,
            );            
            
            $res->execute($tags);

            static::connectWithId($id);
        }
        
        public static function updatePassword($idClient, $old_password, $new_password, $new_password_confirm) {
            // Vérifier que les mots de passe correspondent
            if ($new_password != $new_password_confirm) {
                throw new Exception("Les mots de passe ne correspondent pas");
            }

            // Vérifier que l'ancien mot de passe est correct
            if (!static::checkPassword($idClient, $old_password)) {
                throw new Exception("Ancien mot de passe incorrect");
            }

            // Modifier le mot de passe
            $requetePreparee = "UPDATE `CompteClient` SET `mdpClient` = :mdpClient WHERE `idClient` = :idClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array(
                "mdpClient"=> hash('sha256', $new_password),
                "idClient"=> $idClient,
            );
            $res->execute($tags);
        }

        public static function deleteCompteClient($idClient) {
            $requetePreparee = "DELETE FROM `CompteClient` WHERE `idClient` = :idClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array("idClient"=> $idClient);
            $res->execute($tags);
        }

        public static function connectWithId($idClient) {
            $requetePreparee = "SELECT * FROM `CompteClient` WHERE `idClient` = :idClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array("idClient"=> $idClient);
            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            if ($resultat == null) {
                throw new Exception("Erreur lors de la connexion");
            }

            static::disconnect();
            session_start();
            $_SESSION['idClient'] = $resultat['idClient'];
            $_SESSION['prenomClient'] = $resultat['prenomClient'];
            $_SESSION['nomClient'] = $resultat['nomClient'];
            $_SESSION['emailClient'] = $resultat['emailClient'];
            $_SESSION['telClient'] = $resultat['telClient'];
            $_SESSION['photoDeProfil'] = $ROOT_PATH . (($resultat['urlPhotoProfilClient'] != "") ? $resultat['urlPhotoProfilClient'] : "/assets/images/profile_pictures/client/photoProfil_default.png");
            $_SESSION['ptsFideliteClient'] = $resultat['ptsFideliteClient'];

            return $resultat;
        }

        public static function connect($email, $mdp) {
            $requetePreparee = "SELECT `idClient` FROM `CompteClient` WHERE `emailClient` = :emailClient AND `mdpClient` = :mdpClient";
            $res = static::$connexion->prepare($requetePreparee);
            $tags = array(
                "emailClient"=> $email,
                "mdpClient"=> $mdp,
            );

            $res->execute($tags);
            $resultat = $res->fetch(PDO::FETCH_ASSOC);
            
            if ($resultat == null) {
                throw new Exception("Email ou mot de passe incorrect");
            }

            static::connectWithId($resultat['idClient']);

            return $resultat;
        }

        public static function disconnect() {
            session_status()==PHP_SESSION_NONE ? session_start() : null;
            session_unset();
            session_destroy();
        }
    }
    
?>