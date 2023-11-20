<section>
    <div class="detailAchat">
        <div class="items">
            <div class="block">
                <p>Historique</p>
                <div class="line"></div>
                <?php
                /** @var array $historique */
                foreach ($historique as $achat) {
                    echo '
                    <div class="achat">
                        <p>Date: '.htmlspecialchars($achat["achat"]->getDate()).'</p>
                        <p>Produit: '.htmlspecialchars($achat["produit"]->getNomProduit()).'</p>
                        <p>Quantité: '.htmlspecialchars($achat["quantite"]).'</p>
                        <p>Prix unitaire: '.htmlspecialchars($achat["produit"]->getPrixProduit()).'</p>
                        <p>Prix total: '.htmlspecialchars($achat["prixTotal"]).'</p>
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
                foreach ($historique as $achat) {
                    $prixTotalHistorique += $achat["prixTotal"];
                }
                echo '<p>'.htmlspecialchars($prixTotalHistorique).'</p>';
                ?>
            </div>
        </div>
    </div>
</section>
