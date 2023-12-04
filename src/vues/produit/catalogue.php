<main>
    <div class="container-fluid p-3 height-100">
        <div class="row">
            <?php
            use App\Magasin\Modeles\DataObject\Image;
            use App\Magasin\Modeles\DataObject\Produit;
            use App\Magasin\Modeles\Repository\ImageRepository;
            use App\Magasin\Modeles\Repository\ProduitRepository;

            /** @var array $produits */
            /** @var Image $image */
            /** @var Produit $produit */

            $action = "afficherDetailProduit";

            foreach ($produits as $produit):
                $cheminImage = (new ProduitRepository())->getImageProduit($produit);
                ?>
            <div class="col-md-3 mb-3">
                <div class="card shadow text-center">
                    <div style="min-height:164.883px;" class="d-flex align-items-center rounded">
                        <img src="<?=urlencode($cheminImage)?>" class="card-img-top"  alt="..." >
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fs-6"><?=htmlspecialchars($produit->getNomProduit())?></h5>
                        <form>

                        </form>
                        <a href="controleurFrontal.php?action=<?php echo urlencode($action).'&idProduit='.urlencode($produit->getIdProduit());?>" class="btn btn-outline-secondary">
                            Voir produit
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</main>