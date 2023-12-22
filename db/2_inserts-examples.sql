INSERT INTO Ville
    (idVille, nomVille, codePostalVille)
VALUES
    (1, 'Orsay', '91400'),
    (2, 'Gif-sur-Yvette', '91190'),
    (3, 'Bures-sur-Yvette', '91440'),
    (4, 'Les Ulis', '91940'),
    (5, 'Palaiseau', '91120'),
    (6, 'Massy', '91300'),
    (7, 'Villebon-sur-Yvette', '91140');

INSERT INTO Adresse
    (idAdresse, numAdresse, rueAdresse, complementAdresse, coordoneesAdresse, idVille)
VALUES
    (1, 1, 'Avenue des sciences', NULL, ST_GeomFromText('POINT(48.710991 2.170854)'), 1),
    (2, 15, 'Rue de la Vallée', NULL, ST_GeomFromText('POINT(48.6833 2.167)'), 2),
    (3, 22, 'Chemin des Pruniers', 'Bâtiment B', ST_GeomFromText('POINT(48.695 2.188)'), 3),
    (4, 5, 'Avenue de l''Europe', NULL, ST_GeomFromText('POINT(48.6819 2.169)'), 4),
    (5, 10, 'Boulevard des Maréchaux', NULL, ST_GeomFromText('POINT(48.714 2.246)'), 5),
    (6, 8, 'Rue du Grand Chemin', 'Appartement 3A', ST_GeomFromText('POINT(48.7302 2.274)'), 6),
    (7, 3, 'Allée des Saules', NULL, ST_GeomFromText('POINT(48.699 2.218)'), 7);


INSERT INTO Restaurant
    (idRestaurant, nomRestaurant, idAdresse)
VALUES
    (1, 'Triominos Pizza - Orsay/Gif', 1);

INSERT INTO Vehicule
    (idVehicule, capaciteVehicule, estDispo, estEnPanne, immatriculationVehicule, idRestaurant)
VALUES
    (1, 144, 1, 0, 'AA123AA', 1), -- Motos
    (2, 144, 1, 0, 'AA456AA', 1), -- Motos
    (3, 144, 1, 0, 'AA789AA', 1), -- Motos
    (4, 144, 1, 0, 'AA012AA', 1), -- Motos
    (5, 3000, 1, 0, 'AA345AA', 1), -- Voiture
    (6, 5800, 1, 0, 'AA678AA', 1); -- Camionette

INSERT INTO Role
    (idRole, nomRole)
VALUES
    (1, 'Pizzaiolo'),
    (2, 'Livreur'),
    (3, 'Gestionnaire');

INSERT INTO Employe
    (idEmploye, nomEmploye, prenomEmploye, mdpEmploye, urlPhotoProfilEmploye, idRestaurant)
VALUES
    (1, 'Pizzaiolo', 'Mario', '18652f11d1964a53ba251f59e1fa65a9e4e261b05b18fcf83dc9dab5537db589', '/assets/images/profile_pictures/employe/photoProfilMario.png', 1),      -- MDP : Mario123
    (2, 'Livreur', 'Luigi', 'c7f7f15ca23b57ad66da6214708c786bb9a9b3ee10994fb52b549d0b3ecafd90', '/assets/images/profile_pictures/employe/photoProfilLuigi.png', 1),        -- MDP : Luigi123
    (3, 'Gestionnaire', 'Peach', '63761cf4670adc3ce954534650fb3a69b3b89c9d268b25015895125a359be6b1', '/assets/images/profile_pictures/employe/photoProfilPeach.png', 1);   -- MDP : Peach123

INSERT INTO RoleEmploye
    (idEmploye, idRole)
VALUES
    (1, 1), -- Mario est un pizzaiolo
    (2, 2), -- Luigi est un livreur
    (3, 3); -- Peach est un gestionnaire

INSERT INTO Livreur
    (idLivreur, estDispo, idEmploye)
VALUES
    (1, 1, 2); -- Luigi est un livreur (et il est dispo)

INSERT INTO Menu
    (idMenu, nomMenu, descriptionMenu, prixMenu, urlImageMenu)
VALUES
    (1, 'Pizza + Boisson + Dessert', 'Une pizza, une boisson et un dessert au choix', 15.99, '/assets/images/menus/menu-pizza-boisson-dessert.png'),
    (2, 'Pizza + Boisson', 'Une pizza et une boisson au choix', 12.99, '/assets/images/menus/menu-pizza-boisson.png'),
    (3, 'Pizza + Dessert', 'Une pizza et un dessert au choix', 13.99, '/assets/images/menus/menu-pizza-dessert.png');

-- Un produit peut avoir plusieurs types
INSERT INTO TypeProduit
    (idTypeProduit, nomTypeProduit)
VALUES
    (1, 'Pizza'),
    (2, 'Boisson'),
    (3, 'Dessert'),
    (4, 'Entrée'),
    (5, 'Salade'),
    (6, 'Pâtes'),
    (7, 'Dessert glacé'),
    (8, 'Dessert chaud'),
    (9, 'Soda');

INSERT INTO TypeProduitPossibleMenu
    (idMenu, idTypeProduit)
VALUES
    (1, 1), -- Pizza + Boisson + Dessert : Pizza
    (1, 2), -- Pizza + Boisson + Dessert : Boisson
    (1, 3), -- Pizza + Boisson + Dessert : Dessert
    (2, 1), -- Pizza + Boisson : Pizza
    (2, 2), -- Pizza + Boisson : Boisson
    (3, 1), -- Pizza + Dessert : Pizza
    (3, 3); -- Pizza + Dessert : Dessert

INSERT INTO FicheProduit
    (idFicheProduit, nomProduit, prixProduit, urlImageProduit)
VALUES
    (1, 'Margherita', 9.99, '/assets/images/products/pizza-margherita.png'),
    (2, 'Pepperoni', 10.99, '/assets/images/products/pizza-pepperoni.png'),
    (3, 'Quatre Fromages', 11.99, '/assets/images/products/pizza-quatre-fromages.png'),
    (4, 'Hawaïenne', 10.99, '/assets/images/products/pizza-hawaienne.png'),
    (5, 'Végétarienne', 9.99, '/assets/images/products/pizza-vegetarienne.png'),
    (6, 'Coca-Cola 33cl', 1.50, '/assets/images/products/coca-cola-33cl.png'),
    (7, 'Sprite 33cl', 1.50, '/assets/images/products/sprite-33cl.png'),
    (8, 'Eau Minérale 50cl', 1.00, '/assets/images/products/eau-minerale-50cl.png'),
    (9, 'Tiramisu', 4.99, '/assets/images/products/tiramisu.png'),
    (10, 'Glace Chocolat', 3.99, '/assets/images/products/glace-chocolat.png');

-- Un produit peut avoir plusieurs types
INSERT INTO TypeProduitFicheProduit
    (idFicheProduit, idTypeProduit)
VALUES
    (1, 1), -- Margherita : Pizza
    (2, 1), -- Pepperoni : Pizza
    (3, 1), -- Quatre Fromages : Pizza
    (4, 1), -- Hawaïenne : Pizza
    (5, 1), -- Végétarienne : Pizza
    (6, 2), -- Coca-Cola 33cl : Boisson
    (6, 9), -- Coca-Cola 33cl : Soda
    (7, 2), -- Sprite 33cl : Boisson
    (7, 9), -- Sprite 33cl : Soda
    (8, 2), -- Eau Minérale 50cl : Boisson
    (9, 3), -- Tiramisu : Dessert
    (10, 3), -- Glace Chocolat : Dessert
    (10, 7); -- Glace Chocolat : Dessert glacé
    

INSERT INTO Stock
    (idStock, uniteStock, valeurStock, seuilAlerteStock)
VALUES
    (1, NULL, 500, 50), -- Stock for Coca-Cola 33cl
    (2, NULL, 500, 50), -- Stock for Sprite 33cl
    (3, NULL, 500, 50), -- Stock for Eau Minérale 50cl
    (4, NULL, 100, 10), -- Stock for Tiramisu
    (5, NULL, 100, 10), -- Stock for Glace Chocolat
    (6, 'g', 10000, 1000), -- Stock for Tomate
    (7, 'g', 5000, 500), -- Stock for Mozzarella
    (8, 'g', 2000, 200), -- Stock for Basilic
    (9, 'g', 3000, 300), -- Stock for Pepperoni
    (10, 'g', 2500, 250), -- Stock for Ananas
    (11, 'g', 2000, 200), -- Stock for Champignon
    (12, 'g', 1000, 100), -- Stock for Olives
    (13, 'g', 3000, 300), -- Stock for Poulet
    (14, 'g', 3000, 300), -- Stock for Boeuf
    (15, 'g', 2000, 200), -- Stock for Oignon
    (16, 'g', 3000, 300), -- Stock for Jambon
    (17, 'g', 3000, 300), -- Stock for Cheddar
    (18, 'g', 3000, 300), -- Stock for Parmesan
    (19, 'g', 3000, 300); -- Stock for Gorgonzola

INSERT INTO Allergene
    (idAllergene, nomAllergene, urlIconneAllergene)
VALUES
    (1, 'Gluten', '/assets/images/allergens/gluten.png'),
    (2, 'Crustacés', '/assets/images/allergens/crustaces.png'),
    (3, 'Œufs', '/assets/images/allergens/oeufs.png'),
    (4, 'Poisson', '/assets/images/allergens/poisson.png'),
    (5, 'Arachide', '/assets/images/allergens/arachide.png'),
    (6, 'Soja', '/assets/images/allergens/soja.png'),
    (7, 'Lait', '/assets/images/allergens/lait.png'),
    (8, 'Fruits à coque', '/assets/images/allergens/fruits_a_coque.png'),
    (9, 'Céleri', '/assets/images/allergens/celeri.png'),
    (10, 'Moutarde', '/assets/images/allergens/moutarde.png'),
    (11, 'Graines de sésame', '/assets/images/allergens/sesame.png'),
    (12, 'Sulfites', '/assets/images/allergens/sulfites.png'),
    (13, 'Lupin', '/assets/images/allergens/lupin.png'),
    (14, 'Mollusques', '/assets/images/allergens/mollusques.png');

INSERT INTO ProduitIndustriel
    (idProduitIndustriel, volumeProduit, CodeBarreProduitIndustriel, idStock, idFicheProduit)
VALUES
    (1, 330, '1234567890123', 1, 6), -- Coca-Cola 33cl
    (2, 330, '2345678901234', 2, 7), -- Sprite 33cl
    (3, 500, '3456789012345', 3, 8), -- Eau Minérale 50cl
    (4, 100, '4567890123456', 4, 9), -- Tiramisu
    (5, 100, '5678901234567', 5, 10); -- Glace Chocolat

INSERT INTO ProduitIndustrielAllergene
    (idProduitIndustriel, idAllergene)
VALUES
    -- Tiramisu allergens
    (4, 1), -- Gluten
    (4, 3), -- Œufs (Eggs)
    (4, 7), -- Lait (Milk)
    -- Glace Chocolat allergens
    (5, 7), -- Lait (Milk)
    (5, 6), -- Soja (Soy), if applicable
    (5, 8); -- Fruits à coque (Tree Nuts), if applicable

INSERT INTO Ingredient
    (idIngredient, nomIngredient, prixVenteIngredient, estHalal, estVegan, urlImageIngredient, idStock)
VALUES
    (1, 'Tomate', '0.5', TRUE, TRUE, '/assets/images/ingredients/tomate.png', 6),
    (2, 'Mozzarella', '1.0', TRUE, FALSE, '/assets/images/ingredients/mozzarella.png', 7),
    (3, 'Basilic', '0.2', TRUE, TRUE, '/assets/images/ingredients/basilic.png', 8),
    (4, 'Pepperoni', '1.5', FALSE, FALSE, '/assets/images/ingredients/pepperoni.png', 9),
    (5, 'Ananas', '0.7', TRUE, TRUE, '/assets/images/ingredients/ananas.png', 10),
    (6, 'Champignon', '0.6', TRUE, TRUE, '/assets/images/ingredients/champignon.png', 11),
    (7, 'Olives', '0.3', TRUE, TRUE, '/assets/images/ingredients/olives.png', 12),
    (8, 'Poulet', '1.2', TRUE, FALSE, '/assets/images/ingredients/poulet.png', 13),
    (9, 'Boeuf', '1.4', TRUE, FALSE, '/assets/images/ingredients/boeuf.png', 14),
    (10, 'Oignon', '0.4', TRUE, TRUE, '/assets/images/ingredients/oignon.png', 15),
    (11, 'Jambon', '1.0', TRUE, FALSE, '/assets/images/ingredients/jambon.png', 16),
    (12, 'Cheddar', '1.0', TRUE, FALSE, '/assets/images/ingredients/cheddar.png', 17),
    (13, 'Parmesan', '1.0', TRUE, FALSE, '/assets/images/ingredients/parmesan.png', 18),
    (14, 'Gorgonzola', '1.0', TRUE, FALSE, '/assets/images/ingredients/gorgonzola.png', 19);

INSERT INTO IngredientAllergene
    (idIngredient, idAllergene)
VALUES
    -- Mozzarella allergens
    (2, 7); -- Lait (Milk)

INSERT INTO PatePizza
    (idPate, nomPate, prixSupplementPate)
VALUES
    (1, 'Pâte fine', 0.0),
    (2, 'Pâte épaisse', 1.0),
    (3, 'Pâte sans gluten', 2.0),
    (4, 'Pâte au fromage', 3.0);

INSERT INTO PateAllergene
    (idPate, idAllergene)
VALUES
    -- Pâte fine allergens
    (1, 1), -- Gluten
    -- Pâte épaisse allergens
    (2, 1), -- Gluten
    (2, 7), -- Lait (Milk)
    -- Pâte au fromage allergens
    (4, 1), -- Gluten
    (4, 7); -- Lait (Milk)

INSERT INTO BaseSaucePizza
    (idSauce, nomSauce, prixSupplementBase)
VALUES
    (1, 'Sauce tomate', 0.0),
    (2, 'Crème fraîche', 0.0),
    (3, 'Sauce barbecue', 0.0),
    (4, 'Sauce piquante', 0.0);

INSERT INTO SauceAllergene
    (idSauce, idAllergene)
VALUES
    -- Tomato Sauce
    (1, 7),  -- Lait (Milk)
    (1, 1),  -- Gluten
    -- Crème Fraîche
    (2, 7),  -- Lait (Milk)
    -- Barbecue Sauce
    (3, 1),  -- Gluten
    (3, 10), -- Moutarde
    -- Hot Sauce
    (4, 9);  -- Céleri

INSERT INTO TaillePizza
    (idTaille, nomTaille, volumePizza, capaciteIngredient, prixSupplementTaille)
VALUES
    (1, 'Petite', 500, 7, 0.0),
    (2, 'Moyenne', 1000, 8, 1.0),
    (3, 'Grande', 1500, 10, 2.0);

INSERT INTO RecettePizza
    (idRecettePizza, texteRecettePizza, idFicheProduit)
VALUES
    (1, 'Étalez la pâte à pizza et tartinez de sauce tomate. Garnissez de tranches fines de mozzarella et de feuilles de basilic frais, puis faites cuire jusqu''à ce que la pâte soit dorée et croustillante.', 1),
    (2, 'Commencez par étaler la pâte à pizza et recouvrez-la généreusement de sauce tomate. Ajoutez une couche de mozzarella et de tranches de pepperoni, puis enfournez jusqu''à ce que le fromage soit fondu et légèrement doré.', 2),
    (3, 'Étalez la pâte à pizza et appliquez une fine couche de sauce tomate. Mélangez quatre types de fromages (comme mozzarella, cheddar, parmesan, et gorgonzola), parsemez-les sur la sauce, et cuisez jusqu''à ce que les fromages soient parfaitement fondus.', 3),
    (4, 'Après avoir étalé la pâte, étendez une couche de sauce tomate. Garnissez avec du jambon coupé en dés et des morceaux d''ananas, saupoudrez de mozzarella, et faites cuire jusqu''à ce que le fromage soit bien fondu et la pâte croustillante.', 4),
    (5, 'Tartinez la pâte à pizza avec de la sauce tomate, puis disposez un assortiment de légumes frais de votre choix (comme des poivrons, des oignons, des champignons, et des olives). Ajoutez une couche de mozzarella et faites cuire jusqu''à ce que les légumes soient tendres et le fromage fondu.', 5);

INSERT INTO IngredientRecette
    (idIngredient, idRecettePizza, quantite, estModifiable)
VALUES
    -- Margherita
    (1, 1, 100, 1), -- Tomate
    (2, 1, 100, 1), -- Mozzarella
    (3, 1, 10, 1), -- Basilic
    -- Pepperoni
    (1, 2, 100, 1), -- Tomate
    (2, 2, 100, 1), -- Mozzarella
    (4, 2, 100, 1), -- Pepperoni
    -- Quatre Fromages
    (1, 3, 100, 1), -- Tomate
    (2, 3, 100, 1), -- Mozzarella
    (12, 3, 100, 1), -- Cheddar
    (13, 3, 100, 1), -- Parmesan
    (14, 3, 100, 1), -- Gorgonzola
    -- Hawaïenne
    (1, 4, 100, 1), -- Tomate
    (2, 4, 100, 1), -- Mozzarella
    (5, 4, 100, 1), -- Ananas
    (11, 4, 100, 1), -- Jambon
    -- Végétarienne
    (1, 5, 100, 1), -- Tomate
    (2, 5, 100, 1), -- Mozzarella
    (6, 5, 100, 1), -- Champignon
    (7, 5, 100, 1), -- Olives
    (10, 5, 100, 1); -- Oignon

INSERT INTO CompteClient
    (idClient, prenomClient, nomClient, emailClient, telClient, mdpClient, urlPhotoProfilClient, ptsFideliteClient)
VALUES
    ('492b3a07-9c72-11ee-87a7-00163ed28d69',  'Jean',    'Dupont',   'jean.dupont@gmail.com',    '336123456789', '422d5876278007f6c82c7e5343b4a83e1f1c11680182e5b65d247a6e954c9290', '/assets/images/profile_pictures/client/photoProfil_492b3a07-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Jean123
    ('aa411b31-9c72-11ee-87a7-00163ed28d69',  'Marie',   'Martin',   'marie.martin@gmail.com',   '336234567891', '03af4d45a8d4b110966eee5e8d49eaddb69289bd09715ebb854b3bf4111cbd5c', '/assets/images/profile_pictures/client/photoProfil_aa411b31-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Marie123
    ('b5f9c076-9c72-11ee-87a7-00163ed28d69',  'Pierre',  'Durand',   'pierre.durand@gmail.com',  '336345678912', '47dfd10c891fa36db996eaf47da6e10cb0502c3c94c0a5f3bf571f7fcca4b67c', '/assets/images/profile_pictures/client/photoProfil_b5f9c076-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Pierre123
    ('cfd9dea9-9c72-11ee-87a7-00163ed28d69',  'Sophie',  'Leroy',    'sophie.leroy@gmail.com',   '336456789123', 'ae20655f9be90d606084664d48469bae6aedd65b88f03f175c7e4a1b2410e54b', '/assets/images/profile_pictures/client/photoProfil_cfd9dea9-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Sophie123
    ('d6841300-9c72-11ee-87a7-00163ed28d69',  'Louis',   'Moreau',   'louis.moreau@gmail.com',   '336567891234', 'c7df988f04ce3b4c63b9f959d9e4b64d09add73eb438a271121b3f7330d0b86a', '/assets/images/profile_pictures/client/photoProfil_d6841300-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Louis123
    ('dfe30f24-9c72-11ee-87a7-00163ed28d69',  'Camille', 'Simon',    'camille.simon@gmail.com',  '336678912345', '27d34f2e26284357af7ac6caf7926d02ba45794d2ff7e4df049c894324884aa8', '/assets/images/profile_pictures/client/photoProfil_dfe30f24-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Camille123
    ('e6d087c4-9c72-11ee-87a7-00163ed28d69',  'Paul',    'Laurent',  'paul.laurent@gmail.com',   '336789123456', '1bb78288d604d97f57237f3a1586b567b928d97b9bdbdbf44855be2f3c75bea7', '/assets/images/profile_pictures/client/photoProfil_e6d087c4-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Paul123
    ('eda84ffa-9c72-11ee-87a7-00163ed28d69',  'Léa',     'Michel',   'léa.michel@gmail.com',     '336891234567', 'be47062ff165083c31036d01b82de497fd2c935c269f845e84014ee7de99ee0c', '/assets/images/profile_pictures/client/photoProfil_eda84ffa-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Léa123
    ('f711bf4b-9c72-11ee-87a7-00163ed28d69',  'Lucas',   'Lefebvre', 'lucas.lefebvre@gmail.com', '336912345678', 'cacdda6e5cef374e9a51fe7dd55cc4687ae68ff9e29f006fd648064c29c63546', '/assets/images/profile_pictures/client/photoProfil_f711bf4b-9c72-11ee-87a7-00163ed28d69.png', 0), -- MDP : Lucas123
    ('fc5421e9-9c72-11ee-87a7-00163ed28d69',  'Emma',    'Roux',     'emma.roux@gmail.com',      '336023456789', '6f06716dc6768f84c9f15ef09d3b4e1381de3288e14b609024da02f8c2edbafe', '/assets/images/profile_pictures/client/photoProfil_fc5421e9-9c72-11ee-87a7-00163ed28d69.png', 0); -- MDP : Emma123

INSERT INTO AdresseCompteClient
    (idClient, idAdresse)
VALUES
    ('492b3a07-9c72-11ee-87a7-00163ed28d69', 2), -- Jean Dupont     -> 15 Rue de la Vallée, Gif-sur-Yvette
    ('aa411b31-9c72-11ee-87a7-00163ed28d69', 2), -- Marie Martin    -> 15 Rue de la Vallée, Gif-sur-Yvette
    ('aa411b31-9c72-11ee-87a7-00163ed28d69', 3), -- Marie Martin    -> 22 Chemin des Pruniers, Bures-sur-Yvette
    ('b5f9c076-9c72-11ee-87a7-00163ed28d69', 3), -- Pierre Durand   -> 22 Chemin des Pruniers, Bures-sur-Yvette
    ('cfd9dea9-9c72-11ee-87a7-00163ed28d69', 4), -- Sophie Leroy    -> 5 Avenue de l'Europe, Les Ulis
    ('d6841300-9c72-11ee-87a7-00163ed28d69', 4), -- Louis Moreau    -> 5 Avenue de l'Europe, Les Ulis
    ('d6841300-9c72-11ee-87a7-00163ed28d69', 5), -- Louis Moreau    -> 10 Boulevard des Maréchaux, Palaiseau
    ('dfe30f24-9c72-11ee-87a7-00163ed28d69', 5), -- Camille Simon   -> 10 Boulevard des Maréchaux, Palaiseau
    ('e6d087c4-9c72-11ee-87a7-00163ed28d69', 6), -- Paul Laurent    -> 8 Rue du Grand Chemin, Massy
    ('eda84ffa-9c72-11ee-87a7-00163ed28d69', 7), -- Léa Michel      -> 3 Allée des Saules, Villebon-sur-Yvette
    ('f711bf4b-9c72-11ee-87a7-00163ed28d69', 7), -- Lucas Lefebvre  -> 3 Allée des Saules, Villebon-sur-Yvette
    ('fc5421e9-9c72-11ee-87a7-00163ed28d69', 7); -- Emma Roux       -> 3 Allée des Saules, Villebon-sur-Yvette

INSERT INTO TypeCodePromo
    (idTypeCodePromo)
VALUES
    ('POURCENTAGE'),
    ('MONTANT');

INSERT INTO CodePromo
    (idCodePromo, descCodePromo, dateCreationCodePromo, dateExpirationCodePromo, estExpiré, nbUtilisationsCodePromo, nbUtilisationsMaxCodePromo, valeurCodePromo, idTypeCodePromo)
VALUES
    ('POURCENTAGE_10', '10% de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 10, 'POURCENTAGE'),
    ('POURCENTAGE_20', '20% de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 20, 'POURCENTAGE'),
    ('POURCENTAGE_30', '30% de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 30, 'POURCENTAGE'),
    ('POURCENTAGE_40', '40% de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 40, 'POURCENTAGE'),
    ('POURCENTAGE_50', '50% de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 50, 'POURCENTAGE'),
    ('MONTANT_5', '5€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 5, 'MONTANT'),
    ('MONTANT_10', '10€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 10, 'MONTANT'),
    ('MONTANT_15', '15€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 15, 'MONTANT'),
    ('MONTANT_20', '20€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 20, 'MONTANT'),
    ('MONTANT_25', '25€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 25, 'MONTANT'),
    ('MONTANT_69', '69€ de réduction sur votre commande', '2023-01-01', '2024-06-01', FALSE, 0, 100, 25, 'MONTANT'),
    ('CODE_EXPIRE_DATE', 'Code expiré (date)', '2020-01-01', '2020-06-01', TRUE, 0, 100, 10, 'POURCENTAGE'),
    ('CODE_EXPIRE_NB_UTILISATIONS', 'Code expiré (nombre d''utilisations)', '2023-01-01', '2024-06-01', TRUE, 100, 100, 10, 'POURCENTAGE');

INSERT INTO CodePromoCompteClient
    (idCodePromo, idClient)
VALUES
    ('POURCENTAGE_10', '492b3a07-9c72-11ee-87a7-00163ed28d69'), -- Jean Dupont -> POURCENTAGE_10
    ('MONTANT_5', '492b3a07-9c72-11ee-87a7-00163ed28d69'),      -- Jean Dupont -> MONTANT_5
    ('POURCENTAGE_10', 'aa411b31-9c72-11ee-87a7-00163ed28d69'),   -- Marie Martin -> POURCENTAGE_10
    ('MONTANT_5', 'aa411b31-9c72-11ee-87a7-00163ed28d69'),        -- Marie Martin -> MONTANT_5
    ('CODE_EXPIRE_DATE', 'aa411b31-9c72-11ee-87a7-00163ed28d69'), -- Marie Martin -> CODE_EXPIRE_DATE
    ('CODE_EXPIRE_NB_UTILISATIONS', 'b5f9c076-9c72-11ee-87a7-00163ed28d69'); -- Pierre Durand -> CODE_EXPIRE_NB_UTILISATIONS
    -- Les autres clients n'ont pas de code promo dans leur interface

INSERT INTO Livraison
    (idLivraison, dateHeureDebutLivraision, dateHeureFinLivraison, idVehicule, idLivreur)
VALUES
    (1, '2023-01-01 12:00:00', '2023-01-01 12:25:00', 1, 1), -- Livraison par Luigi avec le véhicule 1 (durée : 25 minutes)
    (2, '2023-01-01 13:00:00', '2023-01-01 12:35:00', 1, 1), -- Livraison par Luigi avec le véhicule 1 (durée : 35 minutes)
    (3, '2023-12-01 13:30:00', NULL, 1, 1);                  -- Livraison par Luigi avec le véhicule 1 (en cours)

INSERT INTO Commande
    (idCommande, dateHeureCommande,     dateHeureLivraison,    estEnLivraison, estPrete, montantFactureCommande, idCodePromo,          idAdresse, idLivraison, idClient                              )
VALUES
    (1,          '2020-01-01 11:45:00', '2020-01-01 12:10:00', FALSE,          TRUE,     10.0,                   'CODE_EXPIRE_DATE',   NULL,      NULL,        '492b3a07-9c72-11ee-87a7-00163ed28d69'), -- Jean Dupont
    (2,          '2023-01-01 11:45:00', '2023-01-01 12:10:00', FALSE,          TRUE,     10.0,                   NULL,                 NULL,      NULL,        '492b3a07-9c72-11ee-87a7-00163ed28d69'), -- Jean Dupont
    (3,          '2023-01-01 12:30:00', '2023-01-01 13:00:00', FALSE,          TRUE,     20.0,                   "MONTANT_10",         NULL,      NULL,        'aa411b31-9c72-11ee-87a7-00163ed28d69'), -- Marie Martin
    (4,          '2023-01-01 12:45:00', '2023-01-01 13:00:00', FALSE,          TRUE,     30.0,                   "POURCENTAGE_10",     NULL,      NULL,        'b5f9c076-9c72-11ee-87a7-00163ed28d69'), -- Pierre Durand
    (5,          '2023-01-01 13:00:00', '2023-01-01 13:30:00', TRUE,           TRUE,     25.0,                   NULL,                 4,         1,           'cfd9dea9-9c72-11ee-87a7-00163ed28d69'), -- Sophie Leroy
    (6,          '2023-01-01 13:15:00', '2023-01-01 13:35:00', TRUE,           TRUE,     35.0,                   NULL,                 5,         1,           'd6841300-9c72-11ee-87a7-00163ed28d69'), -- Louis Moreau
    (7,          '2023-01-02 18:30:00', '2023-01-02 19:00:00', TRUE,           TRUE,     18.5,                   NULL,                 6,         2,           'dfe30f24-9c72-11ee-87a7-00163ed28d69'), -- Camille Simon
    (8,          '2023-01-02 19:15:00', '2023-01-02 19:45:00', FALSE,          TRUE,     22.0,                   'POURCENTAGE_20',     NULL,      NULL,        'e6d087c4-9c72-11ee-87a7-00163ed28d69'), -- Paul Laurent
    (9,          '2023-01-02 20:00:00', '2023-01-02 20:30:00', TRUE,           TRUE,     15.0,                   NULL,                 7,         3,           'eda84ffa-9c72-11ee-87a7-00163ed28d69'), -- Léa Michel
    (10,         '2023-01-03 12:00:00', '2023-01-03 12:30:00', TRUE,           TRUE,     20.0,                   'MONTANT_5',          7,         3,           'f711bf4b-9c72-11ee-87a7-00163ed28d69'), -- Lucas Lefebvre
    (11,         '2023-01-03 12:45:00', '2023-01-03 13:15:00', FALSE,          TRUE,     17.0,                   NULL,                 NULL,      NULL,        'fc5421e9-9c72-11ee-87a7-00163ed28d69'), -- Emma Roux
    (12,         '2023-01-04 18:00:00', NULL,                  FALSE,          FALSE,    26.0,                   NULL,                 NULL,      NULL,        '492b3a07-9c72-11ee-87a7-00163ed28d69'), -- Jean Dupont (en cours)
    (13,         '2023-01-04 18:30:00', NULL,                  FALSE,          FALSE,    19.5,                   NULL,                 NULL,      NULL,        'aa411b31-9c72-11ee-87a7-00163ed28d69'); -- Marie Martin (en cours)

INSERT INTO ProduitAchete
    (idProduitAchete, idFicheProduit)
VALUES
    (1, 4  ),
    (2, 6  ),
    (3, 1  ),
    (4, 9  ),
    (5, 8  ),
    (6, 4  ),
    (7, 9  ),
    (8, 3  ),
    (9, 8  ),
    (10, 2 ),
    (11, 10),
    (12, 5 ),
    (13, 7 ),
    (14, 10),
    (15, 7 ),
    (16, 5 ),
    (17, 5 ),
    (18, 9 ),
    (19, 5 ),
    (20, 6 ),
    (21, 10),
    (22, 2 ),
    (23, 4 ),
    (24, 7 ),
    (25, 9 ),
    (26, 8 ),
    (27, 3 ),
    (28, 6 ),
    (29, 2 ),
    (30, 1 ),
    (31, 7 ),
    (32, 10),
    (33, 5 ),
    (34, 10),
    (35, 3 ),
    (36, 8 ),
    (37, 5 ),
    (38, 9 ),
    (39, 10),
    (40, 5 ),
    (41, 8 ),
    (42, 4 ),
    (43, 3 ),
    (44, 9 ),
    (45, 4 ),
    (46, 7 ),
    (47, 4 ),
    (48, 7 ),
    (49, 6 ),
    (50, 2 ),
    (51, 2 ),
    (52, 10),
    (53, 5 ),
    (54, 7 ),
    (55, 1 ),
    (56, 10),
    (57, 5 ),
    (58, 6 ),
    (59, 9 ),
    (60, 9 );

INSERT INTO ProduitCommande
    (idCommande, idProduitAchete, quantite, instruction)
VALUES
    (1,  5,  3, NULL),
    (1,  6,  2, NULL),
    (1,  7,  1, NULL),
    (3,  15, 1, NULL),
    (4,  16, 2, NULL),
    (5,  22, 3, NULL),
    (6,  26, 2, NULL),
    (6,  29, 1, NULL),
    (7,  32, 2, NULL),
    (8,  35, 3, NULL),
    (8,  36, 3, NULL),
    (8,  39, 3, NULL),
    (9,  42, 2, NULL),
    (10, 47, 1, NULL),
    (10, 48, 2, NULL),
    (11, 49, 2, NULL),
    (12, 50, 3, NULL),
    (13, 60, 1, NULL);

INSERT INTO ProduitMenu
    (idCommande, idProduitAchete, idMenu, quantite, instruction)
VALUES
    (1,  1,  2, 3, NULL),
    (1,  2,  2, 1, NULL),
    (1,  3,  3, 3, NULL),
    (1,  4,  3, 1, NULL),
    (2,  8,  2, 2, NULL),
    (2,  9,  2, 1, NULL),
    (2,  10, 3, 2, NULL),
    (2,  11, 3, 3, NULL),
    (3,  12, 1, 1, NULL),
    (3,  13, 1, 1, NULL),
    (3,  14, 1, 2, NULL),
    (4,  17, 3, 1, NULL),
    (4,  18, 3, 2, NULL),
    (5,  19, 1, 1, NULL),
    (5,  20, 1, 1, NULL),
    (5,  21, 1, 2, NULL),
    (6,  23, 1, 2, NULL),
    (6,  24, 1, 2, NULL),
    (6,  25, 1, 2, NULL),
    (6,  27, 2, 3, NULL),
    (6,  28, 2, 1, NULL),
    (6,  30, 2, 1, NULL),
    (6,  31, 2, 2, NULL),
    (8,  33, 3, 3, NULL),
    (8,  34, 3, 3, NULL),
    (8,  37, 3, 1, NULL),
    (8,  38, 3, 3, NULL),
    (9,  40, 2, 1, NULL),
    (9,  41, 2, 2, NULL),
    (9,  43, 3, 1, NULL),
    (9,  44, 3, 2, NULL),
    (10, 45, 2, 1, NULL),
    (10, 46, 2, 1, NULL),
    (12, 51, 3, 3, NULL),
    (12, 52, 3, 3, NULL),
    (12, 53, 2, 2, NULL),
    (12, 54, 2, 1, NULL),
    (12, 55, 3, 1, NULL),
    (12, 56, 3, 2, NULL),
    (12, 57, 1, 1, NULL),
    (12, 58, 1, 1, NULL),
    (12, 59, 1, 2, NULL);

INSERT INTO EmployePrepareCommande
    (idCommande, idEmploye)
VALUES
    (1,  1),
    (2,  1),
    (3,  1),
    (4,  1),
    (5,  1),
    (6,  1),
    (7,  1),
    (8,  1),
    (9,  1),
    (10, 1),
    (11, 1),
    (12, 1),
    (13, 1);

INSERT INTO VariantePizza
    (idVariantePizza, idPate, idSauce, idTaille, idRecettePizza, idProduitAchete)
VALUES
    (1,  3, 2, 1, 4, 1 ),
    (2,  1, 4, 3, 1, 3 ),
    (3,  2, 1, 2, 4, 6 ),
    (4,  1, 3, 3, 3, 8 ),
    (5,  2, 4, 3, 2, 10),
    (6,  4, 2, 1, 5, 12),
    (7,  1, 2, 3, 5, 16),
    (8,  4, 4, 1, 5, 17),
    (9,  1, 3, 1, 5, 19),
    (10, 4, 2, 3, 2, 22),
    (11, 1, 1, 2, 4, 23),
    (12, 2, 3, 2, 3, 27),
    (13, 4, 1, 3, 2, 29),
    (14, 3, 4, 1, 1, 30),
    (15, 2, 3, 3, 5, 33),
    (16, 2, 1, 2, 3, 35),
    (17, 4, 1, 2, 5, 37),
    (18, 1, 2, 2, 5, 40),
    (19, 2, 2, 3, 4, 42),
    (20, 4, 2, 3, 3, 43),
    (21, 4, 2, 3, 4, 45),
    (22, 3, 3, 3, 4, 47),
    (23, 4, 3, 2, 2, 50),
    (24, 4, 4, 2, 2, 51),
    (25, 3, 1, 2, 5, 53),
    (26, 1, 3, 3, 1, 55),
    (27, 4, 1, 1, 5, 57);

INSERT INTO IngredientAjoutePizza
    (idVariantePizza, idIngredient, quantite)
VALUES
    (3, 1, 2),
    (3, 11, 1),
    (4, 13, 3),
    (5, 4, 2),
    (6, 10, 1),
    (9, 7, 1),
    (12, 1, 2),
    (13, 4, 3),
    (15, 2, 3),
    (16, 2, 3),
    (17, 1, 2),
    (19, 11, 2),
    (23, 2, 3),
    (25, 1, 2),
    (26, 1, 3),
    (27, 6, 1);

INSERT INTO IngredientRetirePizza
    (idVariantePizza, idIngredient, quantite)
VALUES
    (2, 1, 1),
    (5, 1, 1),
    (11, 11, 1),
    (12, 2, 2),
    (13, 4, 1),
    (13, 1, 1),
    (19, 2, 2),
    (20, 13, 2),
    (22, 5, 2),
    (23, 4, 1),
    (26, 2, 1);
