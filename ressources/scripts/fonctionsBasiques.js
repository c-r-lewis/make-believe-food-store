document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll(".quantite").forEach(input => {
        mettreAJourPrixTotal(input);
    });
});

function mettreAJourPrixTotal(input) {
    const prixItem = parseFloat(input.dataset.price);
    const quantite = input.value;
    const total = prixItem * quantite;

    // Find the closest .item container and then get the .prixTotal within it
    input.closest('.item').querySelector('.prixTotal').textContent = total + "€";
}
