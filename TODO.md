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
- [x] Enlever les scripts JS du HTML et leq mettre dans des fichiers JS
- [ ] Mettre les appels à la BDD dans des modèles plutôt que dans les contrôleurs (pour la classe `CompteClient`)
- [ ] Footer
  - [ ] lien Github dans les liens sociaux
- [ ] Remplacer des ROOT_PATH par des ROOT_URL (partout ? ou juste dans les liens ?)
- [ ] Valider les champs des formulaires en back-end (au niveau de PHP et/ou de la BDD)
- [ ] Déplacer les CSS spécifiques à une page dans le head de la page (et non dans le fichier CSS global)
- [ ] Fixes
  - [ ] callback sur le serveur de prod
  - [ ] bouton retour sur une page produit
- [ ] Ajout/retrait d'ingrédients
  - [ ] Vérifier la capacité max de la pizza lorsque l'on ajoute des ingrédients
  - [ ] Afficher le prix des suppléments sur la page produit (et dans le panier ?)
  - [ ] Comptabiliser les ingrédients ajoutés dans le calcul du prix sur la page produit

## Optionnel (mais fortement conseillé)
- [ ] Rendre la saisie du numéro de téléphone plus simple
- [ ] Rendre la saisie de l'adresse plus simple (utiliser l'API du gouvernement : https://geo.api.gouv.fr/adresse)
- [ ] Mettre les couleurs (et autres ?) dans des variables CSS
- [ ] Version "Borne" (juste mettre un paramètre dans l'URL pour activer la version borne et cacher les éléments inutiles (header, footer, ...))

## Facultatif
- [ ] Faire une PWA
- [ ] Remplacer le backgroud de la page d'accueil par une vidéo
- [x] Mettre l'Easter Egg de Noé
- [ ] Faire en sorte que les images ne s'affichent qu'une fois qu'elles sont chargées
  - [ ] Faire un placeholder pour les images pendant le chargement
  - [ ] Faire un système de cache pour les images ?
- [ ] Faire une popup pour les cookies ? 😂
- [ ] Mettre des images par défaut pour tous les modèles qui utilisent des images (produits, menus, ...)
- [ ] Faire un truc de récupération de mdp et/ou de confirmation de compte
- [ ] Faire un formulaire pour récup ses données RGPD
- [ ] Rendre les allergènes dynamiques avec les suppléments (pâtes, sauces, ingrédients ajoutés, ...)