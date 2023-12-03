<main class="d-flex justify-content-center align-items-center">
    <div class="card p-4" style="width: 25rem; height: fit-content">
        <div class="card-header">Détail de la commande</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-6">
                        <span>Date</span><br>
                        <span>10 October 2018</span>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-end">
                        <span>Commande N°</span><br>
                        <span>012j1gvs356c</span>
                    </div>
                </div>
            </li>
            <?php
            /** @var array $produits */
            foreach ($produits as $produit) :?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-7">
                        <span>
                            <?php echo htmlspecialchars($produit->getNomProduit());?>
                        </span>
                    </div>
                    <div class="col-2">
                        <?php echo htmlspecialchars($produit->getQuantite()).' x '.htmlspecialchars($produit->getPrixProduitUnitaire()).' €'; ?>
                    </div>
                    <div class="col-3">
                        <span>
                            <?php echo htmlspecialchars($produit->getPrixProduitUnitaire()*$produit->getQuantite()).'€';?>
                        </span>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-9">
                        <span><strong>Total</strong></span>
                    </div>
                    <span class="col-3">
                        <strong>
                            <?php
                            $prixTotalHistorique = 0;
                            foreach ($produits as $produit) {
                                $prixTotalHistorique += $produit->getPrixProduitUnitaire()*$produit->getQuantite();
                            }
                            echo '<p>'.htmlspecialchars($prixTotalHistorique).' €</p>';
                            ?>
                        </strong>
                    </span>
                </div>
            </li>
        </ul>

    </div>
</main>
