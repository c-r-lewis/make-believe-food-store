<?php

namespace App\Magasin\Modele\Repository;
use App\Magasin\Modele\DataObject\AbstractDataObject as AbstractDataObject;
use App\Magasin\Modele\DataObject\UtilisateurConnecte as UtilisateurConnecte;
abstract class UtilisateurConnecteRepository extends UtilisateurGeneriqueRepository
{


    protected function getNomTable(): string
    {
        return "Site_Utilisateurs";
    }

    protected abstract function getRole() : String;

    protected function sauvegarder(AbstractDataObject $dataObject)
    {

    }

    protected abstract function construireDepuisTableau(array $objetFormatTableau): UtilisateurConnecte;
}