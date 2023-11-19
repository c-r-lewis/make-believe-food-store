<section class="grille-produits">
    <?php
    use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
    use App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

    /** @var array $produits */

    foreach ($produits as $produit) {
        echo '<div class="article">
            <img src="" alt="Produit">
            <p>'.htmlspecialchars($produit->getNomProduit()).'</p>';

        $action = "afficherDetailProduit";
        if (ConnexionUtilisateur::estConnecte()) {
            $utilisateurRepository = new UtilisateurRepository();
            $utilisateur = $utilisateurRepository->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];

            if ($utilisateur->estAdmin()) {
                $action = "afficherModificationProduit";
            }
        }
        echo '<a href="controleurFrontal.php?action='.$action.'&idProduit='.$produit->getIdProduit().'">Voir produit</a>
        </div>';
    }
    ?>
</section>
