<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\PanierConnecte;

class PanierRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Paniers";
    }

    protected function getClePrimaire(): array
    {
        return ["email"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new PanierConnecte(
            $objetFormatTableau["idPanier"],
            $objetFormatTableau["email"]
        );
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idPanier",
            "email"
        ];
    }
}
