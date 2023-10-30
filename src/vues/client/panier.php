<section>
    <div class="line"></div>
    <div class="panier">
        <div class="items">
            <img src="" alt="Produit">
            <p>Nom produit</p>
            <!-- Il faudra récupérer le prix unitaire stocké dans la base de données -->
            <input type="number" min="1" value="1" id="quantite" data-price="10" oninput="mettreAJourPrixTotal(this)">
            <p><span id="prixTotal"></span></p>

            <button class="panier-supprimer">
                <img src="../../../ressources/images/logo-fermer.png"/>
            </button>
        </div>
    </div>
</section>

