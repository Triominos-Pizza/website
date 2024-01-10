<?php
    if (!class_exists('connexion')) {

        isset($CONFIG_IMPORTED) ? null : include('../config/config.php');

        class connexion{
            // L'attribut static qui matérialise la connexion
            private static PDO $pdo;
            
            // Le getter public de cet attribut
            static public function pdo() {
                return self::$pdo;
            }
            
            // La fonction static de connexion qui initialise $pdo
            // et lance la tentative de connexion
            // PDO = PHP Data Object = une classe native adaptée à la connexion
            static public function connect() {
                try {
                    self::$pdo = new PDO(
                        "mysql:host=".HOSTNAME.";dbname=".DATABASE, DB_LOGIN, DB_PASSWORD,
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                    );
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return self::$pdo;
                } catch (PDOException $e) {
                    echo "Connexion échouée : " . $e->getMessage() . "<br/>";
                    return null;
                }
            }

            static public function disconnect() {
                self::$pdo = null;
            }

            static public function test(): bool {
                return self::$pdo->exec("") !== false;
            }
        }

    }
?>