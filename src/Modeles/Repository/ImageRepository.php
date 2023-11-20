<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\AbstractDataObject;
use App\Magasin\Modeles\DataObject\Image;

class ImageRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Site_Images";
    }

    protected function getClePrimaire(): array
    {
        return ["idProduit"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        if (array_key_exists("idProduit", $objetFormatTableau) && array_key_exists("image", $objetFormatTableau)) {
            $image = new Image($objetFormatTableau["idProduit"], $objetFormatTableau["image"]);
        } else {
            $image = new Image($objetFormatTableau["image"]);
        }

        return $image;
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idProduit",
            "image",
        ];
    }
}