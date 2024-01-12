# Triomino's Pizza - Site web

## Description
Projet de site web pour la SAÉ 301 : Développement d'une application à l'IUT d'Orsay (Université Paris-Saclay) en 2e année de BUT Informatique (Parcours A).

$\to$ [https://triominos-pizza.github.io/website/](https://triominos-pizza.github.io/website/)

![image](https://github.com/Triominos-Pizza/website/assets/54336210/bc2d5a5c-c792-4807-848c-241bc4e7d131)

## Fonctionnalités
### **Page d'accueil**
### **Compte client**
  - [x] Création de compte
  - [x] Connexion/Déconnexion
  - [x] Modification des informations personnelles
    - [x] Modification du mot de passe
    - [ ] Modification de la photo de profil *(pas possible avec le serveur fourni par l'IUT)*
  - [x] Mot de passe hashé dans la base de données *(sha256)*
  - [x] Suppression du compte
  - [ ] Gestion de mot de passe oublié *(envoi d'un mail de réinitialisation)*
  - [ ] Historique des commandes
### **Compte gestionnaire**
  - [ ] Connexion/Déconnexion avec un compte gestionnaire
  - [x] Statistiques (CA mensuel/annuel, ...)
  - [ ] Gestion des stocks
  - [ ] Ajout de produits/pizzas
  - [ ] Modification de produits/pizzas existants
  - [ ] Ajout de menus
  - [ ] Modification de menus existants
### **Commande**
  - [x] Ajout d'items au panier
    - [x] Produit seul
    - [ ] Menu
  - [x] Affichage des allergènes sur la page produit
  - [x] Personnalisation des pizzas
    - [x] Choix des options *(taille, pâte, sauce, ...)*
    - [x] Ajout/retrait d'ingrédients
  - [x] Choisir le type de livraison (livraison ou à emporter/sur place)
  - [x] Rentrer les informations de livraison
    - [x] Autocomplétion de l'adresse *([API du gouvernement](https://geo.api.gouv.fr/adresse))*
  - [x] Paiement (simultation)
    - [x] Vérification que le numéro de carte bancaire est valide *(carte Visa/Mastercard + algorithme de Luhn (mod 10) + date d'expiration)*
  - [x] Enregistement de la commande dans la bdd
    - [ ] Vérification des stocks d'ingrédients et de produits
    - [ ] Retirer les stocks d'ingrédients et de produits de la bdd
### **Autres**
- [x] Page d'erreur 404
- [x] Page de maintenance *(redirecton si le site est en maintenance ou si la base de données est inaccessible)*
- [x] Style responsive sur toutes les pages
- [ ] Version "Borne"
- [ ] Progressive Web App (PWA)
- [x] Easter Egg

## Installation
### Prérequis
- PHP (testé sur PHP 8.2.7)
- Base de données MariaDB ou MySQL (testé sur MariaDB 10.11.4)
- Serveur web avec accès FTP (testé sur Apache 2.4.57)

### Base de données
1. Télécharger les scripts SQL [ici](https://github.com/Triominos-Pizza/db).
2. Importer le fichier `sql/1_create-tables.sql` dans votre base de données.
3. Des données de test sont disponibles dans le fichier `sql/2_inserts-examples.sql`.

### Configuration
Copier le fichier `config/config.php.template` en `config/config.php` et modifier les valeurs des constantes pour correspondre à votre configuration (identifiants de la base de données, URL du site, etc.).

## Auteurs
- [Alexandre MALFREYT](https://github.com/AlexZeGamer)
- [Amaury TEYSSEDRE](https://github.com/AmauryMamo)
- [Demba TRAORE](https://github.com/demba77)
