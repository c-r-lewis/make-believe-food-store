<div class="grille-panier">
    <img src="" alt="Produit">
    <p>Nom produit</p>
    <label>Quantité</label>
    <!-- Il faudra récupérer le prix unitaire stocké dans la base de données -->
    <input type="number" min="1" id="quantite" oninput="mettreAJourPrixTotal(10, this.value)">
    <p>Prix : <span id="prixTotal"></span></p>

    <button>Supprimer</button>
</div>
