<main>
    <div class="container-fluid p-3 height-100">
        <div class="row">
            <?php
            use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
            use App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

            /** @var array $produits */

            $action = "afficherDetailProduit";
            if (ConnexionUtilisateur::estConnecte()) {
                $utilisateurRepository = new UtilisateurRepository();
                $utilisateur = $utilisateurRepository->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];

                if ($utilisateur->estAdmin()) {
                    $action = "afficherModificationProduit";
                }
            }

            foreach ($produits as $produit) {
                echo '<div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <img src="https://picsum.photos/200" class="card-img-top" alt="...">
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