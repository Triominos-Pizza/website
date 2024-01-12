<?php
    class cb {
        // Attributs
        public string $nomCarte;
        public string $numeroCarte;
        public string $dateExpirationStr;
        public DateTime $dateExpiration;
        public int $codeSecurite;

        public function __construct($nomCarte, $numeroCarteStr, $dateExpirationStr, $codeSecuriteStr) {
            $this->nomCarte = $nomCarte;
            $this->numeroCarte = preg_replace('/\s+/', '', $numeroCarteStr);
            
            $this->dateExpirationStr = $dateExpirationStr;

            // On ajoute 1 mois à la date d'expiration car la carte est valide jusqu'à la fin du mois
            $this->dateExpiration = DateTime::createFromFormat("d/m/y", "01/".$dateExpirationStr);
            $this->dateExpiration->add(new DateInterval('P1M'));
            $this->dateExpiration->setTime(0,0,0);
            
            $this->codeSecurite = (int)$codeSecuriteStr;
        }
        
        public function check() {
            $valide = true;
            
            // check date d'expiration CB
            $now = new DateTime();
            if ($this->dateExpiration < $now) {
                throw new Exception("Date d'expiration dépassée");
            }
            
            // check numéro de carte
            $card_type = static::validate_cc_number($this->numeroCarte);
            if ($card_type == false) {
                throw new Exception("Numéro de carte invalide");
            }
            
            return $valide;
        }
        
        public static function checkCreditCard(string $nomCarte, string $numeroCarteStr, string $dateExpirationStr, string $codeSecuriteStr) {
            $card = new cb($nomCarte, $numeroCarteStr, $dateExpirationStr, $codeSecuriteStr);
            return $card->check();
        }
    
        public function checkExpirationDate() {
            $now = new DateTime();
            return $this->dateExpiration > $now;
        }

        public static function validate_cc_number(string $cc_number) {
            /* Validate; return value is card type if valid. */
            $false = false;
            $card_regexes = array(
                "/^4\d{12}(\d\d\d){0,1}$/" => "Visa",
                "/^5[12345]\d{14}$/" => "MasterCard"
            );
            
            $card_type = null;
            foreach ($card_regexes as $regex => $type) {
                if (preg_match($regex, $cc_number)) {
                    $card_type = $type;
                    break;
                }
            }
            if (is_null($card_type)) {
                throw new Exception("Regex didn't match known card types");
            }

            /*  mod 10 checksum algorithm  */
            $revcode = strrev($cc_number);
            $checksum = 0;

            for ($i = 0; $i < strlen($revcode); $i++) {
                $current_num = intval($revcode[$i]);
                if ($i & 1) {  /* Odd  position */
                    $current_num *= 2;
                }

                /* Split digits and add. */
                $checksum += $current_num % 10;
                if ($current_num > 9) {
                    $checksum += 1;
                }
            }

            if ($checksum % 10 == 0) {
                return $card_type;
            } else {
                throw new Exception("Checksum invalide");
                // return $false;
            }
        }

        public static function getCardType($cc_number) {
            $card_type = static::validate_cc_number($cc_number);
            if ($card_type == false) {
                throw new Exception("Numéro de carte invalide");
            }
            return $card_type;
        }

        public static function tests() {
            $testsValues = array(
                "5555555555554444" => "MasterCard",
                "5105105105105100" => "MasterCard",
                "4111111111111111" => "Visa",
                "4012888888881881" => "Visa",
                "4222222222222" => "Visa",
            );

            foreach ($testsValues as $cardNb => $type) {
                echo "$cardNb ($type) : ";
                try {
                    if (static::validate_cc_number($cardNb) == $type) {
                        echo "OK";
                    } else {
                        echo "Invalide";
                    }
                } catch (Exception $e) {
                    echo "ERREUR : " . $e->getMessage();
                }
                echo "<br>";
            }
        }
    }
?>