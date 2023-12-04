<?php

use App\Magasin\Modeles\DataObject\Produit as Produit;
use App\Magasin\Modeles\Repository\ProduitRepository;

/** @var Produit $produit */
?>
<main class="d-flex align-items-start p-3 justify-content-end">
    <div class="container-fluid">
        <div class="row product-tab">
            <div class="col-lg-5 col-md-12 main-image d-flex justify-content-md-center">
                <?php
                $cheminImage = (new ProduitRepository())->getImageProduit($produit);
                ?>
                <img src="<?=$cheminImage?>" class="img-fluid" alt="Image produit"/>
            </div>
            <div class="col-lg-7 col-md-12 d-flex flex-column justify-content-md-center justify-content-lg-start">
                <span class="mb-lg-5 fs-1 d-flex justify-content-md-center justify-content-lg-start"><?= htmlspecialchars($produit->getNomProduit()); ?></span>

                <div class="input-group mb-lg-3" style="width: 20rem">
                    <span class="input-group-text">€</span>
                    <span class="form-control"
                          aria-label="Dollar amount (with dot and two decimal places)"><?= htmlspecialchars($produit->getPrixProduit()); ?></span>
                </div>
                <div class="d-flex justify-content-md-between justify-content-lg-start flex-row">
                    <form action="../web/controleurFrontal.php" method="post">
                        <input name="quantite" min="1" type="number" value="1" id="quantite" class="m-3 ms-0"
                               style="width: 8rem">
                        <input type="submit" value="Ajouter au panier"
                               class="btn btn-lg btn-outline-secondary m-3 ms-0">
                        <input type="hidden" name="action" value="ajouterProduitAuPanier">
                        <input type="hidden" name="idProduit" value="<?= urlencode($produit->getIdProduit()); ?>">
                    </form>
                </div>

                <div class="card">
                    <h5 class="card-header">Description</h5>
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($produit->getDescriptionProduit()); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
