<?php
    require_once("../models/objet.php");

    class Panier extends objet {
        public static function getProduitsSeuls() {
            return $_SESSION['panier']['produits'];
        }

        public static function getMenus() {
            return $_SESSION['panier']['menus'];
        }

        public static function getPanier() {
            return $_SESSION['panier'];
        }

        public static function set() {
            $_SESSION['panier'] = array(
                "produits" => array(),
                "menus" => array()
            );
        }

        public static function empty() {
            static::set();
        }
        
        public static function getPos($produit) {
            for ($i=0; $i < count($_SESSION['panier']['produits']); $i++) {
                if ($_SESSION['panier']['produits'][$i]['produit'] == $produit) {
                    return $i;
                }
            }
            return false;
        }

        public static function get($produit) {
            $pos = static::getPos($produit);
            if ($pos !== false) {
                return $_SESSION['panier']['produits'][$pos];
            } else {
                return false;
            }
        }

        public static function remove($pos) {
            // remove product from cart array at index $pos and reindex array
            unset($_SESSION['panier']['produits'][$pos]);
            $_SESSION['panier']['produits'] = array_values($_SESSION['panier']['produits']);
        }

        public static function addProduit($produit, $quantite = 1) {
            if ($quantite < 1) return;
            if (static::getPos($produit) !== false) {
                $pos = static::getPos($produit);
                $_SESSION['panier']['produits'][$pos]['quantite'] += $quantite;
            } else {
                $_SESSION['panier']['produits'][] = array(
                    "produit" => $produit,
                    "quantite" => $quantite
                );
            }
        }

        public static function addMenu($id, $nom, $prix) {
            // TODO
        }

        public static function getTotal() {
            $total = 0;
            foreach ($_SESSION['panier']['produits'] as $produit) {
                $total += $produit['produit']->getPrixStr() * $produit['quantite'];
            }
            return sprintf("%0.2f", $total);
        }

        public static function getTotalApresPromo($codePromo) {
            $total = static::getTotal();
            $requetePreparee = "SELECT TypeCodePromo, valeurCodePromo, dateExpirationCodePromo FROM CodePromo WHERE codePromo = :codePromo;";
            $res = static::$connexion->prepare($requetePreparee);
            $res->execute(array("codePromo" => $codePromo));
            $resultat = $res->fetch();
            if (!$resultat) {
                throw new Exception("Le code promo n'est pas valide");
            }

            $dateExpiration = $resultat['dateExpirationCodePromo'];
            if ($dateExpiration != null) {
                $dateExpiration = new DateTime($dateExpiration);
                $dateExpiration = $dateExpiration->format('Y-m-d H:i:s');
                $dateActuelle = new DateTime();
                $dateActuelle = $dateActuelle->format('Y-m-d H:i:s');
                if ($dateExpiration < $dateActuelle) {
                    throw new Exception("Le code promo a expiré");
                }
            }

            $typeCodePromo = $resultat['TypeCodePromo'];
            $valeurCodePromo = $resultat['valeurCodePromo'];
            if ($typeCodePromo == "POURCENTAGE") {
                $total = $total * (1 - $valeurCodePromo / 100);
            } else if ($typeCodePromo == "MONTANT") {
                $total = $total - $valeurCodePromo;
            } else {
                throw new Exception("Le type de code promo n'est pas valide");
            }
        }

        public static function registerCommande(array $panier, array $account, array $form) : int {
            require_once('../config/config.php');
            require_once('../config/db.php');
            static::$connexion = connexion::connect();


            // ----- 0. Commencer la transaction -----
            static::$connexion->beginTransaction();
            

            // ----- 1. Créer la commande dans la bdd -----
            // 1.1. Vérifier que le client existe
            $requetePreparee = "SELECT idClient FROM CompteClient WHERE idClient = :idClient;";
            $res = static::$connexion->prepare($requetePreparee);
            $res->execute(array("idClient" => $account['idClient']));
            $resultat = $res->fetch();
            if (!$resultat) {
                throw new Exception("Le compte client n'existe pas");
            }

            // 1.2. Vérifier que le panier n'est pas vide
            if (count($panier['produits']) == 0) {
                throw new Exception("Le panier est vide");
            }

            // 1.3. Vérifier que le code promo est valide
            if ($form['codePromo'] != "") {
                $requetePreparee = "SELECT idCodePromo FROM CodePromo WHERE codePromo = :codePromo;";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array("codePromo" => $form['codePromo']));
                $resultat = $res->fetch();
                if (!$resultat) {
                    throw new Exception("Le code promo n'est pas valide");
                }
            }

            if ($form['estEnLivraison'] == "on") {
                // 1.4. Créer la ville dans Ville (si elle n'existe pas déjà)
                $requetePreparee = "SELECT idVille FROM Ville WHERE nomVille = :nomVille AND codePostalVille = :codePostalVille;";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array(
                    "nomVille" => $form['ville'],
                    "codePostalVille" => $form['codePostal'],
                ));
                $resultat = $res->fetch();
                if ($resultat) {
                    $idVille = $resultat['idVille'];
                } else {
                    $requetePreparee = "INSERT INTO Ville (`nomVille`, `codePostalVille`) VALUES (:nomVille, :codePostalVille);";
                    $res = static::$connexion->prepare($requetePreparee);
                    $res->execute(array(
                        "nomVille" => $form['ville'],
                        "codePostalVille" => $form['codePostal'],
                    ));
                    $resultat = $res->fetch();
                    $idVille = static::$connexion->lastInsertId();
                }

                // 1.5. Créer l'adresse de livraison dans Adresse (si elle n'existe pas déjà)
                $requetePreparee = "SELECT idAdresse FROM Adresse WHERE numAdresse = :numeroVoieAdresse AND rueAdresse = :nomVoieAdresse AND complementAdresse = :complementAdresse AND coordoneesAdresse = :coordoneesAdresse AND idVille = :idVille;";
                $res = static::$connexion->prepare($requetePreparee);
                
                $res->execute(array(
                    "numeroVoieAdresse" => $form['numAdresse'],
                    "nomVoieAdresse" => $form['rueAdresse'],
                    "complementAdresse" => $form['complementAdresse'],
                    "coordoneesAdresse" => "ST_GeomFromText('POINT(" . $form['latitude'] . " " . $form['longitude'] . ")')",
                    "idVille" => $idVille,
                ));
                $resultat = $res->fetch();
                if ($resultat) {
                    $idAdresse = $resultat['idAdresse'];
                } else {
                    $requetePreparee = "INSERT INTO Adresse (`numAdresse`, `rueAdresse`, `complementAdresse`, `coordoneesAdresse`, `idVille`) VALUES (:numeroVoieAdresse, :nomVoieAdresse, :complementAdresse, ST_GeomFromText(:coordoneesAdresse), :idVille);";
                    $res = static::$connexion->prepare($requetePreparee);
                    $res->execute(array(
                        "numeroVoieAdresse" => $form['numAdresse'],
                        "nomVoieAdresse" => $form['rueAdresse'],
                        "complementAdresse" => $form['complementAdresse'],
                        "coordoneesAdresse" => "POINT(" . $form['latitude'] . " " . $form['longitude'] . ")",
                        "idVille" => $idVille,
                    ));
                    $resultat = $res->fetch();
                    $idAdresse = static::$connexion->lastInsertId();
                }

                // 1.6. Ajouter l'adresse de livraison au CompteClient (si elle n'existe pas déjà)
                $requetePreparee = "SELECT idAdresse FROM AdresseCompteClient WHERE idAdresse = :idAdresse AND idClient = :idClient;";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array(
                    "idAdresse" => $idAdresse,
                    "idClient" => $account['idClient'],
                ));
                $resultat = $res->fetch();
                if (!$resultat) {
                    $requetePreparee = "INSERT INTO AdresseCompteClient (`idAdresse`, `idClient`) VALUES (:idAdresse, :idClient);";
                    $res = static::$connexion->prepare($requetePreparee);
                    $res->execute(array(
                        "idAdresse" => $idAdresse,
                        "idClient" => $account['idClient'],
                    ));
                    $resultat = $res->fetch();
                }

                // 1.7. Créer la livraison dans Livraison
                // (idLivraison, dateHeureDebutLivraision, dateHeureFinLivraison, idVehicule, idLivreur)
                $requetePreparee = "INSERT INTO Livraison (`dateHeureDebutLivraision`, `dateHeureFinLivraison`, `idVehicule`, `idLivreur`) VALUES (:dateHeureDebutLivraision, :dateHeureFinLivraison, :idVehicule, :idLivreur);";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array(
                    "dateHeureDebutLivraision" => date("Y-m-d H:i:s"),
                    "dateHeureFinLivraison" => null,
                    "idVehicule" => 1,
                    "idLivreur" => 1,
                ));
            }

            // 1.8. Créer la commande dans Commande
            $requetePreparee = "INSERT INTO Commande (`dateHeureCommande`, `dateHeureLivraison`, `estEnLivraison`, `estPrete`, `montantFactureCommande`, `idCodePromo`, `idAdresse`, `idLivraison`, `idClient`) VALUES (:dateHeureCommande, :dateHeureLivraison, :estEnLivraison, :estPrete, :montantFactureCommande, :idCodePromo, :idAdresse, :idLivraison, :idClient);";
            $res = static::$connexion->prepare($requetePreparee);
            $res->execute(array(
                "dateHeureCommande" => date("Y-m-d H:i:s"),
                "dateHeureLivraison" => null,
                "estEnLivraison" => $form['estEnLivraison'] == "on" ? 1 : 0,
                "estPrete" => 0,
                "montantFactureCommande" => $form['codePromo'] != "" ? static::getTotalApresPromo($form['codePromo']) : static::getTotal(),
                "idCodePromo" => $form['codePromo'] != "" ? $form['codePromo'] : null,
                "idAdresse" => $form['estEnLivraison'] == "on" ? $idAdresse : null,
                "idLivraison" => null,
                "idClient" => $account['idClient'],
            ));
            $resultat = $res->fetch();
            $idCommande = static::$connexion->lastInsertId();
            echo "<pre>"; var_dump($idCommande); echo "</pre>";
            

            // ----- 2. Ajouter les produits seuls à la bdd -----
            foreach ($panier['produits'] as $produit) {
                // 2.1. Enregistrer la fiche produit dans ProduitAchete
                $requetePreparee = "INSERT INTO ProduitAchete (`idFicheProduit`) VALUES (:idFicheProduit);";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array("idFicheProduit" => $produit['produit']->idFicheProduit));
                $idProduitAchete = static::$connexion->lastInsertId();

                // 2.2. Si le produit est une pizza, enregistrer la pizza dans VariantePizza (avec les options)
                if (produit::isPizza($produit['produit']->idFicheProduit)) {
                    // 2.2.1. Enregistrer la pizza dans VariantePizza
                    $requetePreparee = "INSERT INTO VariantePizza (`idPate`, `idSauce`, `idTaille`, `idRecettePizza`, `idProduitAchete`) VALUES (:idPate, :idSauce, :idTaille, :idRecettePizza, :idProduitAchete);";
                    $res = static::$connexion->prepare($requetePreparee);
                    $res->execute(array(
                        "idPate" => $produit['produit']->idPate,
                        "idSauce" => $produit['produit']->idSauce,
                        "idTaille" => $produit['produit']->idTaillePizza,
                        "idRecettePizza" => $produit['produit']->idRecettePizza,
                        "idProduitAchete" => $idProduitAchete,
                    ));

                    // 2.2.2. Enregistrer les ingrédients retirés dans IngredientRetirePizza
                    foreach ($produit['produit']->ingredientsRetires as $ingredient) {
                        $requetePreparee = "INSERT INTO IngredientRetirePizza (`idVariantePizza`, `idIngredient`, `quantite`) VALUES (:idVariantePizza, :idIngredient, :quantite);";
                        $res = static::$connexion->prepare($requetePreparee);
                        $res->execute(array(
                            "idVariantePizza" => $idProduitAchete,
                            "idIngredient" => $ingredient['idIngredient'],
                            "quantite" => $ingredient['quantite'],
                        ));
                    }

                    // 2.2.3. Enregistrer les ingrédients ajoutés dans IngredientAjoutePizza
                    foreach ($produit['produit']->ingredientsAjoutes as $ingredient) {
                        $requetePreparee = "INSERT INTO IngredientAjoutePizza (`idVariantePizza`, `idIngredient`, `quantite`) VALUES (:idVariantePizza, :idIngredient, :quantite);";
                        $res = static::$connexion->prepare($requetePreparee);
                        $res->execute(array(
                            "idVariantePizza" => $idProduitAchete,
                            "idIngredient" => $ingredient['idIngredient'],
                            "quantite" => $ingredient['quantite'],
                        ));
                    }
                }

                // 2.3. Enregistrer le produit acheté dans ProduitCommande
                $requetePreparee = "INSERT INTO ProduitCommande (`idCommande`, `idProduitAchete`, `quantite`, `instruction`) VALUES (:idCommande, :idProduitAchete, :quantite, :instruction);";
                $res = static::$connexion->prepare($requetePreparee);
                $res->execute(array(
                    "idCommande" => $idCommande,
                    "idProduitAchete" => $idProduitAchete,
                    "quantite" => $produit['quantite'],
                    "instruction" => isset($produit['instructions']) ? $produit['instructions'] : null, // TODO
                ));
            }


            // ----- 3. Ajouter les menus à la bdd -----
            // TODO


            // ----- 4. Valider la transaction -----
            static::$connexion->commit();

            // ----- 5. Vider le panier -----
            static::empty();

            // ----- 6. Retourner l'id de la commande -----
            return $idCommande;
        }
    }
?>