# Triomino's Pizza - Site web

## Description
Projet de site web pour la SAÉ 301 : Développement d'une application à l'IUT d'Orsay (Université Paris-Saclay) en 2e année de BUT Informatique (Parcours A).

$\to$ [https://triominos-pizza.github.io/website/](https://triominos-pizza.github.io/website/)

![image](https://github.com/Triominos-Pizza/website/assets/54336210/bc2d5a5c-c792-4807-848c-241bc4e7d131)

---

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
