<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\Achat;

class AchatRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Achats";
    }

    protected function getClePrimaire(): array
    {
        return ["idAchat"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Achat($objetFormatTableau["idAchat"], $objetFormatTableau["dateAchat"], $objetFormatTableau["email"]);
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idAchat",
            "dateAchat",
            "email"
        ];
    }
}
