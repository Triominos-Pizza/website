<?php
    class_exists('controllerObjet') ? null : require("../controllers/controllerObjet.php");

    class controllerPaiement extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showPaiementForm() {
            echo "<div class='paiement-form'>";
            echo "<form method='post' action='".ROOT_URL."/controllers/controllerPaiement.php'>";
                    // Informations de livraison
                    echo "<h2>Informations de livraison</h2>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='adresse'>Adresse</label>";
                        echo "<input type='text' name='adresse' id='adresse' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='codePostal'>Code postal</label>";
                        echo "<input type='text' name='codePostal' id='codePostal' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='ville'>Ville</label>";
                        echo "<input type='text' name='ville' id='ville' required />";
                    echo "</div>";

                    // Informations de paiement
                    echo "<h2>Informations de paiement</h2>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='numeroCarte'>Numéro de carte</label>";
                        echo "<input type='text' name='numeroCarte' id='numeroCarte' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='nomCarte'>Nom sur la carte</label>";
                        echo "<input type='text' name='nomCarte' id='nomCarte' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='dateExpiration'>Date d'expiration</label>";
                        echo "<input type='text' name='dateExpiration' id='dateExpiration' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='codeSecurite'>Code de sécurité</label>";
                        echo "<input type='text' name='codeSecurite' id='codeSecurite' required />";
                    echo "</div>";

                    // Bouton "Payer"
                    echo "<div class='paiement-form-input'>";
                        echo "<input type='submit' class='primary-button' value='Payer' />";
                    echo "</div>";
                echo "</form>";
            echo "</div>";
        }
    }
?>
