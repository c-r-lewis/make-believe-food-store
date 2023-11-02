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
                    <form action="../web/controleurFrontal.php">
                        <input type="number" name="quantite" min="1" value="'.$item["quantite"].'" class="quantite" data-price="'.$item["produit"]->getPrixProduit().'" oninput="mettreAJourPrixTotal(this)" onchange="this.form.submit()">
                        <input type="hidden" name="action" value="modifierQuantitePanier">
                        <input type="hidden" name="idProduit" value="'.$item["produit"]->getIdProduit().'">
                    </form>
                    <p><span class="prixTotal"></span></p>

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