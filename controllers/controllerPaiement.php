<?php
    class_exists('controllerObjet') ? null : require("../controllers/controllerObjet.php");
    isset($CONFIG_IMPORTED) ? null : include('../config/config.php');
    
    include_once("../models/cb.php");
    include_once("../models/panier.php");
    
    class_exists('produit') ? null : require("../models/produit.php");
    class_exists('pizza') ? null : require("../models/pizza.php");
    
    (session_status() == PHP_SESSION_NONE) && session_start();

    if (isset($_POST["form"])) {
        switch ($_POST["form"]) {
            case "pay":
                try {
                    // Simulation de paiement
                    // (vérifie que le numéro de carte est un numéro de carte valide visa ou mastercard
                    // et que la date d'expiration n'est pas dépassée)
                    $card = new cb($_POST["nomCarte"], $_POST["numeroCarte"], $_POST["dateExpiration"], $_POST["codeSecurite"]);
                    cb::pay($card->nomCarte, $card->numeroCarte, $card->dateExpirationStr, $card->codeSecurite);

                    // Ici on prendrait une empreinte bancaire dans un cas réel
                } catch (Exception $e) {
                    echo "<div class='error-message'>Erreur lors de la vérification de la carte bancaire : " . $e->getMessage() . "</div>";
                    exit();
                }
                
                // Enregistrement de la commande dans la BDD et suppression du panier
                try {
                    $idCommande = panier::registerCommande($_SESSION['panier'], $_SESSION['account'], $_POST);
                } catch (Exception $e) {
                    echo "<div class='error-message'>Erreur lors de l'enregistrement de la commande : " . $e->getMessage() . "</div>";
                    exit();
                }

                // Ici on validerait le paiement auprès de la banque dans un cas réel

                
                // TODO : Envoyer un mail de confirmation de commande
                
                // Redirection vers la page de validation de commande
                $_SESSION["idCommande"] = $idCommande;
                // header("Location: " . ROOT_URL ."/pages/order_confirmation.php");
                echo "<script type='text/javascript'>
                    alert('Paiement effectué avec succès (Carte **** **** **** " . substr($_POST["numeroCarte"], -4) . " " . $card->getCardType() . ")');
                    window.location.href = '" . ROOT_URL ."/pages/order_confirmation.php';
                </script>";
                
            default:
                break;
        }
    }

    class controllerPaiement extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showPaiementForm() {
            echo "<script type='text/javascript' src='".ROOT_URL."/scripts/js/address_autocomplete.js' defer></script>";
            echo "<script type='text/javascript' src='".ROOT_URL."/scripts/js/inputs_autoformat.js' defer></script>";
            echo "<script type='text/javascript' src='".ROOT_URL."/scripts/js/checkout_inputs.js' defer></script>";

            echo "<div class='paiement-form'>";
                echo "<form method='post' action='".ROOT_URL."/controllers/controllerPaiement.php'>";
                    echo "<input type='hidden' name='form' value='pay' />";

                    // Informations de livraison
                    echo "<h2>Informations de livraison</h2>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='estEnLivraison'>Livraison</label>";
                        echo "<input type='checkbox' name='estEnLivraison' id='estEnLivraison' checked />";
                    echo "</div>";
                    echo  "<div class='paiement-form-adresse'>";
                        echo "<input type='hidden' name='latitude' id='latitude' />";
                        echo "<input type='hidden' name='longitude' id='longitude' />";
                        echo "<input type='hidden' name='numAdresse' id='numAdresse' />";
                        echo "<input type='hidden' name='rueAdresse' id='rueAdresse' />";
                        echo "<div class='paiement-form-input'>";
                            echo "<label for='adresse'>Adresse</label>";
                            echo "<input type='text' name='adresse' id='adresse' required />";
                        echo "</div>";
                        echo "<div class='paiement-form-input'>";
                            echo "<label for='complementAdresse'>Complément d'adresse</label>";
                            echo "<input type='text' name='complementAdresse' id='complementAdresse' />";
                        echo "</div>";
                        echo "<div class='paiement-form-cp-ville'>";
                            echo "<div class='paiement-form-input'>";
                                echo "<label for='codePostal'>Code postal</label>";
                                echo "<input type='text' name='codePostal' id='codePostal' required />";
                            echo "</div>";
                            echo "<div class='paiement-form-input'>";
                                echo "<label for='ville'>Ville</label>";
                                echo "<input type='text' name='ville' id='ville' required />";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";

                    // Informations de paiement
                    echo "<h2>Informations de paiement</h2>";
                    echo "<div class='paiement-form-accepted-cards'>";
                        echo "<img class='paiement-form-accepted-card' src='".ROOT_URL."/assets/images/icons/payment_methods/visa.svg' alt='Visa' />";
                        echo "<img class='paiement-form-accepted-card' src='".ROOT_URL."/assets/images/icons/payment_methods/mastercard.svg' alt='Mastercard' />";
                        echo "<img class='paiement-form-accepted-card' src='".ROOT_URL."/assets/images/icons/payment_methods/bitcoin.svg' alt='Bitcoin' style='filter: grayscale(100%);' title='".htmlspecialchars("Bitcoin n'est pas encore accepté", ENT_QUOTES)."' />";
                    echo "</div>";

                    echo "<div class='paiement-form-input'>";
                        echo "<label for='nomCarte'>Nom sur la carte</label>";
                        echo "<input type='text' name='nomCarte' id='nomCarte' placeholder='JEAN DUPONT' title='Le nom doit être écrit en majuscules et ne contenir que des lettres non accentuées, des espaces, des tirets, des points et des apostrophes' pattern='" . htmlspecialchars("[^A-Z\s\.'-]", ENT_QUOTES) . "' data-force-uppercase data-accepted-characters='" . htmlspecialchars("A-Z\s\.'-", ENT_QUOTES) . "' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='numeroCarte'>Numéro de carte</label>";
                        echo "<input type='text' name='numeroCarte' id='numeroCarte' pattern='(\d{4}\s){3}\d{4}' data-pattern='xxxx xxxx xxxx xxxx' placeholder='1234 1234 1234 1234' required />";
                    echo "</div>";
                    echo "<div class='paiement-form-date-cvv'>";
                        echo "<div class='paiement-form-input'>";
                            echo "<label for='dateExpiration'>Date d'expiration</label>";
                            $now = new DateTime();
                            $dateExpirationExemple = $now->add(new DateInterval('P1Y'));
                            $monthExemple = $dateExpirationExemple->format('m');
                            $yearExemple = $dateExpirationExemple->format('y');
                            echo "<input type='text' name='dateExpiration' id='dateExpiration' pattern='\d{2}/\d{2}' data-pattern='xx/xx' placeholder='$monthExemple/$yearExemple' required />";
                        echo "</div>";
                        echo "<div class='paiement-form-input'>";
                            echo "<label for='codeSecurite'>Code de sécurité</label>";
                            echo "<input type='text' name='codeSecurite' id='codeSecurite' pattern='\d{3}' data-pattern='xxx' placeholder='123' required />";
                        echo "</div>";
                    echo "</div>";

                    // Code promotionnel
                    echo "<div class='paiement-form-input'>";
                        echo "<label for='codePromo'>Code promo</label>";
                        echo "<input type='text' name='codePromo' id='codePromo' data-force-uppercase data-accepted-characters='" . htmlspecialchars("A-Z0-9\-_", ENT_QUOTES) . "' />";
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
