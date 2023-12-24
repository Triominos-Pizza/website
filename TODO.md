# TODO

## Dev
- [ ] Faire un Github Actions pour déployer automatiquement sur le serveur FTP

## Obligatoire
- [ ] Commande
  - [ ] Ajouter des items au panier
    - [ ] Produit seul
    - [ ] Menu
  - [ ] Choisir le type de livraison
    - [ ] Livraison
    - [ ] A emporter
    - [ ] Sur place
  - [ ] Rentrer les informations de livraison
  - [ ] Paiement
  - [ ] Page de confirmation
- [ ] Refaire les include/require
- [ ] Enlever le CSS du HTML et le mettre dans un fichier CSS
- [ ] Version "Borne" (juste mettre un paramètre dans l'URL pour activer la version borne et cacher les éléments inutiles (header, footer, ...))
- [ ] Mettre les appels à la BDD dans des modèles plutôt que dans les contrôleurs (pour la classe `CompteClient`)
- [ ] Mettre le lien Github dans le footer
- [ ] Remplacer des ROOT_PATH par des ROOT_URL (partout ? ou juste dans les liens ?)
- [ ] Valider les champs des formulaires en back-end (au niveau de PHP et/ou de la BDD)

## Optionnel (mais fortement conseillé)
- [ ] Rendre la saisie du numéro de téléphone plus simple
- [ ] Rendre la saisie de l'adresse plus simple (utiliser l'API du gouvernement : https://geo.api.gouv.fr/adresse)

## Facultatif
- [ ] Faire une PWA
- [ ] Remplacer le backgroud de la page d'accueil par une vidéo
- [ ] Mettre l'Easter Egg de Noé
- [ ] Faire en sorte que les images ne s'affichent qu'une fois qu'elles sont chargées
  - [ ] Faire un placeholder pour les images pendant le chargement
  - [ ] Faire un système de cache pour les images ?