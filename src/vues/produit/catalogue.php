<main>
    <div class="container-fluid p-3 height-100">
        <div class="row">
            <?php
            use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
            use App\Magasin\Modeles\DataObject\Image;
            use App\Magasin\Modeles\DataObject\Produit;
            use App\Magasin\Modeles\Repository\ImageRepository;
            use App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

            /** @var array $produits */
            /** @var Image $image */
            /** @var Produit $produit */


            $action = "afficherDetailProduit";

            foreach ($produits as $produit) {
                $repo = new ImageRepository();
                $cheminImage = "../ressources/images/placeholder.png";
                if (count($repo->recupererParClePrimaire([$produit->getIdProduit()])) != 0) {
                    $image = $repo->recupererParClePrimaire([$produit->getIdProduit()])[0];
                    $cheminImage = $image->getImage();
                }
                echo '<div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <img src="' . $cheminImage . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title fs-6">'.htmlspecialchars($produit->getNomProduit()).'</h5>
                    <a href="controleurFrontal.php?action='.$action.'&idProduit='.$produit->getIdProduit().'" class="btn btn-outline-secondary">Voir produit</a>
                </div>
            </div>
        </div>';
            }
            ?>
        </div>
</main>