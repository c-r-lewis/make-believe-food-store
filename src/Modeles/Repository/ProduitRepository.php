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

    protected function getClePrimaire(): array
    {
        return ["idProduit"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        if (array_key_exists("idProduit",$objetFormatTableau)) {
            $produit = new Produit($objetFormatTableau["idProduit"],$objetFormatTableau["nomProduit"], $objetFormatTableau["descriptionProduit"], $objetFormatTableau["prixProduit"]);
        }
        else {
            $produit = new Produit($objetFormatTableau["nomProduit"], $objetFormatTableau["descriptionProduit"], $objetFormatTableau["prixProduit"]);
        }
        return $produit;
    }

    public function getImageProduit(Produit $produit): string
    {
        $repo = new ImageRepository();
        $cheminImage = "../ressources/images/placeholder.png";
        if (count($repo->recupererParClePrimaire([$produit->getIdProduit()])) != 0) {
            $image = $repo->recupererParClePrimaire([$produit->getIdProduit()])[0];
            $cheminImage = $image->getImage();
        }
        return $cheminImage;
    }

    protected function getNomsColonnes(): array
    {
        return [
            "nomProduit",
            "descriptionProduit",
            "prixProduit"
        ];
    }
}