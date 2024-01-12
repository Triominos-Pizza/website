
window.addEventListener('load', () => {
    // Désactier tous les inputs de la page si le panier est vide
    let nbProduitsDansPanier = document.querySelector('#nbProduitsDansPanier');
    if (nbProduitsDansPanier.value == 0) {
        document.querySelectorAll('input').forEach(input => {
            input.disabled = true;
            input.title = 'Le panier est vide';
        });
    };
});

window.addEventListener('load', () => {
    // Désactiver les inputs de la page si la livraison n'est pas cochée
    const estEnLivraison = document.querySelector('#estEnLivraison');
    const formAdresse = document.querySelector('.paiement-form-adresse');
    estEnLivraison.addEventListener('change', () => {
        formAdresse.hidden = !estEnLivraison.checked;
    });
    estEnLivraison.dispatchEvent(new Event('change'));
});