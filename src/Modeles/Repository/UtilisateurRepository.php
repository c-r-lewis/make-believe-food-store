<?php

namespace App\Magasin\Modeles\Repository;

use App\Magasin\Modeles\DataObject\Utilisateur as Utilisateur;

class UtilisateurRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Site_UtilisateursConnectes";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Utilisateur
    {
        return new Utilisateur($objetFormatTableau['email'],$objetFormatTableau['nom'],$objetFormatTableau['prenom'],$objetFormatTableau['mdp'], $objetFormatTableau["estAdmin"]);
    }

    protected function getNomsColonnes(): array
    {
        return
            [
                "email",
                "nom",
                "prenom",
                "mdp",
                "estAdmin"
            ];
    }

    protected function getClePrimaire(): string
    {
        return "email";
    }
}