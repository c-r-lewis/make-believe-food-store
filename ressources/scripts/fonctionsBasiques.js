function mettreAJourPrixTotal(prixItem, quantite) {
    const total = prixItem * quantite;
    document.getElementById("prixTotal").textContent = total + "€";
}