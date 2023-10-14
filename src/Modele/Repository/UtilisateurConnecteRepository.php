<?php

namespace App\Covoiturage\Modele\Repository;
use App\Covoiturage\Modele\DataObject\AbstractDataObject as AbstractDataObject;
use App\Covoiturage\Modele\DataObject\UtilisateurConnecte as UtilisateurConnecte;
abstract class UtilisateurConnecteRepository extends UtilisateurGeneriqueRepository
{


    protected function getNomTable(): string
    {
        return "Site_Utilisateurs";
    }

    protected function sauvegarder(AbstractDataObject $dataObject)
    {

    }

    protected abstract function construireDepuisTableau(array $objetFormatTableau): UtilisateurConnecte;
}