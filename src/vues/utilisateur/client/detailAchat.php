<section>
    <div class="detailAchat">
        <div class="items">
            <div class="block">
                <p>Historique</p>
                <div class="line"></div>
                <?php
                /** @var array $produits */
                foreach ($produits as $produit) {
                    echo '
                    <div class="achat">
                        <p>Produit: '.htmlspecialchars($produit->getIdProduit()).'</p>
                        <p>Quantité: '.htmlspecialchars($produit->getQuantite()).'</p>
                        <p>Prix unitaire: '.htmlspecialchars($produit->getPrixProduitUnitaire()).'</p>
                        <p>Prix total: '.htmlspecialchars($produit->getPrixProduitUnitaire()*$produit->getQuantite()).'</p>
                    </div>
                    <div class="line"></div>';
                }
                ?>
            </div>
        </div>
        <div class="sommaire">
            <div class="block">
                <p>Total</p>
                <?php
                $prixTotalHistorique = 0;
                foreach ($produits as $produit) {
                    $prixTotalHistorique += $produit->getPrixProduitUnitaire()*$produit->getQuantite();
                }
                echo '<p>'.htmlspecialchars($prixTotalHistorique).'</p>';
                ?>
            </div>
        </div>
    </div>
</section>
