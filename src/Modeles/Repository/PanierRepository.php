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
        if (array_key_exists("email",$objetFormatTableau)) {
            $panier = new PanierConnecte($objetFormatTableau["email"],$objetFormatTableau["idPanier"]);
        }
        else {
            $panier = new PanierConnecte($objetFormatTableau["email"]);
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