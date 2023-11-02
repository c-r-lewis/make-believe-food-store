<?php
use App\Magasin\Modeles\DataObject\Produit as Produit;
/** @var Produit $produit */

echo '<section>
<p>Nom produit : '. $produit->getNomProduit() .'</p>
<p>Description produit : '. $produit->getDescriptionProduit() .'</p>
<p>Prix produit : '. $produit->getPrixProduit() .'</p>
</section>';