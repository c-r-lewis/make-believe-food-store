<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\ProduitPanier;

class ProduitPanierRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Contenir";
    }

    protected function getClePrimaire(): array
    {
        return ["idPanier","idProduit"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new ProduitPanier($objetFormatTableau["idPanier"],$objetFormatTableau["idProduit"],$objetFormatTableau["quantite"]);
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