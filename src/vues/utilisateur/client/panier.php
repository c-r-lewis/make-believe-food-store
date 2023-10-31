<section>

    <div class="panier">
        <div class="items">
            <div class="block">
                <p>Panier</p>

                <div class="line"></div>

                <div class="item">
                    <img src="" alt="Produit">
                    <p>Nom produit</p>
                    <!-- Il faudra récupérer le prix unitaire stocké dans la base de données -->
                    <input type="number" min="1" value="1" id="quantite" data-price="10" oninput="mettreAJourPrixTotal(this)">
                    <p><span id="prixTotal"></span></p>

                    <button class="panier-supprimer">
                        <img src="../../../../ressources/images/logo-fermer.png"/>
                    </button>
                </div>

                <div class="line"></div>
            </div>
        </div>
        <div class="sommaire">
            <div class="block">
                <p>Nombre d'items</p>
                <p>Expédition</p>
                <button>Valider</button>
            </div>
        </div>
    </div>

</section>

