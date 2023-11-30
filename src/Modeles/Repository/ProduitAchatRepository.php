<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\ProduitAchat;

class ProduitAchatRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Concerner";
    }

    protected function getClePrimaire(): array
    {
        return ["idProduit", "idAchat"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new ProduitAchat($objetFormatTableau["idProduit"], $objetFormatTableau["idAchat"], $objetFormatTableau["nomProduit"],$objetFormatTableau["quantite"], $objetFormatTableau["prixProduitUnitaire"]);
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idProduit",
            "idAchat",
            "nomProduit",
            "quantite",
            "prixProduitUnitaire"
        ];
    }
}