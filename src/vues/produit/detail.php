<?php
use App\Magasin\Modeles\DataObject\Produit as Produit;
/** @var Produit $produit */
?>
<main class="d-flex align-items-start p-3 justify-content-end">
    <div class="container-fluid">
        <div class="row product-tab">
            <div class="col-lg-5 col-md-12 main-image d-flex justify-content-md-center">
                <img src="https://picsum.photos/700" class="img-fluid"/>
            </div>
            <div class="col-lg-7 col-md-12 d-flex flex-column justify-content-md-center justify-content-lg-start">
                <span class="mb-lg-5 fs-1 d-flex justify-content-md-center justify-content-lg-start"><?php echo htmlspecialchars($produit->getNomProduit()); ?></span>
                <form>
                    <div class="input-group mb-lg-3" style="width: 20rem">
                        <span class="input-group-text">€</span>
                        <span class="form-control" aria-label="Dollar amount (with dot and two decimal places)"><?php echo htmlspecialchars($produit->getPrixProduit()); ?></span>
                    </div>
                    <div class="d-flex justify-content-md-between justify-content-lg-start flex-row">
                        <form action="../web/controleurFrontal.php" method="GET">
                            <input name="quantite" min="1" type="number" value="1" id="quantite" class="m-3 ms-0" style="width: 8rem">
                            <input type="submit" value="Ajouter au panier" class="btn btn-lg btn-outline-secondary m-3 ms-0">
                            <input type="hidden" name="action" value="ajouterProduitAuPanier">
                            <input type="hidden" name="idProduit" value="<?php echo htmlspecialchars($produit->getIdProduit()); ?>">
                        </form>
                    </div>
                </form>
                <div class="card">
                    <h5 class="card-header">Description</h5>
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($produit->getDescriptionProduit()); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
