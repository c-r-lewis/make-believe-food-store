<?php

namespace App\Covoiturage\Modele\Repository;

use AbstractDataObject;
use App\Covoiturage\Modele\Repository\AbstractRepository;
use UtilisateurConnectee;

class UtilisateurRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Site_Utilisateurs";
    }

    protected function sauvegarder(AbstractDataObject $dataObject)
    {

    }

    protected function construireDepuisTableau(array $objetFormatTableau): UtilisateurConnectee
    {
        $utilisateur = new UtilisateurConnectee();
        $utilisateur->setNom($objetFormatTableau['nom']);
        $utilisateur->setMdp($objetFormatTableau['mdp']);
        $utilisateur->setEmail($objetFormatTableau['email']);
        $utilisateur->setPrenom($objetFormatTableau['prenom']);
        return $utilisateur;
    }
}