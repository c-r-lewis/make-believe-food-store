<section class="grille-produits">
    <?php
    /** @var array $produits*/

    foreach($produits as $produit) {
        echo '<div class="article">
            <img src="" alt="Produit">
            <p>'.$produit->getNomProduit().'</p>
            <a href="controleurFrontal.php?action=afficherDetailProduit">Voir produit</a>
        </div>';
    }
    ?>
</section>