<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use PanierConnecte;

class ProduitPanierRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Contenir";
    }

    protected function getClePrimaire(): string
    {
        return "idPanier";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        if (array_key_exists("idPanier",$objetFormatTableau)) {
            $panier = new \ProduitPanier($objetFormatTableau["idPanier"],$objetFormatTableau["idProduit"],$objetFormatTableau["quantite"]);
        }
        else {
            $panier = new PanierConnecte($objetFormatTableau["idProduit"],$objetFormatTableau["quantite"]);
        }
        return $panier;
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idPanier",
            "idProduit",
            "quantite"
        ];
    }
}