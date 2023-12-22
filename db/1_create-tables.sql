-- Tables liées à la gestion du restaurant --
CREATE OR REPLACE TABLE Ville(
   idVille INT AUTO_INCREMENT,
   nomVille VARCHAR(50)  NOT NULL,
   codePostalVille VARCHAR(10)  NOT NULL,
   PRIMARY KEY(idVille)
);

CREATE OR REPLACE TABLE Adresse(
   idAdresse INT AUTO_INCREMENT,
   numAdresse VARCHAR(50)  NOT NULL,
   rueAdresse VARCHAR(50)  NOT NULL,
   complementAdresse VARCHAR(50) ,
   coordoneesAdresse GEOMETRY NOT NULL,
   idVille INT NOT NULL,
   PRIMARY KEY(idAdresse),
   FOREIGN KEY(idVille) REFERENCES Ville(idVille)
);

CREATE OR REPLACE TABLE Restaurant(
   idRestaurant INT AUTO_INCREMENT,
   nomRestaurant VARCHAR(100)  NOT NULL,
   idAdresse INT NOT NULL,
   PRIMARY KEY(idRestaurant),
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse)
);

CREATE OR REPLACE TABLE Vehicule(
   idVehicule INT AUTO_INCREMENT,
   capaciteVehicule INT NOT NULL,
   estDispo BOOLEAN NOT NULL,
   estEnPanne BOOLEAN NOT NULL,
   immatriculationVehicule VARCHAR(9)  NOT NULL,
   idRestaurant INT NOT NULL,
   PRIMARY KEY(idVehicule),
   FOREIGN KEY(idRestaurant) REFERENCES Restaurant(idRestaurant)
);

CREATE OR REPLACE TABLE Role(
   idRole INT AUTO_INCREMENT,
   nomRole VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idRole)
);

CREATE OR REPLACE TABLE Employe(
   idEmploye INT AUTO_INCREMENT,
   nomEmploye VARCHAR(50)  NOT NULL,
   prenomEmploye VARCHAR(50)  NOT NULL,
   mdpEmploye VARCHAR(64)  NOT NULL, -- Hashé en SHA-256
   urlPhotoProfilEmploye TEXT,
   idRestaurant INT NOT NULL,
   PRIMARY KEY(idEmploye),
   FOREIGN KEY(idRestaurant) REFERENCES Restaurant(idRestaurant)
);

CREATE OR REPLACE TABLE RoleEmploye(
   idEmploye INT,
   idRole INT,
   PRIMARY KEY(idEmploye, idRole),
   FOREIGN KEY(idEmploye) REFERENCES Employe(idEmploye),
   FOREIGN KEY(idRole) REFERENCES Role(idRole)
);

CREATE OR REPLACE TABLE Livreur(
   idLivreur INT AUTO_INCREMENT,
   estDispo BOOLEAN NOT NULL,
   idEmploye INT NOT NULL,
   PRIMARY KEY(idLivreur),
   UNIQUE(idEmploye),
   FOREIGN KEY(idEmploye) REFERENCES Employe(idEmploye)
);


-- Tables liées à la gestion des produits à la carte --
CREATE OR REPLACE TABLE Menu(
   idMenu INT AUTO_INCREMENT,
   nomMenu VARCHAR(50) NOT NULL,
   descriptionMenu VARCHAR(50),
   prixMenu DECIMAL(15,2) NOT NULL,
   urlImageMenu TEXT,
   PRIMARY KEY(idMenu)
);

CREATE OR REPLACE TABLE TypeProduit(
   idTypeProduit INT AUTO_INCREMENT,
   nomTypeProduit VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idTypeProduit)
);

CREATE OR REPLACE TABLE TypeProduitPossibleMenu(
   idMenu INT,
   idTypeProduit INT,
   PRIMARY KEY(idMenu, idTypeProduit),
   FOREIGN KEY(idMenu) REFERENCES Menu(idMenu),
   FOREIGN KEY(idTypeProduit) REFERENCES TypeProduit(idTypeProduit)
);

CREATE OR REPLACE TABLE FicheProduit(
   idFicheProduit INT,
   nomProduit VARCHAR(50)  NOT NULL,
   prixProduit DECIMAL(15,2)   NOT NULL,
   urlImageProduit TEXT,
   PRIMARY KEY(idFicheProduit)
);

CREATE OR REPLACE TABLE TypeProduitFicheProduit(
   idTypeProduit INT,
   idFicheProduit INT,
   PRIMARY KEY(idTypeProduit, idFicheProduit),
   FOREIGN KEY(idTypeProduit) REFERENCES TypeProduit(idTypeProduit),
   FOREIGN KEY(idFicheProduit) REFERENCES FicheProduit(idFicheProduit)
);

CREATE OR REPLACE TABLE Stock(
   idStock INT AUTO_INCREMENT,
   uniteStock VARCHAR(15),
   valeurStock INT NOT NULL,
   seuilAlerteStock INT,
   PRIMARY KEY(idStock)
);

CREATE OR REPLACE TABLE Allergene(
   idAllergene INT AUTO_INCREMENT,
   nomAllergene VARCHAR(50)  NOT NULL,
   urlIconneAllergene TEXT,
   PRIMARY KEY(idAllergene)
);

CREATE OR REPLACE TABLE ProduitIndustriel(
   idProduitIndustriel INT,
   volumeProduit INT NOT NULL,
   CodeBarreProduitIndustriel CHAR(13),
   idStock INT NOT NULL,
   idFicheProduit INT NOT NULL,
   PRIMARY KEY(idProduitIndustriel),
   UNIQUE(idFicheProduit),
   FOREIGN KEY(idStock) REFERENCES Stock(idStock),
   FOREIGN KEY(idFicheProduit) REFERENCES FicheProduit(idFicheProduit)
);

CREATE OR REPLACE TABLE ProduitIndustrielAllergene(
   idAllergene INT,
   idProduitIndustriel INT,
   PRIMARY KEY(idAllergene, idProduitIndustriel),
   FOREIGN KEY(idAllergene) REFERENCES Allergene(idAllergene),
   FOREIGN KEY(idProduitIndustriel) REFERENCES ProduitIndustriel(idProduitIndustriel)
);

CREATE OR REPLACE TABLE Ingredient(
   idIngredient INT AUTO_INCREMENT,
   nomIngredient VARCHAR(50)  NOT NULL,
   prixVenteIngredient VARCHAR(50) ,
   estHalal BOOLEAN NOT NULL,
   estVegan BOOLEAN NOT NULL,
   urlImageIngredient TEXT,
   idStock INT NOT NULL,
   PRIMARY KEY(idIngredient),
   FOREIGN KEY(idStock) REFERENCES Stock(idStock)
);

CREATE OR REPLACE TABLE IngredientAllergene(
   idAllergene INT,
   idIngredient INT,
   PRIMARY KEY(idAllergene, idIngredient),
   FOREIGN KEY(idAllergene) REFERENCES Allergene(idAllergene),
   FOREIGN KEY(idIngredient) REFERENCES Ingredient(idIngredient)
);

CREATE OR REPLACE TABLE PatePizza(
   idPate INT AUTO_INCREMENT,
   nomPate VARCHAR(50) NOT NULL,
   prixSupplementPate DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(idPate)
);

CREATE OR REPLACE TABLE PateAllergene(
   idAllergene INT,
   idPate INT,
   PRIMARY KEY(idAllergene, idPate),
   FOREIGN KEY(idAllergene) REFERENCES Allergene(idAllergene),
   FOREIGN KEY(idPate) REFERENCES PatePizza(idPate)
);

CREATE OR REPLACE TABLE BaseSaucePizza(
   idSauce INT AUTO_INCREMENT,
   nomSauce VARCHAR(50) NOT NULL,
   prixSupplementBase DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(idSauce)
);

CREATE OR REPLACE TABLE SauceAllergene(
   idAllergene INT,
   idSauce INT,
   PRIMARY KEY(idAllergene, idSauce),
   FOREIGN KEY(idAllergene) REFERENCES Allergene(idAllergene),
   FOREIGN KEY(idSauce) REFERENCES BaseSaucePizza(idSauce)
);

CREATE OR REPLACE TABLE TaillePizza(
   idTaille INT AUTO_INCREMENT,
   nomTaille VARCHAR(50) NOT NULL,
   volumePizza INT NOT NULL,
   capaciteIngredient VARCHAR(50) NOT NULL,
   prixSupplementTaille DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(idTaille)
);

CREATE OR REPLACE TABLE RecettePizza(
   idRecettePizza INT,
   texteRecettePizza TEXT,
   idFicheProduit INT NOT NULL,
   PRIMARY KEY(idRecettePizza),
   UNIQUE(idFicheProduit),
   FOREIGN KEY(idFicheProduit) REFERENCES FicheProduit(idFicheProduit)
);


CREATE OR REPLACE TABLE IngredientRecette(
   idIngredient INT,
   idRecettePizza INT,
   quantite INT NOT NULL,
   estModifiable VARCHAR(50) ,
   PRIMARY KEY(idIngredient, idRecettePizza),
   FOREIGN KEY(idIngredient) REFERENCES Ingredient(idIngredient),
   FOREIGN KEY(idRecettePizza) REFERENCES RecettePizza(idRecettePizza)
);


-- Tables liées à la gestion des comptes clients --
CREATE OR REPLACE TABLE CompteClient(
   idClient UUID,
   prenomClient VARCHAR(50) NOT NULL,
   nomClient VARCHAR(50) NOT NULL,
   emailClient VARCHAR(50) NOT NULL UNIQUE,
   telClient VARCHAR(50) NOT NULL UNIQUE,
   mdpClient VARCHAR(64) NOT NULL,
   urlPhotoProfilClient TEXT,
   ptsFideliteClient VARCHAR(50),
   PRIMARY KEY(idClient)
);

CREATE OR REPLACE TABLE AdresseCompteClient(
   idClient UUID,
   idAdresse INT,
   PRIMARY KEY(idClient, idAdresse),
   FOREIGN KEY(idClient) REFERENCES CompteClient(idClient),
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse)
);


-- Tables liées à la gestion des promotions --
CREATE OR REPLACE TABLE TypeCodePromo(
   idTypeCodePromo VARCHAR(15), -- POURCENTAGE ou MONTANT
   PRIMARY KEY(idTypeCodePromo)
);

CREATE OR REPLACE TABLE CodePromo(
   idCodePromo VARCHAR(50),
   descCodePromo VARCHAR(500),
   dateCreationCodePromo DATETIME NOT NULL,
   dateExpirationCodePromo DATETIME,
   estExpiré BOOLEAN NOT NULL,
   nbUtilisationsCodePromo INT NOT NULL,
   nbUtilisationsMaxCodePromo INT NOT NULL,
   valeurCodePromo INT NOT NULL,
   idTypeCodePromo VARCHAR(15) NOT NULL,
   PRIMARY KEY(idCodePromo),
   FOREIGN KEY(idTypeCodePromo) REFERENCES TypeCodePromo(idTypeCodePromo)
);


CREATE OR REPLACE TABLE CodePromoCompteClient(
   idClient UUID,
   idCodePromo VARCHAR(50) ,
   PRIMARY KEY(idClient, idCodePromo),
   FOREIGN KEY(idClient) REFERENCES CompteClient(idClient),
   FOREIGN KEY(idCodePromo) REFERENCES CodePromo(idCodePromo)
);


-- Tables liées à la gestion des commandes --
CREATE OR REPLACE TABLE Livraison(
   idLivraison INT AUTO_INCREMENT,
   dateHeureDebutLivraision DATETIME NOT NULL,
   dateHeureFinLivraison DATETIME,
   idVehicule INT NOT NULL,
   idLivreur INT NOT NULL,
   PRIMARY KEY(idLivraison),
   FOREIGN KEY(idVehicule) REFERENCES Vehicule(idVehicule),
   FOREIGN KEY(idLivreur) REFERENCES Livreur(idLivreur)
);

CREATE OR REPLACE TABLE Commande(
   idCommande INT AUTO_INCREMENT,
   dateHeureCommande DATETIME NOT NULL,
   dateHeureLivraison DATETIME,
   estEnLivraison BOOLEAN NOT NULL,
   estPrete BOOLEAN NOT NULL,
   montantFactureCommande DECIMAL(15,2)   NOT NULL,
   idCodePromo VARCHAR(50) ,
   idAdresse INT,
   idLivraison INT,
   idClient UUID,
   PRIMARY KEY(idCommande),
   FOREIGN KEY(idCodePromo) REFERENCES CodePromo(idCodePromo),
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse),
   FOREIGN KEY(idLivraison) REFERENCES Livraison(idLivraison),
   FOREIGN KEY(idClient) REFERENCES CompteClient(idClient)
);

CREATE OR REPLACE TABLE ProduitAchete(
   idProduitAchete INT AUTO_INCREMENT,
   idFicheProduit INT NOT NULL,
   PRIMARY KEY(idProduitAchete),
   FOREIGN KEY(idFicheProduit) REFERENCES FicheProduit(idFicheProduit)
);

CREATE OR REPLACE TABLE ProduitCommande(
   idCommande INT,
   idProduitAchete INT UNIQUE,
   quantite INT NOT NULL,
   instruction TEXT,
   PRIMARY KEY(idCommande, idProduitAchete),
   FOREIGN KEY(idCommande) REFERENCES Commande(idCommande),
   FOREIGN KEY(idProduitAchete) REFERENCES ProduitAchete(idProduitAchete)
);

CREATE OR REPLACE TABLE ProduitMenu(
   idCommande INT,
   idProduitAchete INT,
   idMenu INT,
   quantite INT NOT NULL,
   instruction TEXT,
   PRIMARY KEY(idCommande, idProduitAchete, idMenu),
   FOREIGN KEY(idCommande) REFERENCES Commande(idCommande),
   FOREIGN KEY(idProduitAchete) REFERENCES ProduitAchete(idProduitAchete),
   FOREIGN KEY(idMenu) REFERENCES Menu(idMenu)
);

CREATE OR REPLACE TABLE EmployePrepareCommande(
   idCommande INT,
   idEmploye INT,
   PRIMARY KEY(idCommande, idEmploye),
   FOREIGN KEY(idCommande) REFERENCES Commande(idCommande),
   FOREIGN KEY(idEmploye) REFERENCES Employe(idEmploye)
);

CREATE OR REPLACE TABLE VariantePizza(
   idVariantePizza INT AUTO_INCREMENT,
   idPate INT NOT NULL,
   idSauce INT NOT NULL,
   idTaille INT NOT NULL,
   idRecettePizza INT NOT NULL,
   idProduitAchete INT NOT NULL,
   PRIMARY KEY(idVariantePizza),
   UNIQUE(idProduitAchete),
   FOREIGN KEY(idPate) REFERENCES PatePizza(idPate),
   FOREIGN KEY(idSauce) REFERENCES BaseSaucePizza(idSauce),
   FOREIGN KEY(idTaille) REFERENCES TaillePizza(idTaille),
   FOREIGN KEY(idRecettePizza) REFERENCES RecettePizza(idRecettePizza),
   FOREIGN KEY(idProduitAchete) REFERENCES ProduitAchete(idProduitAchete)
);

CREATE OR REPLACE TABLE IngredientAjoutePizza(
   idVariantePizza INT,
   idIngredient INT,
   quantite INT NOT NULL,
   PRIMARY KEY(idVariantePizza, idIngredient),
   FOREIGN KEY(idVariantePizza) REFERENCES VariantePizza(idVariantePizza),
   FOREIGN KEY(idIngredient) REFERENCES Ingredient(idIngredient)
);

CREATE OR REPLACE TABLE IngredientRetirePizza(
   idVariantePizza INT,
   idIngredient INT,
   quantite INT NOT NULL,
   PRIMARY KEY(idVariantePizza, idIngredient),
   FOREIGN KEY(idVariantePizza) REFERENCES VariantePizza(idVariantePizza),
   FOREIGN KEY(idIngredient) REFERENCES Ingredient(idIngredient)
);


-- Table pour les alertes de stock
-- Indépendante du reste de la base de données
CREATE OR REPLACE TABLE Alerte(
   idAlerte INT AUTO_INCREMENT,
   dateAlerte DATETIME NOT NULL,
   estEnvoyee BOOLEAN NOT NULL,
   idIngredient INT NOT NULL,
   PRIMARY KEY(idAlerte)
);
