
<?php
use App\Magasin\Modeles\DataObject\Produit as Produit;
/** @var Produit $produit */

echo '<section>
<p>Nom produit : '. $produit->getNomProduit() .'</p>
<p>Description produit : '. $produit->getDescriptionProduit() .'</p>
<p>Prix produit : '. $produit->getPrixProduit() .'</p>
<form action="../web/controleurFrontal.php">
        <input name="quantite" type="number" value="1">
        <input type="submit" value="Ajouter au panier">
        <input type="hidden" name="action" value="ajouterProduitAuPanier">
        <input type="hidden" name="idProduit" value="'.$produit->getIdProduit().'">
    </form>
</section>';
