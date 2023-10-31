<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\Produit;

class ProduitRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Produits";
    }

    protected function getClePrimaire(): string
    {
        return "idProduit";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        $produit = new Produit($objetFormatTableau["idProduit"], $objetFormatTableau["nomProduit"], $objetFormatTableau["descriptionProduit"], $objetFormatTableau["prixProduit"]);
        return $produit;
    }
}