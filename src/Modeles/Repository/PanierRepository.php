<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use PanierConnecte;

class PanierRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Paniers";
    }

    protected function getClePrimaire(): string
    {
        return "email";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        if (array_key_exists("idPanier",$objetFormatTableau)) {
            $panier = new PanierConnecte($objetFormatTableau["email"],$objetFormatTableau["idPanier"]);
        }
        else {
            $panier = new PanierConnecte($objetFormatTableau["idPanier"]);
        }
        return $panier;
    }

    protected function getNomsColonnes(): array
    {
        return [
            "email",
            "idPanier"
        ];
    }
}