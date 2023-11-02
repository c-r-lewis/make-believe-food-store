<section class="grille-produits">
    <?php
    use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
    use App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;
    /** @var array $produits*/

    foreach($produits as $produit) {
        echo '<div class="article">
            <img src="" alt="Produit">
            <p>'.$produit->getNomProduit().'</p>';
        $action = "afficherDetailProduit";
        if (ConnexionUtilisateur::estConnecte()){
            if ((new UtilisateurRepository())->recupererParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())->estAdmin()) {
                $action = "afficherModificationProduit";
            }
        }
        echo '<a href="controleurFrontal.php?action='.$action.'&idProduit='.$produit->getIdProduit().'">Voir produit</a>
        </div>';
    }
    ?>
</section>