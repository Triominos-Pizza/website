# TODO

## Dev
- [ ] Faire un Github Actions pour déployer automatiquement sur le serveur FTP

## À faire avant de rendre le projet
- [ ] Update le README.md avec les fonctionnalités
- [ ] Retirer les prints de debug (rechercher les "echo '<pre>';", "var_dump()", "print_r()", ...)
- [ ] Tester que le sénario de test fonctionne

## Obligatoire
- [x] Enlever les scripts JS du HTML et leq mettre dans des fichiers JS
- [ ] Interface Gestionnaire
  - [ ] Afficher des statistiques (CA mensuel/annuel, ...)
  - [ ] Vérifier les stocks
- [x] Commande
  - [x] Ajouter des items au panier
    - [x] Produit seul
    - [ ] Menu
  - [x] Choisir le type de livraison
    - [x] Livraison
    - [ ] A emporter
    - [ ] Sur place
  - [x] Rentrer les informations de livraison
  - [x] Paiement (simultation)
    - [x] Vérification que la carte bancaire est valide (Visa/Mastercard)
  - [ ] Vérification des stocks d'ingrédients et de produits
  - [x] Enregistement de la commande dans la bdd
  - [ ] Retirer les stocks d'ingrédients et de produits de la bdd
  - [x] Page de confirmation
- [ ] Enlever le CSS du HTML et le mettre dans un fichier CSS
- [ ] Mettre les appels à la BDD dans des modèles plutôt que dans les contrôleurs (pour la classe `CompteClient`)
- [ ] Footer
  - [ ] lien Github dans les liens sociaux
- [ ] Refaire les include/require
- [ ] Remplacer des ROOT_PATH par des ROOT_URL (partout ? ou juste dans les liens ?)
  - [ ] Dans les include/require mettre des FTP_ROOT_PATH
- [ ] Valider les champs des formulaires en back-end (au niveau de PHP et/ou de la BDD)
- [ ] Déplacer les CSS spécifiques à une page dans le head de la page (et non dans le fichier CSS global)
- [ ] Fixes
  - [x] callback sur le serveur de prod
  - [x] bouton retour sur une page produit
- [x] Ajout/retrait d'ingrédients
  - [ ] Vérifier la capacité max de la pizza lorsque l'on ajoute des ingrédients
  - [ ] Afficher le prix des suppléments sur la page produit (et dans le panier ?)
  - [ ] Comptabiliser les ingrédients ajoutés dans le calcul du prix sur la page produit
  - [ ] Permettre de retirer/ajouter 1 item depuis le panier

## Optionnel (mais fortement conseillé)
- [ ] Rendre la saisie du numéro de téléphone plus simple
- [x] Rendre la saisie de l'adresse plus simple (utiliser l'API du gouvernement : https://geo.api.gouv.fr/adresse)
- [ ] Mettre les couleurs (et autres ?) dans des variables CSS
- [ ] Version "Borne" (juste mettre un paramètre dans l'URL pour activer la version borne et cacher les éléments inutiles (header, footer, ...))
- [ ] Ajouter la gestion des menus
- [ ] Page d'historique de commandes

## Facultatif
- [x] Mettre l'Easter Egg de Noé
- [ ] Faire une PWA
- [ ] Remplacer le backgroud de la page d'accueil par une vidéo/un gif
- [ ] Faire en sorte que les images ne s'affichent qu'une fois qu'elles sont chargées
  - [ ] Faire un placeholder pour les images pendant le chargement
  - [ ] Fixer les tailles des images dans le css pour éviter que les divs ne soient trop petits avant le chargement des images
  - [ ] Faire un système de cache pour les images ?
- [ ] Faire une popup pour les cookies ? 😂
- [ ] Mettre des images par défaut pour tous les modèles qui utilisent des images (produits, menus, ...)
- [ ] Faire un truc de récupération de mdp et/ou de confirmation de compte
- [ ] Faire un formulaire pour récup ses données RGPD
- [ ] Rendre les allergènes dynamiques avec les suppléments (pâtes, sauces, ingrédients ajoutés, ...)
- [ ] Sur mobile, afficher un bouton flottant pour scoller jusqu'au panier/remonter en haut
- [x] Ajouter des logos Visa/Mastercard/... sur la page de paiement et/ou dans le footer
- [ ] Faire en sorte que le formulaire de paiement soit considéré "sécurisé" par les navigateurs (pour avoir l'autocomplétion de CB)
- [ ] Sur mobile, mettre un bouton pour scroller jusqu'au panier (et/ou pour remonter en haut)
- [ ] Mettre un bouton sur la liste des produits pour ajouter au panier rapidement (sans passer par la page produit)