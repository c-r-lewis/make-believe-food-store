<?php

namespace App\Covoiturage\Modele\Repository;

use AbstractDataObject;
use App\Covoiturage\Modele\Repository\AbstractRepository;
use UtilisateurConnecte;

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