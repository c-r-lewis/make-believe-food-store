<section>
        <div>
            <div class="block">
                <p>Historique</p>
                <div class="line"></div>
                <?php
                /** @var array $produits */
                foreach ($produits as $produit) {
                    echo '
                    <div class="achat">
                        <p>'.htmlspecialchars($produit->getNomProduit()).'</p>
                        <p>'.htmlspecialchars($produit->getQuantite()).' x '.htmlspecialchars($produit->getPrixProduitUnitaire()).' €</p>
                        <p>'.htmlspecialchars($produit->getPrixProduitUnitaire()*$produit->getQuantite()).' €</p>
                    </div>';
                }
                ?>
            </div>
        </div>
        <div class="prixTotal">
            <div class="total">
                <p>Prix total : </p>
                <?php
                $prixTotalHistorique = 0;
                foreach ($produits as $produit) {
                    $prixTotalHistorique += $produit->getPrixProduitUnitaire()*$produit->getQuantite();
                }
                echo '<p>'.htmlspecialchars($prixTotalHistorique).' €</p>';
                ?>
            </div>
        </div>
</section>
