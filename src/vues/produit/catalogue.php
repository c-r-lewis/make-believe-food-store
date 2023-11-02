<section class="grille-produits">
    <?php
    /** @var array $produits*/

    foreach($produits as $produit) {
        echo '<div class="article">
            <img src="" alt="Produit">
            <p>'.$produit->getNomProduit().'</p>
            <button>Voir produit</button>
        </div>';
    }
    ?>
</section>