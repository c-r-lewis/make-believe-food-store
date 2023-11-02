<section>
<?php
use App\Magasin\Modeles\DataObject\Produit as Produit;
/** @var Produit $produit */

echo '<p>Nom produit : '. $produit->getNomProduit() .'</p>
<p>Description produit : '. $produit->getDescriptionProduit() .'</p>
<p>Prix produit : '. $produit->getPrixProduit() .'</p>
<a href="">Ajouter au panier</a>';
?>
    <form>
        <input type="number" value="1">
    </form>
</section>