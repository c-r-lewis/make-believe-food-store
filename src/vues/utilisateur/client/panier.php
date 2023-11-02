<section>
    <div class="panier">
        <div class="items">
            <div class="block">
                <p>Panier</p>

                <div class="line"></div>
                <?php
                /** @var array $produits */
                foreach ($produits as $item) {
                    echo '
                <div class="item">
                    <img src="" alt="Produit">
                    <p>'.$item["produit"]->getNomProduit().'</p>
                    <!-- Il faudra récupérer le prix unitaire stocké dans la base de données -->
                    <input type="number" min="1" value="'.$item["quantite"].'" id="quantite" data-price="10" oninput="mettreAJourPrixTotal(this)">
                    <p><span id="prixTotal"></span></p>

                    <a class="panier-supprimer" href="controleurFrontal.php?action=supprimerProduitDuPanier&idProduit='.$item["produit"]->getIdProduit().'">
                        <img src="../../../../ressources/images/logo-fermer.png" alt="supprimer"/>
                    </a>
                </div>
                <div class="line"></div>
';
                }
                ?>
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