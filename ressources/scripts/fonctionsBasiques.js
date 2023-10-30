document.addEventListener('DOMContentLoaded', (event) => {
    mettreAJourPrixTotal(document.getElementById("quantite"));
});

function mettreAJourPrixTotal(input) {
    const prixItem = parseFloat(input.dataset.price);
    const quantite = input.value;
    const total = prixItem * quantite;
    document.getElementById("prixTotal").textContent = total + "€";
}