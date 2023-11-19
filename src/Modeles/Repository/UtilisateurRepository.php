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
        return new Utilisateur($objetFormatTableau['email'], $objetFormatTableau['nom'], $objetFormatTableau['prenom'], $objetFormatTableau['mdpHache'], $objetFormatTableau["estAdmin"]);
    }

    protected function getNomsColonnes(): array
    {
        return [
            "email",
            "nom",
            "prenom",
            "mdpHache",
            "estAdmin",
            "emailAValider",
            "nonce",
        ];
    }

    protected function getClePrimaire(): array
    {
        return ["email"];
    }
}